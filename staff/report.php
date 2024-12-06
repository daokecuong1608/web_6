<?php
if (!defined('__ROOT__')) {
    define('__ROOT__', dirname(dirname(__FILE__))); // Định nghĩa hằng số __ROOT__ nếu chưa được định nghĩa
}
include_once "../class/product.php";
include_once "../class/staff.php";

$product = new product();
$staff = new staff();

$product_count = $product->get_product_count();
$staff_count = $staff->get_staff_count();
$order_count = $product->get_order_count();
$total_sales = $product->get_total_sales();
$total_sales_from_carta = $product->get_total_sales_from_carta();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Báo cáo</title>
    <link href="css/report.css" rel="stylesheet"> <!-- Liên kết tệp CSS -->
</head>

<body>

    <div class="report-container">
        <h1>Thống kê</h1>
        <div class="report-item">
            <h2>Số lượng sản phẩm</h2>
            <p><?php echo $product_count; ?></p>
        </div>
        <div class="report-item">
            <h2>Số lượng nhân viên</h2>
            <p><?php echo $staff_count; ?></p>
        </div>
        <div class="report-item">
            <h2>Số lượng đơn hàng đã bán</h2>
            <p><?php echo $order_count; ?></p>
        </div>
        <div class="report-item">
            <h2>Số sản phẩm đã bán được </h2>
            <p><?php echo $total_sales  ?> sản phẩm</p>
        </div>
        <div class="report-item">
            <h2>Tổng tiền đã bán được</h2>
            <p><?php echo number_format($total_sales_from_carta); ?> đ</p>
        </div>
        <div class="btn-center">
            <a href="dashboard.php" class="btn btn-secondary">Quay lại trang quản lý</a>
        </div>
    </div>

</body>

</html>