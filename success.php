<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Thành công</title>
    <link href="css/success.css" rel="stylesheet">

</head>

<body>

    <?php
include 'header.php';
include 'carousel.php';
$userid = $_SESSION['user_id']; // Lấy ra user_id từ phiên

?>

    <?php
 if (!defined('__ROOT__')) {
    define('__ROOT__', dirname(__FILE__));
}
require_once(__ROOT__ . '/class/index_class.php'); // Đường dẫn chính xác đến tệp index_class.php
$index = new index();



?>

    <section class="success">
        <div class="success-top">
            <p>ĐẶT HÀNG THÀNH CÔNG</p>
        </div>
        <div class="success-text">
            <?php

        $show_cart = $index->show_order($userid);
        if ($show_cart) {
            while ($result_cart = $show_cart->fetch_assoc()) {
        ?>
            <p>Chào <span style="font-size: 20px; color: #378000;"><?php echo $result_cart['customer_name'] ?></span>,
                đơn hàng của bạn với mã <span
                    style="font-size: 20px; color: #378000;"><?php $ma = substr($userid, 0, 8);
                                                                                                                                                                                                echo $ma   ?></span>
                đã được đặt thành công. <br>
                Đơn hàng của bạn đã được xác nhận tự động. <br>
                <span style="font-weight: bold;">Hiện tại do đang trong Chương trình Sale lớn, đơn hàng của quý khách sẽ
                    gửi chậm hơn so với thời gian dự kiến từ 5-10 ngày. Rất mong quý khách thông cảm vì sự bất tiện
                    này!</span><br>
                <span style="color: red;">(Lưu ý: Nếu bạn không hài lòng gì về chúng tôi hay liên hệ với shop của chúng
                    tôi . Đừng vội đánh giá chúng tôi 1 sao nha.)</span><br>
                Cám ơn <span style="font-size: 20px; color: #378000;"><?php echo $result_cart['customer_name'] ?></span>
                đã tin dùng sản phẩm của shop.
            </p>
            <?php
            }
        }
        ?>
        </div>
        <div class="success-button">
            <a href="detaill.php"><button>XEM CHI TIẾT ĐƠN HÀNG</button></a>
            <a href="index.php"><button>TIẾP TỤC MUA SẮM</button></a>
        </div>
        <p>Mọi thắc mắc quý khách vui lòng liên hệ hotline <span style="font-size: 20px; color: red;">0964732982
            </span> hoặc chat với kênh hỗ trợ trên website để được hỗ trợ nhanh nhất.</p>

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