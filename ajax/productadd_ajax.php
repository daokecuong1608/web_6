<?php
include "../class/product.php";

$product = new product();

if (isset($_GET['danhmuc_id'])) {
    $danhmuc_id = $_GET['danhmuc_id'];
    $show_loaisanpham = $product->show_loaisanpham_by_danhmuc($danhmuc_id);

    echo '<option value="">--Chọn--</option>';
    if ($show_loaisanpham) {
        while ($result_loaisanpham = $show_loaisanpham->fetch_assoc()) {
            echo '<option value="' . $result_loaisanpham['loaisanpham_id'] . '">' . $result_loaisanpham['loaisanpham_ten'] . '</option>';
        }
    } else {
        echo '<option value="">Không có loại sản phẩm</option>';
    }
}
?>