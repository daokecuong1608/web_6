<?php
include 'header.php'; // Path to your header.php
include 'carousel.php'; // Path to your carousel.php

// Kiểm tra xem phiên đã được bắt đầu hay chưa
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$userid = $_SESSION['user_id']; // Lấy ra user_id từ phiên

if (!isset($_SESSION['user_id'])) {
    // Nếu người dùng chưa đăng nhập, chuyển hướng đến trang đăng nhập
    header("Location: login.php");
    exit();
}

$index = new index(); // Instantiate the index class

// Handle POST requests for payment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $today = date('Y-m-d'); // Định dạng ngày chuẩn
    $deliver_method = $_POST['deliver-method'] ?? 'Mặc định';
    $method_payment = $_POST['method-payment'] ?? 'cod'; // Mặc định thanh toán khi nhận hàng
    $total_price = isset($_POST['total_price']) ? intval($_POST['total_price']) : 0;

    // Kiểm tra giá trị total_price và userid
    if (empty($total_price) || empty($userid)) {
        die("Lỗi: Một số giá trị quan trọng bị thiếu.");
    }

    // Xử lý khi chọn VNPay
    if ($method_payment == 'vnpay') {
        header("Location: vnpay_payment.php?amount=$total_price&deliver_method=$deliver_method&method_payment=$method_payment&today=$today&userid=$userid");
        exit();
    } else {
        // Lưu đơn hàng vào CSDL, thêm cả total_price
        $insert_payment = $index->insert_payment($userid, $deliver_method, $method_payment, $today);

        if ($insert_payment) {
            echo "<script>alert('Thanh toán thành công! Đơn hàng của bạn đã được ghi nhận.');</script>";
        } else {
            echo "<script>alert('Lỗi: Không thể lưu đơn hàng, vui lòng thử lại.');</script>";
        }
    }
}

// ========================= TÍNH TỔNG GIÁ TRỊ GIỎ HÀNG =========================
$total_price = 0;
$total_quantity = 0;
$show_cart = $index->show_cartB($userid); // Lấy giỏ hàng từ database

if ($show_cart) {
    while ($result = $show_cart->fetch_assoc()) {
        $product_total = $result['sanpham_gia'] * $result['quantitys'];
        $total_price += $product_total;
        $total_quantity += $result['quantitys'];
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/payment.css" rel="stylesheet">
</head>

<body>

    <section class="payment">
        <div class="container">
            <div class="payment-top-wrap">
                <div class="payment-top">
                    <div class="delivery-top-delivery payment-top-item"><i class="fas fa-shopping-cart"></i></div>
                    <div class="delivery-top-adress payment-top-item"><i class="fas fa-map-marker-alt"></i></div>
                    <div class="delivery-top-payment payment-top-item"><i class="fas fa-money-check-alt"></i></div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="payment-content row">
                <div class="col-md-6">
                    <div class="payment-content-left">
                        <form action="" method="POST" id="payment-form">
                            <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">
                            <input type="hidden" name="order_id" value="<?php echo $insert_payment; ?>">
                            <div class="payment-content-left-method-delivery">
                                <p style="font-weight: bold;">Phương thức giao hàng</p>
                                <div class="payment-content-left-method-delivery-item">
                                    <input name="deliver-method" value="Ship hỏa tốc" checked type="radio">
                                    <label for="">Ship hỏa tốc</label><br>
                                    <input name="deliver-method" value="Giao hàng chuyển phát nhanh" type="radio">
                                    <label for="">Giao hàng chuyển phát nhanh</label>
                                </div>
                            </div>
                            <br>
                            <div class="payment-content-left-method-payment">
                                <p style="font-weight: bold;">Phương thức thanh toán</p>
                                <p>Mọi giao dịch đều được bảo mật và mã hóa.</p>
                                <div class="payment-content-left-method-payment-item">
                                    <input name="method-payment" type="radio">
                                    <label for="">Thanh toán bằng thẻ tín dụng(OnePay)</label>
                                </div>
                                <div class="payment-content-left-method-payment-item-img">
                                    <img src="images/visa.png" alt="Visa">
                                </div>
                                <div class="payment-content-left-method-payment-item">
                                    <input name="method-payment" type="radio">
                                    <label for="">Thanh toán bằng thẻ ATM(OnePay)</label>
                                </div>
                                <div class="payment-content-left-method-payment-item-img">
                                    <img src="images/vcb.png" alt="VCB">
                                </div>
                                <div class="payment-content-left-method-payment-item">
                                    <input name="method-payment" type="radio">
                                    <label for="">Thanh toán Momo</label>
                                </div>
                                <div class="payment-content-left-method-payment-item-img">
                                    <img src="images/momo.png" alt="Momo">
                                </div>
                                <div class="payment-content-left-method-payment-item">
                                    <input name="method-payment" value="vnpay" type="radio" id="vnpay-option">
                                    <label for="">Thanh toán VNPay</label>
                                </div>
                                <div class="payment-content-left-method-payment-item-img">
                                    <img src="images/vnpay.png" alt="VNPay">
                                </div>
                                <div class="payment-content-left-method-payment-item">
                                    <input value="Thanh toán khi nhận hàng " checked name="method-payment" type="radio">
                                    <label for="">Thanh toán khi nhận hàng</label>
                                </div>
                            </div>
                            <div class="payment-content-right-payment">
                                <button type="submit" id="complete-button">HOÀN THÀNH</button>
                                <button type="button" id="continue-button" style="display: none;">TIẾP TỤC</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="payment-content-right">
                        <div class="payment-content-right-button">
                            <input type="text" placeholder="Mã giảm giá/Quà tặng">
                            <button class="btn-check"><i class="fas fa-check"></i></button>
                        </div>
                        <div class="payment-content-right-button">
                            <input type="text" placeholder="Mã cộng tác viên">
                            <button class="btn-check"><i class="fas fa-check"></i></button>
                        </div>
                        <div class="payment-content-right-mnv">
                            <select name="" id="">
                                <option value="">Chọn mã nhân viên thân thiết</option>
                                <option value="">D345</option>
                                <option value="">C333</option>
                                <option value="">T567</option>
                                <option value="">D333</option>
                            </select>
                        </div>
                        <br>
                        <table>
                            <tr>
                                <th>Tên sản phẩm</th>
                                <th>Đơn giá</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
                            </tr>

                            <?php if ($show_cart) {
                                $show_cart = $index->show_cartB($userid);
                                while ($result = $show_cart->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo $result['sanpham_tieude']; ?></td>
                                        <td><?php echo number_format($result['sanpham_gia']); ?>đ</td>
                                        <td><?php echo $result['quantitys']; ?></td>
                                        <td><?php echo number_format($result['sanpham_gia'] * $result['quantitys']); ?>đ</td>
                                    </tr>
                            <?php }
                            } ?>
                            <tr style="border-top: 2px solid red">
                                <td colspan="3" style="font-weight: bold;">Tổng</td>
                                <td style="font-weight: bold;"><?php echo number_format($total_price); ?>đ</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; // Path to your footer.php 
    ?>
    <script>
        document.getElementById('vnpay-option').addEventListener('change', function() {
            document.getElementById('complete-button').style.display = 'none';
            document.getElementById('continue-button').style.display = 'block';
        });

        document.getElementById('continue-button').addEventListener('click', function() {
            document.getElementById('payment-form').submit();
        });

        // Reset buttons when các phương thức thanh toán khác được chọn
        document.querySelectorAll('input[name="method-payment"]').forEach(function(element) {
            element.addEventListener('change', function() {
                if (this.value !== 'vnpay') {
                    document.getElementById('complete-button').style.display = 'block';
                    document.getElementById('continue-button').style.display = 'none';
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
</body>

</html>