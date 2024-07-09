<?php
session_start();
include_once('./cart-services.php');

$carts = new Cart();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $quantity = intval($_POST['quantity']);
    $carts->updateQuantity($id, $quantity);
}

header('Location: cart.php');
exit;
?>
