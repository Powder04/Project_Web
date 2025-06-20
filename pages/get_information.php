<?php
  session_start();
  require_once('../includes/mysqlConnect.php');

  $email = $_SESSION['email'];
  $stm = $mysqli->prepare('SELECT * FROM customer WHERE email = ?');
  $stm->bind_param('s', $email);
  $stm->execute();
  $res = $stm->get_result();
  $customer = $res->fetch_assoc();

  $currentYear = date('Y');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cập nhật thông tin</title>
  <link rel="icon" href="../assets/images/icon.png">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <style>
    header {
      height: 70px;
      width: 100vw;
      padding: 0 5px;
      background-color: white;
      position: fixed;
      z-index: 100;
      box-shadow: 1px 1px 15px rgba(115, 255, 111, 0.825);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
  </style>
</head>

<body>
  <header>
    <article class="navbar">
      <img src="../assets/images/logoname.png" style="width: 240px; height: 60px" usemap="#home" />
      <map name="home">
        <area shape="rect" coords="0 0 943 263" href="./index.php" />
      </map>
      <nav>
        <a href="./index.php">Trang chủ</a>
        <a href="./show_information.php">Thông tin khách hàng</a>
        <a href="./show_product.php">Sản phẩm</a>
        <a href="./inquiry.php">Góp ý</a>
        <a href="./buy_product.php" id="cart-icon" onmouseenter="showCartDropdown()" onmouseleave="hideCartDropdown()"
          style="margin-right: 15px;">
          <i class="fa-solid fa-cart-shopping"></i>
          <div id="cart-dropdown" onmouseenter="cancelHide()" onmouseleave="hideCartDropdown()"></div>
        </a>
        <a href="../account/logout.php"
          style="background-color: rgb(40, 167, 69); border: 1px solid rgb(40, 167, 69); padding: 10px 20px; text-decoration: none; color: white; margin-right: 5px;">Đăng
          xuất</a>
      </nav>
    </article>
  </header>

  <main class="container">
    <fieldset>
      <h1 class="heading">Cập nhật thông tin</h1>
      <form action="../update.php" method="post">
        <article class="account">
          <label class="lab" for="fullname">Họ và tên: </label>
          <input type="text" class="inpt" value="<?php echo $customer['fullname']; ?>" name="fullname">
        </article>
        <article class="account">
          <label class="lab" for="email">Địa chỉ email: </label>
          <input type="email" class="inpt" value="<?php echo $_SESSION['email']; ?>" name="email" disabled>
        </article>
        <article class="account">
          <label class="lab" for="birthday">Năm sinh: </label>
          <select name="birthday" style="padding: 3px;">
            <option value="none">--Chọn năm sinh--</option>
            <?php
            for ($i = $currentYear - 100; $i < $currentYear; $i++) {
              $select = ($i == $customer['birthday']) ? 'selected' : '';
              echo "<option value='$i' $select>{$i}</option>";
            }
            ?>
          </select>
        </article>
        <article class="account">
          <label class="lab" for="pwd">Mật khẩu hiện tại: </label>
          <input type="password" minlength="8" name="pwd" class="inpt" id="pwd">
        </article>
        <article class="account">
          <label class="lab" for="newpwd">Mật khẩu mới: </label>
          <input type="password" minlength="8" name="newpwd" class="inpt" id="newpwd">
        </article>
        <article class="account btn-account" style="margin: 25px 0px 25px 0px;">
          <button type="reset" class="btn btn-1">Hủy</button>
          <button type="submit" class="btn btn-2">Cập nhật thông tin</button>
        </article>
      </form>
    </fieldset>
  </main>
  <script src="../assets/javascript/product.js"></script>
</body>

</html>