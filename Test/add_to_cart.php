<?php
session_start();
if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $_SESSION['cart'][] = ['id' => $data['id'], 'name' => $data['name']];
    echo json_encode(['status' => 'added']);
} else {
    echo json_encode($_SESSION['cart']);
}
