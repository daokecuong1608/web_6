<?php
include 'header.php';
include 'carousel.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userid = $_SESSION['user_id'];
$index = new index();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $today = date('Y-m-d');
    $deliver_method = $_POST['deliver-method'] ?? 'Mặc định';
    $method_payment = $_POST['method-payment'] ?? 'cod';
    $total_price = isset($_POST['total_price']) ? intval($_POST['total_price']) : 0;

    if (empty($total_price) || empty($userid)) {
        die("Lỗi: Một số giá trị quan trọng bị thiếu.");
    }

    if ($method_payment == 'vnpay') {
        // Chuyển hướng đến trang thanh toán VNPay
        header("Location: vnpay_payment.php?amount=$total_price&deliver_method=$deliver_method&method_payment=$method_payment&today=$today&userid=$userid");
        exit();
    } else {
        // Xử lý các phương thức thanh toán khác
        $insert_payment = $index->insert_payment($userid, $deliver_method, $method_payment, $today);
        if ($insert_payment) {
            // Chuyển hướng đến trang success.php
            header("Location: success.php?amount=$total_price&deliver_method=$deliver_method&method_payment=$method_payment");
            exit();
        } else {
            echo "<script>alert('Lỗi: Không thể lưu đơn hàng.');</script>";
        }
    }
}

$total_price = 0;
$total_quantity = 0;
$show_cart = $index->show_cartB($userid);

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
                    <div class="payment-top-item"><i class="fas fa-shopping-cart"></i></div>
                    <div class="payment-top-item"><i class="fas fa-map-marker-alt"></i></div>
                    <div class="payment-top-item"><i class="fas fa-money-check-alt"></i></div>
                </div>
            </div>

            <div class="payment-content row">
                <div class="col-md-6">
                    <form action="" method="POST" id="payment-form">
                        <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">

                        <div class="payment-content-left-method-delivery">
                            <p><strong>Phương thức giao hàng</strong></p>
                            <div class="payment-content-left-method-delivery-item">
                                <input type="radio" name="deliver-method" value="Ship hỏa tốc" data-fee="30000" data-days="1" checked> Ship hỏa tốc (+30,000đ)
                            </div>
                            <div class="payment-content-left-method-delivery-item">
                                <input type="radio" name="deliver-method" value="Giao hàng chuyển phát nhanh" data-fee="20000" data-days="3"> Giao hàng chuyển phát nhanh (+20,000đ)
                            </div>
                            <div class="payment-content-left-method-delivery-item">
                                <input type="radio" name="deliver-method" value="Giao hàng tiêu chuẩn" data-fee="10000" data-days="7"> Giao hàng tiêu chuẩn (+10,000đ)
                            </div>
                            <p id="estimated-delivery-date" style="margin-top:10px;font-weight:bold;"></p>
                        </div>

                        <div class="payment-content-left-method-payment mt-4">
                            <p><strong>Phương thức thanh toán</strong></p>
                            <p>Mọi giao dịch đều được bảo mật và mã hóa.</p>
                            <div class="payment-content-left-method-payment-item">
                                <input name="method-payment" type="radio" value="creditcard">
                                <label for="">Thanh toán bằng thẻ tín dụng(OnePay)</label>
                            </div>
                            <div class="payment-content-left-method-payment-item-img">
                                <img src="images/visa.png" alt="Visa">
                            </div>
                            <div class="payment-content-left-method-payment-item">
                                <input name="method-payment" type="radio" value="atm">
                                <label for="">Thanh toán bằng thẻ ATM(OnePay)</label>
                            </div>
                            <div class="payment-content-left-method-payment-item-img">
                                <img src="images/vcb.png" alt="VCB">
                            </div>
                            <div class="payment-content-left-method-payment-item">
                                <input name="method-payment" type="radio" value="momo">
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
                                <input type="radio" name="method-payment" value="cod" checked>
                                <label for="">Thanh toán khi nhận hàng</label>
                            </div>
                        </div>

                        <div class="payment-content-right mt-4">
                            <p><strong>Tổng cộng:</strong> <span id="total-price"><?php echo number_format($total_price); ?>đ</span></p>
                            <button type="submit" class="btn btn-primary w-100 mt-3">Hoàn tất thanh toán</button>
                        </div>
                    </form>
                </div>

                <div class="col-md-6">
                    <div class="payment-content-right">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Giá</th>
                                    <th>SL</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $show_cart = $index->show_cartB($userid);
                                if ($show_cart) {
                                    while ($result = $show_cart->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?php echo $result['sanpham_tieude']; ?></td>
                                            <td><?php echo number_format($result['sanpham_gia']); ?>đ</td>
                                            <td><?php echo $result['quantitys']; ?></td>
                                            <td><?php echo number_format($result['sanpham_gia'] * $result['quantitys']); ?>đ</td>
                                        </tr>
                                <?php }
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deliveryInputs = document.querySelectorAll('input[name="deliver-method"]');
            const totalPriceElement = document.getElementById('total-price');
            const totalPriceInput = document.querySelector('input[name="total_price"]');
            const estimatedDeliveryDateElement = document.getElementById('estimated-delivery-date');
            let baseTotalPrice = <?php echo $total_price; ?>;

            function calculateDeliveryDate(daysToAdd) {
                const currentDate = new Date();
                currentDate.setDate(currentDate.getDate() + daysToAdd);
                const day = currentDate.getDate();
                const month = currentDate.getMonth() + 1;
                const year = currentDate.getFullYear();
                return `${day}/${month < 10 ? '0' + month : month}/${year}`;
            }

            function updateDeliveryInfo(input) {
                const fee = parseInt(input.getAttribute('data-fee')) || 0;
                const daysToAdd = parseInt(input.getAttribute('data-days')) || 0;
                const newTotal = baseTotalPrice + fee;
                totalPriceElement.textContent = newTotal.toLocaleString() + 'đ';
                totalPriceInput.value = newTotal;
                estimatedDeliveryDateElement.textContent = `Ngày giao hàng dự kiến: ${calculateDeliveryDate(daysToAdd)}`;
            }

            deliveryInputs.forEach(input => {
                input.addEventListener('change', function() {
                    updateDeliveryInfo(this);
                });
            });

            updateDeliveryInfo(document.querySelector('input[name="deliver-method"]:checked'));
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