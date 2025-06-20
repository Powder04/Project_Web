<?php
    $mysqli = new mysqli("127.0.0.1", "root", "", "project");
    if($mysqli->connect_error){
        die("Kết nối thất bại. " .$mysqli->connect_error);
    }
?>