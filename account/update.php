<?php
session_start();
require_once('../mysqlConnect.php');
$mysqli->select_db('project');

$email = $_SESSION['email'];
$fullname = $_POST["fullname"];
$birthday = $_POST["birthday"];
$pwd = $_POST['pwd'];
$newpwd_plain = $_POST['newpwd'];

if (empty($pwd)) {
    $stm = $mysqli->prepare("UPDATE customer SET fullname = ?, birthday = ? WHERE email = ?");
    $stm->bind_param("sss", $fullname, $birthday, $email);
    $stm->execute();
    echo "<script> alert('Thay đổi thông tin thành công.'); window.location.href = './show_information.php'; </script>";
    $stm->close();
    exit;
} else {
    $check = $mysqli->prepare('SELECT pwd FROM customer WHERE email = ?');
    $check->bind_param('s', $email);
    $check->execute();
    $res = $check->get_result();
    $old_pwd = $res->fetch_assoc();

    if (!password_verify($pwd, $old_pwd['pwd'])) {
        echo "<script> alert('Mật khẩu hiện tại không đúng.'); window.history.back(); </script>";
        exit;
    }

    if (empty($newpwd_plain)) {
        echo "<script> alert('Vui lòng nhập mật khẩu mới.'); window.history.back(); </script>";
        exit;
    }

    $newpwd = password_hash($newpwd_plain, PASSWORD_DEFAULT);
    $stm = $mysqli->prepare("UPDATE customer SET fullname = ?, birthday = ?, pwd = ? WHERE email = ?");
    $stm->bind_param("ssss", $fullname, $birthday, $newpwd, $email);
    $stm->execute();
    echo "<script>alert('Thay đổi thông tin thành công.');window.location.href = './show_information.php';</script>";
    $stm->close();
    exit;
}
?>
