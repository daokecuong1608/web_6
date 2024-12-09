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

$product = new product(); 
if (!isset($_GET['sanpham_id'])|| $_GET['sanpham_id']==NULL){
    echo "<script>window.location = 'productlist.php'</script>";
}else {
    $sanpham_id = $_GET['sanpham_id'];
}
$delete_product = $product  -> delete_product($sanpham_id);
$delete_product_anh =  $product -> delete_product_anh($sanpham_id);
header('Location:productlist.php');
?>