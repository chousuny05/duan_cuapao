<?php
ini_set('display_errors', '1');
include "./DBUtils.php";
$dbHelper = new DBUtils();
$id = $_GET['id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Update danh muc</title>
</head>

<body>
    <div class="container">
        <h2>Update Danh mục</h2>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
            if ($_POST['action'] == 'update') {
                if (isset($_POST['username'])) {
                    if (empty($_POST['username'])) {
                        $errors['username'] = "Phải Nhập username";
                    } else {
                        $updated =  $dbHelper->update(
                            "users",
                            array(
                                'username' => $_POST['username'],
                                'email' => $_POST['email'],
                                'password' => $_POST['password'],
                                'role' => $_POST['role'],
                            ),
                            "id=$id"
                        );
                        header("Location: index.php");
                    }
                }
            }
        }
        $dbHelper = new DBUtils();

        $users  = $dbHelper->select("select * from users where id=?", array($id));
        var_dump($users[0]['username']);
        ?>
        <form class="mt-3" method="POST" action="">
            <input class="form-control" type="text" value="<?= $users[0]['username'] ?>" placeholder="ten can sua" name="username"><br>
            <input class="form-control" type="text" value="<?= $users[0]['email'] ?>" placeholder="ten can sua" name="email"><br>
            <input class="form-control" type="text" value="<?= $users[0]['password'] ?>" placeholder="ten can sua" name="password"><br>
            <input class="form-control" type="text" value="<?= $users[0]['role'] ?>" placeholder="ten can sua" name="role"><br>
            <button class="btn btn-success" name="action" value="update" type="submit">update </button>
        </form>

    </div>

</body>

</html>