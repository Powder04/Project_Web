<?php
    require_once('../includes/mysqlConnect.php');

    $page = isset($_POST["page"]) ? (int)$_POST['page'] : 1;
    $limit = 5;
    $offset = ($page - 1) * $limit;
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : null;

    $where = "";
    $types = "";
    $params = [];

    if ($email) {
        $where = "WHERE email = ?";
        $types = "s";
        $params[] = $email;
    }

    $sql_count = "SELECT COUNT(*) FROM orders $where";
    $stm = $mysqli->prepare($sql_count);
    if ($email) $stm->bind_param($types, ...$params);
    $stm->execute();
    $row = $stm->get_result()->fetch_row()[0];
    $totalPages = ceil($row / $limit);
    $stm->close();

    $sql = "SELECT * FROM orders $where ORDER BY order_date DESC LIMIT ? OFFSET ?";
    $stm = $mysqli->prepare($email
        ? "SELECT * FROM orders WHERE email = ? ORDER BY order_date DESC LIMIT ? OFFSET ?"
        : "SELECT * FROM orders ORDER BY order_date DESC LIMIT ? OFFSET ?"
    );

    if ($email) {
        $stm->bind_param("sii", $email, $limit, $offset);
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