<?php
ini_set('display_errors', '1');
include "./DBUtils.php";

session_start();

$dbHelper = new DBUtils();

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['role'] !== 'admin') {
    echo "Bạn không có quyền truy cập trang này. <a href=index.php>callback index</a>";
    exit();
}

// Nội dung trang quản lý người dùng cho admin
echo "Trang quản lý người dùng.";
?>
<a href="logout.php">Đăng xuất</a>
<?php
$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'create': {
                if (isset($_POST['username'])) {
                    if (empty($_POST['username'])) {
                        $errors['username'] = "Phải nhập username";
                    }
                }
                if (isset($_POST['email'])) {
                    if (empty($_POST['email'])) {
                        $errors['email'] = "Phải nhập email";
                    }
                }
                if (isset($_POST['role'])) {
                    if (empty($_POST['role'])) {
                        $errors['role'] = "Phải nhập role";
                    }
                }
                if (isset($_POST['password'])) {
                    if (empty($_POST['password'])) {
                        $errors['password'] = "Phải nhập password";
                    }
                }
                if (count($errors) === 0) {
                    $created = $dbHelper->insert(
                        "users",
                        array(
                            'username' => $_POST['username'],
                            'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
                            'email' => $_POST['email'],
                            'role' => $_POST['role']
                        )
                    );
                    // var_dump($created);
                }
            }
            break;
            case 'delete': {
                $id = $_POST['id'];
                $result = $dbHelper->delete('users', 'id=:id', ['id' => $id]);
            }
            break;            
    }
}

// Xử lý tìm kiếm
$search_keyword = "";
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search'])) {
    $search_keyword = $_GET['search'];
}

// Hàm làm nổi bật từ khóa tìm kiếm
function highlightKeyword($text, $keyword) {
    if ($keyword) {
        $text = preg_replace("/($keyword)/i", "<span style='background-color:yellow;'>$1</span>", $text);
    }
    return $text;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>DEMO CRUD</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
   <div class="container">
       <h2>Quản lý user</h2>
        <form action="" method="post">
            <input type="text" id="username" name="username" class="form-control" placeholder="Enter name" ><br>
            <input type="text" id="email" name="email" class="form-control" placeholder="Enter email"><br>
            <input type="password" id="password" name="password" class="form-control" placeholder="Enter password"><br>
            <input type="text" id="role" name="role" class="form-control" placeholder="Enter role"><br>
            <button class="btn btn-success" name="action" value="create" type="submit">Tạo mới</button>
            <?php 
            foreach ($errors as $error) {
                echo "<br/><span class='text-danger mt-5'>$error</span><br/>";
            }
            ?>
        </form>
         <!-- Form tìm kiếm -->
         <form action="" method="get" class="mt-3">
            <input type="text" id="search" name="search" class="form-control" placeholder="Tìm kiếm user" value="<?= htmlspecialchars($search_keyword) ?>">
            <button class="btn btn-primary mt-2" type="submit">Tìm kiếm</button>
            <button style="background-color: #000;" class="btn btn-primary mt-2"><a style="color: white;" href="index.php">Trở về trang chủ</a></button>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>id</th>
                    <th>username</th>
                    <th>email</th>
                    <th>password</th>
                    <th>role</th>
                    <th>action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                  // Truy vấn dữ liệu
                  if (!empty($search_keyword)) {
                    $users = $dbHelper->select("SELECT * FROM users WHERE username LIKE '%$search_keyword%'");
                } else {
                    $users = $dbHelper->select("SELECT * FROM users");
                }

                foreach ($users as $row) : ?>
                    <tr>
                        <td><?= $row['id']; ?></td>
                        <td><?= highlightKeyword($row['username'], $search_keyword); ?></td>
                        <td><?= $row['email']; ?></td>
                        <td><?= $row['password']; ?></td>
                        <td><?= $row['role']; ?></td>
                        <td>
                            <form method="post" action="">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>" />
                                <button type="submit" class="btn btn-danger" name="action" value="delete">Delete</button>
                                <a class="btn btn-info" href="update_user.php?id=<?= $row['id'] ?>">Edit</a>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody> 
        </table>
    </div>
</body>
</html>
