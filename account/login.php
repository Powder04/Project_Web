<?php
    session_start();
    require_once('../mysqlConnect.php');

    $username = $_POST['username'];
    $pwd = $_POST['pwd'];

    // Lấy thông tin người dùng theo username
    $stm = $mysqli->prepare('SELECT * FROM customer WHERE username = ?');
    $stm->bind_param('s', $username);
    $stm->execute();
    $rs = $stm->get_result();

    if ($rs->num_rows > 0) {
        $customer = $rs->fetch_assoc();

        // So sánh mật khẩu nhập vào với mật khẩu đã hash trong DB
        if (password_verify($pwd, $customer['pwd'])) {
            $_SESSION['login'] = true;
            $_SESSION['username'] = $customer['username'];

            if ($customer['username'] !== 'adminkyu03') {
                header("Location: ../display/main.html");
            } else {
                header("Location: ../admin/admin.html");
            }
            exit();
        } else {
            // Mật khẩu sai
            echo "<script>alert('Đăng nhập thất bại do sai mật khẩu.'); window.location.href = './login.html';</script>";
        }
    } else {
        // Không tìm thấy username
        echo "<script>alert('Đăng nhập thất bại do sai tên đăng nhập.'); window.location.href = './login.html';</script>";
    }

    $stm->close();
    $mysqli->close();
?>