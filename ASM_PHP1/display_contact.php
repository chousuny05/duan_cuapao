<?php
session_start();
if (!isset($_SESSION['name'])) {
    // Chuyển hướng về trang contact nếu không có dữ liệu trong session
    header("Location: contact.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Thông tin liên hệ</title>
</head>

<body>
    <div class="container mt-5">
        <h1>Cảm ơn bạn đã liên hệ!</h1>
        <h2>Thông tin bạn đã gửi</h2>
        <p><strong>Tên:</strong> <?php echo $_SESSION['name']; ?></p>
        <p><strong>Email:</strong> <?php echo $_SESSION['email']; ?></p>
        <p><strong>Chủ đề:</strong> <?php echo $_SESSION['subject']; ?></p>
        <p><strong>Tin nhắn:</strong> <?php echo nl2br($_SESSION['message']); ?></p>
        <a href="contact.php" class="btn btn-primary">Quay lại trang liên hệ</a>
        <p>Cảm ơn bạn đã tin tưởng và mua hàng bên shop pao</p>
    </div>

    <?php
    // Xóa dữ liệu session sau khi hiển thị
    session_unset();
    session_destroy();
    ?>
</body>

</html>
