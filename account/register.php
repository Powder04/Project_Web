<?php
    require_once('../mysqlConnect.php');
    $mysqli->select_db("project");

    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $birthday = $_POST['birthday'];
    $username = $_POST['username'];
    $pwd = $_POST['pwd'];

    $checkEmail = $mysqli->prepare('SELECT * FROM customer WHERE email = ?');
    $checkEmail->bind_param('s', $email);
    $checkEmail->execute();
    $rs_checkemail = $checkEmail->get_result();
    if($rs_checkemail->num_rows > 0) {
        echo "<script>alert('Email đã tồn tại. Vui lòng chọn email khác.'); window.location.href = './register.html';</script>";
        $checkEmail->close();
    }

    else {
        $checkUsername = $mysqli->prepare('SELECT * FROM customer WHERE username = ?');
        $checkUsername->bind_param('s', $username);
        $checkUsername->execute();
        $rs_checkusername = $checkUsername->get_result();
        if($rs_checkusername->num_rows > 0) {
            echo "<script>alert('Tên đăng nhập đã tồn tại.'); window.location.href = './register.html';</script>";
            $checkUsername->close();
        }

        else {
            $encrypt_pwd = password_hash($pwd, PASSWORD_DEFAULT); 
            $stm = $mysqli->prepare('INSERT INTO customer(email, fullname, birthday, username, pwd) VALUES(?, ?, ?, ?, ?)');
            $stm->bind_param("ssiss", $email, $fullname, $birthday, $username, $encrypt_pwd);
            $stm->execute();
            echo "<script>alert('Đăng ký thành công.'); window.location.href = './login.html';</script>";
            $stm->close();
        }
    }
?>