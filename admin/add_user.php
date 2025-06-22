<?php
    require_once('../includes/mysqlConnect.php');

    $fullname = $_POST['fullname'];
    $email = $_POST['newEmail'];
    $birthday = $_POST['birthday'];
    $pwd = $_POST['pwd'];
    date_default_timezone_set("Asia/Ho_Chi_Minh");
    $time = date("Y/m/d H:m:s");

    //Kiểm tra email đã tồn tại trong database chưa
    $checkEmail = $mysqli->prepare('SELECT * FROM user WHERE email = ?');
    $checkEmail->bind_param('s', $email);
    $checkEmail->execute();
    $rs_checkemail = $checkEmail->get_result();

    if ($rs_checkemail->num_rows > 0) {
        echo "<script> alert('Email đã tồn tại. Vui lòng chọn email khác.'); window.history.back(); </script>";
        $checkEmail->close();
        exit;
    }
    $checkEmail->close();

    //Mã hoá mật khẩu + lưu vào database
    $encrypt_pwd = password_hash($pwd, PASSWORD_DEFAULT); 
    $stm = $mysqli->prepare('INSERT INTO user(email, fullname, birthday, pwd, created_at) VALUES(?, ?, ?, ?, ?)');
    $stm->bind_param("ssiss", $email, $fullname, $birthday, $encrypt_pwd, $time);
    $stm->execute();
    $stm->close();

    //Thông báo thành công
    echo "<script> alert('Thêm người dùng thành công.'); window.location.href = './manage_user.html'; </script>";
?>