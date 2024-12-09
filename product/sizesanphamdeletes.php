<?php
session_start(); 
// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    // Nếu chưa đăng nhập, chuyển hướng về trang login
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
if (isset($_GET['sanpham_size_id']) || $_GET['sanpham_size_id'] != NULL) {
    $sanpham_size_id = $_GET['sanpham_size_id'];
}
$delete_size_sanpham = $product->delete_size_sanpham($sanpham_size_id);
header('Location:sizesanphamlists.php?');

?>