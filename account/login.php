<?php
    session_start();
    require_once('../mysqlConnect.php');

    $email = $_POST['email'];
    $pwd = $_POST['pwd'];

    // Lấy thông tin người dùng theo email
    $stm = $mysqli->prepare('SELECT * FROM customer WHERE email = ?');
    $stm->bind_param('s', $email);
    $stm->execute();
    $rs = $stm->get_result();

    if ($rs->num_rows > 0) {
        $customer = $rs->fetch_assoc();

        // So sánh mật khẩu nhập vào với mật khẩu đã hash trong DB
        password_verify($pwd, $customer['pwd']);
        $_SESSION['login'] = true;
        $_SESSION['email'] = $customer['email'];

        if ($customer['email'] !== 'adminkyu03') {
            header("Location: ../display/main.html");
        } else {
            header("Location: ../admin/admin.html");
        }
        exit();
    } else {
        // Không tìm thấy email
        echo "<script>alert('Đăng nhập thất bại do sai tên đăng nhập hoặc mật khẩu.'); window.history.back(); </script>";
    }

    $stm->close();
    $mysqli->close();
?>