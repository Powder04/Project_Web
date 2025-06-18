<?php
    session_start();
    require_once("../mysqlConnect.php");

    date_default_timezone_set("Asia/Ho_Chi_Minh");
    $time_order = date("Y/m/d H:m:s");
    $email = $_SESSION["email"];
    $name_customer = $_POST["name_customer"];
    $province = $_POST["province"];
    $district = $_POST["district"];
    $ward = $_POST["ward"];
    $detail_address = $_POST["detail_address"];
    $address = $detail_address.", ".$ward.", ".$district.", ".$province;
    $total_price = 0;
    for($i = 0; $i<count($_SESSION["cart"]); $i++) {
        foreach($_SESSION["cart"][$i] as $key => $value) {
            if($key === "total_price") $total_price += $value;
        }
    }

    $stm = $mysqli->prepare("INSERT INTO orders(email, order_date, total_price, address) VALUES(?, ?, ?, ?)");
    $stm->bind_param("ssis", $email, $time_order, $total_price, $address);
    $stm->execute();
    $order_id = $mysqli->insert_id;
    $stm->close();

    for($i = 0; $i<count($_SESSION["cart"]); $i++) {
        $product_id = $_SESSION["cart"][$i]["product_id"];
        $name = $_SESSION["cart"][$i]["name"];
        $quantity = $_SESSION["cart"][$i]["quantity"];
        $total_price = $_SESSION["cart"][$i]["total_price"];

        $stm = $mysqli->prepare("INSERT INTO order_detail(order_id, product_id, product_name, quantity, total_price) VALUES(?, ?, ?, ?, ?)");
        $stm->bind_param("issii", $order_id, $product_id, $name, $quantity, $total_price);
        $stm->execute();
        $stm->close();

        //Update warehouse
        $stm = $mysqli->prepare("SELECT quantity, sold_count FROM product WHERE product_id = ?");
        $stm->bind_param("s", $product_id);
        $stm->execute();
        $old_warehouse = $stm->get_result()->fetch_assoc();
        $stm->close();
        $new_quantity = $old_warehouse["quantity"] - $quantity;
        $new_sold = $old_warehouse["sold_count"] + 1;

        $update = $mysqli->prepare("UPDATE product SET quantity = ?, sold_count = ? WHERE product_id = ?");
        $update->bind_param("iis", $new_quantity, $new_sold);
        $update->execute();
        $update->close();
    }
?>