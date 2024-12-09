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
include_once "../class/product.php"; // Bao gồm tệp chứa định nghĩa của lớp product
$product = new product();
$get_all_anh = $product->get_all_anh();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GET ALL ẢNH</title>
    <link href="css/anhsanphamlists.css" rel="stylesheet"> <!-- Liên kết tệp CSS -->

</head>

<body>

    <div class="anh-content-right">
        <div class="table-content">
            <div class="button-container">

                <div class="add-button">
                    <a href="anhsanphamadd.php" class="btn btn-primary">Thêm ảnh mới</a>
                </div>
            </div>
            <h2>Ảnh sản phẩm</h2>
            <table>
                <tr>
                    <th>Stt</th>
                    <th>ID</th>
                    <th>ID Sản phẩm</th>
                    <th>Mã Sản phẩm</th>
                    <th>Ảnh</th>
                    <th>Tùy chỉnh</th>
                </tr>

                <?php
                    if($get_all_anh){
                        $i = 0;
                        while($result = $get_all_anh->fetch_assoc()){
                            $i++;

                    ?>
                <tr>
                    <td> <?php echo $i ?></td>
                    <td> <?php echo $result['sanpham_anh_id'] ?></td>
                    <td> <?php echo $result['sanpham_id']  ?></td>
                    <td> <?php echo $result['sanpham_ma']  ?></td>
                    <td> <img style="width: 80px; height: auto"
                            src="../images/product/<?php echo $result['sanpham_anh'] ?>" alt="">
                    </td>
                    <td><a href="anhsanphamdeletes.php?sanpham_anh_id=<?php echo $result['sanpham_anh_id'] ?>"
                            class="btn btn-danger">Xóa</a></td>
                    </td>
                </tr>
                <?php
                        }
                    }
                    ?>
                <table>

        </div>
        <div class="back-button">
            <a href="../admin/admin_dashboard.php" class="btn">Quay lại trang quản lý</a>
        </div>
    </div>

</body>

</html>