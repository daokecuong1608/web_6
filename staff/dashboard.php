<?php
session_start(); // Khởi tạo phiên nếu chưa có phiên nào được khởi tạo

if (!isset($_SESSION['staff_login']) || $_SESSION['staff_login'] !== true) {
    // Nếu nhân viên chưa đăng nhập, chuyển hướng đến trang đăng nhập
    header("Location: loginstaff.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="css/dashboard.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h2>Chào mừng, <?php echo $_SESSION['staff_name']; ?>!</h2>
                <p>Đây là trang dashboard dành cho nhân viên.</p>
                <div class="card">
                    <div class="card-header">
                        Thông tin nhân viên
                    </div>
                    <div class="card-body">
                        <p><strong>Tên:</strong> <?php echo $_SESSION['staff_name']; ?></p>
                        <p><strong>Email:</strong> <?php echo $_SESSION['staff_email']; ?></p>
                        <!-- Thêm các thông tin khác của nhân viên nếu cần -->
                    </div>
                </div>
                <div class="mt-3">
                    <a href="productlist.php" class="btn btn-primary">Xem danh sách sản phẩm</a>
                    <a href="report.php" class="btn btn-primary">Xem báo cáo thống kê</a>
                    <a href="categorylist.php" class="btn btn-primary">Xem danh mục</a>
                    <a href="brandlist.php" class="btn btn-primary">Xem thể loại</a>
                    <a href="colorlist.php" class="btn btn-primary">Xem màu </a>

                </div>
                <a href="logoutstaff.php" class="btn btn-danger mt-3">Đăng xuất</a>
            </div>
        </div>
    </div>
</body>

</html>