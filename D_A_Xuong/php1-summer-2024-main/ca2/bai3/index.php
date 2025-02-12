<?php
ini_set('display_errors', '1');
include "./DBUtils.php";

$dbHelper = new DBUtils();

// var_dump($categories);

$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'create': {
                if (isset($_POST['name'])) {
                    if (empty($_POST['name'])) {
                        $errors['name'] = "Phải Nhập name";
                    } else {
                        /**
                         * create
                         */
                        $created =  $dbHelper->insert(
                            "categories",
                            array(
                                'name' => $_POST['name']
                            )
                        );
                        var_dump($created);
                    }
                }
            }
            break;
        case 'delete': {
                $id = $_POST['id'];
                $result = $dbHelper->delete('categories', 'id=' . $id);
            }
            break;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>DEMO CRUD</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
        <h2>Danh Mục sản phẩm</h2>
        <form action="" method="post">
            <input type="text" placeholder="enter name" name="name">
            <button class="btn btn-success" name="action" value="create" type="submit">create </button>
            <?php if (isset($errors['name'])) {
                echo "<br/><span class='text-danger mt-5'> $errors[name] <span><br/>";
            }
            ?>

        </form>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $categories  = $dbHelper->select("select * from categories");
                foreach ($categories as $row) : ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= $row['name']; ?></td>
                    <td>
                        <form method="post" action="index.php?id=<?= $row['id'] ?>">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>" />
                            <button type="submit" class="btn btn-danger" name="action" value="delete"
                                type="button">delete</button>
                            <a class="btn btn-info" href="update.php?id=<?= $row['id'] ?>">edit</a>
                        </form>


                    </td>

                </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</body>

</html>