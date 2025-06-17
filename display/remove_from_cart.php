<?php
    session_start();
    $index = $_POST['index'] ?? -1;
    if ($index >= 0 && isset($_SESSION["cart"][$index])) {
        array_splice($_SESSION["cart"], $index, 1);
    }
    echo json_encode(["status" => "removed"]);
?>