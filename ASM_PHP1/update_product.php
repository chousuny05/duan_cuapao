<?php
ini_set('display_errors', '1');
include "./DBUtils.php";
$dbHelper = new DBUtils();
$id = $_GET['id'];
$errors = [];

// Fetch the existing category data
$product = $dbHelper->select("SELECT * FROM products WHERE id=?", array($id));
if (empty($product)) {
    die("product not found.");
}
$product = $product[0];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'update') {
        if (isset($_POST['name']) && empty($_POST['name'])) {
            $errors['name'] = "Phải Nhập name";
        }
        if (isset($_POST['description']) && empty($_POST['description'])) {
            $errors['description'] = "Phải Nhập description";
        }
        if (isset($_POST['image']) && empty($_POST['image'])) {
            $errors['image'] = "Phải Nhập image";
        }
        if (isset($_POST['price']) && empty($_POST['price'])) {
            $errors['price'] = "Phải Nhập price";
        }
        if (isset($_POST['quantity']) && empty($_POST['quantity'])) {
            $errors['quantity'] = "Phải Nhập quantity";
        }
        if (isset($_POST['sale']) && empty($_POST['sale'])) {
            $errors['sale'] = "Phải Nhập sale";
        }
        if (isset($_POST['status']) && empty($_POST['status'])) {
            $errors['status'] = "Phải Nhập status";
        }

        if (empty($errors)) {
            $updated = $dbHelper->update(
                "products",
                array(
                    'name' => $_POST['name'],
                    'description' => $_POST['description'],
                    'image' => $_POST['image'],
                    'price' => $_POST['price'],
                    'quantity' => $_POST['quantity'],
                    'sale' => $_POST['sale'],
                    'status' => $_POST['status'],
                ),
                "id=$id"
            );
            header("Location: index.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Update Danh Mục</title>
</head>
<body>
    <div class="container">
        <h2>Update Danh mục</h2>
        <form class="mt-3" method="POST" action="" >
            <input type="text" class="form-control" placeholder="enter name" name="name" value="<?= htmlspecialchars($product['name']) ?>"><br>
            <?php if (isset($errors['name'])) {
                echo "<span class='text-danger'>$errors[name]</span><br/>";
            } ?>
            <input type="text" class="form-control" name="description" placeholder="description" value="<?= htmlspecialchars($product['description']) ?>"><br>
            <?php if (isset($errors['description'])) {
                echo "<span class='text-danger'>$errors[description]</span><br/>";
            } ?>
            <input type="url" class="form-control" id="image" name="image" placeholder="https://example.com/image.jpg" value="<?= htmlspecialchars($product['image']) ?>"><br>
            <?php if (isset($errors['image'])) {
                echo "<span class='text-danger'>$errors[image]</span><br/>";
            } ?>
            <input type="text" class="form-control" name="price" placeholder="price" value="<?= htmlspecialchars($product['price']) ?>"><br>
            <?php if (isset($errors['price'])) {
                echo "<span class='text-danger'>$errors[price]</span><br/>";
            } ?>
            <input type="text" class="form-control" name="quantity" placeholder="quantity" value="<?= htmlspecialchars($product['quantity']) ?>"><br>
            <?php if (isset($errors['quantity'])) {
                echo "<span class='text-danger'>$errors[quantity]</span><br/>";
            } ?>
            <input type="text" class="form-control" name="sale" placeholder="sale" value="<?= htmlspecialchars($product['sale']) ?>"><br>
            <?php if (isset($errors['sale'])) {
                echo "<span class='text-danger'>$errors[sale]</span><br/>";
            } ?>
            <input type="text" class="form-control" name="status" placeholder="status" value="<?= htmlspecialchars($product['status']) ?>"><br>
            <?php if (isset($errors['status'])) {
                echo "<span class='text-danger'>$errors[status]</span><br/>";
            } ?>
            <button class="btn btn-success" name="action" value="update" type="submit">Update</button>
        </form>
    </div>
    
</body>
</html>
