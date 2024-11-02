<?php
include_once "../class/product.php"; // Bao gồm tệp chứa định nghĩa của lớp product

$product = new product(); // Đảm bảo tên lớp là Product với chữ P viết hoa
if (isset($_GET['sanpham_size_id']) || $_GET['sanpham_size_id'] != NULL) {
    $sanpham_size_id = $_GET['sanpham_size_id'];
}
$delete_size_sanpham = $product->delete_size_sanpham($sanpham_size_id);
header('Location:productlist.php?');

?>