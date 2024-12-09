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

include_once "../class/product.php"; 

$product = new product(); 

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $current_status = $product->get_order_status($user_id);

    if ($current_status !== null) {
        $new_status = ($current_status == 1) ? 0 : 1;
        $update_result = $product->update_order_status($user_id, $new_status);

        if ($update_result) {
            header("Location: orderlistall.php?message=Status updated successfully.");
            exit();
        } else {
            header("Location: orderlistall.php?message=Failed to update status.");
            exit();
        }
    } else {
        header("Location: orderlistall.php?message=Invalid order ID.");
        exit();
    }
} else {
    header("Location: orderlistall.php?message=No order ID provided.");
    exit();
}
?>