<?php
session_start();

// Kiểm tra nếu biểu mẫu đã được gửi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ biểu mẫu
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Lưu dữ liệu vào các biến session
    $_SESSION['name'] = $name;
    $_SESSION['email'] = $email;
    $_SESSION['subject'] = $subject;
    $_SESSION['message'] = $message;

    // Chuyển hướng đến trang hiển thị
    header("Location: display_contact.php");
    exit();
}
?>
