<?php
include_once "../class/product.php"; // Bao gồm tệp chứa định nghĩa của lớp product

$product = new product(); 
$get_all_size =  $product -> get_all_size();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All size sản phẩm </title>
    <link href="css/sizesanphamlists.css" rel="stylesheet"> <!-- Liên kết tệp CSS -->

</head>

<body>

    <div class="sz-content-right">
        <div class="button-container">

            <div class="add-button">
                <a href="sizesanphamadd.php" class="btn btn-primary">Thêm size</a>
            </div>
        </div>
        <div class="table-content">
            <h2>Danh sách size sản phẩm</h2>

            <table>
                <tr>
                    <th>Stt</th>
                    <th>ID</th>
                    <th>ID Sản phẩm</th>
                    <th>Mã Sản phẩm</th>
                    <th>Size Sản phẩm</th>
                    <th>Tùy chỉnh</th>
                </tr>
                <?php
                if ($get_all_size) {
                    $i = 0;
                    while ($result = $get_all_size->fetch_assoc()) {
                        $i++;

                ?>
                <tr>
                    <td> <?php echo $i ?></td>
                    <td> <?php echo $result['sanpham_size_id'] ?></td>
                    <td> <?php echo $result['sanpham_id'] ?></td>
                    <td> <?php echo $result['sanpham_ma']  ?></td>
                    <td> <?php echo $result['sanpham_size']  ?></td>
                    <td><a href="sizesanphamdeletes.php?sanpham_size_id=<?php echo $result['sanpham_size_id'] ?>"
                            class="btn btn-danger">Xóa</a></td>
                </tr>
                <?php

                    }
                }

                ?>
            </table>
            <div class="back-button">
                <a href="../admin/admin_dashboard.php" class="btn">Quay lại trang quản lý</a>
            </div>
        </div>

    </div>
</body>

</html>