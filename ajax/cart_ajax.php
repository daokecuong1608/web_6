<?php
include '../class/index_class.php';
$index = new index();

if(isset($_POST['sanpham_anh'])){
    $sanpham_tieude = $_POST['sanpham_tieude'];
    $session_id = $_POST['session_id'];
    $sanpham_id = $_POST['sanpham_id'];
    $sanpham_anh = $_POST['sanpham_anh'];
    $sanpham_gia = $_POST['sanpham_gia'];
    $color_anh = $_POST['color_anh'];
    $quantitys = $_POST['quantitys'];
    $sanpham_size = $_POST['sanpham_size'];
    $insert_cart = $index->insert_cart($sanpham_anh, $session_id, $sanpham_id, $sanpham_tieude, $sanpham_gia, $color_anh, $quantitys, $sanpham_size);
    if ($insert_cart) {
        echo "Sản phẩm đã được thêm vào giỏ hàng.";
    } else {
        echo "Lỗi khi thêm sản phẩm vào giỏ hàng.";
    }
} else {
    echo "Dữ liệu không hợp lệ.";
}
?>