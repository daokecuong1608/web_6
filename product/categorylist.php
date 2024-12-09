<?php

session_start(); 

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: /web_quan_ao/login.php");  
      exit();
}

// Kiểm tra xem người dùng có phải là admin không
if ($_SESSION['role'] !== 'admin') {
    header("Location: /web_quan_ao/index.php");  
    exit();
}

include_once "../class/category.php"; // Bao gồm tệp chứa định nghĩa của lớp product

$category = new category();
$show_category = $category->show_category();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách danh mục </title>
    <link href="css/categorylist.css" rel="stylesheet"> <!-- Liên kết tệp CSS -->
</head>

<body>

    <div class="list-cate-content-right">
        <div class="button-container">
            <div class="back-button">
                <a href="../admin/admin_dashboard.php" class="btn">Quay lại trang quản lý</a>
            </div>
            <div class="add-button">
                <a href="categoryadd.php" class="btn btn-primary">Thêm danh mục</a>
            </div>
        </div>
        <div class="cate-table-content">
            <h2>Danh sách danh mục</h2>
            <table>
                <tr>
                    <th>STT</th>
                    <th>ID</th>
                    <th>Tên danh mục</th>
                    <th>Tùy chỉnh</th>
                </tr>
                <?php
            if ($show_category) {
                $i = 0;
                while ($result = $show_category->fetch_assoc()) {
                    $i++;
            ?>
                <tr>
                    <td> <?php echo $i ?></td>
                    <td> <?php echo $result['danhmuc_id'] ?></td>
                    <td> <?php echo $result['danhmuc_ten']  ?></td>
                    <td>
                        <a href="categoryedit.php?danhmuc_id=<?php echo $result['danhmuc_id'] ?>"
                            class="btn btn-edit">Sửa</a>
                        <a href="categorydelete.php?danhmuc_id=<?php echo $result['danhmuc_id'] ?>"
                            class="btn btn-delete">Xóa</a>
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