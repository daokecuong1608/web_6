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

include_once "../class/brand.php"; // Bao gồm tệp chứa định nghĩa của lớp product

$brand = new brand(); // Đảm bảo tên lớp là Brand với chữ B viết hoa
if (isset($_GET['color_id']) && $_GET['color_id'] != NULL) {
    $color_id = $_GET['color_id'];
    $delete_color = $brand->delete_color($color_id);
    if ($delete_color) {
        header('Location: colorlist.php');
        exit();
    } else {
        echo "Xóa màu thất bại.";
    }
} else {
    header('Location: colorlist.php');
    exit();
}
?>