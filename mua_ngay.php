<?php
session_start();

// Kết nối và tải các class cần thiết
define('__ROOT__', dirname(__FILE__));
require_once(__ROOT__ . '/class/product.php');
require_once(__ROOT__ . '/lib/database.php');

$product = new Product();
$database = new Database();
// Lấy thông tin từ URL
if (isset($_GET['sanpham_id']) && !empty($_GET['sanpham_id'])) {
    $sanpham_id = $_GET['sanpham_id'];
    $user_id = $_SESSION['user_id']; // Giả sử bạn đã lưu user_id trong session khi người dùng đăng nhập

    if (!$user_id) {
        header('Location: login.php'); // Nếu chưa đăng nhập, chuyển hướng tới trang đăng nhập
        exit();
    }

    // Lấy thông tin chi tiết sản phẩm
    $product_details = $product->get_product_by_id($sanpham_id);
    if ($product_details) {
        // Sử dụng fetch_assoc() để lấy dữ liệu dưới dạng mảng
        $row = $product_details->fetch_assoc();
        
        $sanpham_anh = $row['sanpham_anh'];
        $sanpham_tieude = $row['sanpham_tieude'];
        $sanpham_gia = $row['sanpham_gia'];
        $color_anh = $row['color_anh']; // Màu sắc (hoặc ảnh màu)
        $sanpham_size = 'M'; // Bạn có thể thêm tùy chọn size nếu cần
        $quantitys = 1; // Mặc định là mua 1 sản phẩm



        // Lưu thông tin sản phẩm vào giỏ hàng
        $insert_cart = $product->insert_cart($sanpham_id, $user_id, $sanpham_tieude, $sanpham_gia, $color_anh, $quantitys, $sanpham_size, $sanpham_anh );
        if($insert_cart){
            echo 'Thêm sản phẩm vào giỏ hàng thành công';
            header("Location: delivery.php");
            exit();
        }else{
            echo 'Thêm sản phẩm vào gior hang that bai';
            exit();
        }
    }else{
        echo 'Không tìm thấy sản phẩm';
        exit();
    }
}else{
      // Nếu không nhận đúng tham số, chuyển hướng về trang chủ
      header("Location: index.php");
      exit();
}
?>