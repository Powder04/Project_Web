<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Góp ý</title>
    <link rel="icon" href="../assets/images/icon.png">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <style>
        header {
            height: 70px;
            width: 100vw;
            padding: 0 5px;
            position: fixed;
            z-index: 100;
            box-shadow: 1px 1px 15px rgba(115, 255, 111, 0.825);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: white;
        }
    </style>
</head>
<body>
    <header>
        <article class="navbar">
            <img src="../assets/images/logoname.png" style="width: 240px; height: 60px; margin-left: 5px;" usemap="#home">
            <map name="home">
                <area shape="rect" coords="0 0 943 263" href="./index.php">
            </map>
            <nav>
                <a href="./index.php">Trang chủ</a>
                <a href="./show_information.php">Thông tin khách hàng</a>
                <a href="./get_information.php">Cập nhật thông tin</a>
                <a href="./show_product.php">Sản phẩm</a>
                <a href="./buy_product.php" id="cart-icon" onmouseenter="showCartDropdown()" onmouseleave="hideCartDropdown()" style="margin-right: 15px;">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <div id="cart-dropdown" onmouseenter="cancelHide()" onmouseleave="hideCartDropdown()"></div>
                </a>
                <a href="../includes/logout.php" style="background-color: rgb(40, 167, 69); border: 1px solid rgb(40, 167, 69); padding: 10px 20px; text-decoration: none; color: white; margin-right: 20px;">Đăng xuất</a>
            </nav>
        </article>
    </header>
    <main style="margin: 0px 5px;" class="container">
        <fieldset>
            <h1 class="heading">Thông tin góp ý</h1>
            <form action="../account/feedback.php" method="post">
                <article class="account">
                    <label class="lab">Địa chỉ email: </label>
                    <input class="inpt" type="email" value="<?php session_start(); echo $_SESSION["email"]; ?>" disabled>
                </article>
                <article class="account">
                    <label class="lab" for="msg">Thông điệp: </label>
                    <textarea name="msg" class="inpt" rows="5" cols="50" placeholder="Nhập góp ý của bạn ở đây ..."></textarea>
                </article>
                <article class="account btn-account" style="margin-bottom: 20px;">
                    <button type="reset" class="btn btn-1">Xóa</button>
                    <button type="submit" class="btn btn-2">Gửi</button>
                </article>
            </form>
        </fieldset>
    </main>
    <script src="../assets/javascript/product.js"></script>
</body>
</html>