<?php
include_once "../class/product.php"; // Bao gồm tệp chứa định nghĩa của lớp product

$product = new product(); // Đảm bảo tên lớp là Product với chữ P viết hoa
if (isset($_GET['sanpham_anh_id']) || $_GET['sanpham_anh_id'] != NULL) {
    $sanpham_anh_id = $_GET['sanpham_anh_id'];
}
$delete_anh_sanpham = $product->delete_anh_sanpham($sanpham_anh_id);
header('Location:productlist.php?');

?>