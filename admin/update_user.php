<?php
    require_once("../mysqlConnect.php");

    $old_email = $_POST["old_email"] ?? null;
    $new_email = $_POST["email"] ?? null;
    $fullname = $_POST["fullname"] ?? null;
    $birthday = $_POST["birthday"] ?? null;

    if ($old_email == null) {
        echo "Thiếu email cũ để cập nhật!";
        exit;
    }

    if ($new_email !== $old_email) {
        $stm = $mysqli->prepare("SELECT email FROM customer WHERE email = ?");
        $stm->bind_param("s", $new_email);
        $stm->execute();
        if ($stm->get_result()->num_rows > 0) {
            echo "Email mới đã tồn tại! Không thể đổi email. ";
            $new_email = $old_email;
        }
        $stm->close();
    }

    $sql = "UPDATE customer SET ";
    $params = [];
    $types = "";

    if ($new_email !== null) {
        $sql .= "email = ?, ";
        $types .= "s";
        $params[] = $new_email;
    }
    if ($fullname !== null && strlen($fullname) > 0) {
        $sql .= "fullname = ?, ";
        $types .= "s";
        $params[] = $fullname;
    }
    if ($birthday !== null && is_numeric($birthday)) {
        $sql .= "birthday = ?, ";
        $types .= "i";
        $params[] = (int)$birthday;
    }

    $sql = rtrim($sql, ", ") . " WHERE email = ?";
    $types .= "s";
    $params[] = $old_email;

    if (count($params) == 1) { 
        echo "Không có trường nào để cập nhật!";
        exit;
    }

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param($types, ...$params);
    if ($stmt->execute()) {
        echo "Cập nhật thành công!";
    } else {
        echo "Lỗi khi cập nhật!";
    }

    $stmt->close();
    $mysqli->close();
?>