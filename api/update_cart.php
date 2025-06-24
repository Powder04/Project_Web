<?php
    session_start();

    $data = json_decode(file_get_contents('php://input'), true);
    $index = $data['index'];
    $quantity = $data['quantity'];

    if(isset($_SESSION['cart'][$index])) {
        $_SESSION['cart'][$index]['quantity'] = $quantity;
        $_SESSION['cart'][$index]['total_price'] = $_SESSION['cart'][$index]['price'] * $quantity;
    }

    echo json_encode(['status' => 'success']);
?>