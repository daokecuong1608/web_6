<?php
session_start(); // Khởi tạo session
// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: /web_quan_ao/login.php");  
      exit();
}
// Kiểm tra xem người dùng có phải là admin không
if ($_SESSION['role'] !== 'admin') {
    header("Location: /web_quan_ao/index.php");  
    exit();
}
include_once "../class/product.php"; // Bao gồm tệp chứa định nghĩa của lớp product
$product = new product(); // Đảm bảo tên lớp là Product với chữ P viết hoa
if (isset($_GET['sanpham_anh_id']) || $_GET['sanpham_anh_id'] != NULL) {
    $sanpham_anh_id = $_GET['sanpham_anh_id'];
}
$delete_anh_sanpham = $product->delete_anh_sanpham($sanpham_anh_id);
header('Location:productlist.php?');

?>