<?php
session_start();
if (!isset($_SESSION['logged_in']) || ($_SESSION['logged_in']) !== true) {
    header('location:login.php');
    exit();
}
include_once("DBUtil.php");

// Khởi tạo đối tượng DBUntil
$dbUtils = new DBUntil();

// Lấy thông tin từ session
$username = $_SESSION['username'];

// Truy vấn người dùng từ CSDL
$sql = "SELECT * FROM users WHERE username = :username";
$result = $dbUtils->select($sql, [':username' => $username]);

// Kiểm tra kết quả trả về từ CSDL
if ($result === false || count($result) === 0) {
    die("Lỗi khi truy vấn thông tin người dùng từ CSDL.");
}

// Lấy thông tin từ kết quả truy vấn
$userInfo = $result[0];
$id = $userInfo['id'];
$email = $userInfo['email'];
$password = $userInfo['password'];
$role = $userInfo['role'];

// Xử lý cập nhật thông tin người dùng
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'update') {
    if (isset($_POST['username'])) {
        if (empty($_POST['username'])) {
            $errors['username'] = "Phải nhập username";
        } else {
            $updated = $dbUtils->update(
                "users",
                array(
                    'username' => $_POST['username'],
                    'email' => $_POST['email'],
                    'password' => $_POST['password'],
                    'role' => $_POST['role'],
                ),
                "id={$id}"
            );
            header("Location: index.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/view-account.css">
    <title>Thông Tin Tài Khoản</title>
</head>
<body>

    <form id="account" action="">
        <h1>Thông Tin Tài Khoản</h1>
        <p><strong>Tên của bạn:</strong> <?= htmlspecialchars($username) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
        <p><strong>Mật khẩu:</strong> <?= htmlspecialchars($password) ?></p>
        <p><strong>Vai trò:</strong> <?= htmlspecialchars($role) ?></p>
        <a class="btn btn-info" href="?action=edit&id=<?= $id ?>">Chỉnh sửa</a>
        <p>Bạn quên mật khẩu?</p>
    </form>
    <?php if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) : ?>
        <form id="edit-account" action="" method="post">
            <h1>CHỈNH SỬA TÀI KHOẢN</h1>
            <input type="hidden" name="action" value="update">
         Name:   <input type="text" name="username" placeholder="Tên đăng nhập của bạn..?" value="<?= htmlspecialchars($username) ?>"><br>
         Password:   <input type="password" name="password" placeholder="Mật khẩu của bạn..?"><br>
         Email:   <input type="email" name="email" placeholder="Email của bạn..?" value="<?= htmlspecialchars($email) ?>"><br>
            <button type="submit" class="btn btn-danger">CHỈNH SỬA</button>
        </form>
    <?php endif; ?>
</body>
</html>
