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

    $sql = "SELECT click_num, meta FROM jobs WHERE url = 'http://www.jobkorea.co.kr//Recruit/GI_Read/17169773?Oem_Code=C1&rPageCode=ST&PageGbn=ST' LIMIT 1";

    $result = mysqli_query($conn, $sql);

    $click_num="";
    $meta="";
    $row = mysql_fetch_assoc(mysql_query($result));
    $click_num = $row['click_num'];
    $meta = $row['meta'];


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
