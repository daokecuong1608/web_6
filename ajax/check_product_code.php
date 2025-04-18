<?php
ini_set('display_errors', 1);  // Hiển thị lỗi PHP
error_reporting(E_ALL);  // Báo lỗi đầy đủ

include_once "../class/product.php";

// Set header cho JSON
header('Content-Type: application/json');

// Đảm bảo không có ký tự thừa trong dữ liệu phản hồi
ob_clean(); // Xóa bất kỳ nội dung nào đã được ghi ra

// Kiểm tra nếu có mã sản phẩm
if (isset($_GET['sanpham_ma'])) {
    $sanpham_ma = $_GET['sanpham_ma'];
    $product = new product();
    
    // Kiểm tra nếu mã sản phẩm đã tồn tại
    $exists = $product->check_product_code($sanpham_ma); // Hàm kiểm tra mã sản phẩm

    echo json_encode(['exists' => $exists]); // Trả về true/false tùy theo kết quả
    exit();
} else {
    echo json_encode(['exists' => false]); // Nếu không có mã sản phẩm
    exit();
}
?>