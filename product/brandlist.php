<?php
session_start(); // Khởi tạo session
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
include_once "../class/brand.php"; // Bao gồm tệp chứa định nghĩa của lớp product
$brand = new brand(); 
$show_brand = $brand->show_brand();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách thể loại</title>
    <link href="css/brandlist.css" rel="stylesheet"> <!-- Liên kết tệp CSS -->
</head>

<body>

    <div class="lis-tl-content-right">
        <div class="button-container">
            <div class="back-button">
                <a href="../admin/admin_dashboard.php" class="btn">Quay lại trang quản lý</a>
            </div>
            <div class="add-button">
                <a href="brandadd.php" class="btn btn-primary">Thêm thể loại</a>
            </div>
        </div>
        <div class="tl-table-content">
            <h2>Danh sách thể loại</h2>
            <table>
                <tr>
                    <th>STT</th>
                    <th>ID</th>
                    <th>Danh mục</th>
                    <th>Loại sản phẩm</th>
                    <th>Tùy chỉnh </th>
                </tr>
                <?php
                if ($show_brand) {
                    $i = 0;
                    while ($result = $show_brand->fetch_assoc()) {
                        $i++;
                ?>
                <tr>
                    <td> <?php echo $i ?></td>
                    <td> <?php echo $result['loaisanpham_id'] ?></td>
                    <td> <?php echo $result['danhmuc_ten']  ?></td>
                    <td> <?php echo $result['loaisanpham_ten'] ?></td>
                    <td>
                        <a href="brandedit.php?loaisanpham_id=<?php echo $result['loaisanpham_id'] ?>"
                            class="btn btn-edit">Sửa</a>
                        <a href="branddelete.php?loaisanpham_id=<?php echo $result['loaisanpham_id'] ?>"
                            class="btn btn-delete"
                            onclick="return confirm('Bạn có chắc chắn muốn xóa thể loại sản phẩm này không?');">Xóa</a>
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