<?php

$id = $_GET['id'];
var_dump($id);


$dbHelper = new DBUntil();

$categories = $dbHelper->delete("categories", "id = $id");
// session thong bao

$_SESSION['message'] = "xoa thanh cong";

header("Location: index.php?view=category_list");
