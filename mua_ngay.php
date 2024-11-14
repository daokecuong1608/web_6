<?php
session_start();
if (!defined('__ROOT__')) {
    define('__ROOT__', dirname(dirname(__FILE__))); // Định nghĩa hằng số __ROOT__ nếu chưa được định nghĩa
}
include_once "../class/product.php"; // Bao gồm tệp chứa định nghĩa của lớp product

$product = new product();

if (!isset($_SESSION['userid'])) {
    // Nếu người dùng chưa đăng nhập, chuyển hướng đến trang đăng nhập
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $sanpham_id = intval($_GET['id']);
    $quantity = 1; // Số lượng mặc định là 1

    // Kiểm tra xem giỏ hàng đã tồn tại trong session chưa
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
    if (isset($_SESSION['cart'][$sanpham_id])) {
        // Nếu sản phẩm đã có trong giỏ hàng, tăng số lượng lên 1
        $_SESSION['cart'][$sanpham_id]['quantity'] += $quantity;
    } else {
        // Nếu sản phẩm chưa có trong giỏ hàng, thêm sản phẩm vào giỏ hàng
        $product_details = $product->get_sanpham($sanpham_id);
        if ($product_details) {
            $row = $product_details->fetch_assoc();
            $_SESSION['cart'][$sanpham_id] = array(
                'sanpham_id' => $row['sanpham_id'],
                'sanpham_tieude' => $row['sanpham_tieude'],
                'sanpham_gia' => $row['sanpham_gia'],
                'quantity' => $quantity
            );
        }
    }

    // Chuyển hướng người dùng đến trang giỏ hàng hoặc trang thanh toán
    header("Location: cart.php");
    exit();
} else {
    // Nếu không có tham số id, chuyển hướng người dùng về trang chủ
    header("Location: index.php");
    exit();
}
?>