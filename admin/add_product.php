<?php
    require_once('../includes/mysqlConnect.php');

    $nameProduct = $_POST['nameProduct'];
    $productID = $_POST['productID'];
    $typeProduct = $_POST['typeProduct'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    if(!isset($_FILES['image_file'])) {
        die("No file uploaded.");
    }

    if($_FILES['image_file']['error'] !== UPLOAD_ERR_OK) {
        die("Upload error: " . $_FILES['image_file']['error']);
    }

    $filename = $_FILES['image_file']['name'];
    $mime_type = $_FILES['image_file']['type'];
    $file_size = $_FILES['image_file']['size'];
    $image_data = file_get_contents($_FILES['image_file']['tmp_name']);

    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    if(!in_array($mime_type, $allowed_types)) {
        die("Invalid file type. Only JPG, PNG, and GIF are allowed.");
    }

    if($file_size > 2 * 1024 * 1024) {
        die("File size too large. Max allowed size is 2MB.");
    }

    $stm = $mysqli->prepare("INSERT INTO product (product_id, name, category, price, quantity) VALUES (?, ?, ?, ?, ?)");
    $stm->bind_param("sssii", $productID, $nameProduct, $typeProduct, $price, $quantity);
    if(!$stm->execute()) {
        die("Failed to insert product: " . $stm->error);
    }
    $stm->close();

    $stm = $mysqli->prepare("INSERT INTO images (product_id, filename, mime_type, file_size, image_data) VALUES (?, ?, ?, ?, ?)");
    $stm->bind_param("sssis", $productID, $filename, $mime_type, $file_size, $image_data);
    $stm->send_long_data(4, $image_data);

    if(!$stm->execute()) {
        die("Failed to insert image: " . $stm->error);
    }
    $stm->close();

    echo '<script> alert("Thêm sản phẩm thành công."); window.location.href = "./form_product.html"; </script>';
    $mysqli->close();
?>