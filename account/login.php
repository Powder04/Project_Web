<?php
// Đăng nhập
    session_start();
    require_once('../includes/mysqlConnect.php');

    $email = $_POST['email'];
    $pwd = $_POST['pwd'];

    $stm = $mysqli->prepare('SELECT * FROM user WHERE email = ?');
    $stm->bind_param('s', $email);
    $stm->execute();
    $rs = $stm->get_result();

    if($rs->num_rows > 0) {
        $customer = $rs->fetch_assoc();
        if(password_verify($pwd, $customer['pwd'])) {
            if($customer["status"] === 1) {
                $_SESSION['login'] = true;
                $_SESSION['email'] = $customer['email'];
                $_SESSION["role"] = $customer['role'];
                
                if($customer['role'] !== 'admin') {
                    echo '<script> alert("Đăng nhập thành công."); window.location.href="../pages/index.php"; </script>';
                } else {
                    echo '<script> alert("Đăng nhập thành công. Chào admin!"); window.location.href="../admin/index.php"; </script>';
                }
                exit();
            }
            else {
                echo "<script>alert('Tài khoản đã bị khóa.'); window.history.back(); </script>";
                exit();
            }
        }
    }
    
    echo "<script>alert('Thông tin đăng nhập không đúng.'); window.history.back(); </script>";

    $stm->close();
    $mysqli->close();
?>