<?php
    require_once('../includes/mysqlConnect.php');

    $product_id = $name = $quantity = $price = $type = '';
    $image_data = '';
    $mime_type = '';
    $is_edit = false;

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
        $product_id = $_POST['product_id'];

        $stm = $mysqli->prepare("SELECT p.name, p.category, p.price, p.quantity, i.image_data, i.mime_type FROM product p
                                LEFT JOIN images i ON p.product_id = i.product_id WHERE p.product_id = ?");
        $stm->bind_param("s", $product_id);
        $stm->execute();
        $stm->bind_result($name, $type, $price, $quantity, $image_data, $mime_type);
        if($stm->fetch()) {
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
    <title><?php echo $is_edit ? 'Chỉnh sửa sản phẩm' : 'Thêm sản phẩm mới'; ?></title>
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
                <button onclick="window.location.href='./manage_product.html';" style="padding: 8px 20px">
                    <i class="fa-solid fa-backward"></i>
                </button>
            </div>
            <div class="form-wrapper">
                <fieldset>
                    <h1 class="heading"><?php echo $is_edit ? 'Chỉnh sửa sản phẩm' : 'Thêm sản phẩm mới'; ?></h1>
                    <form action="<?php echo $is_edit ? './update_product.php' : './add_product.php'; ?>" method="post" enctype="multipart/form-data" id="formProduct">

                        <?php if($is_edit): ?>
                            <article class="account">
                                <label class="lab" for="product_id">Mã sản phẩm: </label>
                                <input type="text" class="inpt" name="product_id" value="<?php echo htmlspecialchars($product_id); ?>" required />
                            </article>
                        <?php endif; ?>
                        
                        <article class="account">
                            <label class="lab" for="nameProduct">Tên sản phẩm: </label>
                            <input type="text" class="inpt" name="nameProduct" value="<?php echo htmlspecialchars($name); ?>" required />
                        </article>

                        <?php if(!$is_edit): ?>
                            <article class="account">
                                <label class="lab" for="productID">Mã sản phẩm: </label>
                                <input type="text" class="inpt" name="productID" required />
                            </article>
                        <?php endif; ?>

                        <article class="account">
                            <label class="lab" for="image_file">Hình ảnh sản phẩm:</label><br>
                            <?php if($is_edit && $image_data): ?>
                                <img src="data:<?php echo $mime_type; ?>;base64,<?php echo base64_encode($image_data); ?>" width="120px"><br>
                            <?php endif; ?>
                            <input type="file" name="image_file" accept="image/png, image/jpg, image/jpeg, image/gif"
                                <?php echo $is_edit ? '' : 'required'; ?> />
                        </article>

                        <article class="account">
                            <label class="lab" for="typeProduct">Loại sản phẩm:</label>
                            <select name="typeProduct" style="padding: 3px">
                                <option value="Khác" <?php if($type == 'Khác')
                                    echo 'selected'; ?>>O-Khác</option>
                                <option value="Balo" <?php if($type == 'Balo')
                                    echo 'selected'; ?>>BP-Balo</option>
                                <option value="Móc khóa" <?php if($type == 'Móc khóa')
                                    echo 'selected'; ?>>KC-Móc khóa
                                </option>
                                <option value="Phụ kiện tóc" <?php if($type == 'Phụ kiện tóc')
                                    echo 'selected'; ?>>HA-Phụ kiện tóc
                                </option>
                                <option value="Túi" <?php if($type == 'Túi')
                                    echo 'selected'; ?>>B-Túi</option>
                                <option value="Combo" <?php if($type == 'Combo')
                                    echo 'selected'; ?>>CB-Combo</option>
                            </select>
                        </article>

                        <article class="account">
                            <label class="lab" for="price">Giá sản phẩm: </label>
                            <input type="number" min="1" name="price" class="inpt" value="<?php echo $price; ?>"
                                required />
                        </article>

                        <article class="account">
                            <label class="lab" for="quantity">Số lượng: </label>
                            <input type="number" min="1" name="quantity" class="inpt" value="<?php echo $quantity; ?>"
                                required />
                        </article>

                        <article class="account btn-account">
                            <button type="reset" class="btn btn-1">Xóa</button>
                            <button type="submit"
                                class="btn btn-2"><?php echo $is_edit ? 'Cập nhật sản phẩm' : 'Thêm sản phẩm'; ?></button>
                        </article>
                    </form>
                </fieldset>
            </div>
        </div>
    </div>
</body>

</html>