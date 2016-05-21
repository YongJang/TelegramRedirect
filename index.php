<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
    $servername = "telegramdb.cctjzlx6kmlc.ap-northeast-1.rds.amazonaws.com";
    $username = "yongjang";
    $password = "yongjang";
    $mysql_db = "telegramdb";

    $conn = mysqli_connect($servername, $username, $password, $mysql_db);
    if(!$conn){
      die('Could not connect:'.mysql_error());
    }
    echo 'Connected successfully';

    mysqli_query($conn, "set names utf8");

    $url = $_GET["url"];

    $test = "<h1>".$url."</h1>";

    $sql = "SELECT * FROM jobs WHERE PK_aid = 10";

    //$result = mysqli_query($conn, $sql);
    $cursor = mysql_query($sql);

    //$row = mysql_fetch_row($result);
    $row = mysql_fetch_row($cursor);
    $click_num = $row[1];
    $meta = $row[2];
    echo "!!!!";


 ?>
<html>
        <head>
          <?php
          echo $meta;
          ?>



        </head>
        <body>
           this is  url
              <?php
                echo $meta;
                echo $test;
              ?>
        </body>
</html>

<?php
  mysql_close($conn);
 ?>
