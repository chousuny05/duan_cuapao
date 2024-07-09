<?php
session_start();
include "./database.php"; // Include file kết nối CSDL

// Kiểm tra và lấy user_id từ session (giả sử đã được lưu từ khi người dùng đăng nhập)
if (!isset($_SESSION['user_id'])) {
    die("Session user_id not set.");
}

$user_id = $_SESSION['user_id'];

// Tạo kết nối đến CSDL
$db = new Database();
$conn = $db->getConnection();

// Process confirm order action
if (isset($_POST['confirm_order'])) {
    $order_id = $_POST['order_id'];
    $sql = "UPDATE orders SET status='confirmed' WHERE order_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$order_id]);
    header("Location: admin-status.php");
    exit();
}

// Process cancel order action
if (isset($_POST['cancel_order'])) {
    $order_id = $_POST['order_id'];
    $sql = "UPDATE orders SET status='cancelled' WHERE order_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$order_id]);
    header("Location: admin-status.php");
    exit();
}

$sql = "SELECT o.order_id, o.user_id, o.email as email, o.total, o.address, o.customer_name as order_name, oi.product_name, oi.quantity, oi.price, oi.created_at as order_date, o.status
        FROM orders o 
        JOIN order_details oi ON o.order_id = oi.order_id 
        WHERE o.user_id = ? 
        ORDER BY oi.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        <a href="index.php"class="btn btn-success" >call back index</a>
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
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
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
                        <td><?php echo htmlspecialchars($order['status']); ?></td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                                <button type="submit" name="confirm_order" class="btn btn-success">Xác nhận</button>
                                <button type="submit" name="cancel_order" class="btn btn-danger">Hủy</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>
