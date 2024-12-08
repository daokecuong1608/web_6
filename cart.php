<?php
// Kiểm tra sự tồn tại của tham số 'id'
if (!isset($_GET['id'])) {
    echo "<meta http-equiv='refresh' content='0; url=?id=live'>";
    exit();
}

// Kiểm tra nếu người dùng đã đăng nhập
session_start();
$userid = $_SESSION['user_id'] ?? 0; // Lấy ID người dùng từ session
if ($userid == 0) {
    echo "Vui lòng đăng nhập để xem giỏ hàng.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="css/view_product.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="css/cart.css" rel="stylesheet">
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
            // Lấy danh sách giỏ hàng từ cơ sở dữ liệu
            $show_cart = $index->show_cart($userid);
            if ($show_cart) {
            ?>
            <div class="cart-content row justify-content-center">
                <div class="col-md-8">
                    <div class="cart-content-left">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Chọn mua</th>
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
                                while ($result = $show_cart->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="product-checkbox"
                                            data-cart-id="<?php echo $result['cart_id']; ?>"
                                            <?php echo ($result['status'] == 'CHỌN') ? 'checked' : ''; ?>>
                                    </td>
                                    <td><img src="<?php echo $result['sanpham_anh']; ?>" alt=""></td>
                                    <td>
                                        <p><?php echo $result['sanpham_tieude']; ?></p>
                                    </td>
                                    <td><img src="<?php echo $result['color_anh']; ?>" alt=""></td>
                                    <td>
                                        <p><?php echo $result['sanpham_size']; ?></p>
                                    </td>
                                    <td class="product-quantity"><span><?php echo $result['quantitys']; ?></span></td>
                                    <td class="product-price">
                                        <p><?php echo number_format($result['sanpham_gia']); ?><sup>đ</sup></p>
                                    </td>
                                    <td><a
                                            href="cartdelete.php?cart_id=<?php echo $result['cart_id']; ?>"><span>x</span></a>
                                    </td>

                                    <?php
                                    // Tính tổng tiền cho sản phẩm
                                    if ($result['status'] == 'CHON') {
                                        $SL += $result['quantitys']; // Tổng số lượng
                                        $TTA = (int)$result['sanpham_gia'] * (int)$result['quantitys']; // Tổng tiền cho sản phẩm
                                        $TT += $TTA; // Cộng dồn tổng tiền cho giỏ hàng
                                    }
                                    ?>
                                </tr>
                                <?php } ?>
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
                                    <td id="total_products"><?php echo number_format($SL); ?></td>
                                </tr>
                                <tr>
                                    <td>TỔNG TIỀN HÀNG</td>
                                    <td id="total_price">
                                        <p><?php echo number_format($TT); ?><sup>đ</sup></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>THÀNH TIỀN</td>
                                    <td>
                                        <p id="final_price"><?php echo number_format($TT); ?><sup>đ</sup></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>TẠM TÍNH</td>
                                    <td id="temp_price">
                                        <p style="font-weight: bold; color: black;">
                                            <?php echo number_format($TT); ?><sup>đ</sup></p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="cart-content-right-text">
                            <p>Bạn sẽ được miễn phí ship khi đơn hàng có tổng giá trị trên 2,000,000<sup>đ</sup></p><br>
                            <div class="free-shipping-message"></div> <!-- This is where the message will be updated -->
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
                echo "Bạn chưa thêm sản phẩm nào vào giỏ hàng. Vui lòng chọn sản phẩm!";
            }
            ?>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.product-checkbox');
        let totalPrice = <?php echo $TT; ?>; // Tổng tiền hiện tại
        let totalProducts = <?php echo $SL; ?>; // Tổng số sản phẩm hiện tại

        // Update shipping message based on total price
        const updateShippingMessage = () => {
            const freeShippingMessage = document.querySelector('.free-shipping-message');
            if (totalPrice >= 2000000) {
                freeShippingMessage.innerHTML =
                    '<p style="color: red; font-weight: bold;">Đơn hàng của bạn đủ điều kiện để được <span style="font-size: 18px;">Free</span> ship</p>';
            } else {
                freeShippingMessage.innerHTML =
                    `<p style="color: red; font-weight: bold;">Mua thêm <span style="font-size: 18px;">${(2000000 - totalPrice).toLocaleString()} đ</span> để được miễn phí SHIP</p>`;
            }
        };

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const cartId = this.dataset.cartId;
                const price = parseFloat(this.closest('tr').querySelector('.product-price')
                    .innerText.replace('đ', '').replace(/,/g, '').trim());

                const quantity = parseInt(this.closest('tr').querySelector('.product-quantity')
                    .innerText);

                // Kiểm tra nếu giá trị price hợp lệ
                if (isNaN(price)) {
                    console.error("Giá không hợp lệ:", price);
                    return; // Dừng xử lý nếu giá không hợp lệ
                }

                if (this.checked) {
                    // Tăng tổng số sản phẩm và tổng tiền khi checkbox được chọn
                    totalPrice += price * quantity;
                    totalProducts += quantity;
                } else {
                    // Giảm tổng số sản phẩm và tổng tiền khi checkbox bị bỏ chọn
                    totalPrice -= price * quantity;
                    totalProducts -= quantity;
                }

                // Cập nhật tổng số sản phẩm và tổng tiền trên trang
                document.getElementById('total_products').innerText = totalProducts
                    .toLocaleString();
                document.getElementById('total_price').innerText = totalPrice.toLocaleString() +
                    " đ";
                document.getElementById('final_price').innerText = totalPrice.toLocaleString() +
                    " đ";
                document.getElementById('temp_price').innerText = totalPrice.toLocaleString() +
                    " đ";

                // Update the shipping message based on the total price
                updateShippingMessage();

                // Gửi yêu cầu AJAX để cập nhật trạng thái
                const newStatus = this.checked ? 'CHON' : 'KHONG';
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "ajax/update_status.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                xhr.onload = function() {
                    if (xhr.status === 200) {
                        console.log("Cập nhật trạng thái thành công:", xhr.responseText);
                    } else {
                        console.error("Lỗi khi gửi yêu cầu AJAX:", xhr.responseText);
                    }
                };

                const data = `cart_id=${cartId}&status=${newStatus}`;
                xhr.send(data);
            });
        });
    });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" crossorigin="anonymous">
    </script>

</body>

</html>