<?php
    require_once("../includes/mysqlConnect.php");

    $order_id = $_POST["order_id"];
    $data_order = null;
    $data_detail = [];

    $stm = $mysqli->prepare("SELECT * FROM orders WHERE id = ?");
    $stm->bind_param("i", $order_id);
    $stm->execute();
    $result = $stm->get_result();
    if ($row = $result->fetch_assoc()) {
        $data_order = $row;
    }
    $stm->close();

    $stm = $mysqli->prepare("SELECT od.order_id, od.product_id, od.product_name, od.quantity, od.total_price,
                                    i.filename, i.mime_type, TO_BASE64(i.image_data) AS image_data
                             FROM order_detail od
                             LEFT JOIN images i ON od.product_id = i.product_id
                             WHERE od.order_id = ?");
    $stm->bind_param("i", $order_id);
    $stm->execute();
    $result = $stm->get_result();
    while ($row = $result->fetch_assoc()) {
        $data_detail[] = $row;
    }
    $stm->close();
    $mysqli->close();

    header('Content-Type: application/json');
    echo json_encode([
        "data_order" => $data_order,
        "data_detail" => $data_detail
    ]);
?>