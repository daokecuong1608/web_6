<?php
session_start(); // Khởi tạo session
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
include_once "../class/category.php"; // Bao gồm tệp chứa định nghĩa của lớp product
$category = new category();//khởi tạo đối tượng category
if( isset($_GET['danhmuc_id'])|| $_GET['danhmuc_id'] == NULL){
    echo "<script>window.location = 'categorylist.php'</script>";
}else{
    $danhmuc_id = $_GET['danhmuc_id'];
}
$delete_category = $category->delete_category($danhmuc_id);
header('Location:categorylist.php');
?>