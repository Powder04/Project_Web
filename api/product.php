<?php
    require_once('../includes/mysqlConnect.php');

    $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
    $limit = 20;
    $offset = ($page - 1) * $limit;

    $orderBy = [];
    if (!empty($_POST["sale"]) && $_POST["sale"] !== "Không") $orderBy[] = "p.sold_count " . $_POST["sale"];
    if (!empty($_POST["price"]) && $_POST["price"] !== "Không") $orderBy[] = "p.price " . $_POST["price"];

    if (empty($orderBy)) $orderBy[] = "p.product_id DESC";
    
    $orderBySql = " ORDER BY " . implode(", ", $orderBy);

    if (empty($_POST["type"]) || $_POST["type"] === "Tất cả") {
        // Đếm tổng số
        $rs = $mysqli->query("SELECT COUNT(*) FROM product WHERE quantity > 0");
        $total = $rs->fetch_row()[0];
        $total_pages = ceil($total / $limit);

        $sql = "SELECT p.product_id, p.name, p.price, p.quantity, p.sold_count, i.mime_type, TO_BASE64(i.image_data) 
                AS image_data FROM product p
                LEFT JOIN images i ON p.product_id = i.product_id
                WHERE p.quantity > 0 $orderBySql LIMIT ? OFFSET ?";
        $stm = $mysqli->prepare($sql);
        $stm->bind_param("ii", $limit, $offset);
    } 
    else {
        $type = $_POST["type"];
        $rs = $mysqli->prepare("SELECT COUNT(*) FROM product WHERE category = ? AND quantity > 0");
        $rs->bind_param("s", $type);
        $rs->execute();
        $rs->bind_result($total);
        $rs->fetch();
        $rs->close();

        $total_pages = ceil($total / $limit);
        
        $sql = "SELECT p.product_id, p.name, p.price, p.quantity, p.sold_count, i.mime_type, TO_BASE64(i.image_data) 
                AS image_data FROM product p
                LEFT JOIN images i ON p.product_id = i.product_id
                WHERE p.quantity > 0 AND p.category = ?
                $orderBySql LIMIT ? OFFSET ?";
        $stm = $mysqli->prepare($sql);
        $stm->bind_param("sii", $type, $limit, $offset);
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
        'data' => $data,
        'page' => $page,
        'limit' => $limit,
        'total_pages' => $total_pages,
        'type' => $_POST["type"] ?? "Tất cả",
        'sale' => $_POST["sale"] ?? "Không",
        'price' => $_POST["price"] ?? "Không"
    ]);
?>