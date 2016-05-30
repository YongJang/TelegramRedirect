<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

    if(isset($_GET["url"])){
      $url = $_GET["url"];
      $tb = $_GET["tb"];
      $uid = $_GET["uid"];
    }
    if(isset($url)){
    $servername = "telegramdb.cctjzlx6kmlc.ap-northeast-1.rds.amazonaws.com";
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


    $test = "<h1>".$url."</h1>";

    echo "tb : ".$tb."\n";
    echo "url : ".$url."\n";


    $sql = "SELECT * FROM ".$tb." WHERE url = '".$url."' LIMIT 1";

    //$result = mysqli_query($conn, $sql);
    $cursor = mysqli_query($conn, $sql);

    //$row = mysql_fetch_row($result);
    $row = mysqli_fetch_assoc($cursor);
    $click_num = $row["click_num"];
    $meta = $row["meta"];


 ?>
<html>
        <head>
          <meta charset="utf-8"/>
          <?php
          echo $meta;
          ?>



        </head>
        <body>
           this is  url
              <?php
                echo $meta;
              ?>
        </body>
</html>

<?php
  $tmp_url = $url;
  $tmp_url = str_replace("&", "%26", $tmp_url);

  if($agent != "TelegramBot (like TwitterBot)"){
    $sql = "UPDATE ".$tb." SET click_num = click_num + 1 WHERE url = '".$tmp_url."';";
    $cursor = mysqli_query($conn, $sql);
  }

  mysqli_close($conn);
  header ("Location: $url");
  }
 ?>
