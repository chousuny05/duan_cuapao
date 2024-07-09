<?php
include_once('./DBUtil.php');
include_once('./cart.php');
ini_set('display_errors', '1');
$dbHelper = new DBUntil();
$categories = $dbHelper->select("select * from products");
$errors = [];
$carts = new Cart();
$discount = 0;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'checkCode') {
    if (isset($_POST['code']) && !empty($_POST['code'])) {
        $code = $dbHelper->select(
            "SELECT * FROM coupons WHERE code = :code AND quantity > 0 AND 
            startDate <= :currentDate AND endDate >= :currentDate",
            array(
                'code' => $_POST['code'],
                'currentDate' => date("Y-m-d")
            )
        );
        if (count($code) == 0) {
            $errors['code'] = "Invalid code";
        } else {
            // Giảm số lượng mã giảm giá
            $dbHelper->select("UPDATE coupons SET quantity = quantity - 1 WHERE code = :code", array('code' => $_POST['code']));
            // Lấy tỉ lệ giảm giá từ mã giảm giá
            $discount = $code[0]['discount'];
        }
    }
}

$total = $carts->getTotal();
$discountedTotal = $carts->applyDiscount($discount);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <style>
        .flex-center {
            margin-top: 20px;
            display: flex;
            justify-content: end;
        }

        .txt-danger {
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="container mt-3">
        <h2>Sản phẩm</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>id</th>
                    <th>tên sản phẩm</th>
                    <th>hình ảnh</th>
                    <th>giá bán </th>
                    <th>số lượng</th>
                    <th>action</th>
                </tr>
            </thead>

            <?php
            foreach ($categories as $item) {
                echo "<tr>";
                echo "<td>$item[id]</td>";
                echo "<td>$item[name]</td>";
                echo "<td><img src='$item[image]' width='200px'/></td>";
                echo "<td>$item[price]</td>";
                echo "<td>$item[quantity]</td>";
                echo "<td> <a class='btn btn-primary' href='cart-handle.php?id=$item[id]&action=add'><i class='bi bi-cart'></i> Thêm vào giỏ hàng</a></td>";
                echo "</tr>";
            }
            ?>
        </table>

        <h2>Giỏ hàng</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>id</th>
                    <th>tên sản phẩm</th>
                    <th>giá bán </th>
                    <th>số lượng</th>
                    <th>Tổng tiền</th>
                    <th>action</th>
                </tr>
            </thead>

            <?php
            foreach ($carts->getCart() as $item) {
                $subTotal = $item['quantity'] * $item['price'];
                echo "<tr>";
                echo "<td>$item[id]</td>";
                echo "<td>$item[name]</td>";
                echo "<td>$item[price]</td>";
                echo "<td>$item[quantity]</td>";
                echo "<td>$subTotal</td>";
                echo "<td> <a class='btn btn-danger' href='cart-handle.php?id=$item[id]&action=remove'><i class='bi bi-x'></i></a></td>";
                echo "</tr>";
            }
            ?>
        </table>

        <form method="post" action="">
            <div class="flex-center">
                <input type="text" name="code" class="form-control" style="width: 200px" placeholder="nhập mã khuyến mãi" />
                <button type="submit" class="btn btn-primary" name="action" value="checkCode">Apply</button>
                <a href=""></a>
                <?php if (isset($errors['code'])) {
                    echo "<br/>";
                    echo "<span class='txt-danger'>$errors[code]</span>";
                } ?>
            </div>
        </form>

        <h2>Tổng đơn hàng: <?= number_format($total) ?>VNĐ</h2>
        <?php if ($discount > 0) : ?>
            <h2>Giảm giá: <?= $discount ?>%</h2>
            <h2>Tổng sau khi giảm giá: <?= number_format($discountedTotal) ?> VNĐ</h2>
        <?php endif; ?>
        <a href="checkout.php" class="btn btn-primary" >CHECKOUT</a><br>
    </div>
<br>
</body>

</html>