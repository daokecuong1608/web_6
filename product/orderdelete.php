<?php

session_start(); 

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

include_once "../helper/format.php";
include_once "../class/product.php"; // Bao gồm tệp chứa định nghĩa của lớp product

$product = new product(); 
if (!isset($_GET['user_id'])|| $_GET['user_id']==NULL){
    echo "<script>window.location = 'orderlistall.php'</script>";

}else{
    $user_id = $_GET['user_id'];
}

 $delete_payment = $product  -> delete_payment($user_id);
    $delete_order =  $product -> delete_order($user_id);
    $delete_cart =  $product -> delete_cart($user_id);

    header('Location:orderlistall.php');
?>