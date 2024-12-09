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

include_once "../class/staff.php"; // Bao gồm tệp chứa định nghĩa của lớp product

$staff = new staff();
if(isset($_GET['staff_id'])){
    $staff_id = $_GET['staff_id'];
    $delete_staff = $staff->delete_staff($staff_id);
    header('Location: stafflist.php');
}

?>