<?php
    require_once("../includes/mysqlConnect.php");

    $stm = $mysqli->query("SELECT p.product_id, p.name, p.price, i.mime_type, TO_BASE64(i.image_data) 
                            AS image_data FROM product p
                            LEFT JOIN images i ON p.product_id = i.product_id
                            ORDER BY p.sold_count LIMIT 12");
    $data = [];
    while($row = $stm->fetch_assoc()) {
        $data[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($data, JSON_UNESCAPED_UNICODE); //JSON_UNESCAPED_UNICODE => giữ nguyên tiếng Việt, không mã hóa Unicode
?>