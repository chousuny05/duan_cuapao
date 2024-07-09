<?php
include_once("DBUtil.php");
session_start();
$errors = [];

function login(){
    global $errors;
    if(!isset($_POST['username']) || empty($_POST['username'])){
        $errors['username'] = "Vui lòng nhập Tên";
    }
    if(!isset($_POST['password']) || empty($_POST['password'])){
        $errors['password'] = "Vui lòng nhập mật khẩu";
    }
    if(!isset($_POST['email']) || empty($_POST['email'])){
        $errors['email'] = "Vui lòng nhập Email";
    }
    if(!isset($_POST['role']) || empty($_POST['role'])){
        $errors['role'] = "Vui lòng nhập Role";
    }
    
   
    return $errors;
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $errors = login();

    if(count($errors) == 0){
        $dbUtils = new DBUntil();
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $role = $_POST['role'];

        $result = $dbUtils->select(
            "SELECT * FROM users WHERE username = :username",
            [':username' => $username]
        );
        
        if($result === false){
            echo "Truy vấn cơ sở dữ liệu lỗi";
            exit();
        }
        
        // Kiểm tra Tên có tồn tại không
        if(count($result) == 0){
            $errors['username'] = "Tên người dùng không tồn tại";
        } else {
            // Lấy mật khẩu đã mã hóa từ cơ sở dữ liệu
            $hashed_password = $result[0]['password'];
            
            // Kiểm tra mật khẩu
            if (password_verify($password, $hashed_password)) {
                // Mật khẩu chính xác, lưu thông tin người dùng vào session
                $_SESSION["logged_in"] = true;
                $_SESSION["username"] = $username;
                $_SESSION["id"] = $result[0]['user_id'];
                $_SESSION["email"] = $result[0]['email'];
                $_SESSION["role"] = $result[0]['role'];
                
                // Chuyển hướng tới trang chính
                header("Location: index.php");
                exit();
            } else {
                $errors['password'] = "Mật khẩu không chính xác.";
            }
            
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://kit.fontawesome.com/e5e78b1ae2.js" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login/reset.css">
    <link rel="stylesheet" href="../css/login/app.css">
    <title>Document</title>
</head>
<body>
    <div id="wrapper">
        <form action="" id="form-login" method="post">
            <h1 class="form-header">FORM LOGIN</h1>
            <div class="form-group">
                <i class="fa-regular fa-user"></i>
                <input type="text" class="form-input" name="username" placeholder="Tên đăng nhập">
                <?php
                if (isset($errors['username'])) {
                    echo "<span class='txt-dange'>{$errors['username']}</span>";
                }
                ?>
            </div>
            <div class="form-group">
                <i class="fa-solid fa-key"></i>
                <input type="password" class="form-input" name="password" placeholder="Mật khẩu">
                <div id="eye"><i class="fa-regular fa-eye"></i></div>
                <?php
                if (isset($errors['password'])) {
                    echo "<span class='txt-dange'>{$errors['password']}</span>";
                }
                ?>
            </div>
            <input type="submit" value="Đăng nhập" class="form-submit">
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="../js/app.js"></script>
</body>
</html>
