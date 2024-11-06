<?php
include_once "../helper/format.php";
include_once "../class/product.php"; // Bao gồm tệp chứa định nghĩa của lớp product

$product = new product(); // Đảm bảo tên lớp là Product với chữ P viết hoa
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sản phẩm</title>
    <link href="css/productlist.css" rel="stylesheet"> <!-- Liên kết tệp CSS -->
</head>

<body>

    <div class="list-pro-content-right">
        <div class="lis-button-container">
            <div class="back-button">
                <a href="../admin/admin_dashboard.php" class="btn">Quay lại trang quản lý</a>
            </div>
            <div class="add-button">
                <a href="productadd.php" class="btn btn-primary">Thêm sản phẩm mới</a>
            </div>
        </div>

        <div class="lis-table-content">
            <h2>Danh sách sản phẩm</h2>
            <table>
                <tr>
                    <th>Stt</th>
                    <th>Tiêu đề</th>
                    <th>Mã sản phẩm </th>
                    <th>Danh mục</th>
                    <th>Loại sản phẩm</th>
                    <th>Màu</th>
                    <th>Giá</th>
                    <th>Chi tiết</th>
                    <th>Bảo quản</th>
                    <th>Ảnh</th>
                    <th>Xem ảnh</th>
                    <th>Size sản phẩm</th>
                    <th>Tùy chỉnh</th>
                </tr>

                <?php
                $show_product = $product->show_product();
                if ($show_product) {
                    $i = 0;
                    while ($result = $show_product->fetch_assoc()) {
                        $i++;
                ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $result['sanpham_tieude']; ?></td>
                    <td><?php echo $result['sanpham_ma']; ?></td>
                    <td> <?php echo $result['danhmuc_ten']  ?></td>
                    <td> <?php echo $result['loaisanpham_ten']  ?></td>
                    <td><?php echo $result['color_ten']; ?></td>
                    <td><?php echo $result['sanpham_gia']; ?></td>
                    <td><?php echo $result['sanpham_chitiet']; ?></td>
                    <td><?php echo $result['sanpham_baoquan']; ?></td>
                    <td>
                        <?php if (!empty($result['sanpham_anh'])): ?>
                        <img src="../images/product/<?php echo $result['sanpham_anh']; ?>" alt="" width="100px">
                        <?php else: ?>
                        Không có ảnh
                        <?php endif; ?>
                    </td>
                    <td><a href="anhsanphamlist.php?sanpham_id=<?php echo $result['sanpham_id'] ?>"
                            class="btn btn-view">Xem</a></td>
                    <td><a href="sizesanphamlist.php?sanpham_id=<?php echo $result['sanpham_id'] ?>"
                            class="btn btn-view">Xem</a></td>
                    <td>
                        <a href="productedit.php?sanpham_id=<?php echo $result['sanpham_id']; ?>"
                            class="btn btn-edit">Sửa</a>
                        <a href="productdelete.php?sanpham_id=<?php echo $result['sanpham_id']; ?>"
                            class="btn btn-delete">Xóa</a>
                    </td>
                </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='11'>Không có sản phẩm nào</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>

</body>

</html>