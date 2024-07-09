<?php
session_start();
include_once('./cart-services.php');

$carts = new Cart();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $carts->remove($id);
}

header('Location: cart.php');
exit;
?>
