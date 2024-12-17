<?php
include '../class/index_class.php';
$index = new index();
if (isset($_POST['sanpham_id']) && isset($_POST['quantity'])) {
    $sanpham_id = $_POST['sanpham_id'];
    $quantity = $_POST['quantity'];

    $result = $index->update_sanpham_quantity($sanpham_id, $quantity);

    if ($result) {
        echo "Cập nhật số lượng sản phẩm thành công.";
    } else {
        echo "Cập nhật số lượng sản phẩm thất bại.";
    }
} else {
    echo "Dữ liệu không hợp lệ.";
}
?>