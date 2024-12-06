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
        $color_ten = $row['color_ten']; // Màu sắc (hoặc ảnh màu)
        $sanpham_size = 'M'; // Bạn có thể thêm tùy chọn size nếu cần
        $quantity = 1; // Mặc định là mua 1 sản phẩm

        // Kiểm tra sản phẩm đã tồn tại trong giỏ hàng chưa
        $checkQuery = "SELECT * FROM tbl_cart WHERE user_id = '$user_id' AND sanpham_id = '$sanpham_id' AND sanpham_size = '$sanpham_size'";
        echo "<pre>Check Query: $checkQuery</pre>"; // Log câu truy vấn
        $checkResult = $database->select($checkQuery);

        if ($checkResult) {
            $rowCart = $checkResult->fetch_assoc();
            $current_quantity = $rowCart['quantitys']; // Đảm bảo trường trong DB là "quantitys"
            $new_quantity = $current_quantity + 1;
            echo "<pre>Current Quantity: $current_quantity</pre>"; // Log số lượng hiện tại
            echo "<pre>New Quantity: $new_quantity</pre>"; // Log số lượng mới

            // Cập nhật số lượng
            $updateQuery = "UPDATE tbl_cart SET quantitys = '$new_quantity' WHERE user_id = '$user_id' AND sanpham_id = '$sanpham_id' AND sanpham_size = '$sanpham_size'";
            echo "<pre>Update Query: $updateQuery</pre>"; // Log câu truy vấn cập nhật
            $database->update($updateQuery);
        } else {
          // Tạo câu truy vấn để thêm sản phẩm vào giỏ hàng
            $insertQuery = "INSERT INTO tbl_cart (sanpham_anh, user_id, sanpham_id, sanpham_tieude, sanpham_gia, color_anh, quantitys, sanpham_size) 
            VALUES ('$sanpham_anh', '$user_id', '$sanpham_id', '$sanpham_tieude', '$sanpham_gia', '$color_anh', '$quantity', '$sanpham_size')";

            // Log câu truy vấn để kiểm tra
            echo "<pre>Insert Query: $insertQuery</pre>";

            // Thực thi câu truy vấn
            $insertResult = $database->insert($insertQuery);

            // Kiểm tra kết quả thêm sản phẩm
            if ($insertResult) {
            echo "<script>alert('Product added to cart successfully!');</script>";
            } else {
            echo "<script>alert('Failed to add product to cart.');</script>";
            }

        }

        // Chuyển hướng tới trang giỏ hàng
        header('Location: cart.php');
        exit();
    } else {
        echo "<script>alert('Product not found.');</script>";
    }
} else {
    echo "<script>alert('No product ID provided.');</script>";
}
?>