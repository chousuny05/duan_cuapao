<?php
include_once("./DBUtils.php");
session_start();
$errors = [];
$dbUtils = new DBUtils();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Kiểm tra và gán giá trị cho biến $_POST
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $role = isset($_POST['role']) ? $_POST['role'] : '';
    $passwordconfirm = isset($_POST['passwordconfirm']) ? $_POST['passwordconfirm'] : '';

    // Kiểm tra các điều kiện và ghi nhận lỗi
    if (empty($username)) {
        $errors['username'] = "Vui lòng nhập tên đăng nhập";
    }
    if (empty($password)) {
        $errors['password'] = "Vui lòng nhập mật khẩu";
    }
    if (empty($email)) {
        $errors['email'] = "Vui lòng nhập email";
    }
    if (empty($role)) {
        $errors['role'] = "Vui lòng chọn vai trò";
    }
    if (empty($passwordconfirm)) {
        $errors['passwordconfirm'] = "Vui lòng nhập lại mật khẩu";
    } elseif ($passwordconfirm != $password) {
        $errors['passwordconfirm'] = "Mật khẩu nhập lại không khớp";
    }

    // Nếu không có lỗi, tiến hành insert vào cơ sở dữ liệu
    if (count($errors) == 0) {
        // Kiểm tra tồn tại username hoặc email
     // Kiểm tra tồn tại username hoặc email
$sqlCheck = "SELECT * FROM users WHERE LOWER(username) = LOWER(:username) OR LOWER(email) = LOWER(:email)";
$existingUser = $dbUtils->select($sqlCheck, ['username' => strtolower($username), 'email' => strtolower($email)]);


        if (count($existingUser) > 0) {
            $errors['username'] = "Tên người dùng hoặc email đã tồn tại";
        } else {
            // Xử lý đăng ký tài khoản
            $data = [
                'username' => $username,
                'password' => password_hash($password, PASSWORD_DEFAULT), // Hash mật khẩu
                'email' => $email,
                'role' => $role
            ];
            $isCreated = $dbUtils->insert('users', $data);
            if ($isCreated) {
                // Đăng ký thành công, chuyển hướng đến trang đăng nhập
                header('Location: login.php');
                exit(); // Đảm bảo không có mã nào khác được thực thi
            } else {
                $errors['general'] = "Đã có lỗi xảy ra trong quá trình đăng ký. Vui lòng thử lại sau.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
   <link rel="stylesheet" href="register.css">
    <title>Đăng ký</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>
    
    <div class="container">
        <h1>Đăng ký</h1>
        <form action="" method="post">
            <div class="form-group">
                <input class="form-control" type="text" name="username" id="username" placeholder="Nhập tên đăng nhập...">
                <?php if (isset($errors['username'])) {
                    echo "<span class='text-danger'>$errors[username]</span>";
                } ?>
            </div><br>

            <div class="form-group">
                <input class="form-control" type="password" name="password" id="password" placeholder="Nhập mật khẩu...">
                <?php if (isset($errors['password'])) {
                    echo "<span class='text-danger'>$errors[password]</span>";
                } ?>
            </div><br>

            <div class="form-group">
                <input class="form-control" type="text" name="email" id="email" placeholder="Nhập email...">
                <?php if (isset($errors['email'])) {
                    echo "<span class='text-danger'>$errors[email]</span>";
                } ?>
            </div><br>

            <div class="form-group">
                <select class="form-control" name="role" id="role">
                    <option value="">Chọn vai trò</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
                <?php if (isset($errors['role'])) {
                    echo "<span class='text-danger'>$errors[role]</span>";
                } ?>
            </div><br>

            <div class="form-group">
                <input class="form-control" type="password" name="passwordconfirm" id="passwordconfirm" placeholder="Nhập lại mật khẩu...">
                <?php if (isset($errors['passwordconfirm'])) {
                    echo "<span class='text-danger'>$errors[passwordconfirm]</span>";
                } ?>
            </div><br>

            <button type="submit" class="btn btn-primary">Đăng ký</button>
            <a href="login.php">Login</a>
        </form>
    </div>
</body>

</html>
