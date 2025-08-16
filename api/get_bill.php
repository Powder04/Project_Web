<?php
    require_once('../includes/mysqlConnect.php');
    session_start();

    $page = isset($_POST["page"]) ? (int)$_POST['page'] : 1;
    $limit = 5;
    $offset = ($page - 1) * $limit;
    $email = $_SESSION["email"];

    $stm = $mysqli->prepare("SELECT COUNT(*) FROM orders WHERE email = ?");
    $stm->bind_param("s", $email);
    $stm->execute();
    $row = $stm->get_result()->fetch_row()[0];
    $totalPages = ceil($row / $limit);
    $stm->close();

    $sql = "SELECT * FROM orders WHERE email = ? ORDER BY order_date DESC LIMIT ? OFFSET ?";
    $stm = $mysqli->prepare($sql);
    $stm->bind_param("sii", $email, $limit, $offset);
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