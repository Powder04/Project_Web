<?php
    require_once('../includes/mysqlConnect.php');

    $email = $_POST["email"];
    $stm = $mysqli->prepare("DELETE FROM orders WHERE email = ?");
    $stm->bind_param("s", $email);
    if($stm->execute()) {
        echo "Xóa thành công.";
    } else {
        echo "Lỗi xóa: " . $stm->error;
    }
    $stm->close();
    $mysqli->close();
?>