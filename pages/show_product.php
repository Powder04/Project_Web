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
    <style>
        body {
            max-width: 100%;
            overflow-x: hidden;
        }
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
        }
    </style>
</head>
<body>
    <header style="background-color: white;">
        <article class="navbar">
            <img src="../assets/images/logoname.png" style="width: 240px; height: 60px; margin-left: 5px;" usemap="#home">
            <map name="home">
                <area shape="rect" coords="0 0 943 263" href="./index.php">
            </map>
            <nav>
                <a href="./index.php">Trang chủ</a>
                <?php
                    session_start();
                    if(isset($_SESSION["login"]) && $_SESSION["login"] === true && $_SESSION["role"] === "user") echo '
                    <a href="./show_information.php">Thông tin khách hàng</a>
                    <a href="./get_information.php">Cập nhật thông tin</a>
                    <a href="./inquiry.php">Góp ý</a>';
                ?>  
                <a <?php if(isset($_SESSION["login"]) && $_SESSION["login"] === true && $_SESSION["role"] === "user") echo 'href="./buy_product.php"';
                         else echo 'href="./login.html"'; ?> id="cart-icon" onmouseenter="showCartDropdown()" onmouseleave="hideCartDropdown()" style="margin-right: 15px;">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <div id="cart-dropdown" onmouseenter="cancelHide()" onmouseleave="hideCartDropdown()"></div>
                </a>
                <?php
                    if(isset($_SESSION["login"]) && $_SESSION["login"] === true && $_SESSION["role"] === "user") echo '
                    <a href="../includes/logout.php" style="background-color: rgb(40, 167, 69); border: 1px solid rgb(40, 167, 69); padding: 10px 20px; text-decoration: none; color: white; margin-right: 5px;">Đăng xuất</a>';
                    else echo '<a href="./login.html" style="background-color: white; border: 1px solid rgb(40, 167, 69); padding: 10px 20px; text-decoration: none; color: rgb(40, 167, 69); margin-right: 5px;">Đăng nhập</a>';
                ?>
            </nav>
        </article>
    </header>
    <main style="margin: 0px 5px;" class="main-product">
        <div class="hero-container">
            <div style="margin-top: 30px; margin-left: auto; display: flex;">
                <label style="margin: 2px 5px 0 0;" for="typeProduct">Loại sản phẩm: </label>
                <select id="typeProduct" name="typeProduct" onchange="fetchProduct(1)" style="padding: 3px; margin-right: 15px;">
                    <option value="Tất cả" selected>Tất cả</option>
                    <option value="Balo">Balo</option>
                    <option value="Móc khóa">Móc khóa</option>
                    <option value="Phụ kiện tóc">Phụ kiện tóc</option>
                    <option value="Túi">Túi</option>
                    <option value="Combo">Combo</option>
                    <option value="Khác">Khác</option>
                </select>
                <label style="margin: 2px 5px 0 0;" for="saleProduct">Lượt bán: </label>
                <select name="sale" id="saleProduct" onchange="fetchProduct(1)" style="padding: 3px; margin-right: 15px;">
                    <option value="Không" selected>Không</option>
                    <option value="ASC">Thấp đến cao</option>
                    <option value="DESC">Cao đến thấp</option>
                </select>
                <label style="margin: 2px 5px 0 0;" for="price">Giá bán: </label>
                <select name="price" id="priceProduct" onchange="fetchProduct(1)" style="padding: 3px;">
                    <option value="Không" selected>Không</option>
                    <option value="ASC">Thấp đến cao</option>
                    <option value="DESC">Cao đến thấp</option>
                </select>
            </div>
            <div class="hero-container1"></div>
            <div id="pagination-product"></div>
        </div>
    </main>
    <footer style="margin: 70px 5px 0px 5px;">
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
</body>
</html>