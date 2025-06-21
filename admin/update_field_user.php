<?php
    require_once('../includes/mysqlConnect.php');

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST["email"];
        $field = $_POST["field"];
        $value = $_POST["value"];

        if($field === "status") {
            $value = (int)$value;
            $stm = $mysqli->prepare("UPDATE user SET status = ? WHERE email = ?");
            $stm->bind_param("is", $value, $email);
        }
        elseif($field === "role") {
            $stm = $mysqli->prepare("UPDATE user SET role = ? WHERE email = ?");
            $stm->bind_param("ss", $value, $email);
        }
        else {
            echo "Lỗi.";
            $mysqli->close();
            exit();
        }
        if ($stm->execute()) {
            echo "Cập nhật thành công.";
        } else {
            echo "Error: " . $stm->error;
        }
        $stm->close();
        $mysqli->close();
    }
?>