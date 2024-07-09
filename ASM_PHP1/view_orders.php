<?php
// Kết nối đến cơ sở dữ liệu MySQL bằng PDO
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "php1-ca2-spring-2024";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Câu lệnh SQL để lấy danh sách các đơn hàng
    $sql = "SELECT * FROM orders";

    // Thực thi câu lệnh SQL
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Lấy kết quả trả về dưới dạng mảng kết hợp
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Kiểm tra và hiển thị dữ liệu
    if (count($orders) > 0) {
        echo "<h2>Danh sách đơn hàng</h2>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Tên khách hàng</th><th>Email</th><th>Điện thoại</th><th>Địa chỉ</th><th>Tạm tính</th><th>Giảm giá</th><th>Tổng</th></tr>";
        foreach ($orders as $order) {
            echo "<tr>";
            echo "<td>" . $order['id'] . "</td>";
            echo "<td>" . htmlspecialchars($order['name']) . "</td>";
            echo "<td>" . htmlspecialchars($order['email']) . "</td>";
            echo "<td>" . htmlspecialchars($order['phone']) . "</td>";
            echo "<td>" . nl2br(htmlspecialchars($order['address'])) . "</td>";
            echo "<td>$" . number_format($order['subtotal'], 2) . "</td>";
            echo "<td>$" . number_format($order['discount'], 2) . "</td>";
            echo "<td>$" . number_format($order['total'], 2) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Không có đơn hàng nào được tìm thấy.";
    }
} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
}

// Đóng kết nối
$conn = null;
