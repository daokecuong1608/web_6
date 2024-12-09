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
include_once "../class/category.php"; // Bao gồm tệp chứa định nghĩa của lớp product
$category = new category();
if($_SERVER['REQUEST_METHOD']==='POST'){
    $category_name = $_POST['category_name'];
    $insert_category = $category->insert_category($category_name);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm danh mục</title>
</head>

<body>

    <div class="add-cate-content-right">
        <div class="cate-content">
            <form action="" method="POST" enctype="multipart/form-data">
                <label for="">Vùi lòng danh mục<span style="color: red;">*</span></label> <br>
                <input type="text" name="category_name">
                <button class="admin-btn" type="submit">Gửi</button>
            </form>
        </div>
    </div>


</body>

</html>