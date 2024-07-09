<!DOCTYPE html>
<html lang="en">

<head>
    <title>Shopping Cart</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./cart.css">
</head>

<body>
    <?php
    include_once('./cart-services.php');
    $carts = new Cart();
    ?>
    <div class="container padding-bottom-3x mb-1">
        <!-- Alert-->
        <!-- Shopping Cart-->
        <div class="table-responsive shopping-cart">
            <table class="table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Subtotal</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($carts->getCart() as $item) { ?>
                        <tr>
                            <td>
                                <div class="product-item">
                                    <a class="product-thumb" href="#"><img style="width: 100px;" src="<?php echo $item['image']; ?>" alt=""></a>
                                    <div class="product-info">
                                        <h4 class="product-title">
                                            Name: <?php echo $item['name']; ?><br>
                                            Price: <?php echo '$' . number_format($item['price'], 2); ?>
                                        </h4>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <form method="post" action="cart-update.php">
                                    <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                    <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" onchange="this.form.submit()">
                                </form>
                            </td>
                            <td class="text-center text-lg text-medium"><?php echo '$' . number_format($item['price'] * $item['quantity'], 2); ?></td>
                            <td class="text-center">
                                <form method="post" action="cart-remove.php">
                                    <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="shopping-cart-footer">
            <div class="column">
                <form class="coupon-form" method="post" action="apply-coupon.php">
                <input class="form-control" type="text" name="coupon_code" placeholder="Nhập mã giảm giá" required>
                 <button class="btn btn-outline-primary" type="submit">Áp dụng mã</button>
                </form>
            </div>
            <div class="column text-lg">
                <?php
                $totals = $carts->getTotal();
                ?>
                Subtotal: <span class="text-medium"><?php echo '$' . number_format($totals['subtotal'], 2); ?></span><br>
                Giảm giá: <span class="text-medium"><?php echo '$' . number_format($totals['discount'], 2); ?></span><br>
                Total: <span class="text-medium"> <?php echo '$' . number_format($totals['total'], 2); ?></span>
            </div>
        </div>
        <div class="shopping-cart-footer">
            <div class="column"><a class="btn btn-outline-secondary" href="index.php"><i class="icon-arrow-left"></i>&nbsp;Back
                    to Shopping</a></div>
          <div class="column"><a class="btn btn-primary" href="#" data-toast="" data-toast-type="success" data-toast-position="topRight" data-toast-icon="icon-circle-check" data-toast-title="Your cart" data-toast-message="is updated successfully!">Update Cart</a>  
                <a class="btn btn-success" href="checkout.php">Checkout</a>
            </div>
        </div>
    </div>
</body>

</html>