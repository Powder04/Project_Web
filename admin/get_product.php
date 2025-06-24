<?php
    require_once('../includes/mysqlConnect.php');

    $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;

    // Xử lý ORDER BY
    $orderBy = [];
    if(!empty($_POST["saleProduct"]) && $_POST["saleProduct"] !== "Không") $orderBy[] = "p.sold_count " . $_POST["saleProduct"];
    if(!empty($_POST["priceProduct"]) && $_POST["priceProduct"] !== "Không") $orderBy[] = "p.price " . $_POST["priceProduct"];
    if(empty($orderBy)) $orderBy[] = "p.product_id DESC";
    $orderBySql = " ORDER BY " . implode(", ", $orderBy);

    if(empty($_POST["typeProduct"]) || $_POST["typeProduct"] === "Tất cả") {
        $resultCount = $mysqli->query("SELECT COUNT(*) FROM product");
        $total = $resultCount->fetch_row()[0];
        $totalPages = ceil($total / $limit);

        $sql = "SELECT p.product_id, p.name, p.category, p.price, p.quantity, p.sold_count, i.mime_type, TO_BASE64(i.image_data) 
                AS image_data FROM product p
                LEFT JOIN images i ON p.product_id = i.product_id
                $orderBySql LIMIT ? OFFSET ?";

        $stm = $mysqli->prepare($sql);
        $stm->bind_param("ii", $limit, $offset);
    }
    else {
        $rs = $mysqli->prepare("SELECT COUNT(*) FROM product WHERE category = ?");
        $rs->bind_param("s", $_POST["typeProduct"]);
        $rs->execute();
        $rs->bind_result($total);
        $rs->fetch();
        $rs->close();

        $totalPages = ceil($total / $limit);

        $sql = "SELECT p.product_id, p.name, p.category, p.price, p.quantity, p.sold_count, i.mime_type, TO_BASE64(i.image_data) 
                AS image_data FROM product p
                LEFT JOIN images i ON p.product_id = i.product_id WHERE p.category = ?
                $orderBySql LIMIT ? OFFSET ?";

        $stm = $mysqli->prepare($sql);
        $stm->bind_param("sii", $_POST["typeProduct"], $limit, $offset);
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
        'total_pages' => $totalPages,
        'typeProduct' => $_POST["typeProduct"] ?? "Tất cả",
        'saleProduct' => $_POST["saleProduct"] ?? "Không",
        'priceProduct' => $_POST["priceProduct"] ?? "Không"
    ]);
?>