<?php
    require_once('../includes/mysqlConnect.php');

    $page = isset($_POST["page"]) ? (int)$_POST['page'] : 1;
    $limit = 5;
    $offset = ($page - 1) * $limit;
    $role = isset($_POST["role"]) ? trim($_POST["role"]) : null;

    $where = "";
    $type = "";
    $params = [];
    if($role !== null) {
        $where = "WHERE role = ?";
        $type = "s";
        $params[] = $role;
    }

    $sql = "SELECT COUNT(*) FROM user $where";
    $result = $mysqli->prepare($sql);

    if($role !== null) $result->bind_param($type, ...$params);

    $result->execute();
    $total_rows = $result->get_result()->fetch_row()[0];
    $totalPages = ceil($total_rows / $limit);
    $result->close();

    $sql = "SELECT * FROM user $where ORDER BY created_at DESC LIMIT ? OFFSET ?";
    $stm = $mysqli->prepare($sql);
    if($role !== null) {
        $type .= "ii";
        $params[] = $limit;
        $params[] = $offset;
        $stm->bind_param($type, ...$params);
    } 
    else $stm->bind_param("ii", $limit, $offset);
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