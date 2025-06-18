<?php
    require_once('../mysqlConnect.php');

    $productID = $_POST['productID'];

    $stm = $mysqli->prepare("DELETE FROM product WHERE product_id = ?");
    $stm->bind_param("s", $productID);
    if ($stm->execute()) {
        echo "Xóa sản phẩm thành công!";
    } else {
        echo "Lỗi xóa: " . $stm->error;
    }
    $stm->close();
    $mysqli->close();
?>