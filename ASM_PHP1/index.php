<?php
session_start();
include "./DBUtils.php";

$dbHelper = new DBUtils();
// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php");
//     exit();
// }

if (!isset($_SESSION['role'])) {
    echo "Vai trò không được xác định.";
    exit();
}

// if ($_SESSION['role'] === 'admin') {
//     echo "Chào mừng Admin, " . $_SESSION['username'];
//     echo "<a href='product_management.php'>Quản lý sản phẩm</a><br>";
//     echo "<a href='user_management.php'>Quản lý người dùng</a>";
// } elseif ($_SESSION['role'] === 'user') {
//     echo "Chào mừng User, " . $_SESSION['username'];
// } else {
//     echo "Vai trò không hợp lệ.";
//     exit();
// }

// Xóa sản phẩm
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'delete') {
    $id = $_POST['id'];
    $result = $dbHelper->delete('products', 'id=:id', ['id' => $id]);
    $_SESSION['success_message'] = "Xóa sản phẩm thành công";
    header("Location: index.php"); // Chuyển hướng trở lại trang index sau khi xóa
    exit();
}

// Lấy danh sách sản phẩm
$products = $dbHelper->select("SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="index.css">
    <title>index</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
                    <form action="search.php" method="GET" class="search-form">
                        <input type="text" name="product_name" placeholder="Nhập tên sản phẩm...">
                        <button type="submit">Tìm kiếm</button>
                        <button class="header"><a href="logout.php">Logout</a></button>
                    </form>
                </nav>
            </div>
            <div class="baner">
                <img src="https://noithattugia.com/wp-content/uploads/Tong-the-khong-gian-thiet-ke-rong-rai-thoang-rong-voi-mau-sac-tinh-te-an-tuong-1067x800.jpg" alt="" style="width: 100%; height: 500px;">
            </div>
        </header>

    </div>
 
    <main>
    
        <h1>Welcome to Pao Shop</h1>
        <div class="container_mt-5">
            <h2 class="mb-4"></h2>
            <div class="row">
                <?php foreach ($products as $product) { ?>
                    <div class="col-md-4" style=" margin-bottom: 40px; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3); /* Đổ bóng nhẹ */">
                        <div class="card" style="width: 300px;">
                            <img src="<?php echo $product['image']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>">
                            <div class="card-body" style="width: 300px;height:200px; ">
                                <h5 style="font-weight:bold;" class="card-title"><?php echo $product['name']; ?></h5>
                                <p style="color: red;" class="card-text"><?php echo $product['price']; ?></p>
                                <form method="post" action="cart-handle.php">
                                    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                                    <input type="hidden" name="name" value="<?php echo $product['name']; ?>">
                                    <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
                                    <input type="hidden" name="image" value="<?php echo $product['image']; ?>">
                                    <a href="detail-products.php?id=<?php echo $product['id']; ?>" class="btn btn-outline-success">Chi tiết sản phẩm</a>
                                    <button type="submit" name="action" value="add" class="btn btn-outline-success">Thêm vào giỏ hàng</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>     
        </div>

    </main>
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