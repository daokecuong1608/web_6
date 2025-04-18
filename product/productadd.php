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
                <span id="tenSanPhamError" style="color: red;"></span>

                <label for="maSanPham">Mã sản phẩm<span style="color: red;">*</span></label> <br>
                <input required type="text" name="sanpham_ma" id="maSanPham"> <br>
                <span id="maSanPhamError" style="color: red;"></span>


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
                <input required type="text" name="sanpham_gia" id="sanpham_gia"> <br>
                <span id="sanpham_gia_error" style="color: red;"></span> <!-- Thông báo lỗi cho giá sản phẩm -->

                <label for="">Số lượng sản phẩm<span style="color: red;">*</span></label> <br>
                <input required type="text" name="sanpham_soluong" id="sanpham_soluong"> <br>
                <span id="sanpham_soluong_error" style="color: red;"></span>
                <!-- Thông báo lỗi cho số lượng sản phẩm -->

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
        //blur : khi người dùng rời khỏi ô input API sẽ được gọi 
        $("#tenSanPham").blur(function() {
            var tenSanPham = $(this).val();
            if (tenSanPham.trim() !== "") {
                $.get("../ajax/check_product_name.php", {
                        sanpham_tieude: tenSanPham
                    })
                    .done(function(data) {
                        console.log("Dữ liệu trả về từ server:",
                            data); // Kiểm tra dữ liệu trả về từ server
                        try {
                            // Nếu dữ liệu trả về là đối tượng JSON hợp lệ
                            if (typeof data === 'object') {
                                // Không cần phải parse nếu dữ liệu đã là object
                                if (data.exists) {
                                    $("#tenSanPhamError").text(
                                        "Tên sản phẩm đã tồn tại!"); // Hiển thị lỗi
                                } else {
                                    $("#tenSanPhamError").text(""); // Không có lỗi
                                }
                            } else {
                                // Nếu dữ liệu trả về không phải object, parse nó
                                var result = JSON.parse(data);
                                if (result.exists) {
                                    $("#tenSanPhamError").text("Tên sản phẩm đã tồn tại!");
                                } else {
                                    $("#tenSanPhamError").text("");
                                }
                            }
                        } catch (e) {
                            console.error("Lỗi parse JSON:", e);
                            $("#tenSanPhamError").text("Lỗi kiểm tra tên sản phẩm.");
                        }
                    })
                    .fail(function(xhr, status, error) {
                        if (xhr.status !== 200) {
                            $("#tenSanPhamError").text("Không thể kết nối đến server.");
                        }
                    });
            } else {
                $("#maSanPhamError").text(""); // Nếu ô input trống, xóa thông báo lỗi
            }
        });



        // Kiểm tra mã sản phẩm
        $("#maSanPham").blur(function() {
            var maSanPham = $(this).val();
            if (maSanPham.trim() !== "") {
                $.get("../ajax/check_product_code.php", {
                        sanpham_ma: maSanPham
                    })
                    .done(function(data) {
                        console.log("Dữ liệu trả về từ server:",
                            data); // Kiểm tra dữ liệu trả về từ server
                        try {
                            // Nếu dữ liệu trả về là đối tượng JSON hợp lệ
                            if (typeof data === 'object') {
                                if (data.exists) {
                                    $("#maSanPhamError").text(
                                        "Mã sản phẩm đã tồn tại!"); // Hiển thị lỗi
                                } else {
                                    $("#maSanPhamError").text(""); // Không có lỗi
                                }
                            } else {
                                var result = JSON.parse(
                                    data); // Parse JSON nếu dữ liệu trả về là chuỗi
                                if (result.exists) {
                                    $("#maSanPhamError").text("Mã sản phẩm đã tồn tại!");
                                } else {
                                    $("#maSanPhamError").text("");
                                }
                            }
                        } catch (e) {
                            console.error("Lỗi parse JSON:", e);
                            $("#maSanPhamError").text("Lỗi kiểm tra mã sản phẩm.");
                        }
                    })
                    .fail(function(xhr, status, error) {
                        if (xhr.status !== 200) {
                            $("#maSanPhamError").text("Không thể kết nối đến server.");
                        }
                    });
            } else {
                $("#maSanPhamError").text(""); // Nếu ô input trống, xóa thông báo lỗi
            }

        });



        $("#sanpham_gia").blur(function() {
            var giaSanPham = $(this).val();
            if (isNaN(giaSanPham) || giaSanPham <= 0) {
                $("#sanpham_gia_error").text("Giá sản phẩm phải là một số lớn hơn 0.");
            } else {
                $("#sanpham_gia_error").text("");
            }
        });

        // Kiểm tra giá trị số lượng sản phẩm
        $("#sanpham_soluong").blur(function() {
            var soLuongSanPham = $(this).val();
            if (isNaN(soLuongSanPham) || soLuongSanPham <= 0) {
                $("#sanpham_soluong_error").text("Số lượng sản phẩm phải là một số lớn hơn 0.");
            } else {
                $("#sanpham_soluong_error").text("");
            }
        });



        $("#danhmuc_id").change(function() {
            var x = $(this).val();
            $.get("../ajax/productadd_ajax.php", {
                danhmuc_id: x
            }, function(data) {
                $("#loaisanpham_id").html(data);
            });
        });


        // Xử lý khi gửi form
        $("form").submit(function(event) {
            if ($("#tenSanPhamError").text() !== "" || $("#maSanPhamError").text() !== "" || $(
                    "#sanpham_gia_error").text() !== "" || $("#sanpham_soluong_error").text() !== "") {
                event.preventDefault();
                alert("Vui lòng sửa lỗi trước khi gửi form!");
            }
        });


    });
    </script>

</body>

</html>