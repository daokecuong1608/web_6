<?php
include_once "../class/brand.php"; // Bao gồm tệp chứa định nghĩa của lớp product

$brand = new Brand(); // Đảm bảo tên lớp là Brand với chữ B viết hoa
$show_color = $brand->show_color();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách màu</title>
    <link href="css/colorlist.css" rel="stylesheet"> <!-- Liên kết tệp CSS -->
</head>

<body>

    <div class="col-content-right">
        <div class="button-container">
            <div class="back-button">
                <a href="dashboard.php" class="btn">Quay lại trang quản lý</a>
            </div>
            <div class="add-button">
                <a href="coloradd.php" class="btn btn-primary">Thêm màu mới</a>
            </div>
        </div>
        <h2>Danh sách màu</h2>
        <div class="table-content">
            <table>
                <tr>
                    <th>Stt</th>
                    <th>ID</th>
                    <th>Tên màu</th>
                    <th>Ảnh</th>
                    <th>Tùy chỉnh</th>
                </tr>
                <?php
                if ($show_color) {
                    $i = 0;
                    while ($result = $show_color->fetch_assoc()) {
                        $i++;
                ?>
                <tr>
                    <td><?php echo $i ?></td>
                    <td><?php echo $result['color_id'] ?></td>
                    <td><?php echo $result['color_ten'] ?></td>
                    <td><img style="width: 50px; height: 50px" src="../<?php echo $result['color_anh'] ?>" alt=""></td>
                    <td>
                        <a href="coloredit.php?color_id=<?php echo $result['color_id'] ?>" class="btn btn-edit">Sửa</a>
                        <a href="colordelete.php?color_id=<?php echo $result['color_id'] ?>"
                            class="btn btn-danger">Xóa</a>
                    </td>
                </tr>
                <?php
                    }
                }
                ?>
            </table>
        </div>
    </div>

</body>

</html>