<?php
    require_once("../includes/mysqlConnect.php");

    $stm = $mysqli->query("SELECT * FROM product ORDER BY sold_count DESC LIMIT 12");
    $data = [];
    while($row = $stm->fetch_assoc()) {
        $data[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($data, JSON_UNESCAPED_UNICODE); //JSON_UNESCAPED_UNICODE => giữ nguyên tiếng Việt, không mã hóa Unicode
?>