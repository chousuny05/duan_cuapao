<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    die("Session user_id not set.");
}

$user_id = $_SESSION['user_id'];
class Cart
{
    public $items = array();

    public function __construct()
    {
        if (!isset($_SESSION['carts'])) {
            $_SESSION['carts'] = [];
        }
        $this->items = $_SESSION['carts'];
    }

    public function add($product)
    {
        $productId = $product['id'];
        if (isset($this->items[$productId])) {
            $this->items[$productId]['quantity']++;
        } else {
            $product['quantity'] = 1;
            $this->items[$productId] = $product;
        }
        $this->setCart();
    }

    public function updateQuantity($productId, $quantity)
    {
        if (isset($this->items[$productId])) {
            $this->items[$productId]['quantity'] = $quantity;
            $this->setCart();
        }
    }

    public function remove($productId)
    {
        if (isset($this->items[$productId])) {
            unset($this->items[$productId]);
            $this->setCart();
        }
    }

    public function clear()
    {
        $this->items = array();
        $this->setCart();
    }

    private function setCart()
    {
        $_SESSION['carts'] = $this->items;
    }

    public function getCart()
    {
        return $this->items;
    }

    public function getTotal()
    {
        $subtotal = 0;
        $discount = 0;
        foreach ($this->items as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        // Áp dụng mã giảm giá nếu có
        if (isset($_SESSION['coupon'])) {
            $discount = $subtotal * $_SESSION['coupon']['discount'];
        }
        $total = $subtotal - $discount;

        return array(
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total
        );
    }
    public function setItems($items) {
        $this->items = $items;
        $_SESSION['cart'] = $items; // Lưu lại vào phiên
    }
}
?>
