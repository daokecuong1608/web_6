<?php
session_start();
if (!defined('__ROOT__')) {
    define('__ROOT__', dirname(dirname(__FILE__))); // Định nghĩa hằng số __ROOT__ nếu chưa được định nghĩa
}
include_once(__ROOT__ . "/class/product.php"); // Bao gồm tệp chứa định nghĩa của lớp product

$product = new product();

if (!isset($_SESSION['user_id'])) {
    // Nếu người dùng chưa đăng nhập, chuyển hướng đến trang đăng nhập
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $sanpham_id = intval($_GET['id']);
    $quantity = 1; // Số lượng mặc định là 1
    $user_id = $_SESSION['user_id'];

    // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
    $query = "SELECT * FROM cart WHERE user_id = ? AND sanpham_id = ?";
    $stmt = $product->db->link->prepare($query);
    $stmt->bind_param("ii", $user_id, $sanpham_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Nếu sản phẩm đã có trong giỏ hàng, tăng số lượng lên 1
        $query = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND sanpham_id = ?";
        $stmt = $product->db->link->prepare($query);
        $stmt->bind_param("ii", $user_id, $sanpham_id);
        $stmt->execute();
    } else {
        // Nếu sản phẩm chưa có trong giỏ hàng, thêm sản phẩm vào giỏ hàng
        $query = "INSERT INTO cart (user_id, sanpham_id, quantity) VALUES (?, ?, ?)";
        $stmt = $product->db->link->prepare($query);
        $stmt->bind_param("iii", $user_id, $sanpham_id, $quantity);
        $stmt->execute();
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