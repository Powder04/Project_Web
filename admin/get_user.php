<?php
    require_once("../mysqlConnect.php");

    $page = isset($_POST["page"]) ? (int)$_POST['page'] : 1;
    $limit = 5;
    $offset = ($page - 1) * $limit;

    $email = "adminkyu03@gmail.com";
    $stm = $mysqli->prepare("SELECT COUNT(*) FROM customer WHERE email <> ?");
    $stm->bind_param("s", $email);
    $stm->execute();
    $row = $stm->get_result()->fetch_row()[0];
    $totalPages = ceil($row / $limit);
    $stm->close();

    $stm = $mysqli->prepare("SELECT email, fullname, birthday, total_bill FROM customer WHERE email <> ?");
    $stm->bind_param("s", $email);
    $stm->execute();
    $rs = $stm->get_result();

    $data = [];
    while($row = $rs->fetch_assoc()) {
        $data[] = $row;
    }

    $stm->close();
    $mysqli->close();

    echo json_encode([
        "data" => $data,
        "page" => $page,
        "limit" => $limit,
        "total_pages" => $totalPages
    ]);
?>