<?php
include_once("./DBUtil.php");

$dbHelper = new DBUntil();

$errors = [];
// Kiểm tra xem request method có phải là POST hay không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra xem trường name có tồn tại và không rỗng không
    if (!isset($_POST["name"]) || empty($_POST['name'])) {
        $errors['name'] = "Name is required";
    }
    // Kiểm tra xem trường code có tồn tại và không rỗng không
    if (!isset($_POST["code"]) || empty($_POST['code'])) {
        $errors['code'] = "Code is required";
    } else {
        // Kiểm tra xem mã giảm giá đã tồn tại trong cơ sở dữ liệu chưa
        $code = $dbHelper->select("SELECT * FROM coupons WHERE code = ?", [$_POST['code']]);
        if ($code) {
            $errors['code'] = "Code already exists";
        }
    }
}
?>