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


include_once "../helper/format.php";
include_once "../class/product.php"; // Bao gồm tệp chứa định nghĩa của lớp product

$product = new product(); // Đảm bảo tên lớp là Product với chữ P viết hoa
?>

<?php
$product = new product();
if (isset($_GET['order_ma']) || $_GET['order_ma'] != NULL) {
    $order_ma = $_GET['order_ma'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="css/orderdetail.css" rel="stylesheet"> <!-- Liên kết tệp CSS -->
</head>

<body>
    <div class="container mt-4">
        <h1 class="mb-4">Chi tiết đơn hàng</h1>
        <div class="table-content">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Stt</th>
                        <th>Mã đơn hàng</th>
                        <th>Tên Sản phẩm</th>
                        <th>Ảnh</th>
                        <th>SL</th>
                        <th>Màu</th>
                        <th>Đơn giá</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $TT = 0;
                    $show_order_detail = $product->show_order_detail($order_ma);
                    if ($show_order_detail) {
                        $i = 0;
                        while ($result = $show_order_detail->fetch_assoc()) {
                            $i++;
                    ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td>Ivy_<?php $ma = substr($result['user_id'], 0, 8);
                                    echo $ma ?></td>
                        <td><?php echo $result['sanpham_tieude'] ?></td>
                        <td><img style="width:50px" src="../<?php echo $result['sanpham_anh'] ?>" alt=""></td>
                        <td><?php echo $result['quantitys'] ?></td>
                        <td><img style="width:30px" src="../<?php echo $result['color_anh'] ?>" alt=""></td>
                        <td><?php $c = number_format($result['sanpham_gia']);
                                echo $c ?></td>
                        <td><?php $a = (int)$result['sanpham_gia'];
                                $b = (int)$result['quantitys'];
                                $TTA = $a * $b;
                                $f = number_format($TTA);
                                echo $f ?>
                        </td>
                    </tr>
                    <?php
                            $TT =  $TT  + $TTA;
                        }
                    }
                    ?>
                    <tr>
                        <td style="font-weight: bold;" colspan="7">Tổng tiền</td>
                        <td><?php $k = number_format($TT);
                                echo $k ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="btn-center">
            <a href="orderlistall.php" class="btn btn-primary">Quay lại</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6YVFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
</body>

</html>