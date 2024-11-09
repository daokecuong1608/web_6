<?php
include 'header.php';
include 'carousel.php';
?>
<?php
$index = new index();
if(isset($_GET['loaisanpham_id'])){
    $loaisanpham_id = $_GET['loaisanpham_id'];
}
$get_loaisanpham = $index->get_loaisanpham($loaisanpham_id);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="css/category.css" rel="stylesheet"> <!-- Liên kết tệp CSS -->
</head>

<body>

    <div class="container">
        <div class="cartegory-right">
            <div class="cartegory-right-top row justify-content-end">
                <div class="cartegory-right-top-item">
                    <button><span>Bộ lọc</span><i class="fas fa-sort-down"></i></button>
                </div>
                <div class="cartegory-right-top-item">
                    <select name="" id="">
                        <option value="">Sắp xếp</option>
                        <option value="">Giá cao đến thấp</option>
                        <option value="">Giá thấp đến cao</option>
                    </select>
                </div>
            </div>
            <div class="cartegory-right-content row">
                <?php
                $get_loaisanpham = $index->get_loaisanpham($loaisanpham_id);
                if ($get_loaisanpham) {
                    while ($result = $get_loaisanpham->fetch_assoc()) {
                ?>
                <div class="cartegory-right-content-item">
                    <a href="product.php?sanpham_id=<?php echo $result['sanpham_id'] ?>"><img
                            src="images/product/<?php echo $result['sanpham_anh'] ?>" alt=""></a>
                    <a href="product.php?sanpham_id=<?php echo $result['sanpham_id'] ?>">
                        <h1><?php echo $result['sanpham_tieude'] ?></h1>
                    </a>
                    <div class="product-info">
                        <p>Giá bán: <?php $result_gia = number_format($result['sanpham_gia']);
                echo $result_gia ?><sup>đ</sup></p>
                        <button class="btn btn-quick-view"
                            onclick="window.location.href='view_product.php?sanpham_id=<?php echo $result['sanpham_id']; ?>'">Xem
                            nhanh</button>
                    </div>
                </div>
                <?php
                    }
                } else {
                    echo "Không có sản phẩm nào";
                }
                ?>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
</body>

</html>