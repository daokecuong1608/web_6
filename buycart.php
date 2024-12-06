<?php
session_start();

define('__ROOT__', dirname(__FILE__));
require_once(__ROOT__ . '/class/index_class.php');
require_once(__ROOT__ . '/lib/database.php');


// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$index = new index();
$cart_items = $index->show_carta($user_id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách đơn hàng đã mua</title>
    <link href="css/buycart.css" rel="stylesheet"> <!-- Link to your CSS file -->
</head>

<body>
    <div class="container">
        <h1>Danh sách đơn hàng đã mua</h1>
        <?php if ($cart_items): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Mã sản phẩm</th>
                    <th>Ảnh sản phẩm</th>
                    <th>Tiêu đề sản phẩm</th>
                    <th>Màu sắc</th>
                    <th>Kích thước</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($item = $cart_items->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['sanpham_id']); ?></td>
                    <td><img src="<?php echo htmlspecialchars($item['sanpham_anh']); ?>" alt="Product Image" width="50">
                    </td>
                    <td><?php echo htmlspecialchars($item['sanpham_tieude']); ?></td>
                    <td><img src="<?php echo htmlspecialchars($item['color_anh']); ?>" alt="Color Image" width="20">
                    </td>
                    <td><?php echo htmlspecialchars($item['sanpham_size']); ?></td>
                    <td><?php echo htmlspecialchars($item['quantitys']); ?></td>
                    <td><?php echo htmlspecialchars($item['sanpham_gia']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p>Bạn chưa có đơn hàng nào.</p>
        <?php endif; ?>
        <a href="/web_quan_ao/index.php" class="btn btn-primary">Quay lại trang chủ</a>
    </div>
</body>

</html>