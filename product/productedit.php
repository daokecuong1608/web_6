<?php
session_start(); // Khởi tạo session

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
//kiểm tra xem biến có tồn tại hay không
    if(isset($_GET['sanpham_id']) || $_GET['sanpham_id'] != NULL){
        $sanpham_id = $_GET['sanpham_id'];
    }
    $get_sanpham = $product -> get_sanpham($sanpham_id);
    if($get_sanpham){
        $result = $get_sanpham -> fetch_assoc();
    }
?>
<?php
//kiểm tra xem biểu mẫu có được gửi bằng phương thức POST hay không
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])){
    $update_product = $product -> update_product($_POST, $_FILES , $sanpham_id);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update sản phẩm </title>
    <link href="css/productedit.css" rel="stylesheet"> <!-- Liên kết tệp CSS -->

</head>

<body>
    <div class="up-pro-content-right">
        <div class="product-add-content">
            <h2>Cập nhật sản phẩm</h2>
            <?php
                if(isset($update_product)){
                    echo $update_product;
                }
                ?>
            <form action="" method="POST" enctype="multipart/form-data">

                <label for="tenSanPham">Tên sản phẩm<span style="color: red;">*</span> </label><br>
                <input value="<?php echo $result['sanpham_tieude'] ?>" require type="text" name="sanpham_tieude"
                    id="tenSanPham"><br>

                <label for="maSanPham">Mã sản phẩm <span style="color: red;">*</span> </label><br>
                <input value="<?php echo $result['sanpham_ma'] ?>" require type="text" name="sanpham_ma"
                    id="maSanPham"><br>


                <label for="">Chọn danh mục<span style="color: red;">*</span></label> <br>
                <select required="required" name="danhmuc_id" id="danhmuc_id">
                    <option value="">--Chọn--</option>
                    <?php
                        $show_danhmuc = $product ->show_danhmuc();
                        if($show_danhmuc){
                            while($result_danhmuc=$show_danhmuc->fetch_assoc()){
                        ?>
                    <option <?php if($result_danhmuc['danhmuc_id']== $result['danhmuc_id']) {echo "selected";} ?>
                        value="<?php echo $result_danhmuc['danhmuc_id'] ?>"><?php echo $result_danhmuc['danhmuc_ten'] ?>
                    </option>
                    <?php
                        }}
                        ?>
                </select><br>

                <label for="">Chọn Loại sản phẩm<span style="color: red;">*</span></label> <br>
                <select required="required" name="loaisanpham_id" id="loaisanpham_id">
                    <option value="">--Chọn--</option>
                    <?php
                        $show_loaisanpham = $product ->show_loaisanpham();
                        if($show_loaisanpham){
                            while($result_loaisanpham=$show_loaisanpham->fetch_assoc()){
                        ?>
                    <option
                        <?php if($result_loaisanpham['loaisanpham_id']== $result['loaisanpham_id']) {echo "selected";} ?>
                        value="<?php echo $result_loaisanpham['loaisanpham_id'] ?>">
                        <?php echo $result_loaisanpham['loaisanpham_ten'] ?>
                    </option>
                    <?php
                        }}
                        ?>

                </select>



                <label for="color">Chọn Màu sản phẩm<span style="color: red;">*</span></label> <br>
                <select require="require" name="color_id" id="color">
                    <option value="">Chọn màu</option>
                    <?php
                        $show_color = $product->show_color();
                        if($show_color){
                            while(
                                $result_color = $show_color->fetch_assoc()){
                    ?>
                    <option <?php if($result['color_id'] == $result_color['color_id']){  echo 'selected'; }?>
                        value="<?php echo $result_color['color_id'] ?>">
                        <?php echo $result_color['color_ten'] ?>
                    </option>
                    <?php
                        }
                        }
                        ?>
                </select>

                <label for="giaSanPham">Giá sản phẩm <span style="color: red;">*</span> </label><br>
                <input value="<?php echo $result['sanpham_gia'] ?>" require type="text" name="sanpham_gia"
                    id="giaSanPham"><br>

                <label for="">Chi tiết<span style="color: red;">*</span></label> <br>
                <textarea required name="sanpham_chitiet" cols="60"
                    rows="5"><?php echo $result['sanpham_chitiet'] ?></textarea><br>

                <label for="">Bảo quản<span style="color: red;">*</span></label> <br>
                <textarea required name="sanpham_baoquan" cols="60"
                    rows="5"><?php echo $result['sanpham_baoquan'] ?></textarea><br>

                <label for=""> Ảnh đại diện <span style="color: red;">*</span></label> <br>
                <img style="width: 100px; height: 100px" src="../images/product/<?php echo $result['sanpham_anh'] ?>">
                <br>
                <input type="file" name="sanpham_anh"> <br>

                <label for="">Ảnh Sản phẩm<span style="color: red;">*</span></label> <br>
                <div class="sanpham_anh">
                    <?php
                $get_anh = $product -> get_anh($sanpham_id);
                if($get_anh){
                    while($result_anh= $get_anh -> fetch_assoc()){
                   ?>
                    <img style="width: 100px; height: 100px"
                        src="../images/product/<?php echo $result_anh['sanpham_anh'] ?>">
                    <?php
                    }
                }
                ?>
                </div>
                <input type="file" multipart name="sanpham_anhs[]"><br>
                <button class="admin-btn" type="submit" name="submit">Gửi</button>
                <a href="productlist.php" class="admin-btn">Quay lại</a>


            </form>
        </div>
    </div>
</body>

</html>