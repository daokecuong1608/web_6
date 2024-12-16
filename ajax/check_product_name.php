<?php
ini_set('display_errors', 1);  // Hiển thị lỗi PHP
error_reporting(E_ALL);  // Báo lỗi đầy đủ

include_once "../class/product.php";

// Set header cho JSON
header('Content-Type: application/json');

// Đảm bảo không có ký tự thừa trong dữ liệu phản hồi
ob_clean(); // Xóa bất kỳ nội dung nào đã được ghi ra

// Kiểm tra dữ liệu từ GET request
if (isset($_GET['sanpham_tieude'])) {
    $sanpham_tieude = trim($_GET['sanpham_tieude']); // Loại bỏ khoảng trắng thừa từ tên sản phẩm

    $product = new product();

    // Kiểm tra nếu sản phẩm đã tồn tại
    $exists = $product->check_product_name($sanpham_tieude); // Giả sử trả về true/false

    // Trả về dữ liệu JSON hợp lệ
    echo json_encode(['exists' => $exists]); // Trả về giá trị thực tế từ hàm check_product_name
    exit();
} else {
    // Trả về JSON với thông tin lỗi nếu không có tên sản phẩm
    echo json_encode(['exists' => false]);  
    exit();
}
?>