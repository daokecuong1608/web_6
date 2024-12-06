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
    <title>Danh sách đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="css/orderlistall.css" rel="stylesheet"> <!-- Liên kết tệp CSS -->
</head>

<body>
    <div class="container mt-4">
        <h1 class="mb-4">Danh sách đơn hàng</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Stt</th>
                    <th>Mã đơn hàng</th>
                    <th>Ngày đặt hàng</th>
                    <th>Tên</th>
                    <th>Điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Giao hàng</th>
                    <th>Thanh toán</th>
                    <th>Chi tiết đơn hàng</th>
                    <th>Tình trạng</th>
                    <th>Tùy chỉnh</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $show_orderAll = $product->show_orderAll();
                if ($show_orderAll) {
                    $i = 0;
                    while ($result = $show_orderAll->fetch_assoc()) {
                        $i++;
                ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php $ma = substr($result['user_id'],0,8); echo $ma   ?></td>
                    <td> <?php echo $result['order_date']?></td>
                    <td> <?php echo $result['customer_name']?></td>
                    <td> <?php echo $result['customer_phone'] ?></td>
                    <td> <?php echo $result['customer_diachi']  ?>, <?php echo $result['phuong_xa']  ?>,
                        <?php echo $result['quan_huyen']  ?>, <?php echo $result['tinh_tp']  ?></td>
                    <td> <?php echo $result['giaohang']  ?></td>
                    <td> <?php echo $result['thanhtoan']  ?></td>
                    <td> <a href="orderdetail.php?order_ma=<?php echo $result['user_id'] ?>"
                            class="btn btn-info">Xem</a></td>
                    <td>
                        <a href="changestatus.php?user_id=<?php echo $result['user_id']; ?>" class="btn btn-warning">
                            <?php if($result['status'] == 1) { echo "Đã hoàn thành"; } else { echo "Chưa hoàn thành"; } ?>
                        </a>
                    </td>
                    <td><a href="orderdelete.php?user_id=<?php echo $result['user_id'] ?>" class="btn btn-danger"
                            onclick="return confirm('Đơn hàng sẽ bị xóa vĩnh viễn, bạn có chắc muốn tiếp tục không?');">Xóa</a>
                    </td>
                </tr>
                <?php
                    }
                }
               ?>
            </tbody>
        </table>
        <div class="btn-center">
            <a href="../admin/admin_dashboard.php" class="btn btn-primary">Quay lại trang quản lý</a>
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