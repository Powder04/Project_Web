<?php
require 'db.php';
session_start();
$cart = $_SESSION['cart'] ?? [];

if ($_POST && $cart) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $stmt = $pdo->prepare("INSERT INTO orders (name, address, items) VALUES (?, ?, ?)");
    $items = json_encode($cart);
    $stmt->execute([$name, $address, $items]);

    // Xóa giỏ hàng
    unset($_SESSION['cart']);
    echo "Đặt hàng thành công!";
} else {
    echo "Giỏ hàng trống hoặc thiếu thông tin.";
}
