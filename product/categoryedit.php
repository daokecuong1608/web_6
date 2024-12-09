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
include_once "../class/category.php"; 
$category = new category();
if(isset($_GET['danhmuc_id']) && $_GET['danhmuc_id'] != NULL){
    $danhmuc_id = $_GET['danhmuc_id'];
}
$get_category = $category->get_cartegory($danhmuc_id);
if($get_category){
    $result = $get_category->fetch_assoc();
}
?>
<?php
if($_SERVER['REQUEST_METHOD']==='POST'){
    $danhmuc_ten = $_POST['danhmuc_ten'];
    $update_category = $category->update_category($danhmuc_ten, $danhmuc_id);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update danh mục </title>
    <link href="css/categoryedit.css" rel="stylesheet"> <!-- Liên kết tệp CSS -->
</head>

<body>

    <div class="up-cate-content-right">
        <h2>Sửa danh mục</h2>
        <div class="cartegory-cate-content">
            <form action="" method="POST" enctype="multipart/form-data">
                <label for="">Vùi lòng danh mục<span style="color: red;">*</span></label> <br>
                <input type="text" name="danhmuc_ten" value="<?php echo $result['danhmuc_ten'] ?>">
                <div class="form-buttons">
                    <a href="categorylist.php" class="admin-btn">Quay lại</a>
                    <button class="admin-btn" type="submit">Sửa</button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>