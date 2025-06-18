<?php
    session_start();
    require_once('../mysqlConnect.php');

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
    <link rel="icon" href="../img/icon.png" />
    <link rel="stylesheet" href="../style/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  </head>
  <body>
    <header>
      <article class="navbar">
        <img src="../img/logoname.png" style="width: 240px; height: 60px" usemap="#home"/>
        <map name="home">
          <area shape="rect" coords="0 0 943 263" href="../display/main.html"/>
        </map>
        <nav>
          <a href="../display/main.html">Trang chủ</a>
          <a href="">Giới thiệu</a>
          <a href="./show_information.php">Thông tin khách hàng</a>
          <a href="../display/show_product.php">Sản phẩm</a>
          <a href="../account/logout.php" style="background-color: rgb(40, 167, 69); border: 1px solid rgb(40, 167, 69); padding: 10px 20px; text-decoration: none; color: white; margin-right: 5px;">Đăng xuất</a>
        </nav>
      </article>
    </header>

    <main class="container">
      <fieldset>
        <h1 class="heading">Cập nhật thông tin</h1>
        <form action="./update.php" method="post">
            <article class="account">
                <label class="lab">Họ và tên: </label>
                <input type="text" class="inpt" value="<?php echo $customer['fullname']; ?>" name="fullname">
            </article>
            <article class="account">
                <label class="lab">Địa chỉ email: </label>
                <input type="email" class="inpt" value="<?php echo $_SESSION['email']; ?>" name="email" disabled>
            </article>
            <article class="account">
                <label class="lab">Năm sinh: </label>
                <select name="birthday" style="padding: 3px;">
                    <option value="none">--Chọn năm sinh--</option>
                    <?php
                        for($i = $currentYear-100; $i < $currentYear; $i++) {
                            $select = ($i == $customer['birthday']) ? 'selected' : '';
                            echo "<option value='$i' $select>{$i}</option>";
                        }
                    ?>
                </select>
            </article>
            <article class="account">
                <label class="lab">Mật khẩu hiện tại: </label>
                <input type="password" minlength="8" name="pwd" class="inpt" id="pwd">
            </article>
            <article class="account">
                <label class="lab">Mật khẩu mới: </label>
                <input type="password" minlength="8" name="newpwd" class="inpt" id="newpwd">
            </article>
          <article class="account btn-account" style="margin: 25px 0px 25px 0px;">
            <button type="reset" class="btn btn-1">Hủy</button>
            <button type="submit" class="btn btn-2">Cập nhật thông tin</button>
          </article>
        </form>
      </fieldset>
    </main>
  </body>
</html>