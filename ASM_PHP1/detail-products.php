<?php
session_start();
include "./DBUtils.php";

$dbHelper = new DBUtils();

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header("Location: login.php");
    exit();
}

// Lấy ID sản phẩm từ URL
$product_id = isset($_GET['id']) ? $_GET['id'] : 1;

// Truy vấn thông tin sản phẩm
$product = $dbHelper->select("SELECT * FROM products WHERE id = $product_id")[0];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sản phẩm</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <h2>chi tiết sản phẩm</h2>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <img src="<?php echo $product['image']; ?>" class="img-fluid" alt="Hình ảnh sản phẩm">
            </div>
            <div class="col-md-6">
                <h2><?php echo $product['name']; ?></h2>
                <p><?php echo $product['description']; ?></p>
                <h4>Giá: <?php echo number_format($product['price'], 0, ',', '.'); ?> VND</h4>
              <button class="btn btn-outline-success"> <a href="index.php">call back</a></button>
            </div>
        </div>
    </div>
</body>

</html>
