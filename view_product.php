<?php
include 'header.php';
include 'carousel.php';

if(isset($_GET['sanpham_id']) && $_GET['sanpham_id'] != NULL ){
    $sanpham_id = $_GET['sanpham_id'];
} else {
    // Xử lý khi không có id trong URL, ví dụ:
    header('Location: index.php');
    exit();
}
// Kiểm tra trạng thái đăng nhập
$is_logged_in = isset($_SESSION['login']) && $_SESSION['login'] === true;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sản phẩm </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="css/view_product.css" rel="stylesheet"> <!-- Liên kết tệp CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Liên kết jQuery -->
</head>

<body>

    <Session class="pruduct">
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-6">
                    <div class="product-top">
                        <?php
                        $get_sanpham = $index->get_sanpham($sanpham_id);
                        if ($get_sanpham) {
                            $result_sp = $get_sanpham->fetch_assoc();
                        }
                        ?>
                        <p><a href="index.php">Trang chủ</a></p> <span>&#8594;</span>
                        <p><?php echo $result_sp['danhmuc_ten'] ?></p><span>&#8594;</span>
                        <p><?php echo $result_sp['loaisanpham_ten'] ?></p><span>&#8594;</span>
                        <p><?php echo $result_sp['sanpham_tieude'] ?></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <h2>Chi tiết sản phẩm</h2>
                </div>

                <div class="product-content row">
                    <?php
                    $get_sanpham = $index->get_sanpham($sanpham_id);
                    if ($get_sanpham) {
                        while($result_sanpham = $get_sanpham->fetch_assoc()){
                    ?>
                    <div class="product-content-left row">
                        <div class="product-content-left-big-img">
                            <img class="sanpham_anh" src="images/product/<?php echo $result_sanpham['sanpham_anh'] ?>"
                                alt="">
                        </div>
                        <div class="product-content-left-small-img">
                            <?php  
                            $sanpham_id = $result_sanpham['sanpham_id'];
                            $get_sanpham_anh = $index->get_anh($sanpham_id);
                            if ($get_sanpham_anh) {
                                while($result_sanpham_anh = $get_sanpham_anh->fetch_assoc()){        
                            ?>
                            <img src="images/product/<?php echo $result_sanpham['sanpham_anh'] ?>" alt="">
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <div class="product-content-right">
                        <div class="product-content-right-product-name">

                            <input class="user_id" type="hidden" value="<?php echo $userid; ?>">
                            <!-- Sử dụng $_SESSION['user_id'] -->
                            <input class="sanpham_id" type="hidden" value="<?php echo $result_sanpham['sanpham_id'] ?>">
                            <h1 class="sanpham_tieude"><?php echo $result_sanpham['sanpham_tieude'] ?></h1>
                            <p><?php echo $result_sanpham['sanpham_ma'] ?></p>
                        </div>

                        <div class="product-content-right-product-price">
                            <p><span><?php $result_gia = number_format($result_sanpham['sanpham_gia']);
                                        echo $result_gia ?></span><sup>đ</sup></p>
                            <input class="sanpham_gia" type="hidden"
                                value="<?php echo $result_sanpham['sanpham_gia'] ?>">
                        </div>

                        <div class="product-content-right-product-color">
                            <p><span style="font-weight: bold;">Màu
                                    sắc</span>:<?php echo $result_sanpham['color_ten'] ?>
                                <span style="color: red;">*</span>
                            </p>
                            <div class="product-content-right-product-color-IMG">
                                <img class="color_anh" src="<?php echo $result_sanpham['color_anh'] ?>" alt="">
                            </div>
                        </div>

                        <div class="product-content-right-product-size">
                            <p style="font-weight: bold"> Size: </p>
                            <div class="size">
                                <?php
                                $sanpham_id = $result_sanpham['sanpham_id'];
                                $get_size = $index->get_size($sanpham_id);
                                if ($get_size) {
                                    while($result_size = $get_size->fetch_assoc()){
                                ?>
                                <div class="size-item">
                                    <input class="size-item-input" value="<?php echo $result_size['sanpham_size'] ?>"
                                        name="size-item" type="radio">
                                    <span><?php echo $result_size['sanpham_size'] ?></span>
                                </div>
                                <?php
                                    }
                                }
                                ?>
                            </div>

                            <div class="quantity">
                                <p style="font-weight: bold"> Số lượng: </p>
                                <input class="quantitys" type="number" min="0" value="1">
                            </div>
                            <p class="size-alert" style="color: red;"></p>
                        </div>

                        <div class="product-content-right-product-button">
                            <button class="add-cart-btn"> <i class="fas fa-shopping-cart"></i>
                                <p>MUA HÀNG</p>
                            </button>
                            <button>
                                <p>TÌM TẠI CỬA HÀNG</p>
                            </button>
                        </div>

                        <div class="product-content-right-product-icon">
                            <div class="product-content-right-product-icon-item">
                                <i class="fas fa-phone-alt"></i>
                                <p>Hotline</p>
                            </div>
                            <div class="product-content-right-product-icon-item">
                                <i class="far fa-comments"></i>
                                <p>Chat</p>
                            </div>
                            <div class="product-content-right-product-icon-item">
                                <i class="far fa-envelope"></i>
                                <p>Mail</p>
                            </div>
                        </div>

                        <div class="product-content-right-product-QR">
                            <img src="images/qrcode2.png" alt="">
                        </div>

                        <div class="product-content-right-bottom">
                            <div class="product-content-right-bottom-top">
                                &#8744;
                            </div>
                            <div class="product-content-right-bottom-content-big">
                                <div class="product-content-right-bottom-title">
                                    <div class="product-content-right-bottom-title-item chitiet">
                                        <p>Chi tiết</p>
                                    </div>
                                    <div class="product-content-right-bottom-title-item baoquan">
                                        <p>Bảo quản</p>
                                    </div>
                                    <div class="product-content-right-bottom-title-item">
                                        <p>Tham khảo size</p>
                                    </div>
                                </div>
                                <div class="product-content-right-bottom-content">
                                    <div class="product-content-right-bottom-content-chitiet">
                                        <?php echo $result_sanpham['sanpham_chitiet'] ?>
                                    </div>
                                    <div class="product-content-right-bottom-content-baoquan">
                                        <?php echo $result_sanpham['sanpham_baoquan'] ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
    </Session>
    <!-- -------------------------SẢN PHẨM LIÊN QUAN -->
    <section class="product-related">
        <div class="container">
            <div class="product-related-title">
                <p>SẢN PHẨM LIÊN QUAN</p>
            </div>
            <div class="row justify-between">
                <?php
                $loaisanpham_id = $result_sp['loaisanpham_id'];
                $get_sanphamlienquan = $index->get_sanphamlienquan($loaisanpham_id, $sanpham_id);
                if ($get_sanphamlienquan) {
                    while ($result_sp_lienquan = $get_sanphamlienquan->fetch_assoc()) {
                ?>
                <div class="product-related-item">
                    <a href="view_product.php?sanpham_id=<?php echo $result_sp_lienquan['sanpham_id'] ?>"><img
                            src="images/product/<?php echo $result_sp_lienquan['sanpham_anh'] ?>" alt=""></a>
                    <a href="view_product.php?sanpham_id=<?php echo $result_sp_lienquan['sanpham_id'] ?>">
                        <h1><?php echo $result_sp_lienquan['sanpham_tieude'] ?></h1>
                    </a>
                    <p><?php $result_gia_1 = number_format($result_sp_lienquan['sanpham_gia']);
                            echo $result_gia_1 ?><sup>đ</sup></p>
                </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>
    </section>

    <?php
       include 'footer.php';
    ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6YVFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>

    <script>
    $(document).ready(function() {
        var s = '';
        $('.size-item-input').each(function(index) {
            $(this).change(function() {
                s = $(this).val();
            });
        });
        $('.add-cart-btn').click(function() {
            if (s == "") {
                $('.size-alert').text('Vui lòng chọn size*');
            } else {
                <?php if ($is_logged_in) { ?>
                var x = $(this).parent().parent().find('.sanpham_tieude').text();
                var user_id =
                    "<?php echo $userid; ?>"; // Sử dụng $_SESSION['user_id'] để quản lý phiên đăng nhập
                var sp = $(this).parent().parent().find('.sanpham_id').val();
                var y = $(this).parent().parent().parent().find('.sanpham_anh').attr('src');
                var z = $(this).parent().parent().find('.sanpham_gia').val();
                var c = $(this).parent().parent().find('.color_anh').attr('src');
                var q = $(this).parent().parent().find('.quantitys').val();
                $.ajax({
                    url: "ajax/cart_ajax.php",
                    method: "POST",
                    data: {
                        user_id: user_id,
                        sanpham_id: sp,
                        sanpham_tieude: x,
                        sanpham_anh: y,
                        sanpham_gia: z,
                        color_anh: c,
                        quantitys: q,
                        sanpham_size: s
                    },
                    success: function(data) {
                        console.log(data); // Kiểm tra phản hồi từ server
                        $.ajax({
                            url: "ajax/update_quantity.php",
                            method: "POST",
                            data: {
                                sanpham_id: sp,
                                quantity: q
                            },
                            success: function(data) {
                                console.log(
                                    data); // Kiểm tra phản hồi từ server
                                $(location).attr('href', 'cart.php');
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr
                                    .responseText); // Kiểm tra lỗi nếu có
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText); // Kiểm tra lỗi nếu có
                    }
                });














                <?php } else { ?>
                $(location).attr('href', 'login.php');
                <?php } ?>
            }
        });
    });
    </script>
</body>

</html>