<?php
    require_once('../includes/mysqlConnect.php');
    session_start();

    if ($_SESSION["login"] !== true || !isset($_SESSION["login"]) || $_SESSION["role"] !== "admin") {
        header("Location: ../pages/login.html");
        exit();
    }

    // Lấy ngày lọc
    $fromDate = $_GET['from_date'] ?? date('Y-m-01'); // mặc định từ đầu tháng
    $toDate = $_GET['to_date'] ?? date('Y-m-d');       // mặc định đến hôm nay
    $fromDateFull = $fromDate . " 00:00:00";
    $toDateFull = $toDate . " 23:59:59";

    $total_users = $mysqli->query("SELECT COUNT(*) FROM user WHERE created_at BETWEEN '$fromDateFull' AND '$toDateFull'")->fetch_row()[0];
    $pending_feedback = $mysqli->query("SELECT COUNT(*) FROM feedback WHERE status = 'Đang xử lý' AND submitted_at 
                                        BETWEEN '$fromDateFull' AND '$toDateFull'")->fetch_row()[0];
    $stock_quantity = $mysqli->query("SELECT SUM(quantity) FROM product")->fetch_row()[0] ?? 0;
    $orders_total = $mysqli->query("SELECT COUNT(*) FROM orders WHERE order_date BETWEEN '$fromDateFull' AND '$toDateFull'")->fetch_row()[0];
    $revenue_total = $mysqli->query("SELECT SUM(total_price) FROM orders 
                                    WHERE order_status = 'Thành công' 
                                    AND order_date BETWEEN '$fromDateFull' AND '$toDateFull'")->fetch_row()[0] ?? 0;
    $total_sold = $mysqli->query("SELECT SUM(sold_count) FROM product")->fetch_row()[0] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../assets/images/icon.png">
  <link rel="stylesheet" href="../assets/css/style_admin.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <title>Dashboard</title>
</head>
<body>
<header>
  <article class="navbar">
    <img src="../assets/images/logoname.png" style="width: 240px; height: 60px; margin-left: 5px;">
    <nav>
      <a href="../includes/logout.php" style="background-color: rgb(40, 167, 69); border: 1px solid rgb(40, 167, 69); padding: 10px 20px; text-decoration: none; color: white; margin-right: 5px;">Đăng xuất</a>
    </nav>
  </article>
</header>

<div class="main-container">
  <div class="navcontainer">
    <nav class="nav">
      <div class="nav-upper-options">
        <a href="./index.php"><div class="nav-option"><h3>Danh mục</h3></div></a>
        <a href="./manage_product.html"><div class="nav-option"><h3>Quản lý sản phẩm</h3></div></a>
        <a href="./manage_user.html"><div class="nav-option"><h3>Quản lý tài khoản</h3></div></a>
        <a href="./manage_bill.html"><div class="nav-option"><h3>Quản lý đơn hàng</h3></div></a>
        <a href="./manage_feedback.html"><div class="nav-option"><h3>Quản lý phản hồi</h3></div></a>
      </div>
    </nav>
  </div>

  <div class="main">
    <h1 style="color: rgb(40, 167, 69);">Dashboard</h1>

    <form method="get" id="product" style="margin-bottom: 20px;" >
      <label>Từ: <input type="date" name="from_date" value="<?= htmlspecialchars($fromDate) ?>"></label>
      <label style="margin-left: 10px;">Đến: <input type="date" name="to_date" value="<?= htmlspecialchars($toDate) ?>"></label>
      <button type="submit" style="margin-left: 10px;">Lọc</button>
    </form>

    <div class="dashboard">
      <fieldset class="card">
        <div class="icon-box"><i class="fas fa-users"></i></div>
        <div class="card-content">
          <div class="title">Người dùng mới</div>
          <div class="value"><?= $total_users ?></div>
        </div>
      </fieldset>

      <fieldset class="card">
        <div class="icon-box"><i class="fas fa-shopping-cart"></i></div>
        <div class="card-content">
          <div class="title">Đơn hàng</div>
          <div class="value"><?= $orders_total ?></div>
        </div>
      </fieldset>

      <fieldset class="card">
        <div class="icon-box"><i class="fas fa-dollar-sign"></i></div>
        <div class="card-content">
          <div class="title">Doanh thu</div>
          <div class="value"><?= number_format($revenue_total, 0, ',', '.') ?> VNĐ</div>
        </div>
      </fieldset>

      <fieldset class="card">
        <div class="icon-box"><i class="fas fa-box-open"></i></div>
        <div class="card-content">
          <div class="title">Đã bán (tổng)</div>
          <div class="value"><?= $total_sold ?></div>
        </div>
      </fieldset>

      <fieldset class="card">
        <div class="icon-box"><i class="fas fa-comment-dots"></i></div>
        <div class="card-content">
          <div class="title">Phản hồi chờ</div>
          <div class="value"><?= $pending_feedback ?></div>
        </div>
      </fieldset>

      <fieldset class="card">
        <div class="icon-box"><i class="fas fa-warehouse"></i></div>
        <div class="card-content">
          <div class="title">Tồn kho</div>
          <div class="value"><?= $stock_quantity ?></div>
        </div>
      </fieldset>
    </div>
  </div>
</div>
</body>
</html>
