<?php
require_once "../class/brand.php"; 
require_once "../class/product.php";

$brand = new brand(); 
$product = new product(); 

if (isset($_GET['loaisanpham_id']) && $_GET['loaisanpham_id'] != NULL) {
    $loaisanpham_id = $_GET['loaisanpham_id'];
}
$get_brand = $brand->get_brand($loaisanpham_id);
if ($get_brand) {
    $resul = $get_brand->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $loaisanpham_ten = $_POST['loaisanpham_ten'];
    $danhmuc_id = $_POST['danhmuc_id'];
    $update_brand = $brand->update_brand($loaisanpham_ten, $danhmuc_id, $loaisanpham_id);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update thể loại</title>
    <link href="css/brandedit.css" rel="stylesheet"> <!-- Liên kết tệp CSS -->
</head>

<body>

    <div class="up-tl-content-right">
        <h2>Sửa thể loại</h2>
        <div class="tl-content">
            <form action="" method="POST" enctype="multipart/form-data">
                <label for="">Chọn danh mục<span style="color: red;">*</span></label> <br>
                <select required="required" name="danhmuc_id" id="">
                    <option value="">--Chọn--</option>
                    <?php
                        $show_danhmuc = $product->show_danhmuc();
                        if ($show_danhmuc) {
                            while ($result = $show_danhmuc->fetch_assoc()) {
                    ?>
                    <option <?php if ($resul['danhmuc_id'] == $result['danhmuc_id']) { echo "selected"; } ?>
                        value="<?php echo $result['danhmuc_id'] ?>"><?php echo $result['danhmuc_ten'] ?></option>
                    <?php
                            }
                        }
                    ?>
                </select><br>
                <label for="">Vui lòng chọn Loại sản phẩm<span style="color: red;">*</span></label> <br>
                <input class="subcartegory-input" type="text" value="<?php echo $resul['loaisanpham_ten'] ?>"
                    name="loaisanpham_ten">
                <div class="form-buttons">
                    <a href="brandlist.php" class="admin-btn">Quay lại</a>
                    <button class="admin-btn" type="submit">Gửi</button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>