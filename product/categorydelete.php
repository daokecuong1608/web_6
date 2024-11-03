<?php
include_once "../class/category.php"; // Bao gồm tệp chứa định nghĩa của lớp product

$category = new category();
if(!isset($_GET['danhmuc_id']) || $_GET['danhmuc_id'] == NULL){
    echo "<script>window.location = 'categorylist.php'</script>";
}else{
    $danhmuc_id = $_GET['danhmuc_id'];
}
$delete_category = $category->delete_category($danhmuc_id);
header('Location:categorylist.php');
?>