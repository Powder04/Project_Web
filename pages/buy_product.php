<!DOCTYPE html>
<html lang="en">
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng</title>
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
            background-color: white;
            position: fixed;
            z-index: 100;
            box-shadow: 1px 1px 15px rgba(115, 255, 111, 0.825);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        form .inf {
            display: block;
            margin-bottom: 5px;
        }
        .main-product {
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        #pay, #pay button {
            margin-top: 20px;
            float: right;
        }
        #pay button {
            background-color: rgb(40, 167, 69);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
        }
        select {
            padding: 5px;
            width: 55%;
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
                <a href="./inquiry.php">Góp ý</a>
                <a href="../account/logout.php" style="background-color: rgb(40, 167, 69); border: 1px solid rgb(40, 167, 69); padding: 10px 20px; text-decoration: none; color: white; margin-right: 5px;">Đăng xuất</a>
            </nav>
        </article>
    </header>
    <main style="margin: 0px 5px;" class="main-product">
        <form action="../account/buy.php" method="post" style="display: flex; width: 1300px; background-color: white;">
            <div class="hero-container inf" style="flex: 1; padding: 20px;">
                <h1 style="text-align: center;">Thông tin đặt hàng</h1>
                <div class="account" style="margin-top: 30px;">
                    <label class="lab" for="email">Địa chỉ email: </label>
                    <input name="email" class="inpt" value="<?php session_start(); echo $_SESSION['email']; ?>" disabled>
                </div>
                <div class="account">
                    <label class="lab" for="name_customer">Họ và tên khách hàng: </label>
                    <input class="inpt" type="text" name="name_customer" required placeholder="Nhập vào họ và tên">
                </div>
                <div class="account">
                    <label class="lab" for="tel_customer">Số điện thoại giao hàng: </label>
                    <input class="inpt" type="tel" name="tel_customer" required placeholder="0123 456 789" pattern="0[0-9]{9}">
                </div>
                <div class="account">
                    <label class="lab" for="province">Tỉnh/Thành phố: </label>
                    <select name="province" id="province">
                        <option value="">--Chọn Tỉnh/Thành phố--</option>
                    </select>
                </div>
                <div class="account">
                    <label class="lab" for="district">Quận/Huyện: </label>
                    <select name="district" id="district">
                        <option value="">--Chọn Quận/Huyện--</option>
                    </select>
                </div>
                <div class="account">
                    <label class="lab" for="ward">Phường/Xã: </label>
                    <select name="ward" id="ward">
                        <option value="">--Chọn Phường/Xã--</option>
                    </select>
                </div>
                <div class="account">
                    <label class="lab" for="detail_address">Địa chỉ cụ thể: </label>
                    <input class="inpt" name="detail_address" type="text" placeholder="Số nhà, tên đường, khu vực, ...">
                </div>
                <div class="account">
                    <label class="lab" for="payment_method">Phương thức thanh toán: </label>
                    <select name="payment_method" id="payment_method" onchange="toggleQR()">
                        <option value="Thanh toán khi nhận hàng" selected>Thanh toán khi nhận hàng</option>
                        <option id="bank" value="Chuyển khoản qua ngân hàng">Chuyển khoản qua ngân hàng</option>
                        <option id="momo" value="Thanh toán qua Momo">Thanh toán qua Momo</option>
                    </select>
                </div>
                <div class="account" id="bankQR" style="display: none;">
                    <label class="lab">Quét mã để thanh toán </label>
                    <img src="../assets/images/bankQR.jpg" width="300px" style="margin-left: 218px; margin-top: -15px;">
                </div>
                <div class="account" id="momoQR" style="display: none;">
                    <label class="lab">Quét mã để thanh toán </label>
                    <img src="../assets/images/momoQR.jpg" width="300px" style="margin-left: 218px; margin-top: -15px;">
                </div>
            </div>
            <div class="hero-container inf" style="flex: 1; padding: 20px; border-left: 1px solid #000;">
                <h1 style="text-align: center;">Thông tin sản phẩm</h1>
                <div id="cart" style="margin-top: 30px;"></div>
            </div>
        </form>
    </main>
    <footer style="margin: 100px 5px 0px 5px;">
        <article style="margin-left: 5px;">
            <h3>Mạng xã hội</h3>
            <article>
                <a href="https://www.facebook.com/people/Ti%E1%BB%87m-len-c%E1%BB%A7a-Kyu/61576619864144/"><i class="fa-brands fa-facebook"></i> Facebook</a>
                <br>
                <a href="https://www.instagram.com/"><i class="fa-brands fa-instagram"></i> Instagram</a>
                <br>
                <a href="https://www.youtube.com/"><i class="fa-brands fa-youtube"></i> YouTube</a>
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
    <script src="../assets/javascript/payment.js"></script>
</body>
</html>