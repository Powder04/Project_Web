<?php
    require_once('../includes/mysqlConnect.php');

    $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;

    $resultCount = $mysqli->query("SELECT COUNT(*) FROM product");
    $total = $resultCount->fetch_row()[0];
    $totalPages = ceil($total / $limit);

    $sql = "SELECT p.product_id, p.name, p.category, p.price, p.quantity, p.sold_count, i.mime_type, TO_BASE64(i.image_data) 
            AS image_data FROM product p
            LEFT JOIN images i ON p.product_id = i.product_id
            ORDER BY p.product_id DESC LIMIT ? OFFSET ?";

    $stm = $mysqli->prepare($sql);
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
        'data' => $data,
        'page' => $page,
        'limit' => $limit,
        'total_pages' => $totalPages
    ]);
?>