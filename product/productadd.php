<?php

session_start(); 

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: /web_quan_ao/login.php");  
      exit();
}

// Kiểm tra xem người dùng có phải là admin không
if ($_SESSION['role'] !== 'admin') {
    header("Location: /web_quan_ao/index.php");  
    exit();
}

include_once "../class/product.php"; // Bao gồm tệp chứa định nghĩa của lớp product

$product = new product(); 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $insert_product = $product->insert_product($_POST, $_FILES);
    header('Location: productlist.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sản phẩm </title>
    <link href="css/productadd.css" rel="stylesheet"> <!-- Liên kết tệp CSS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Liên kết thư viện jQuery -->
</head>

<body>
    <div class="add-pro-content-right">
        <div class="product-add-content">
            <?php
                if (isset($insert_product)) {
                    echo $insert_product;
                }
                ?>
            <h2>Thêm sản phẩm</h2>
            <form action="productadd.php" method="POST" enctype="multipart/form-data">

                <label for="tenSanPham">Tên sản phẩm<span style="color: red;">*</span></label> <br>
                <input required type="text" name="sanpham_tieude" id="tenSanPham"> <br>
                <label for="maSanPham">Mã sản phẩm<span style="color: red;">*</span></label> <br>
                <input required type="text" name="sanpham_ma" id="maSanPham"> <br>

                <label for="">Chọn danh mục<span style="color: red;">*</span></label> <br>
                <select required="required" name="danhmuc_id" id="danhmuc_id">
                    <option value="">--Chọn--</option>
                    <?php
                        $show_danhmuc = $product->show_danhmuc();
                        if ($show_danhmuc) {
                            while ($result = $show_danhmuc->fetch_assoc()) {
                    ?>
                    <option value="<?php echo $result['danhmuc_id'] ?>"><?php echo $result['danhmuc_ten'] ?></option>
                    <?php
                            }
                        }
                    ?>
                </select>

                <label for="">Chọn Loại sản phẩm<span style="color: red;">*</span></label> <br>
                <select required="required" name="loaisanpham_id" id="loaisanpham_id">
                    <option value="">--Chọn--</option>
                </select>


                <label for="color">Chọn Màu sản phẩm<span style="color: red;">*</span></label> <br>
                <select required name="color_id" id="color">
                    <option value="">Chọn màu</option>
                    <?php
                        $show_color = $product->show_color();
                        if ($show_color) {
                            while ($result_color = $show_color->fetch_assoc()) {
                    ?>
                    <option value="<?php echo $result_color['color_id'] ?>">
                        <?php echo $result_color['color_ten'] ?>
                    </option>
                    <?php
                            }
                        }
                    ?>
                </select><br>
                <label for="size">Chọn Size sản phẩm<span style="color: red;">*</span></label> <br>
                <div class="sanpham-size" id="size">
                    <p>S</p> <input type="checkbox" name="sanpham_size[]" value="S">
                    <p>M</p> <input type="checkbox" name="sanpham_size[]" value="M">
                    <p>L</p> <input type="checkbox" name="sanpham_size[]" value="L">
                    <p>XL</p> <input type="checkbox" name="sanpham_size[]" value="XL">
                    <p>XXL</p> <input type="checkbox" name="sanpham_size[]" value="XXL">
                </div>
                <label for="">Giá sản phẩm<span style="color: red;">*</span></label> <br>
                <input required type="text" name="sanpham_gia"> <br>
                <label for="">Chi tiết<span style="color: red;">*</span></label> <br>
                <textarea class="ckeditor" required name="sanpham_chitiet" cols="60" rows="5"></textarea><br>
                <label for="">Bảo quản<span style="color: red;">*</span></label> <br>
                <textarea class="ckeditor" required name="sanpham_baoquan" cols="60" rows="5"></textarea><br>
                <label for="">Ảnh đại diện<span style="color: red;">*</span></label> <br>
                <input required type="file" name="sanpham_anh"> <br>
                <label for="">Ảnh Sản phẩm<span style="color: red;">*</span></label> <br>
                <input required type="file" multiple name="sanpham_anhs[]"> <br>
                <button class="admin-btn" name="submit" type="submit">Gửi</button>

            </form>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        $("#danhmuc_id").change(function() {
            var x = $(this).val();
            $.get("../ajax/productadd_ajax.php", {
                danhmuc_id: x
            }, function(data) {
                $("#loaisanpham_id").html(data);
            });
        });
    });
    </script>

</body>

</html>