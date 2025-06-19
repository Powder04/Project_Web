<?php
//thêm time đăng ký
    require_once('../includes/mysqlConnect.php');

    //Lấy dữ liệu từ form
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $birthday = $_POST['birthday'];
    $pwd = $_POST['pwd'];
    date_default_timezone_set("Asia/Ho_Chi_Minh");
    $time_register = date("Y/m/d H:m:s");

    //Kiểm tra cú pháp email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script> alert('Email không hợp lệ.'); window.history.back(); </script>";
        exit;
    }

    //Kiểm tra domain email có MX record (mail server)
    list($user, $domain) = explode('@', $email);
    if (!checkdnsrr($domain, 'MX')) {
        echo "<script> alert('Tên miền email không có máy chủ mail.'); window.history.back(); </script>";
        exit;
    }

    //Kiểm tra email có thật sự tồn tại qua MailboxLayer API
    $access_key = '63ec847456ad6bbca7e9ffdb5a0a2577'; //API key trên MailboxLayer
    $emailToVerify = urlencode($email);
    $url = "http://apilayer.net/api/check?access_key={$access_key}&email={$emailToVerify}&smtp=1&format=1";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);

    //Kiểm tra kết quả trả về
    if ($data['format_valid'] != 1 || $data['smtp_check'] != 1) {
        echo "<script> alert('Email không hợp lệ hoặc không tồn tại.'); window.history.back(); </script>";
        exit;
    }

    //Kiểm tra email đã tồn tại trong database chưa
    $checkEmail = $mysqli->prepare('SELECT * FROM customer WHERE email = ?');
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
    $stm = $mysqli->prepare('INSERT INTO customer(email, fullname, birthday, pwd, created_at) VALUES(?, ?, ?, ?, ?)');
    $stm->bind_param("ssiss", $email, $fullname, $birthday, $encrypt_pwd, $time_register);
    $stm->execute();
    $stm->close();

    //Thông báo thành công
    echo "<script> alert('Đăng ký thành công.'); window.location.href = '../pages/login.html'; </script>";
?>
