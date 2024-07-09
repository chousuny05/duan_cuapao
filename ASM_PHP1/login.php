<?php
session_start(); // Bắt đầu session

include_once("./DBUtils.php");

$errors = [];

function login() {
    global $errors;

    if (!isset($_POST['username']) || empty($_POST['username'])) {
        $errors['username'] = "Vui lòng nhập tên đăng nhập";
    }

    if (!isset($_POST['password']) || empty($_POST['password'])) {
        $errors['password'] = "Vui lòng nhập mật khẩu";
    }

    if (!isset($_POST['role']) || empty($_POST['role'])) {
        $errors['role'] = "Vui lòng chọn vai trò";
    }

    return $errors;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = login();

    if (count($errors) == 0) {
        $dbHelper = new DBUtils();

        $username = $_POST['username'];
        $password = $_POST['password'];
        $role = $_POST['role'];

        // Kiểm tra xem có dữ liệu trả về từ cơ sở dữ liệu hay không
        $result = $dbHelper->select(
            "SELECT * FROM users WHERE username = :username",
            array(
                'username' => $username,
            )
        );

        if ($result === false) {
            echo "Có lỗi xảy ra trong quá trình truy vấn cơ sở dữ liệu.";
            exit();
        }

        // Kiểm tra xem có người dùng nào tương ứng với tên đăng nhập đã nhập hay không
        if (count($result) == 0) {
            $errors['username'] = "Tên đăng nhập không tồn tại.";
        } else {
            // Lấy mật khẩu đã mã hóa từ cơ sở dữ liệu
            $hashed_password = $result[0]['password'];
            $user_id = $result[0]['id'];
          

            // Kiểm tra mật khẩu
            if (password_verify($password, $hashed_password)) {
                // Mật khẩu chính xác, lưu tên đăng nhập, vai trò và user_id vào session
                $_SESSION["logged_in"] = true;
                $_SESSION["username"] = $username;
                $_SESSION["role"] = $role;
                $_SESSION["id"] = $id;
                $_SESSION["user_id"] = $user_id;
                
           
                // Chuyển hướng tới trang chính
                header("Location: index.php");
                exit();
            } else {
                $errors['password'] = "Mật khẩu không chính xác.";
            }
            if (!array_key_exists('user_id', $_SESSION)) {  
                die("Session user_id not set.");
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
    <title>Đăng nhập</title>
</head>
<body>
    <div class="container">
        <h1>Đăng nhập</h1>
        <form action="" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Tên đăng nhập</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Nhập tên đăng nhập...">
                <?php if (isset($errors['username'])) {
                    echo "<span class='text-danger'>$errors[username]</span>";
                } ?>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu...">
                <?php if (isset($errors['password'])) {
                    echo "<span class='text-danger'>$errors[password]</span>";
                } ?>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Vai trò</label>
                <select class="form-control" id="role" name="role">
                    <option value="">Chọn vai trò</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
                <?php if (isset($errors['role'])) {
                    echo "<span class='text-danger'>$errors[role]</span>";
                } ?>
            </div>
            <button type="submit" class="btn btn-primary">Đăng nhập</button>
            <a href="register.php" class="btn btn-link">Đăng ký tại đây</a>
        </form>
    </div>
</body>
</html>
