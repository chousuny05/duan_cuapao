<?php
session_start();
include_once('./cart-services.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $couponCode = $_POST['coupon_code'];

    // Giả sử bạn có một hàm để kiểm tra mã giảm giá và lấy giá trị giảm giá
    function checkCoupon($code) {
        // Các mã giảm giá mẫu và giá trị giảm giá tương ứng
        $coupons = [
            'DISCOUNT10' => 0.10, // Giảm 10%
            'DISCOUNT20' => 0.20, // Giảm 20%
        ];
        return isset($coupons[$code]) ? $coupons[$code] : 0;
    }

    $discountPercent = checkCoupon($couponCode);

    // Lưu giá trị giảm giá vào session
    if ($discountPercent > 0) {
        $_SESSION['coupon'] = [
            'code' => $couponCode,
            'discount' => $discountPercent
        ];
    } else {
        unset($_SESSION['coupon']);
    }

    // Chuyển hướng trở lại trang giỏ hàng
    header('Location: cart.php');
    exit;
}
?>
