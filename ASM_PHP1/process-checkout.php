<?php
session_start();
include_once('./cart-services.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['customer_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $state = $_POST['state'];

    // Kiểm tra dữ liệu hợp lệ (có thể thêm các kiểm tra khác tùy nhu cầu)

    $cart = new Cart();
    $totals = $cart->getTotal();

    // Ở đây bạn có thể thêm logic xử lý thanh toán và tạo đơn hàng.
    // Hiện tại, chúng tôi chỉ lưu thông tin đơn hàng vào session và xóa giỏ hàng để mô phỏng việc thanh toán thành công.

    $order = [
        'customer_name' => $name,
        'email' => $email,
        'phone' => $phone,
        'address' => $address,
        'state' => $state,
        'items' => $cart->getCart(),
        'totals' => $totals
    ];

    // Lưu đơn hàng vào session (hoặc lưu vào cơ sở dữ liệu)
    $_SESSION['order'] = $order;

    // // Xóa giỏ hàng
    $cart->clear();

    // Chuyển hướng đến trang thành công
    header('Location: order-success.php');
    exit;
}
?>
