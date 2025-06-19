<?php
    session_start();

    $response = ['login' => false];

    if (isset($_SESSION['email'])) {
        $response['login'] = true;
        $response['email'] = $_SESSION['email'];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
?>