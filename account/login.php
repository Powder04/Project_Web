<?php
    session_start();
    require_once('../includes/mysqlConnect.php');

    $email = $_POST['email'];
    $pwd = $_POST['pwd'];

    $stm = $mysqli->prepare('SELECT * FROM customer WHERE email = ?');
    $stm->bind_param('s', $email);
    $stm->execute();
    $rs = $stm->get_result();

    if ($rs->num_rows > 0) {
        $customer = $rs->fetch_assoc();
        if (password_verify($pwd, $customer['pwd'])) {
            $_SESSION['login'] = true;
            $_SESSION['email'] = $customer['email'];

            if ($customer['role'] !== 'admin') {
                echo '<script> alert("Đăng nhập thành công."); window.location.href="../pages/main.html"; </script>';
            } else {
                echo '<script> alert("Đăng nhập thành công. Chào admin!"); window.location.href="../admin/index.html"; </script>';
            }
            exit();
        }
    }

    echo "<script>alert('Thông tin đăng nhập không đúng.'); window.history.back(); </script>";

    $stm->close();
    $mysqli->close();
?>