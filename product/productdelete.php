<?php
include_once "../class/product.php"; // Bao gồm tệp chứa định nghĩa của lớp product

$product = new product(); 
if (!isset($_GET['sanpham_id'])|| $_GET['sanpham_id']==NULL){
    echo "<script>window.location = 'productlist.php'</script>";
}else {
    $sanpham_id = $_GET['sanpham_id'];
}
$delete_product = $product  -> delete_product($sanpham_id);
$delete_product_anh =  $product -> delete_product_anh($sanpham_id);
header('Location:productlist.php');
?>