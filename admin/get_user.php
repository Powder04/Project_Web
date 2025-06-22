<?php
    require_once('../includes/mysqlConnect.php');

    $page = isset($_POST["page"]) ? (int)$_POST['page'] : 1;
    $limit = 5;
    $offset = ($page - 1) * $limit;

    $result = $mysqli->query("SELECT COUNT(*) FROM user");
    $row = $result->fetch_row()[0];
    $totalPages = ceil($row / $limit);
    $result->free_result();

    $stm = $mysqli->prepare("SELECT * FROM user ORDER BY created_at DESC LIMIT ? OFFSET ?");
    $stm->bind_param("ii", $limit, $offset);
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