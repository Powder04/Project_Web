<?php
  session_start();
  require_once('../mysqlConnect.php');
  $mysqli->select_db('project');

  $stm = $mysqli->prepare('SELECT fullname, birthday FROM customer WHERE email = ?');
  $stm->bind_param('s', $_SESSION['email']);
  $stm->execute();
  $rs = $stm->get_result();
  $customer = $rs->fetch_assoc();

  $stm->close();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Thông tin khách hàng</title>
    <link rel="icon" href="../img/icon.png" />
    <link rel="stylesheet" href="../style/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <style>
      span {
        padding: 4.5px;
      }
      .lab {
        width: 45%;
      }
    </style>
  </head>
  <body>
    <header>
      <article class="navbar">
        <img
          src="../img/logoname.png"
          style="width: 240px; height: 60px"
          usemap="#home"
        />
        <map name="home">
          <area shape="rect" coords="0 0 943 263" href="../display/main.html" />
        </map>
        <nav>
          <a href="">Trang chủ</a>
          <a href="">Giới thiệu</a>
          <a href="">Cập nhật thông tin</a>
        </nav>
      </article>
    </header>

    <main class="container">
      <fieldset>
        <h1 class="heading">Thông tin khách hàng</h1>
          <article class="account">
            <label class="lab"><b>Họ và tên: </b></label>
            <span><?php echo $customer['fullname'] ?></span>
          </article>
          <article class="account">
            <label class="lab"><b>Địa chỉ email: </b></label>
            <span><?php echo $_SESSION['email']; ?></span>
          </article>
          <article class="account" style="margin-bottom: 25px;">
            <label class="lab"><b>Năm sinh: </b></label>
            <span><?php echo $customer['birthday'] ?></span>
          </article>
      </fieldset>
    </main>
  </body>
</html>
