<?php
include_once "../class/product.php"; // Bao gồm tệp chứa định nghĩa của lớp product

$product = new Product(); // Đảm bảo tên lớp là Product với chữ P viết hoa
if (isset($_GET['sanpham_id']) || $_GET['sanpham_id'] != NULL) {
    $sanpham_id = $_GET['sanpham_id'];
}
$get_anh = $product->get_anh($sanpham_id);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ảnh sản phẩm</title>
    <link href="css/anhsanphamlist.css" rel="stylesheet"> <!-- Liên kết tệp CSS -->
</head>

<body>

    <div class="anh-content-right">
        <h2>Ảnh sản phẩm</h2>
        <div class="table-content">
            <table>
                <tr>
                    <th>Stt</th>
                    <th>ID Sản phẩm</th>
                    <th>Tên Sản phẩm</th>
                    <th>Ảnh</th>
                    <th>Tùy chỉnh</th>
                </tr>
                <?php
                if ($get_anh) {
                    $i = 0;
                    while ($result = $get_anh->fetch_assoc()) {
                        $i++;
                ?>
                <tr>
                    <td><?php echo $i ?></td>
                    <td><?php echo $result['sanpham_id'] ?></td>
                    <td><?php echo $result['sanpham_ma'] ?></td>
                    <td><img style="width: 150px; height: auto"
                            src="images/product/<?php echo $result['sanpham_anh'] ?>" alt=""></td>
                    <td><a href="anhsanphamdelete.php?sanpham_anh_id=<?php echo $result['sanpham_anh_id'] ?>"
                            class="btn btn-danger">Xóa</a></td>
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