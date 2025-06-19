<?php
    require_once('../includes/mysqlConnect.php');

    $productID = $_POST['productID'];
    $quantity = (int)$_POST['quantity'] ?? null;
    $price = (float)$_POST['price'] ?? null;

    $sql = "UPDATE product SET ";
    $params = [];
    $types = "";

    if ($quantity !== null) {
        $sql .= "quantity = ?, ";
        $types .= "i";
        $params[] = $quantity;
    }
    if ($price !== null) {
        $sql .= "price = ?, ";
        $types .= "d";
        $params[] = $price;
    }

    $sql = rtrim($sql, ', ') . " WHERE product_id = ?";
    $types .= "s";
    $params[] = $productID;

    $stm = $mysqli->prepare($sql);
    $stm->bind_param($types, ...$params);

    if ($stm->execute()) {
        echo "Cập nhật thành công!";
    } else {
        echo "Lỗi cập nhật: " . $stm->error;
    }

    $stm->close();
    $mysqli->close();
?>