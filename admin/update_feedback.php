<?php
    require_once('../includes/mysqlConnect.php');

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST["email"];
        $status = $_POST["status"];

        $stm = $mysqli->prepare("UPDATE feedback SET status = ? WHERE email = ?");
        $stm->bind_param("ss", $status, $email);
        if($stm->execute()) {
            echo "Cập nhật thành công.";
        } else {
            echo "Error: " . $stm->error;
        }
        $stm->close();
        $mysqli->close();
    }
?>