<?php
    $servername = "telegramdb.cctjzlx6kmlc.ap-northeast-1.rds.amazonaws.com";
    $username = "yongjang";
    $password = "yongjang";
    $mysql_db = "telegramdb";

    $conn = new mysql_connect($servername, $username, $password);
    if($conn){
      die('Could not connect:'.mysql_error());
    }
    echo 'Connected successfully';
//    $dbconn = mysql_select_db($mysql_db, $conn);

//    mysql_query("set names utf8");

    $url = $_GET["url"];

    $test = "<h1>".$url."</h1>";
/*
    $sql = "SELECT click_num, meta FROM jobs WHERE url = \'".$url."\'";

    $result = mysql_query($sql, $conn);

    $click_num;
    $meta;
    while($row = mysql_fetch_array($result)){
      $click_num = $row['click_num'];
      $meta = $row['meta'];
    }
*/
 ?>
<html>
        <head>
          <?php
      //    echo $meta;
          ?>



        </head>
        <body>
           this is  url
              <?php
              //  echo $meta;
                echo $test;
              ?>
        </body>
</html>

<?php
  mysql_close($conn);
 ?>
