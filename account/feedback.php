<?php
    require_once("../includes/mysqlConnect.php");

    session_start();
    date_default_timezone_set("Asian/Ho_Chi_Minh");
    $time = date("Y/m/d H:m:s");
    $email = $_SESSION["email"];
    $msg = $_POST["msg"];

    $stm = $mysqli->prepare("INSERT INTO feedback(email, message, submitted_at) VALUES(?, ?, ?)");
    $stm->bind_param("sss", $email, $msg, $time);
    $stm->execute();
    $stm->close();

    echo '<script> alert("Cảm ơn quý khách đã gửi góp ý."); window.location.href="../pages/index.php"; </script>';
?>