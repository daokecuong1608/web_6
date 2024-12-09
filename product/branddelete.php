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
require_once "../class/brand.php"; 
$brand = new brand(); 
if (isset($_GET['loaisanpham_id']) && $_GET['loaisanpham_id'] != NULL) {
    $loaisanpham_id = $_GET['loaisanpham_id'];
}
$delete_brand = $brand->delete_brand($loaisanpham_id);
header('Location:brandlist.php');


?>