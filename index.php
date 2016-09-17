<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);


    if(isset($_GET["url"])){
      $aid = $_GET["url"];
      $tb = $_GET["tb"];
      $uid = $_GET["uid"];
    }
    if(isset($aid)){
    $servername = "telegramdb.cjks7yer9qjg.ap-northeast-2.rds.amazonaws.com";
    $username = "yongjang";
    $password = "yongjang";
    $mysql_db = "telegramdb";

    $conn = mysqli_connect($servername, $username, $password, $mysql_db);
    if(!$conn){
      die('Could not connect:'.mysql_error());
    }
    echo '해당 링크로 연결 중입니다.';

    mysqli_query($conn, "set names utf8");





    $agent = $_SERVER['HTTP_USER_AGENT'];
    // if user is Telegram, USER_AGENT is
    // TelegramBot (like TwitterBot)
    // $botfindsql = "INSERT INTO bot (name) VALUES ('".$agent."');";
    // $cursor = mysqli_query($conn, $botfindsql);


    $test = "<h1>".$aid."</h1>";

    echo "tb : ".$tb."\n";
    echo "url : ".$aid."\n";


    $sql = "SELECT * FROM ".$tb." WHERE PK_aid = '".$aid."' LIMIT 1";

    //$result = mysqli_query($conn, $sql);
    $cursor = mysqli_query($conn, $sql);

    //$row = mysql_fetch_row($result);
    $row = mysqli_fetch_assoc($cursor);
    $url = $row["url"];
    $click_num = $row["click_num"];
    $meta = $row["meta"];
    $kGroup = $row["k_group"];
    $high = $row["high"];

    if($tb == "information" && $agent != "TelegramBot (like TwitterBot)"){
      print("one");
      $sql = "SELECT * FROM users WHERE PK_uid = '".$uid."' LIMIT 1";
      $cursor = mysqli_query($conn, $sql);
      $row = mysqli_fetch_assoc($cursor);
      $user_kGroup = $row["k_group"];

      if($high == "IT"){
        $tableName = "relationIT";
      }else{
        $tableName = "relationEconomy";
      }

      $sql = "SELECT * FROM ".$tableName." WHERE PK_uid = '".$uid."' LIMIT 1";
      $cursor = mysqli_query($conn, $sql);
      $row = mysqli_fetch_assoc($cursor);
      // relation 테이블에 유저 테이블이 존재하지 않을 때
      if(safeCount($row) < 1){
        $sql = "INSERT INTO ".$tableName." (PK_uid, G1, G2, G3, G4, G5, G6, G7, G8, G9, G10, ETC) VALUES ('".$uid."',0,0,0,0,0,0,0,0,0,0,0);";
        $cursor = mysqli_query($conn, $sql);
      }
      // relation 테이블 업데이트
      if((int)$kGroup < 11 && (int)$kGroup > 0){
        $sql = "UPDATE ".$tableName." SET G".$kGroup." = G".$kGroup." + 1 WHERE PK_uid = '".$uid."';";
      }else{
        $sql = "UPDATE ".$tableName." SET ETC = ETC + 1 WHERE PK_uid = '".$uid."';";
      }

      $cursor = mysqli_query($conn, $sql);
      // 가장 수치 높은 k_group 계산
      $sql = "SELECT * FROM ".$tableName." WHERE PK_uid = '".$uid."' LIMIT 1";
      $cursor = mysqli_query($conn, $sql);
      $row = mysqli_fetch_row($cursor);
      $karray = array();

      for($i = 1; $i <= 10; $i++){
        array_push($karray, $row[$i]);
      }

      $maxIndex = 0;
      $sumOfKgroup = 0;
      for($i = 0; $i <= safeCount($karray); $i++){
        $sumOfKgroup = $sumOfKgroup + $karray[$i];
        if($karray[$i] > $maxIndex){
          $maxIndex = $i;
        }
      }
      // 데이터 베이스에서는 1 부터 시작하므로 1을 더함
      $maxIndex = $maxIndex + 1;
      // 유저의 k_group 정보를 업데이트
      // $sumOfKgroup > n 에서 n은 kgroup을 지정하기 위한 최소한의 데이터 사이즈
      if($sumOfKgroup > 0){
        if($high == "IT"){
          $sql = "UPDATE users SET kgroupIT = ".$maxIndex." WHERE PK_uid = '".$uid."';";
        }else{
          $sql = "UPDATE users SET kgroupEconomy = ".$maxIndex." WHERE PK_uid = '".$uid."';";
        }
        $cursor = mysqli_query($conn, $sql);
      }
    }


 ?>
<html>
        <head>
          <meta charset="utf-8"/>
          <?php
          echo $meta;
          ?>



        </head>
        <body>
              <?php
                echo $meta;
              ?>
        </body>
</html>

<?php
  $tmp_url = $url;
  $tmp_url = str_replace("%26", "&", $tmp_url);

  if($agent != "TelegramBot (like TwitterBot)"){
    $sql = "UPDATE ".$tb." SET click_num = click_num + 1 WHERE PK_aid = '".$aid."';";
    $cursor = mysqli_query($conn, $sql);
  }

  mysqli_close($conn);
  header ("Location: $tmp_url");
  }

  function safeCount($array) {
    if (isset($array)) return count($array);
    return -1;
  }
 ?>
