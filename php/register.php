<?php
include_once("DBUtil.php");
session_start();
$errors = [];
$dbUtils = new DBUntil();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = isset($_POST['name']) ? $_POST['name'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $passwordConfirm = isset($_POST['password-confirm']) ? $_POST['password-confirm'] : '';
    $role = isset($_POST['role']) ? $_POST['role'] : '';

    // kiểm tra báo lỗi
    if (empty($username)) {
        $errors['username'] = "Vui lòng nhập Tên";
    }
    if (empty($password)) {
        $errors['password'] = "Vui lòng nhập Mật khẩu";
    }
    if (empty($email)) {
        $errors['email'] = "Vui lòng nhập email";
    }
    if ($password !== $passwordConfirm) {
        $errors['password-confirm'] = "Mật khẩu không khớp, vui lòng nhập lại";
    } else if (empty($passwordConfirm)) {
        $errors['password-confirm'] = "Vui lòng nhập lại mật khẩu";
    }
    if (empty($role)) {
        $errors['role'] = "Vui lòng chọn role";
    }
    //nếu  không lỗi tiến hành insert vào csdl
    if (count($errors) == 0) {
        //Kiểm tra username or email tồn tại
        $sqlCheck = "SELECT * FROM users WHERE LOWER(username) = LOWER(:username) OR LOWER(email) = LOWER(:email)";
        $params = [
            ':username' => $username,
            ':email' => $email
        ];
        $existingUser = $dbUtils->select($sqlCheck, $params);

        if (count($existingUser) > 0) {
            $errors['username'] = "Tên người dùng đã tồn tại";
        } else {
            //sử lý đăng ký tk
            $data = [
                'username' => $username,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'email' => $email,
                'role' => $role,
            ];
            $isCreated = $dbUtils->insert('users', $data);
            if ($isCreated) {
                header('location:login.php');
                exit();
            } else {
                $errors['general'] = "Đã có lỗi. đăng ký không thành công";
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
    <link rel="stylesheet" href="./register.css">
    <title>REGISTER</title>
    <style>
        span {
            color: red;
        }
    </style>
</head>

<body>
    <div id="wrapper">
        <form action="#" id="form-register" method="post">
            <h1 class="form-header">FORM REGISTER</h1>
            <div class="form-group">
                <input type="text" class="form-input" name="name" id="name" placeholder="Tên đăng nhập"><br>
                <?php
                if (isset($errors['username'])) {
                    echo "<span class='txt-dange'>{$errors['username']}</span>";
                }
                ?>
            </div>
            <div class="form-group">
                <input type="password" class="form-input" name="password" id="password" placeholder="Mật khẩu"><br>
                <?php
                if (isset($errors['password'])) {
                    echo "<span class='txt-dange'>{$errors['password']}</span>";
                }
                ?>
            </div>
            <div class="form-group">
                <input type="email" class="form-input" name="email" id="email" placeholder="Nhập email"><br>
                <?php
                if (isset($errors['email'])) {
                    echo "<span class='txt-dange'>{$errors['email']}</span>";
                }
                ?>
            </div>
            <div class="form-group">
                <input type="password" class="form-input" name="password-confirm" id="password-confirm" placeholder="Nhập lại mật khẩu"><br>
                <?php
                if (isset($errors['password-confirm'])) {
                    echo "<span class='txt-dange'>{$errors['password-confirm']}</span>";
                }
                ?>
            </div>
            <select class="form-control" name="role" id="role">
                <option value="">Chọn vai trò</option>
                <option value="admin">Admin</option>
                <option value="supplier">Supplier</option>
                <option value="user">User</option>
            </select><br>
            <?php
            if (isset($errors['role'])) {
                echo "<span class='txt-dange'>{$errors['role']}</span>";
            }
            ?>

            <input type="submit" value="Đăng ký" class="form-submit">
        </form>
    </div>
</body>

</html>