<?php
include_once "../class/product.php"; // Bao gồm tệp chứa định nghĩa của lớp product

$product = new product();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sanpham_id = $_POST['sanpham_id'];
    $sanpham_size = $_POST['sanpham_size'];
    $insert_sizesp = $product->insert_sizesp($sanpham_id, $sanpham_size);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADD SIZE</title>
    <link href="css/sizesanphamadd.css" rel="stylesheet"> <!-- Liên kết tệp CSS -->
</head>

<body>

    <div class="add-s-content-right">
        <div class="subcartegory-add-content">
            <form action="" method="POST" enctype="multipart/form-data">
                <label for="sanpham_id"><b>Thêm size sản phẩm</b></label>
                <select name="sanpham_id" id="sanpham_id" required>
                    <option value="">Chọn sản phẩm</option>
                    <?php
                    $show_product = $product->show_product();
                    if ($show_product) {
                        while ($result = $show_product->fetch_assoc()) {
                    ?>
                    <option value="<?php echo $result['sanpham_id'] ?>"><?php echo $result['sanpham_ma'] ?></option>
                    <?php
                        }
                    }
                    ?>
                </select>
                <br>

                <label for="sanpham_size">Chọn Size sản phẩm<span style="color: red;">*</span></label> <br>
                <select name="sanpham_size" id="sanpham_size" required>
                    <option value="">--Chọn--</option>
                    <option value="S">Size S</option>
                    <option value="M">Size M</option>
                    <option value="L">Size L</option>
                    <option value="XL">Size XL</option>
                    <option value="XXL">Size XXL</option>
                </select>
                <button class="admin-btn" type="submit">Gửi</button>
                <a href="sizesanphamlists.php" class="admin-btn">Quay lại</a>
            </form>
        </div>
    </div>

</body>

</html>