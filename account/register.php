<?php
    require_once("../mysqlConnect.php");
    $mysqli->select_db("project");

    function insert_customer($fullname, $username, $email, $pwd, $birth, $mysqli) {
        $encrypt_pwd = password_hash($pwd, PASSWORD_DEFAULT); 
        $stm = $mysqli->prepare("INSERT INTO customer(email, fullname, birthday, username, pwd) VALUES (?, ?, ?, ?, ?)");
        $stm->bind_param("sssss", $email, $fullname, $birth, $username, $encrypt_pwd);
        
        if($stm->execute()){
            header("Location: ./login.html");
            exit();
        } else {
            echo "Lỗi đăng ký: " . $stm->error;
        }

        $stm->close();
    }

    insert_customer($_POST["fullname"], $_POST['username'], $_POST["email"], $_POST["pwd"], $_POST["birthday"], $mysqli);
?>
