<?php
session_start();

define('__ROOT__', dirname(__FILE__));
require_once(__ROOT__ . '/class/index_class.php');
require_once(__ROOT__ . '/lib/database.php');

// Kiểm tra nếu người dùng đã đăng nhập
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
                    <th>Trạng thái</th> <!-- Cột trạng thái -->
                    <th>Hành động</th> <!-- Cột nút thay đổi trạng thái -->
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
                    <td id="status-<?php echo $item['cart_id']; ?>"><?php echo htmlspecialchars($item['status']); ?>
                    </td> <!-- Hiển thị trạng thái -->
                    <td>
                        <button class="btn btn-primary" onclick="changeStatus(<?php echo $item['cart_id']; ?>)">
                            Thay đổi
                        </button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p>Bạn chưa có đơn hàng nào.</p>
        <?php endif; ?>
        <a href="/web_quan_ao/index.php" class="btn btn-primary">Quay lại trang chủ</a>
    </div>

    <script>
    // Hàm thay đổi trạng thái khi nút được nhấn
    function changeStatus(cartId) {
        const statusCell = document.getElementById('status-' + cartId);
        const currentStatus = statusCell.innerText.trim();

        // Đặt trạng thái mới dựa trên trạng thái hiện tại
        let newStatus = (currentStatus === 'CHUA_NHAN') ? 'DA_NHAN' : 'CHUA_NHAN';

        // Cập nhật trạng thái trên giao diện
        statusCell.innerText = newStatus;

        // Gửi yêu cầu AJAX để cập nhật trạng thái vào cơ sở dữ liệu
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/update_statusa.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onload = function() {
            if (xhr.status === 200) {
                console.log("Cập nhật trạng thái thành công:", xhr.responseText);
            } else {
                console.error("Lỗi khi gửi yêu cầu AJAX:", xhr.responseText);
            }
        };

        const data = `cart_id=${cartId}&status=${newStatus}`;
        xhr.send(data);
    }
    </script>
</body>

</html>