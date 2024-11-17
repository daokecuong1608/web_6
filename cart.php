<?php
// Kiểm tra sự tồn tại của tham số 'id'
if (!isset($_GET['id'])) {
    echo "<meta http-equiv='refresh' content='0; url=?id=live'>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="css/view_product.css" rel="stylesheet"> <!-- Liên kết tệp CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="css/cart.css" rel="stylesheet"> <!-- Liên kết tệp CSS -->

</head>

<body>

    <?php
        include 'header.php';
        include 'carousel.php';
    ?>
    <section class="cart">
        <div class="container">
            <div class="cart-top-wrap">
                <div class="cart-top">
                    <div class="cart-top-cart cart-top-item">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="cart-top-adress cart-top-item">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="cart-top-payment cart-top-item">
                        <i class="fas fa-money-check-alt"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <?php
            $show_cart = $index->show_cart($userid);
            if ($show_cart) {
            ?>
            <div class="cart-content row justify-content-center">
                <div class="col-md-8">
                    <div class="cart-content-left">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Màu</th>
                                    <th>Size</th>
                                    <th>Số lượng</th>
                                    <th>Giá</th>
                                    <th>Xóa</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $SL = 0;
                                $TT = 0;
                                $show_cart = $index->show_cart($userid);
                                if ($show_cart) {
                                    while ($result = $show_cart->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><img src="<?php echo $result['sanpham_anh'] ?>" alt=""></td>
                                    <td>
                                        <p><?php echo $result['sanpham_tieude'] ?></p>
                                    </td>
                                    <td><img src="<?php echo $result['color_anh'] ?>" alt=""></td>
                                    <td>
                                        <p><?php echo $result['sanpham_size'] ?></p>
                                    </td>
                                    <td><span><?php echo $result['quantitys'] ?></span></td>
                                    <td>
                                        <p><?php $result_gia = number_format($result['sanpham_gia']);
                                            echo $result_gia ?><sup>đ</sup></p>
                                    </td>
                                    <td><a
                                            href="cartdelete.php?cart_id=<?php echo $result['cart_id'] ?>"><span>x</span></a>
                                    </td>


                                    <?php $a = (int)$result['sanpham_gia'];
                                    $b = (int)$result['quantitys'];
                                    $TTA = $a * $b; ?>
                                </tr>
                                <?php
                                        $SL = $SL + $result['quantitys'];
                                        Session::set('SL', $SL);
                                        $TT =  $TT  + $TTA;
                                    }
                                }
                                ?>
                            </tbody>

                        </table>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="cart-content-right">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="2">
                                        <p>TỔNG TIỀN GIỎ HÀNG</p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>TỔNG SẢN PHẨM</td>
                                    <td><?php $result_tong_sp = number_format($SL);
                                    echo $result_tong_sp ?></td>
                                </tr>
                                <tr>
                                    <td>TỔNG TIỀN HÀNG</td>
                                    <td>
                                        <p><?php $result_tien = number_format($TT);
                                        echo $result_tien ?><sup>đ</sup></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>THÀNH TIỀN</td>
                                    <td>
                                        <p><?php $result_tongtien = number_format($TT);
                                        echo $result_tongtien;
                                        Session::set('TT', $result_tongtien); ?><sup>đ</sup></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>TẠM TÍNH</td>
                                    <td>
                                        <p style="font-weight: bold; color: black;"><?php $result_tamtinh = number_format($TT);
                                        echo $result_tamtinh ?><sup>đ</sup></p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="cart-content-right-text">
                            <p>Bạn sẽ được miễn phí ship khi đơn hàng của bạn có tổng giá trị trên 2,000,000<sup>đ</sup>
                            </p><br>
                            <?php
                            if ($TT >= 2000000) {
                            ?>
                            <p style="color: red;font-weight: bold;">Đơn hàng của bạn đủ điều kiện được <span
                                    style="font-size: 18px;">Free</span> ship</p>
                            <?php
                            } else {
                            ?>
                            <p style="color: red;font-weight: bold;">Mua thêm <span style="font-size: 18px;"><?php $them = 2000000 - $TT;
                                $result_ship = number_format($them);
                                echo $result_ship  ?><sup>đ</sup></span> để được miễn phí
                                SHIP</p>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="cart-content-right-button">
                            <a href="index.php" class="btn-continue-shopping">TIẾP TỤC MUA SẮM</a>
                            <a href="delivery.php" class="btn-checkout"><button>THANH TOÁN</button></a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            } else {
                echo "Bạn vẫn chưa thêm sản phẩm nào vào giỏ hàng, Vui lòng chọn sản phẩm nhé!";
            }
            ?>
        </div>
    </section>

    <?php
       include 'footer.php';
    ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>

</body>

</html>