<?php
include_once "../class/product.php"; // Bao gồm tệp chứa định nghĩa của lớp product

$product = new product(); // Đảm bảo tên lớp là Product với chữ P viết hoa

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