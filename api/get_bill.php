<?php
    require_once('../includes/mysqlConnect.php');

    $page = isset($_POST["page"]) ? (int)$_POST['page'] : 1;
    $limit = 5;
    $offset = ($page - 1) * $limit;
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : null;
    $status = isset($_POST["status"]) ? trim($_POST["status"]) : null;

    $where = [];
    $types = "";
    $params = [];
    if($email) {
        $where[] = "email = ?";
        $types .= "s";
        $params[] = $email;
    }
    if($status && $status !== "Tất cả") {
        $where[] = "order_status = ?";
        $types .= "s";
        $params[] = $status;
    }
    $whereSQL = "";
    if(!empty($where)) {
        $whereSQL = "WHERE " . implode(" AND ", $where);
    }

    $sql_count = "SELECT COUNT(*) FROM orders $whereSQL";
    $stm = $mysqli->prepare($sql_count);
    if(!empty($params)) {
        $stm->bind_param($types, ...$params);
    }
    $stm->execute();
    $row = $stm->get_result()->fetch_row()[0];
    $totalPages = ceil($row / $limit);
    $stm->close();

    $sql = "SELECT * FROM orders $whereSQL ORDER BY order_date DESC LIMIT ? OFFSET ?";
    $stm = $mysqli->prepare($sql);

    if(!empty($params)) {
        $types .= "ii";
        $params[] = $limit;
        $params[] = $offset;
        $stm->bind_param($types, ...$params);
    } else {
        $stm->bind_param("ii", $limit, $offset);
    }

    $stm->execute();
    $result = $stm->get_result();
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    $stm->close();
    $mysqli->close();

    header('Content-Type: application/json');
    echo json_encode([
        "data" => $data,
        "page" => $page,
        "limit" => $limit,
        "total_pages" => $totalPages
    ]);
?>