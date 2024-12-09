<?php
include_once "../class/brand.php"; // Bao gồm tệp chứa định nghĩa của lớp product

$brand = new brand(); // Đảm bảo tên lớp là Brand với chữ B viết hoa
if (isset($_GET['color_id']) && $_GET['color_id'] != NULL) {
    $color_id = $_GET['color_id'];
    $delete_color = $brand->delete_color($color_id);
    if ($delete_color) {
        header('Location: colorlist.php');
        exit();
    } else {
        echo "Xóa màu thất bại.";
    }
} else {
    header('Location: colorlist.php');
    exit();
}
?>