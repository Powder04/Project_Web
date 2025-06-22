<?php
    require_once('../includes/mysqlConnect.php');

    $email = $fullname = $birthday = $pwd = '';
    $is_edit = false;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
        $email = $_POST['email'];

        $stm = $mysqli->prepare("SELECT email, fullname, birthday, pwd FROM user WHERE email = ?");
        $stm->bind_param("s", $email);
        $stm->execute();
        $stm->bind_result($email, $fullname, $birthday, $pwd);
        if ($stm->fetch()) {
            $is_edit = true;
        }
        $stm->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="../assets/images/icon.png">
    <link rel="stylesheet" href="../assets/css/style_admin.css">
    <title><?php echo $is_edit ? 'Chỉnh sửa người dùng' : 'Thêm người dùng mới'; ?></title>
</head>

<body>
    <header>
        <article class="navbar">
            <img src="../assets/images/logoname.png" style="width: 240px; height: 60px; margin-left: 5px;">
            <nav>
                <a href="../account/logout.php"
                    style="background-color: rgb(40, 167, 69); border: 1px solid rgb(40, 167, 69); padding: 10px 20px; text-decoration: none; color: white; margin-right: 5px;">Đăng xuất</a>
            </nav>
        </article>
    </header>

    <div class="main-container">
        <div class="navcontainer">
            <nav class="nav">
                <div class="nav-upper-options">
                    <a href="./index.html">
                        <div class="nav-option">
                            <h3>Danh mục</h3>
                        </div>
                    </a>
                    <a href="./manage_product.html">
                        <div class="nav-option">
                            <h3>Quản lý sản phẩm</h3>
                        </div>
                    </a>
                    <a href="./manage_user.html">
                        <div class="nav-option">
                            <h3>Quản lý người dùng</h3>
                        </div>
                    </a>
                    <a href="./manage_bill.html">
                        <div class="nav-option">
                            <h3>Quản lý đơn hàng</h3>
                        </div>
                    </a>
                    <a href="./manage_feedback.html">
                        <div class="nav-option">
                            <h3>Quản lý phản hồi</h3>
                        </div>
                    </a>
                </div>
            </nav>
        </div>
        <div class="main">
            <div id="back">
                <button onclick="window.location.href='./manage_user.html';" style="padding: 8px 20px">
                    <i class="fa-solid fa-backward"></i>
                </button>
            </div>
            <div class="form-wrapper">
                <fieldset>
                    <h1 class="heading"><?php echo $is_edit ? 'Chỉnh sửa người dùng' : 'Thêm người dùng mới'; ?></h1>
                    <form action="<?php echo $is_edit ? './update_user.php' : './add_user.php'; ?>" method="post" enctype="application/x-www-form-urlencoded" id="formUser">

                        <?php if ($is_edit): ?>
                            <input type="hidden" class="inpt" name="oldEmail" value="<?php echo htmlspecialchars($email); ?>"/>
                        <?php endif; ?>

                        <article class="account">
                            <label class="lab" for="newEmail">Địa chỉ email: </label>
                            <input type="email" class="inpt" name="newEmail" value="<?php echo htmlspecialchars($email); ?>" required />
                        </article>
                        
                        <article class="account">
                            <label class="lab" for="fullname">Họ và tên: </label>
                            <input type="text" class="inpt" name="fullname" value="<?php echo htmlspecialchars($fullname); ?>" required />
                        </article>

                        <article class="account">
                            <label class="lab" for="birthday">Năm sinh: </label>
                            <input type="number" name="birthday" class="inpt" value="<?php echo $birthday; ?>" required />
                        </article>

                        <article class="account">
                            <label class="lab" for="pwd"><?php echo $is_edit ? 'Mật khẩu mới:' : 'Mật khẩu:'; ?> </label>
                            <input type="password" name="pwd" id="password" class="inpt" placeholder="<?php echo $is_edit ? 'Để trống nếu không đổi' : ''; ?>" <?php echo $is_edit ? '' : 'required'; ?>/>
                            <span class="toggle-icon" id="toggleIcon" onclick="togglePassword()">
                                <i class="fa-solid fa-eye-slash"></i>
                            </span>
                        </article>

                        <article class="account btn-account">
                            <button type="reset" class="btn btn-1">Xóa</button>
                            <button type="submit" class="btn btn-2"><?php echo $is_edit ? 'Cập nhật người dùng' : 'Thêm người dùng'; ?></button>
                        </article>
                    </form>
                </fieldset>
            </div>
        </div>
    </div>
    <script>
        function togglePassword() {
            var passwordInput = document.getElementById("password");
            var icon = document.getElementById("toggleIcon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.innerHTML = '<i class="fa-solid fa-eye"></i>';
            } else {
                passwordInput.type = "password";
                icon.innerHTML = '<i class="fa-solid fa-eye-slash"></i>';
            }
        }
    </script>
</body>

</html>