<?php
session_start(); // Khởi tạo phiên nếu chưa có phiên nào được khởi tạo

if (!isset($_SESSION['staff_login']) || $_SESSION['staff_login'] !== true) {
    // Nếu nhân viên chưa đăng nhập, chuyển hướng đến trang đăng nhập
    header("Location: loginstaff.php");
    exit();
}

if (!defined('__ROOT__')) {
    define('__ROOT__', dirname(dirname(__FILE__))); // Định nghĩa hằng số __ROOT__ nếu chưa được định nghĩa
}
include_once(__ROOT__ . "/class/product.php");

$product = new product();
$product_list = $product->show_product();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="css/productlist.css" rel="stylesheet"> <!-- Liên kết tệp CSS -->
</head>

<body>
    <div class="container">
        <h2>Danh sách sản phẩm</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Danh mục</th>
                    <th>Loại sản phẩm</th>
                    <th>Màu sắc</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($product_list) {
                    while ($row = $product_list->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['sanpham_id'] . "</td>";
                        echo "<td>" . $row['sanpham_tieude'] . "</td>";
                        echo "<td>" . $row['sanpham_gia'] . "</td>";
                        echo "<td>" . $row['danhmuc_ten'] . "</td>";
                        echo "<td>" . $row['loaisanpham_ten'] . "</td>";
                        echo "<td>" . $row['color_ten'] . "</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
        <a href="dashboard.php" class="btn btn-secondary mt-3">Quay lại</a>
    </div>
</body>

</html>