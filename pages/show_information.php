<?php
  session_start();
  require_once('../includes/mysqlConnect.php');

  $stm = $mysqli->prepare('SELECT fullname, birthday FROM user WHERE email = ?');
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
  <link rel="icon" href="../assets/images/icon.png">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <style>
    span {
      padding: 4.5px;
    }

    .lab {
      width: 45%;
    }

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
        <a href="./get_information.php">Cập nhật thông tin</a>
        <a href="./show_product.php">Sản phẩm</a>
        <a href="./inquiry.php">Góp ý</a>
        <a href="./buy_product.php" id="cart-icon" onmouseenter="showCartDropdown()" onmouseleave="hideCartDropdown()"
          style="margin-right: 15px;">
          <i class="fa-solid fa-cart-shopping"></i>
          <div id="cart-dropdown" onmouseenter="cancelHide()" onmouseleave="hideCartDropdown()"></div>
        </a>
        <a href="../includes/logout.php"
          style="background-color: rgb(40, 167, 69); border: 1px solid rgb(40, 167, 69); padding: 10px 20px; text-decoration: none; color: white; margin-right: 5px;">Đăng
          xuất</a>
      </nav>
    </article>
  </header>

  <main class="container">
    <fieldset style="display: block;" id="information">
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
      <div id="product" style="text-align: center;">
        <button type="button" style="padding: 8px 20px;" onclick="fetchHistory(1)">Lịch sử mua hàng</button>
      </div>
    </fieldset>
    <div id="list_order" style="display: none;">
      <div id="product">
        <button type="button" style="padding: 8px 20px;" onclick="backToList()">Quay lại</button>
      </div>
      <div class="box-container">
        <table>
          <thead>
            <tr>
              <th>STT</th>
              <th>Email</th>
              <th>Họ và tên</th>
              <th>Số điện thoại</th>
              <th>Ngày đặt đơn</th>
              <th>Thành tiền</th>
              <th>Chi tiết</th>
            </tr>
          </thead>
          <tbody id="historyTable"></tbody>
        </table>
      </div>
    </div>
    <div id="order_detail" style="display: none;">
      <div id="product">
        <button type="button" style="padding: 8px 20px;" onclick="backToHistory()"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <table>
        <thead>
          <tr>
            <th><h2>Thông tin đặt hàng</h2></th>
            <th><h2>Thông tin sản phẩm</h2></th>
          </tr>
        </thead>
        <tbody id="detailTable">
          <td id="child1"></td>
          <td id="child2">
            <table>
              <thead>
                <tr>
                  <th>Mã sản phẩm</th>
                  <th>Tên sản phẩm</th>
                  <th>Hình ảnh</th>
                  <th>Số lượng</th>
                  <th>Thành tiền</th>
                </tr>
              </thead>
              <tbody id="bill"></tbody>
            </table>
            <div id="total"></div>
          </td>
        </tbody>
      </table>
    </div>
  </main>
  <script src="../assets/javascript/product.js"></script>
</body>

</html>