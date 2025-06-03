<?php
    session_start();
    session_destroy();
    header("Location: ../display/index.html");
?>