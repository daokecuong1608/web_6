<?php
require_once "../class/brand.php"; 
require_once "../class/product.php";

$brand = new brand(); 
$product = new product(); 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $loaisanpham_name = $_POST['loaisanpham_name'];
    $danhmuc_id = $_POST['danhmuc_id'];
    $insert_brand = $brand->insert_brand($danhmuc_id, $loaisanpham_name);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm thể loại</title>
    <link href="css/brandadd.css" rel="stylesheet"> <!-- Liên kết tệp CSS -->
</head>

<body>

    <div class="add-tl-content-right">
        <h2>Thêm thể loại</h2>
        <div class="tl-content">
            <form action="" method="POST" enctype="multipart/form-data">
                <label for="danhMuc">Chọn danh mục<span style="color: red;">*</span></label> <br>
                <select required="required" name="danhmuc_id" id="danhMuc">
                    <option value="">--Chọn--</option>
                    <?php
                    $show_danhmuc = $product->show_danhmuc();
                    if ($show_danhmuc) {
                        while (
                            $result_danhmuc = $show_danhmuc->fetch_assoc()) {
                    ?>
                    <option value="<?php echo $result_danhmuc['danhmuc_id'] ?>">
                        <?php echo $result_danhmuc['danhmuc_ten'] ?></option>
                    <?php
                        }
                    }
                    ?>
                </select></br>
                <label for="">Vui lòng chọn Loại sản phẩm<span style="color: red;">*</span></label> <br>
                <input class="subcartegory-input" type="text" name="loaisanpham_name">
                <div class="form-buttons">
                    <a href="brandlist.php" class="admin-btn">Quay lại</a>
                    <button class="admin-btn" type="submit">Gửi</button>
                </div>

            </form>
        </div>
    </div>
</body>

</html>