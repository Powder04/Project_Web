<?php
    $mysqli = new mysqli("127.0.0.1", "root", "", "demo");
    if($mysqli->connect_error){
        die("Kết nối thất bại. " .$mysqli->connect_error);
    }
?>