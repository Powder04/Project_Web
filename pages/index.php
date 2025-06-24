<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link rel="icon" href="../assets/images/icon.png">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
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
                <?php
                    session_start();
                    if(isset($_SESSION["login"]) && $_SESSION["login"] === true) echo '
                    <a href="./show_information.php">Thông tin khách hàng</a>
                    <a href="./get_information.php">Cập nhật thông tin</a>
                    <a href="./inquiry.php">Góp ý</a>';
                ?>
                <a href="./show_product.php">Sản phẩm</a>
                <?php
                    if(isset($_SESSION["login"]) && $_SESSION["login"] === true) echo '
                    <a href="./buy_product.php" id="cart-icon" onmouseenter="showCartDropdown()" onmouseleave="hideCartDropdown()"
                        style="margin-right: 15px;"><i class="fa-solid fa-cart-shopping"></i>
                        <div id="cart-dropdown" onmouseenter="cancelHide()" onmouseleave="hideCartDropdown()"></div>
                    </a>
                    <a href="../includes/logout.php" style="background-color: rgb(40, 167, 69); border: 1px solid rgb(40, 167, 69); padding: 10px 20px; text-decoration: none; color: white; margin-right: 5px;">Đăng xuất</a>';
                    else echo '<a href="./login.html" style="background-color: white; border: 1px solid rgb(40, 167, 69); padding: 10px 20px; text-decoration: none; color: rgb(40, 167, 69); margin-right: 5px;">Đăng nhập</a>';
                ?>
            </nav>
        </article>
        <article style="margin: 0px 5px;">
            <img src="../assets/images/background.png" style="height: 720px; width: 100%;">
        </article>
    </header>
    <main style="margin: 0px 5px;" >
        <article>
            <section class="hero">
                <div class="hero-content hero-content-1">
                    <img src="../uploads/HA001.jpg">
                    <h1>Phụ kiện tóc</h1>
                </div>
                <div class="hero-content hero-content-1">
                    <img src="../uploads/B007.jpg">
                    <h1>Túi đựng AirPods</h1>
                </div>
                <div class="hero-content hero-content-1">
                    <img src="../uploads/KC002.jpg">
                    <h1>Móc Khóa</h1>
                </div>
            </section>
        </article>
        <article>
            <section>
                <div class="container-title">
                    <h3 class="section-title">
                        <b></b><span>Sản phẩm nổi bật</span><b></b>
                    </h3>
                </div>
                <div class="hero" id="top_product"></div>
            </section>
        </article>
    </main>
    <footer>
        <article style="margin-left: 5px;">
            <h3>Mạng xã hội</h3>
            <article>
                <a href="https://www.facebook.com/people/Ti%E1%BB%87m-len-c%E1%BB%A7a-Kyu/61576619864144/"><i class="fa-brands fa-facebook"></i> Facebook</a>
                <br>
                <a href="https://www.instagram.com/"><i class="fa-brands fa-instagram"></i> Instagram</a>
                <br>
                <a href="https://www.youtube.com/@Kiiv_1112"><i class="fa-brands fa-youtube"></i> YouTube</a>
            </article>
        </article> 
        <article>
            <h3>Thông tin liên lạc</h3>
            <article>
                <p><i class="fa-solid fa-phone-volume"></i> +84 985 722 359</p>
                <p><i class="fa-solid fa-envelope"></i> tiemlencuakyu@gmail.com</p>
                <p><i class="fa-solid fa-location-dot"></i> 32, đường số 9, phường A, quận B, thành phố C</p>
            </article>
        </article>
        <article style="margin-right: 5px;" class="payment">
            <h3>Phương thức thanh toán</h3>
            <i class="fa-solid fa-money-bill"></i>
            <i class="fa-solid fa-credit-card"></i>
            <i class="fa-brands fa-cc-visa"></i>
            <i class="fa-brands fa-cc-amazon-pay"></i>
            <i class="fa-brands fa-cc-jcb"></i>
        </article>
    </footer>
    <script src="../assets/javascript/product.js"></script>
    <script src="../assets/javascript/push_top_product.js"></script>
</body>
</html>