<?php
session_start(); 
// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    // Nếu chưa đăng nhập, chuyển hướng về trang login
    header("Location: /web_quan_ao/login.php");  
      exit();
}
// Kiểm tra xem người dùng có phải là admin không
if ($_SESSION['role'] !== 'admin') {
    header("Location: /web_quan_ao/index.php");  
    exit();
}
include_once "../class/product.php"; // Bao gồm tệp chứa định nghĩa của lớp product
$product = new product(); // Đảm bảo tên lớp là Product với chữ P viết hoa
if (isset($_GET['sanpham_id']) || $_GET['sanpham_id'] != NULL) {
    $sanpham_id = $_GET['sanpham_id'];
}
$get_size = $product->get_size($sanpham_id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Size</title>
    <link href="css/sizesanphamlist.css" rel="stylesheet"> <!-- Liên kết tệp CSS -->
</head>

<body>

    <div class="s-content-right">
        <h2>Size sản phẩm</h2>
        <div class="table-content">
            <table>
                <tr>
                    <th>Stt</th>
                    <th>Mã sản phẩm</th>
                    <th>Size sản phẩm</th>
                    <th>Tùy chỉnh</th>
                </tr>
                <?php
                if ($get_size) {
                    $i = 0;
                    while ($result = $get_size->fetch_assoc()) {
                        $i++;
                ?>
                <tr>
                    <td><?php echo $i ?></td>
                    <td><?php echo $result['sanpham_ma'] ?></td>
                    <td><?php echo $result['sanpham_size'] ?></td>
                    <td><a href="sizesanphamdelete.php?sanpham_size_id=<?php echo $result['sanpham_size_id'] ?>"
                            class="btn btn-danger"
                            onclick="return confirm('Bạn có chắc chắn muốn xóa size sản phẩm này không?');">Xóa</a></td>
                </tr>
                <?php
                    }
                }
                ?>
            </table>
        </div>
        <div class="back-button">
            <a href="productlist.php" class="btn btn-primary">Quay về trang danh sách sản phẩm</a>
        </div>
    </div>

</body>

</html>