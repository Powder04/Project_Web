<?php
    require_once('../includes/mysqlConnect.php');

    $nameProduct = $_POST['nameProduct'];
    $productID = $_POST['productID'];
    $typeProduct = $_POST['typeProduct'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    if(!isset($_FILES['image_file'])) {
        echo "<script> alert('Chưa thêm file ảnh của sản phẩm.'); window.history.back(); </script>";
    }

    if($_FILES['image_file']['error'] !== UPLOAD_ERR_OK) {
        echo "<script> alert('Lỗi file ảnh.'); window.history.back(); </script>";
    }

    $filename = $_FILES['image_file']['name'];
    $mime_type = $_FILES['image_file']['type'];
    $file_size = $_FILES['image_file']['size'];
    $image_data = file_get_contents($_FILES['image_file']['tmp_name']);

    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    if(!in_array($mime_type, $allowed_types)) {
        echo "<script> alert('Định dạng file ảnh không hợp lệ.'); window.history.back(); </script>";
    }

    if($file_size > 2 * 1024 * 1024) {
        echo "<script> alert('Kích thước file ảnh quá lớn.'); window.history.back(); </script>";
    }

    $stm = $mysqli->prepare("INSERT INTO product (product_id, name, category, price, quantity) VALUES (?, ?, ?, ?, ?)");
    $stm->bind_param("sssii", $productID, $nameProduct, $typeProduct, $price, $quantity);
    if(!$stm->execute()) {
        echo "<script> alert('Lỗi thêm sản phẩm.'); window.history.back(); </script>";
    }
    $stm->close();

    $stm = $mysqli->prepare("INSERT INTO images (product_id, filename, mime_type, file_size, image_data) VALUES (?, ?, ?, ?, ?)");
    $stm->bind_param("sssis", $productID, $filename, $mime_type, $file_size, $image_data);
    $stm->send_long_data(4, $image_data);

    if(!$stm->execute()) {
        echo "<script> alert('Lỗi thêm sản phẩm.'); window.history.back(); </script>";
    }
    $stm->close();

    echo '<script> alert("Thêm sản phẩm thành công."); window.location.href = "./form_product.php"; </script>';
    $mysqli->close();
?>