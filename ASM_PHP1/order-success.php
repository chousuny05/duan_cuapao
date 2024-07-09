<?php
ob_start(); // Bắt đầu bộ đệm đầu ra
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
include_once("./DBUtils.php");

// Kiểm tra và lấy user_id từ session (giả sử đã được lưu từ khi người dùng đăng nhập)
if (!isset($_SESSION['user_id'])) {
    die("Session user_id not set.");
}
// kiểm quyền

if (!isset($_SESSION['role'])) {
    $_SESSION['role'] = 'guest'; // Đặt mặc định là 'guest' nếu không tồn tại
}

$role = $_SESSION['role'];



$user_id = $_SESSION['user_id'];

// Khởi tạo đối tượng DBUtils để sử dụng các phương thức truy vấn CSDL
$dbHelper = new DBUtils();

$sql = "SELECT o.order_id, o.user_id, o.email as email, o.total, o.address, o.customer_name as order_name, oi.product_name, oi.quantity, oi.price, oi.created_at as order_date
        FROM orders o 
        JOIN order_details oi ON o.order_id = oi.order_id 
        WHERE o.user_id = ? 
        ORDER BY oi.created_at DESC";

// Thực thi câu truy vấn SQL với tham số là user_id của người dùng hiện tại
$orders = $dbHelper->select($sql, [$user_id]);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thông tin đơn hàng</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>
   
    <div class="container mt-5">
        <h2>Thông tin các đơn hàng của bạn</h2>
        <div class="container mt-5">
        <?php if ($role === 'admin') : ?>
            <a href="admin-status.php" class="btn btn-primary">View History Orders</a>
        <?php else : ?>
            <a href="order-success.php" class="btn btn-primary">View Order Success</a>
        <?php endif; ?>
        <a href="index.php" class="btn btn-primary">call back index</a>
    </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID Đơn hàng</th>
                    <th scope="col">ID User</th>
                    <th scope="col">Tổng tiền</th>
                    <th scope="col">Email người mua</th>

                    <th scope="col">Địa chỉ</th>
                    <th scope="col">Tên người nhận</th>
                    <th scope="col">Tên sản phẩm</th>
                    <th scope="col">Số lượng</th>
                    <th scope="col">Đơn giá</th>
                    <th scope="col">Ngày đặt hàng</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                        <td><?php echo htmlspecialchars($order['user_id']); ?></td>
                        <td><?php echo htmlspecialchars($order['total']); ?></td>
                        <td><?php echo htmlspecialchars($order['email']); ?></td>
                        <td><?php echo htmlspecialchars($order['address']); ?></td>
                        <td><?php echo htmlspecialchars($order['order_name']); ?></td>
                        <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                        <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($order['price']); ?></td>
                        <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>