<?php
@ob_start(); // Khởi tạo bộ đệm đầu ra
include 'header.php';
$userid = $_SESSION['user_id']; // Lấy ra user_id từ phiên

if (!isset($_SESSION['user_id'])) {
    // Nếu người dùng chưa đăng nhập, chuyển hướng đến trang đăng nhập
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $loaikhach = $_POST['loaikhach'];
    $customer_name = trim($_POST['customer_name']);
    $customer_phone = trim($_POST['customer_phone']);
    $customer_tinh = $_POST['customer_tinh'];
    $customer_huyen = $_POST['customer_huyen'];
    $customer_xa = $_POST['customer_xa'];
    $customer_diachi = trim($_POST['customer_diachi']);

    $errors = [];
    if (strlen($customer_name) > 50 || preg_match('/^\s/', $customer_name)) {
        $errors[] = "Tên khách hàng không được quá 50 ký tự và không được có khoảng trắng đầu câu.";
    }
    if (!preg_match('/^0\d{9}$/', $customer_phone)) {
        $errors[] = "Số điện thoại phải gồm 10 số và bắt đầu bằng số 0.";
    }
    if (strlen($customer_diachi) > 50) {
        $errors[] = "Địa chỉ không được vượt quá 50 ký tự.";
    }

    if (empty($errors)) {
        $insert_order = $index->insert_order($userid, $loaikhach, $customer_name, $customer_phone, $customer_tinh, $customer_huyen, $customer_xa, $customer_diachi);
        if ($insert_order) {
            header('Location: payment.php');
            exit(); // Dừng thực thi mã sau khi chuyển hướng
        } else {
            echo "Failed to insert order.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="css/delivery.css" rel="stylesheet"> <!-- Liên kết tệp CSS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Liên kết jQuery -->
</head>

<body>

    <?php include 'carousel.php'; ?>

    <?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $error): ?>
            <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <section class="delivery">
        <div class="container">
            <div class="delivery-top-wap">
                <div class="delivery-top">
                    <div class="delivery-top-cart delivery-top-item">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="delivery-top-adress delivery-top-item">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="delivery-top-payment delivery-top-item">
                        <i class="fas fa-money-check-alt"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <?php
            // Fetch cart items based on the 'status = 'CHỌN''
            $show_cart = $index->show_cartB($userid);
            if ($show_cart):
                $total_amount = 0; // Initialize total amount to 0
            ?>
            <div class="delivery-content row">
                <div class="col-md-6">
                    <div class="delivery-content-left">
                        <form action="" method="POST">
                            <h3>Vui lòng chọn địa chỉ giao hàng</h3>
                            <br>
                            <input style="float: left;margin-right:12px" checked="checked" name="loaikhach" type="radio"
                                value="khachle">
                            <p><span style="font-weight: bold;">Khách lẻ</span> (Nếu bạn không muốn lưu lại thông tin)
                            </p>
                            <br>
                            <div class="delivery-content-left-input-top row">
                                <div class="delivery-content-left-input-top-item">
                                    <label for="">Họ tên <span style="color: red;">*</span></label>
                                    <input name="customer_name"
                                        oninvalid="this.setCustomValidity('Vui lòng không để trống')"
                                        oninput="this.setCustomValidity('')" required type="text">
                                </div>
                                <div class="delivery-content-left-input-top-item">
                                    <label for="">Điện thoại <span style="color: red;">*</span></label>
                                    <input name="customer_phone"
                                        oninvalid="this.setCustomValidity('Vui lòng không để trống')"
                                        oninput="this.setCustomValidity('')" required type="text">
                                </div>

                                <div class="delivery-content-left-input-top-item">
                                    <label for="">Tỉnh/Tp <span style="color: red;">*</span></label>
                                    <select name="customer_tinh" id="tinh_tp"
                                        oninvalid="this.setCustomValidity('Vui lòng không để trống')"
                                        oninput="this.setCustomValidity('')" required name="" id="">
                                        <option value="#">Chọn Tỉnh/Tp</option>
                                        <?php
                                        $show_diachi = $index->show_diachi();
                                        if ($show_diachi) {
                                            while ($result_diachi = $show_diachi->fetch_assoc()) {
                                        ?>
                                        <option value="<?php echo $result_diachi['ma_tinh'] ?>">
                                            <?php echo $result_diachi['tinh_tp'] ?>
                                        </option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="delivery-content-left-input-top-item">
                                    <label for="">Quận/Huyện <span style="color: red;">*</span></label>
                                    <select name="customer_huyen" id="quan_huyen"
                                        oninvalid="this.setCustomValidity('Vui lòng không để trống')"
                                        oninput="this.setCustomValidity('')" required name="" id="">
                                        <option value="#">Chọn Quận/Huyện</option>
                                    </select>
                                </div>
                            </div>
                            <div class="delivery-content-left-input-bottom">
                                <label for="">Phường/Xã <span style="color: red;">*</span></label>
                                <select name="customer_xa" id="phuong_xa"
                                    oninvalid="this.setCustomValidity('Vui lòng không để trống')"
                                    oninput="this.setCustomValidity('')" required name="" id="">
                                    <option value="#">Chọn Phường/Xã</option>
                                </select>
                            </div>
                            <div class="delivery-content-left-input-bottom">
                                <label for="">Địa chỉ <span style="color: red;">*</span></label>
                                <input name="customer_diachi"
                                    oninvalid="this.setCustomValidity('Vui lòng không để trống')"
                                    oninput="this.setCustomValidity('')" required type="text">
                            </div>
                            <div class="delivery-content-right-button">
                                <a href="cart.php" class="btn btn-secondary">Quay lại giỏ hàng</a>
                                <button type="submit" class="btn btn-primary">Thanh toán</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="delivery-content-right">
                        <h3> Thanh toán </h3>
                        <table>
                            <tr>
                                <th>Tên sản phẩm</th>
                                <th>Đơn giá</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
                            </tr>
                            <?php
                            while ($result_cart = $show_cart->fetch_assoc()):
                                $product_price = $result_cart['sanpham_gia'];
                                $product_quantity = $result_cart['quantitys'];
                                $total_item_price = $product_price * $product_quantity;
                                $total_amount += $total_item_price; // Accumulate the total amount
                            ?>
                            <tr>
                                <td><?php echo $result_cart['sanpham_tieude'] ?></td>
                                <td><?php echo number_format($product_price); ?> đ</td>
                                <td><?php echo $product_quantity; ?></td>
                                <td><?php echo number_format($total_item_price); ?><sup>đ</sup></td>
                            </tr>
                            <?php endwhile; ?>
                            <tr style="border-top: 2px solid red">
                                <td colspan="3" style="font-weight: bold; border-top: 2px solid #dddddd">Tổng</td>
                                <td style="font-weight: bold; border-top: 2px solid #dddddd">
                                    <p><?php echo number_format($total_amount); ?><sup>đ</sup></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="font-weight: bold;">Tổng tiền hàng</td>
                                <td style="font-weight: bold;">
                                    <p><?php echo number_format($total_amount); ?><sup>đ</sup></p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <p>Bạn vẫn chưa thêm sản phẩm nào vào giỏ hàng, vui lòng chọn sản phẩm nhé!</p>
            <?php endif; ?>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>

    <script>
    $(document).ready(function() {
        $("#tinh_tp").change(function() {
            var x = $(this).val();
            $.get("ajax/deliveryqh_ajax.php", {
                tinh_id: x
            }, function(data) {
                $("#quan_huyen").html(data);
            })
        })
        $("#quan_huyen").change(function() {
            var x = $(this).val();
            $.get("ajax/deliverypx_ajax.php", {
                quan_huyen_id: x
            }, function(data) {
                $("#phuong_xa").html(data);
            })
        })
    })
    </script>

</body>

</html>