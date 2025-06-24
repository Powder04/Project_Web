<?php
    require_once('../includes/mysqlConnect.php');

    if($_SERVER["REQUEST_METHOD"] === "POST") {
        $oldEmail = $_POST["oldEmail"];
        $newEmail = $_POST["newEmail"];
        $fullname = $_POST["fullname"];
        $birthday = $_POST["birthday"];

        if($oldEmail !== $newEmail) {
            $check = $mysqli->prepare("SELECT email FROM user WHERE email = ?");
            $check->bind_param("s", $newEmail);
            $check->execute();
            $check->store_result();
            if($check->num_rows) {
                echo '<script> alert("Đã tồn tại email. Kiểm tra lại email."); window.history.back(); </script>';
                $check->close();
                exit();   
            } $check->close();
        }

        if(empty($_POST["pwd"])) {
            $stm = $mysqli->prepare("UPDATE user SET email = ?, fullname = ?, birthday = ? WHERE email = ?");
            $stm->bind_param("ssis", $newEmail, $fullname, $birthday, $oldEmail);
        }
        else {
            $pwd = password_hash($_POST["pwd"], PASSWORD_DEFAULT);
            $stm = $mysqli->prepare("UPDATE user SET email = ?, fullname = ?, birthday = ?, pwd = ? WHERE email = ?");
            $stm->bind_param("ssis", $newEmail, $fullname, $birthday, $pwd, $oldEmail);
        }

        if($stm->execute()) {
            echo '<script> alert("Cập nhật thành công."); window.location.href="./manage_user.html"; </script>';
        }
        else {
            echo "Error.";
        }
        $stm->close();
        $mysqli->close();
    }
?>