<?php
session_start();
include_once("./DBUtil.php");
ini_set('display_errors', '1');
$errors = [];
$dbHelper = new DBUntil();

// Kiểm tra xem có phải phương thức POST không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate từng trường dữ liệu
    if (!isset($_POST["firstname"]) || empty($_POST['firstname'])) {
        $errors['firstname'] = "Full Name is required";
    }

    if (!isset($_POST["email"]) || empty($_POST['email'])) {
        $errors['email'] = "Email is required";
    }

    if (!isset($_POST["address"]) || empty($_POST['address'])) {
        $errors['address'] = "Address is required";
    }


    // Nếu không có lỗi, chèn dữ liệu vào cơ sở dữ liệu
    if (count($errors) == 0) {
      

        // Chèn dữ liệu vào bảng 'orders'
        $isInserted = $dbHelper->insert('orders', array(
            'customer_name' => $_POST['firstname'],
            'address' => $_POST['address'],
            'email' => $_POST['email'],
            'state' => $_POST['state'],
           
        ));
        // var_dump($isInserted );

        // Kiểm tra kết quả chèn dữ liệu
        // if ($isInserted) {
        //     echo "Dữ liệu đã được chèn thành công vào cơ sở dữ liệu.";
        // } else {
        //     echo "Có lỗi khi chèn dữ liệu vào cơ sở dữ liệu.";
        // }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="checkout.css">
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>
    <h2>Responsive Checkout Form</h2>
    <div class="row">
        <div class="col-75">
            <div class="container">
                <form action="" method="post">

                    <div class="row">
                        <div class="col-50">
                            <h3>Billing Address</h3>
                            <label for="fname"><i class="fa fa-user"></i> Full Name</label>
                            <input type="text" id="fname" name="firstname" placeholder="John M. Doe" required>
                            <?php if (!empty($errors['firstname'])) : ?>
                                <span class="error"><?php echo $errors['firstname']; ?></span>
                            <?php endif; ?>

                            <label for="email"><i class="fa fa-envelope"></i> Email</label>
                            <input type="text" id="email" name="email" placeholder="john@example.com" required>
                            <?php if (!empty($errors['email'])) : ?>
                                <span class="error"><?php echo $errors['email']; ?></span>
                            <?php endif; ?>

                            <label for="adr"><i class="fa fa-address-card-o"></i> Address</label>
                            <input type="text" id="adr" name="address" placeholder="542 W. 15th Street" required>
                            <?php if (!empty($errors['address'])) : ?>
                                <span class="error"><?php echo $errors['address']; ?></span>
                            <?php endif; ?>

                          

                            <div class="row">
                                <div class="col-50">
                                    <label for="state">State</label>
                                    <input type="text" id="state" name="state" placeholder="NY" required>
                                    <?php if (!empty($errors['state'])) : ?>
                                        <span class="error"><?php echo $errors['state']; ?></span>
                                    <?php endif; ?>
                                </div>
                              
                            </div>
                        </div>

                        <div class="col-50">
                            <h3>Payment</h3>
                            <label for="fname">Accepted Cards</label>
                            <div class="icon-container">
                                <i class="fa fa-cc-visa" style="color:navy;"></i>
                                <i class="fa fa-cc-amex" style="color:blue;"></i>
                                <i class="fa fa-cc-mastercard" style="color:red;"></i>
                                <i class="fa fa-cc-discover" style="color:orange;"></i>
                            </div>
                            <label for="cname">Name on Card</label>
                            <input type="text" id="cname" name="cardname" placeholder="John More Doe" required>
                            <label for="ccnum">Credit card number</label>
                            <input type="text" id="ccnum" name="cardnumber" placeholder="1111-2222-3333-4444" required>
                            <label for="expmonth">Exp Month</label>
                            <input type="text" id="expmonth" name="expmonth" placeholder="September" required>
                            <div class="row">
                                <div class="col-50">
                                    <label for="expyear">Exp Year</label>
                                    <input type="text" id="expyear" name="expyear" placeholder="2018" required>
                                </div>
                                <div class="col-50">
                                    <label for="cvv">CVV</label>
                                    <input type="text" id="cvv" name="cvv" placeholder="352" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <label>
                        <input type="checkbox" checked="checked" name="sameadr"> Shipping address same as billing
                    </label>
                    <input type="submit" value="Continue to checkout" class="btn">
                </form>
            </div>
        </div>
        <div class="col-25">
            <div class="container">
                <h4>Cart <span class="price" style="color:black"><i class="fa fa-shopping-cart"></i> <b>4</b></span></h4>
                <p><a href="#">Product 1</a></p>
                <!-- Thêm các sản phẩm khác nếu-->

                <!-- Add more product lines as needed -->
                <p><a href="#">Product 2</a></p>
                <!-- Replace with actual product names and links -->

                <!-- Total price can be calculated and displayed here -->
                <hr>
                <p>Total <span class="price" style="color:black"><b>/b></span></p>
            </div>
        </div>

</body>

</html>