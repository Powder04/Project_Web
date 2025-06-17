<?php
    session_start();

    $data = json_decode(file_get_contents("php://input"), true);
    if (!isset($_SESSION["cart"])) $_SESSION["cart"] = [];

    $product_id = $data['product_id'];
    $found = false;
    foreach ($_SESSION["cart"] as &$item) {
        if ($item['product_id'] === $product_id) {
            $item['quantity'] += $data['quantity'];
            $item['total_price'] = $item['quantity'] * $item['price'];
            $found = true;
            break;
        }
    }
    unset($item);
    if (!$found) {
        $_SESSION["cart"][] = [
            "product_id" => $data["product_id"],
            "name" => $data["name"],
            "price" => $data["price"],
            "quantity" => $data["quantity"],
            "total_price" => $data["total_price"],
            "image" => $data["image"]
        ];
    }

    echo json_encode(['status' => 'added']);
?>