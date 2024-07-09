<?php
include_once('./DBUtil.php');
ini_set('display_errors', '1');
include_once("./header.php");

$dbHelper = new DBUntil();

// Khởi tạo biến $thongbao
$thongbao = "";

if (isset($_GET['act'])) {
    $act = $_GET['act'];

    switch ($act) {
        case 'adddm':
            // Kiểm tra xem người dùng có click vào nút "THÊM MỚI" hay không
            if(isset($_POST['themmoi'])&&($_POST['themmoi'])){
                $tenloai=$_POST['tenloai'];
                $sql= "INSERT INTO dm_sanpham(name) values('$tenloai')";
                $thongbao="Thêm thành công";
            }
            include_once("danhmuc/add.php");
            break;
        case 'addsp':
            include_once("product/add.php");
            break;
        default:
            include_once("home.php");
            break;
    }
} else {
    include_once("home.php");
}

include_once("./footer.php");
?>
