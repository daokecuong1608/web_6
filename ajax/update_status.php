<?php
include '../class/index_class.php';
$index = new index();

if (isset($_POST['cart_id']) && isset($_POST['status'])) {
    $cart_id = $_POST['cart_id'];
    $status = $_POST['status'];

     // Gọi phương thức cập nhật trạng thái
     $resultMessage = $index->updateCartStatus($cart_id, $status);

     echo $resultMessage;
} else {
    echo "Dữ liệu không hợp lệ.";
}
?>