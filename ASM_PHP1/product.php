<?php
ini_set('display_errors', '1');
session_start();
include "./DBUtils.php";

$dbHelper = new DBUtils();

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['role'] !== 'admin') {
    echo "Bạn không có quyền truy cập trang này. <a href=index.php>call back index</a>";
    exit();
}

// Nội dung trang quản lý sản phẩm cho admin
echo "Trang quản lý sản phẩm.";

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'create': {
                if (isset($_POST['name']) && empty($_POST['name'])) {
                    $errors['name'] = "Phải Nhập name";
                }
                if (isset($_POST['description']) && empty($_POST['description'])) {
                    $errors['description'] = "Phải Nhập description";
                }
                if (isset($_POST['image']) && empty($_POST['image'])) {
                    $errors['image'] = "Phải Nhập image";
                }
                if (isset($_POST['price']) && empty($_POST['price'])) {
                    $errors['price'] = "Phải Nhập price";
                }
                if (isset($_POST['quantity']) && empty($_POST['quantity'])) {
                    $errors['quantity'] = "Phải Nhập quantity";
                }
                if (isset($_POST['sale']) && empty($_POST['sale'])) {
                    $errors['sale'] = "Phải Nhập sale";
                }
                if (isset($_POST['status']) && empty($_POST['status'])) {
                    $errors['status'] = "Phải Nhập status";
                }

                // If no errors, proceed with insertion
                if (empty($errors)) {
                    $created = $dbHelper->insert(
                        "products",
                        array(
                            'name' => $_POST['name'],
                            'description' => $_POST['description'],
                            'image' => $_POST['image'],
                            'price' => $_POST['price'],
                            'quantity' => $_POST['quantity'],
                            'sale' => $_POST['sale'],
                            'status' => $_POST['status'],
                        )
                    );
                    if ($created) {
                        $_SESSION['success_message'] = "Thêm sản phẩm thành công.";
                        header("Location: product.php");
                        exit;
                    } else {
                        $_SESSION['error_message'] = "Không thể thêm sản phẩm.";
                    }
                }
                break;
            }
        case 'delete': {
                if (isset($_POST['id'])) {
                    $id = $_POST['id'];
                    $result = $dbHelper->delete('products', 'id=:id', ['id' => $id]);
                    if ($result > 0) {
                        $_SESSION['success_message'] = "Xóa sản phẩm thành công.";
                    } else {
                        $_SESSION['error_message'] = "Không thể xóa sản phẩm.";
                    }
                    header("Location: product.php");
                    exit();
                }
                break;
            }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>DEMO CRUD</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="product.css">
</head>

<body>
    <div class="container">
        <header>
            <div id="header">
                <nav>
                    <ul id="nav">
                        <li>
                            <img src="" alt="logo" class="nav-logo">
                        </li>
                        <li>
                            <a href="index.php">Home
                                <i class="fa-solid fa-house"></i>
                            </a>
                        </li>
                        <li>
                            <a href="product.php">Product</a>
                        </li>

                        <li>
                            <a href="">
                                Menu
                                <i class="fa-solid fa-caret-down"></i>
                            </a>
                            <ul class="subnav">
                                <li><a href="">Shoes</a></li>
                                <li><a href="">Span</a></li>
                                <li><a href="">Shirt</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="cart.php">
                                CART
                                <i class="fa-solid fa-cart-shopping"></i>
                            </a>
                        </li>
                        <li>
                            <a href="user.php">
                                USER
                                <i class="fa-solid fa-user"></i>
                            </a>
                        </li>
                        <li>
                            <a href="contact.php">
                                Contact
                                <i class="fa-solid fa-envelope"></i>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                More
                                <i class="fa-solid fa-caret-down"></i>
                            </a>
                            <ul class="subnav">
                                <li><a href="">Hot</a></li>
                                <li><a href="">New</a></li>
                                <li><a href="">Sale</a></li>
                            </ul>
                        </li>
                    </ul>
                    <div class="search-btn">
                        <input type="text" placeholder="Search here.....">
                        <button class="header" type="submit">Search</button>
                        <button class="header"><a href="dangnhap.html">Login</a></button>
                        <button class="header"><a href="dangnhap.html">Logout</a></button>
                    </div>
                </nav>
            </div>

        </header>

    </div>
    <div class="baner">
        <img src="https://noithattugia.com/wp-content/uploads/Tong-the-khong-gian-thiet-ke-rong-rai-thoang-rong-voi-mau-sac-tinh-te-an-tuong-1067x800.jpg" alt="" style="width: 100%; height: 500px;">
    </div>

    <div class="container">
        <?php
        if (isset($_SESSION['success_message'])) {
            echo "<div class='alert alert-success'>" . $_SESSION['success_message'] . "</div>";
            unset($_SESSION['success_message']);
        }
        ?>
        <h2>Danh Mục sản phẩm</h2>
        <form action="" method="post" class="form_product">
            <input type="text" class="form-control" placeholder="Tên sản phẩm....." name="name"><br>
            <?php if (isset($errors['name'])) {
                echo "<span class='text-danger'>$errors[name]</span><br/>";
            } ?>
            <input type="text" class="form-control" name="description" placeholder="Miêu tả sản phẩm....."><br>
            <?php if (isset($errors['description'])) {
                echo "<span class='text-danger'>$errors[description]</span><br/>";
            } ?>
            <input type="text" class="form-control" id="image" name="image" placeholder="ảnh sản phẩm" .....><br>
            <?php if (isset($errors['image'])) {
                echo "<span class='text-danger'>$errors[image]</span><br/>";
            } ?>
            <input type="text" class="form-control" name="price" placeholder="Giá....."><br>
            <?php if (isset($errors['price'])) {
                echo "<span class='text-danger'>$errors[price]</span><br/>";
            } ?>
            <input type="text" class="form-control" name="quantity" placeholder="Số lượng....."><br>
            <?php if (isset($errors['quantity'])) {
                echo "<span class='text-danger'>$errors[quantity]</span><br/>";
            } ?>
            <input type="text" class="form-control" name="sale" placeholder="Giảm giá....."><br>
            <?php if (isset($errors['sale'])) {
                echo "<span class='text-danger'>$errors[sale]</span><br/>";
            } ?>
            <input type="text" class="form-control" name="status" placeholder="Tình trạng....."><br>
            <?php if (isset($errors['status'])) {
                echo "<span class='text-danger'>$errors[status]</span><br/>";
            } ?>
            <button class="btn btn-success" name="action" value="create" type="submit">create</button>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NAME</th>
                    <th>DESCRIPTION</th>
                    <th>IMAGE</th>
                    <th>PRICE</th>
                    <th>QUANTITY</th>
                    <th>SALE</th>
                    <th>STATUS</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $products = $dbHelper->select("SELECT * FROM products");
                foreach ($products as $row) : ?>
                    <tr>
                        <td><?= $row['id']; ?></td>
                        <td><?= $row['name']; ?></td>
                        <td><?= $row['description']; ?></td>
                        <td><img src="<?= htmlspecialchars($row['image']) ?>" alt="image" width="100"></td>
                        <td><?= $row['price']; ?></td>
                        <td><?= $row['quantity']; ?></td>
                        <td><?= $row['sale']; ?></td>
                        <td><?= $row['status']; ?></td>
                        <td>
                            <form method="post" action="">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <button type="submit" class="btn btn-danger" name="action" value="delete">delete</button>
                                <a class="btn btn-info" href="update_product.php?id=<?= $row['id'] ?>">edit</a>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <footer>
        <div class="footer-container">
            <div class="footer-section about">
                <h2>Pao</h2>
                <p>Cửa hàng thời trang của bạn với những xu hướng mới nhất. Tại Pao, chúng tôi cung cấp đa dạng các loại trang phục phù hợp với mọi phong cách và dịp.</p>
                <div class="socials">
                    <a href="#"><i class="fa fa-facebook"></i></a>
                    <a href="#"><i class="fa fa-twitter"></i></a>
                    <a href="#"><i class="fa fa-instagram"></i></a>
                    <a href="#"><i class="fa fa-linkedin"></i></a>
                </div>
            </div>
            <div class="footer-section links">
                <h2>Liên kết nhanh</h2>
                <ul>
                    <li><a href="#">Trang chủ</a></li>
                    <li><a href="#">Sản phẩm</a></li>
                    <li><a href="#">Giới thiệu</a></li>
                    <li><a href="#">Liên hệ</a></li>
                    <li><a href="#">Blog</a></li>
                </ul>
            </div>
            <div class="footer-section contact">
                <h2>Liên hệ</h2>
                <ul>
                    <li><i class="fa fa-map-marker"></i> 123 Đường ABC, Quận 1, TP. HCM</li>
                    <li><i class="fa fa-phone"></i> +84 123 456 789</li>
                    <li><i class="fa fa-envelope"></i> support@pao.com</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; 2024 Pao. All rights reserved.
        </div>
    </footer>
</body>

</html>