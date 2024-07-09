<?php
session_start();
include "./DBUtils.php";

$dbHelper = new DBUtils();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header("Location: login.php");
    exit();
}

// Lấy từ khóa tìm kiếm từ URL
$query = isset($_GET['product_name']) ? $_GET['product_name'] : '';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả tìm kiếm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Kết quả tìm kiếm cho: "<?php echo htmlspecialchars($query); ?>"</h2>
        
        <div class="row">
            <?php
            // Truy vấn sản phẩm theo từ khóa tìm kiếm
            if (!empty($query)) {
                $queryParam = "%" . $query . "%";
                $products = $dbHelper->select("SELECT * FROM products WHERE name LIKE ? OR description LIKE ?", [$queryParam, $queryParam]);

                // Hiển thị sản phẩm
                if (count($products) > 0) {
                    foreach ($products as $product) { ?>
                        <div class="col-md-4 mb-4">
                            <div class="card" style="width: 300px;">
                                <img src="<?php echo $product['image']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>">
                                <div class="card-body" style="width: 300px; height: 200px;">
                                    <h5 style="font-weight: bold;" class="card-title"><?php echo $product['name']; ?></h5>
                                    <p style="color: red;" class="card-text"><?php echo number_format($product['price'], 0, ',', '.'); ?> VND</p>
                                    <a href="detail-products.php?id=<?php echo $product['id']; ?>" class="btn btn-outline-success">Chi tiết sản phẩm</a>
                                </div>
                            </div>
                        </div>
                    <?php }
                } else {
                    echo "<p>Không tìm thấy sản phẩm nào phù hợp.</p>";
                }
            } else {
                echo "<p>Vui lòng nhập từ khóa tìm kiếm.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>
