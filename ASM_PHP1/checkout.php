<?php
ob_start();
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
include_once("./DBUtils.php");
include_once("./cart.php");

$errors = [];

// Kiểm tra và lấy user_id từ session (giả sử đã được lưu từ khi người dùng đăng nhập)
if (!isset($_SESSION['user_id'])) {
    die("Session user_id not set.");
}

$user_id = $_SESSION['user_id'];

// Khởi tạo đối tượng DBUtils để sử dụng các phương thức truy vấn CSDL
$dbHelper = new DBUtils();

// Xử lý khi người dùng nhấn nút thanh toán
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate các trường dữ liệu
    $firstname = htmlspecialchars($_POST["firstname"]);
    $email = htmlspecialchars($_POST["email"]);
    $phone = htmlspecialchars($_POST["phone"]);
    $state = htmlspecialchars($_POST["state"]);
    $address = htmlspecialchars($_POST["address"]);

    if (empty($firstname)) {
        $errors['firstname'] = "Tên đầy đủ là bắt buộc.";
    }
    if (empty($email)) {
        $errors['email'] = "Email là bắt buộc.";
    }
    if (empty($phone)) {
        $errors['phone'] = "Số điện thoại là bắt buộc.";
    }
    if (empty($state)) {
        $errors['state'] = "Tỉnh/thành phố là bắt buộc.";
    }
    if (empty($address)) {
        $errors['address'] = "Địa chỉ là bắt buộc.";
    }

    // Nếu không có lỗi, thực hiện lưu đơn hàng vào cơ sở dữ liệu
    if (count($errors) == 0) {
        // Lấy thông tin giỏ hàng từ session (giả sử đã lưu từ trang trước)
        $carts = $_SESSION['carts'];

        // Tính tổng số tiền của đơn hàng
        $totals = calculateTotals($carts);

        // Chèn thông tin đơn hàng vào bảng orders
        $order_id = $dbHelper->insert('orders', [
            'user_id' => $user_id,
            'customer_name' => $firstname,
            'email' => $email,
            'phone' => $phone,
            'state' => $state,
            'address' => $address,
            'total' => $totals['total'],
            'status' => 'Đang xử lý' // Mặc định là đang xử lý khi mới tạo đơn hàng
        ]);

        if ($order_id) {
            // Lưu thông tin chi tiết sản phẩm vào bảng order_details
            foreach ($carts as $item) {
                $product_name = $item['name'];
                $quantity = $item['quantity'];
                $price = $item['price'];

                // Chèn thông tin chi tiết đơn hàng vào bảng order_details
                $isDetailInserted = $dbHelper->insert('order_details', [
                    'order_id' => $order_id,
                    'product_name' => $product_name,
                    'quantity' => $quantity,
                    'price' => $price,
                    'created_at' => date('Y-m-d H:i:s'), // Thời điểm hiện tại
                    'updated_at' => date('Y-m-d H:i:s') // Thời điểm hiện tại
                ]);

                if (!$isDetailInserted) {
                    echo "Có lỗi khi lưu chi tiết đơn hàng.";
                    // Xử lý thêm logic xóa đơn hàng đã tạo thành công ở đây nếu cần thiết
                    break;
                }
            }

            // Xóa giỏ hàng sau khi đã thanh toán thành công
            unset($_SESSION['carts']);

            // Chuyển hướng đến trang cảm ơn
            header("Location: thankyou.php");
            exit();
        } else {
            echo "Có lỗi xảy ra khi lưu đơn hàng vào cơ sở dữ liệu.";
        }
    }
}

// Hàm tính tổng số tiền trong giỏ hàng
function calculateTotals($cart) {
    $subtotal = 0;
    foreach ($cart as $item) {
        $subtotal += $item['quantity'] * $item['price'];
    }

    $discount = 0; // Giả sử không có giảm giá
    $total = $subtotal - $discount;

    return [
        'subtotal' => $subtotal,
        'discount' => $discount,
        'total' => $total
    ];
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thanh toán</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Thông tin thanh toán</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="mb-3">
            <label for="firstname" class="form-label">Họ và tên</label>
            <input type="text" class="form-control" id="firstname" name="firstname" required>
            <?php if (isset($errors['firstname'])) echo "<span class='text-danger'>" . $errors['firstname'] . "</span>"; ?>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
            <?php if (isset($errors['email'])) echo "<span class='text-danger'>" . $errors['email'] . "</span>"; ?>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Số điện thoại</label>
            <input type="text" class="form-control" id="phone" name="phone" required>
            <?php if (isset($errors['phone'])) echo "<span class='text-danger'>" . $errors['phone'] . "</span>"; ?>
        </div>
        <div class="mb-3">
            <label for="state" class="form-label">Tỉnh/Thành phố</label>
            <input type="text" class="form-control" id="state" name="state" required>
            <?php if (isset($errors['state'])) echo "<span class='text-danger'>" . $errors['state'] . "</span>"; ?>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Địa chỉ</label>
            <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
            <?php if (isset($errors['address'])) echo "<span class='text-danger'>" . $errors['address'] . "</span>"; ?>
        </div>

        <!-- Hiển thị thông tin sản phẩm từ giỏ hàng -->
        <div class="mb-3">
            <h3>Thông tin sản phẩm</h3>
            <ul>
                <?php foreach ($_SESSION['carts'] as $item): ?>
                    <li><?php echo $item['name']; ?> - Số lượng: <?php echo $item['quantity']; ?> - Giá: <?php echo '$' . number_format($item['price'], 2); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Hiển thị tổng số tiền -->
        <div class="column text-lg">
            <?php
            $totals = calculateTotals($_SESSION['carts']);
            ?>
            Subtotal: <span class="text-medium"><?php echo '$' . number_format($totals['subtotal'], 2); ?></span><br>
            Giảm giá: <span class="text-medium"><?php echo '$' . number_format($totals['discount'], 2); ?></span><br>
            Total: <span class="text-medium"> <?php echo '$' . number_format($totals['total'], 2); ?></span>
        </div>

        <button type="submit" class="btn btn-primary">Xác nhận thanh toán</button>
    </form>
</div>
</body>
</html>
