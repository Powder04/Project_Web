<?php
    require_once('../includes/mysqlConnect.php');
    session_start();
    if($_SESSION["login"] !== true && !isset($_SESSION["login"])) header("Location: ../pages/login.html");

    // --- Thống kê ---
    $total_users = $mysqli->query("SELECT COUNT(*) FROM user")->fetch_row()[0];
    $pending_feedback = $mysqli->query("SELECT COUNT(*) FROM feedback WHERE status = 'Đang xử lý'")->fetch_row()[0];
    $stock_quantity = $mysqli->query("SELECT SUM(quantity) FROM product")->fetch_row()[0] ?? 0;

    // Đơn hàng tuần này / trước
    $orders_this_week = $mysqli->query("SELECT COUNT(*) FROM orders WHERE YEARWEEK(order_date, 1) = YEARWEEK(CURDATE(), 1)")->fetch_row()[0];
    $orders_last_week = $mysqli->query("SELECT COUNT(*) FROM orders WHERE YEARWEEK(order_date, 1) = YEARWEEK(CURDATE() - INTERVAL 1 WEEK, 1)")->fetch_row()[0];
    $orders_change = $orders_last_week > 0 ? (($orders_this_week - $orders_last_week) / $orders_last_week) * 100 : 100;

    // Doanh thu tuần này / trước
    $revenue_this_week = $mysqli->query("SELECT SUM(total_price) FROM orders WHERE order_status = 'Thành công' AND YEARWEEK(order_date, 1) = YEARWEEK(CURDATE(), 1)")->fetch_row()[0] ?? 0;
    $revenue_last_week = $mysqli->query("SELECT SUM(total_price) FROM orders WHERE order_status = 'Thành công' AND YEARWEEK(order_date, 1) = YEARWEEK(CURDATE() - INTERVAL 1 WEEK, 1)")->fetch_row()[0] ?? 0;
    $revenue_change = $revenue_last_week > 0 ? (($revenue_this_week - $revenue_last_week) / $revenue_last_week) * 100 : 100;

    // Sản phẩm bán ra (dựa trên sold_count)
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
  <title>Danh mục</title>
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
                    <a href="./index.php">
                        <div class="nav-option">
                            <h3>Danh mục</h3>
                        </div>
                    </a>
                    <a href="./manage_product.html">
                        <div class="nav-option">
                            <h3>Quản lý sản phẩm</h3>
                        </div>
                    </a>
                    <a href="./manage_user.html">
                        <div class="nav-option">
                            <h3>Quản lý người dùng</h3>
                        </div>
                    </a>
                    <a href="./manage_bill.html">
                        <div class="nav-option">
                            <h3>Quản lý đơn hàng</h3>
                        </div>
                    </a>
                    <a href="./manage_feedback.html">
                        <div class="nav-option">
                            <h3>Quản lý phản hồi</h3>
                        </div>
                    </a>
                </div>
            </nav>
        </div>
        <div class="main">
            <h1 style="color: rgb(40, 167, 69);">Overview</h1>
            <div class="dashboard">
                <fieldset class="card">
                    <div class="icon-box"><i class="fas fa-users"></i></div>
                    <div class="card-content">
                    <div class="title">Người dùng</div>
                    <div class="value"><?= $total_users ?></div>
                    </div>
                </fieldset>

                <fieldset class="card">
                    <div class="icon-box"><i class="fas fa-shopping-cart"></i></div>
                    <div class="card-content">
                    <div class="title">Đơn hàng (tuần)</div>
                    <div class="value"><?= $orders_this_week ?></div>
                    <div class="compare" style="color: <?= $orders_change >= 0 ? 'green' : 'red' ?>">
                        <?= ($orders_change >= 0 ? '+' : '') . round($orders_change, 1) ?>% so với tuần trước
                    </div>
                    </div>
                </fieldset>

                <fieldset class="card">
                    <div class="icon-box"><i class="fas fa-dollar-sign"></i></div>
                    <div class="card-content">
                    <div class="title">Doanh thu (tuần)</div>
                    <div class="value"><?= number_format($revenue_this_week, 0, ',', '.') ?> VNĐ</div>
                    <div class="compare" style="color: <?= $revenue_change >= 0 ? 'green' : 'red' ?>">
                        <?= ($revenue_change >= 0 ? '+' : '') . round($revenue_change, 1) ?>% so với tuần trước
                    </div>
                    </div>
                </fieldset>

                <fieldset class="card">
                    <div class="icon-box"><i class="fas fa-box-open"></i></div>
                    <div class="card-content">
                    <div class="title">Đã bán</div>
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
                    <div class="title">Sản phẩm tồn</div>
                    <div class="value"><?= $stock_quantity ?></div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
</body>
</html>