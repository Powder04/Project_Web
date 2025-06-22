<?php
    require_once('../includes/mysqlConnect.php');

    $order_status = $_POST["order_status"];
    $order_id = $_POST["order_id"];

    $stm = $mysqli->prepare("UPDATE orders SET order_status = ? WHERE id = ?");
    $stm->bind_param("si", $order_status, $order_id);
    $stm->execute();
    $stm->close();
    $mysqli->close();

    echo '<script> alert("Thay đổi trạng thái đơn hàng thành công."); window.history.back(); </script>'
?>