<?php
    require_once('../includes/mysqlConnect.php');

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $product_id = $_POST['product_id'];
        $name = $_POST['nameProduct'];
        $category = $_POST['typeProduct'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];

        $stmt = $mysqli->prepare("UPDATE product SET name = ?, category = ?, price = ?, quantity = ? WHERE product_id = ?");
        $stmt->bind_param("ssiis", $name, $category, $price, $quantity, $product_id);

        if(!$stmt->execute()) {
            echo "Lỗi khi cập nhật product: " . $stmt->error;
            $stmt->close();
            exit();
        }
        $stmt->close();

        if(isset($_FILES['image_file']) && $_FILES['image_file']['size'] > 0) {
            $image_data = file_get_contents($_FILES['image_file']['tmp_name']);
            $mime_type = $_FILES['image_file']['type'];
            $filename = $_FILES['image_file']['name'];
            $file_size = $_FILES['image_file']['size'];

            $checkStmt = $mysqli->prepare("SELECT id FROM images WHERE product_id = ?");
            $checkStmt->bind_param("s", $product_id);
            $checkStmt->execute();
            $checkStmt->store_result();

            if($checkStmt->num_rows > 0) {
                $updateImgStmt = $mysqli->prepare("UPDATE images SET filename = ?, mime_type = ?, file_size = ?, image_data = ? WHERE product_id = ?");
                $updateImgStmt->bind_param("ssiss", $filename, $mime_type, $file_size, $image_data, $product_id);

                if(!$updateImgStmt->execute()) {
                    echo "Lỗi khi cập nhật ảnh: " . $updateImgStmt->error;
                    $updateImgStmt->close();
                    $checkStmt->close();
                    exit();
                }
                $updateImgStmt->close();
            } else {
                $insertImgStmt = $mysqli->prepare("INSERT INTO images (product_id, filename, mime_type, file_size, image_data) VALUES (?, ?, ?, ?, ?)");
                $insertImgStmt->bind_param("sssis", $product_id, $filename, $mime_type, $file_size, $image_data);

                if(!$insertImgStmt->execute()) {
                    echo "Lỗi khi thêm ảnh mới: " . $insertImgStmt->error;
                    $insertImgStmt->close();
                    $checkStmt->close();
                    exit();
                }
                $insertImgStmt->close();
            }

            $checkStmt->close();
        }
        echo '<script> alert("Cập nhật thành công."); window.location.href="./manage_product.html"; </script>';
        exit();
    }
?>