<?php
    require_once('../mysqlConnect.php');
    $mysqli->select_db("project");

    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $birthday = $_POST['birthday'];
    $pwd = $_POST['pwd'];

    $checkEmail = $mysqli->prepare('SELECT * FROM customer WHERE email = ?');
    $checkEmail->bind_param('s', $email);
    $checkEmail->execute();
    $rs_checkemail = $checkEmail->get_result();
    if($rs_checkemail->num_rows > 0) {
        echo "<script>alert('Email đã tồn tại. Vui lòng chọn email khác.'); window.history.back();</script>";
        $checkEmail->close();
    }
    else {
        $encrypt_pwd = password_hash($pwd, PASSWORD_DEFAULT); 
        $stm = $mysqli->prepare('INSERT INTO customer(email, fullname, birthday, pwd) VALUES(?, ?, ?, ?)');
        $stm->bind_param("ssis", $email, $fullname, $birthday, $encrypt_pwd);
        $stm->execute();
        echo "<script>alert('Đăng ký thành công.'); window.location.href = './login.html';</script>";
        $stm->close();
    }
?>