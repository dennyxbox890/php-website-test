<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="style2.css">
  <link rel="stylesheet" href="style1.css">
</head>

<body>
  <div class="main_title">
  </div>
  <div class="navbar">
    <a href="index.php">首頁</a>
    <a href="http://tsj.tw/">分頁1</a>
    <div class="dropdown">

      <button class="dropbtn">連結
        <!--<i class="fa fa-caret-down"></i>-->
      </button>
      <div class="dropdown-content">
        <!--<div class="header">
              <h2>測試選單</h2>
            </div>-->
        <div class="row"></div>
        <div class="column">
          <a href="page1.php">測試頁面</a>
          <a href="phpmyadmin">phpMyAdmin</a>
          <a href="pagetemp.php">phpInfo</a>
          <a href="#">施工中</a>
        </div>
      </div>
    </div>
  </div>
  </div>
  <div class="paragraph">
    <div id="php1">
      <h1 class="ex_title1">Text input test</h1>
      <div class="form">
        <!--from https://www.w3schools.com/html/html_forms.asp-->
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
          test input: <input type="text" name="a" id="text_box">
          <input type="submit" id="submit_button">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          //using htmlspecialchars 2 prevent hack
          $a = htmlspecialchars($_POST['a'] ?? null);
          if (empty($a)) {
            echo "empty";
          } else {
            echo $a;
          }
        }
        ?>
      </div>
      <h1 class="ex_title1">Link MySQL</h1>
      <div class="linkSQL">
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
          test input: <input type="text" name="b" id="text_box">
          <input type="submit" id="submit_button">
        </form>
        <?php
        // 建立MySQL的資料庫連接 
        $dsn = "mysql:dbname=test;host=localhost;port=3306;";
        $username = "dennyxbox890";
        try {
          // 建立MySQL伺服器連接和開啟資料庫 
          $link = new PDO($dsn, $username);
          // 指定PDO錯誤模式和錯誤處理
          $link->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
          );

          echo "連接成功<br>";
        } catch (PDOException $e) {
          echo "連接失敗: " . $e->getMessage() . "<br/>";
        }
        try {
          $link->query("CREATE TABLE `account` (
            `firstname` VARCHAR(50)
            )
          ");
        } catch (PDOException $e) {
          echo '已存在資料表:)<br>';
        }
        try {
          $d=null;
          if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //using htmlspecialchars 2 prevent hack
            $b = htmlspecialchars($_POST['b'] ?? null) ;
            if (empty($b)) {
              echo "empty";
            } else {
              $temp1 = "INSERT INTO `account` (`firstname`)
                VALUES ('" . $b . "')";
              $link->query($temp1);
              $sql = "SELECT * FROM `account`";
              //echo "SQL查詢字串: $sql <br/>";
              // 送出UTF8編碼的MySQL指令
              $link->query('SET NAMES utf8');
              // 送出查詢的SQL指令
              if ($result = $link->query($sql)) {
                echo "<br/><b>資料:</b><hr/>";  // 顯示查詢結果
                // 取得記錄數
                $total_records = $result->rowCount();
                $d=$total_records;
                echo "資料筆數: $total_records 筆<br/>";
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                  echo $row["firstname"] . "<br/>";
                }
              }
            }
          }
          if($d>=5){
            $link->query("DROP TABLE `account`");
            $link = null;
          }
        } catch (PDOException $e) {
          echo "讀取失敗: " . $e->getMessage() . "<br/>";
        }
        

        ?>


      </div>

      <hr>

      <div class="sys_time">
        <?php
        echo date("Y-m-d\ne h:i");
        ?>
      </div>
    </div>
  </div>
</body>

</html>