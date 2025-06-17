<?php
session_start();
$cart = $_SESSION['cart'] ?? [];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Thanh toán</title>
</head>
<body>
<h2>Danh sách sản phẩm</h2>
<ul>
    <?php foreach ($cart as $item): ?>
        <li><?= htmlspecialchars($item['name']) ?></li>
    <?php endforeach; ?>
</ul>

<h3>Thông tin đặt hàng</h3>
<form action="place_order.php" method="POST">
    Tên: <input type="text" name="name" required><br>
    Địa chỉ: <input type="text" name="address" required><br>
    <button type="submit">Đặt hàng</button>
</form>
</body>
</html>
