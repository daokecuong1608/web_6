<?php


include 'header.php'; // Đường dẫn chính xác đến tệp header.php
include 'carousel.php'
?>
<?php

$index = new index();
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
$session_idA = session_id();
$today = date('d/m/y');
$deliver_method = $_POST['deliver-method'];
$method_payment = $_POST['method-payment'];
$insert_payment = $index ->insert_payment($session_idA,$deliver_method,$method_payment,$today );
 // Kiểm tra kết quả của truy vấn INSERT
 if ($insert_payment) {
    echo "Payment inserted successfully.";
} else {
    echo "Failed to insert payment.";
}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Payment</title>
    <link href="css/payment.css" rel="stylesheet"> <!-- Liên kết tệp CSS -->

</head>

<body>


    <section class="payment">

        <div class="container">
            <div class="payment-top-wrap">
                <div class="payment-top">
                    <div class="delivery-top-delivery payment-top-item">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="delivery-top-adress payment-top-item">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="delivery-top-payment payment-top-item">
                        <i class="fas fa-money-check-alt"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <?php
            $today = date('d/m/y');
            $session_id = session_id();
            echo "Session ID: " . $session_id;
            $show_cart = $index -> show_cart($session_id);
            if($show_cart){
             ?>
            <div class="payment-content row">
                <div class="col-md-6">
                    <div class="payment-content-left">
                        <form action="" method="POST">
                            <div class="payment-content-left-method-delivery">
                                <p style="font-weight: bold;">Phương thức giao hàng</p> <br>
                                <div class="payment-content-left-method-delivery-item">
                                    <input name="deliver-method" value="Ship hỏa tốc" checked type="radio">
                                    <label for="">Ship hỏa tốc</label><br>
                                    <input name="deliver-method" value="Giao hàng chuyển phát nhanh" checked
                                        type="radio">
                                    <label for="">Giao hàng chuyển phát nhanh</label>
                                </div>
                            </div>
                            <br>
                            <div class="payment-content-left-method-payment">
                                <p style="font-weight: bold;">Phương thức thanh toán</p> <br>
                                <p>Mọi giao dịch đều được bảo mật và mã hóa.</p> <br>

                                <div class="payment-content-left-method-payment-item">
                                    <input name="method-payment" type="radio">
                                    <label for="">Thanh toán bằng thẻ tín dụng(OnePay)</label>
                                </div>
                                <div class="payment-content-left-method-payment-item-img">
                                    <img src="images/visa.png" alt="">
                                </div>
                                <div class="payment-content-left-method-payment-item">
                                    <input name="method-payment" type="radio">
                                    <label for="">Thanh toán bằng thẻ ATM(OnePay)</label>
                                </div>
                                <div class="payment-content-left-method-payment-item-img">
                                    <img src="images/vcb.png" alt="">
                                </div>
                                <div class="payment-content-left-method-payment-item">
                                    <input name="method-payment" type="radio">
                                    <label for="">Thanh toán Momo</label>
                                </div>
                                <div class="payment-content-left-method-payment-item-img">
                                    <img src="image/momo.png" alt="">
                                </div>
                                <div class="payment-content-left-method-payment-item">
                                    <input value="Thanh toán khi nhận hàng " checked name="method-payment" type="radio">
                                    <label for="">Thanh toán khi nhận hàng</label>
                                </div>
                            </div>
                            <div class="payment-content-right-payment">
                                <button type="submit">HOÀN THÀNH</button>
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

                            <?php
                            $session_id = session_id();
                            $SL = 0;
                            $TT = 0;
                            $show_cart = $index -> show_cartB($session_id);
                            if($show_cart){
                                while($result = $show_cart->fetch_assoc()){
                            ?>


                            <tr>
                                <td><?php  echo $result['sanpham_tieude'] ?></td>
                                <td><?php $a = number_format($result['sanpham_gia']); echo $a  ?></td>
                                <td><?php echo $result['quantitys'] ?></td>
                                <td>
                                    <p><?php $a = $result['sanpham_gia']*$result['quantitys']; $b = number_format($a); echo $b ?><sup>đ</sup>
                                    </p>
                                </td>
                            </tr>

                            <?php
                                }
                            }
                            ?>
                            <tr style="border-top: 2px solid red">
                                <td style="font-weight: bold;border-top: 2px solid #dddddd" colspan="3">Tổng</td>
                                <td style="font-weight: bold;border-top: 2px solid #dddddd">
                                    <p><?php if(Session::get('TT'))  {echo Session::get('TT'); } ?><sup>đ</sup></p>
                                </td>
                            </tr>

                            <tr>
                                <td style="font-weight: bold;" colspan="3">Tổng tiền hàng</td>
                                <td style="font-weight: bold;">
                                    <p><?php if(Session::get('TT'))  {echo Session::get('TT'); } ?><sup>đ</sup></p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <?php
            }else {echo "Bạn vẫn chưa thêm sản phẩm nào vào giỏ hàng, Vui lòng chọn sản phẩm nhé!";}
            ?>
        </div>
    </section>

    <?php
        include 'footer.php'; // Đường dẫn chính xác đến tệp footer.php
        ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>

</body>

</html>