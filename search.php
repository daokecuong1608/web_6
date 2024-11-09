<?php
 include 'header.php'; // Đường dẫn chính xác đến tệp header.php
$index = new index();

$searchQuery = '';
if (isset($_GET['searchQuery'])) {
    $searchQuery = $_GET['searchQuery'];
}

$searchResults = [];
if (!empty($searchQuery)) {
    $searchResults = $index->searchProducts($searchQuery);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả tìm kiếm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="css/search.css" rel="stylesheet"> <!-- Liên kết tệp CSS -->
</head>

<body>


    <div class="container mt-4">
        <h1>Kết quả tìm kiếm cho: "<?php echo htmlspecialchars($searchQuery); ?>"</h1>
        <?php if ($searchResults && $searchResults->num_rows > 0): ?>
        <div class="row">
            <?php while ($result = $searchResults->fetch_assoc()): ?>
            <div class="col-md-3">
                <div class="card mb-3">
                    <img src="images/product/<?php echo $result['sanpham_anh']; ?>" class="card-img-top"
                        alt="<?php echo htmlspecialchars($result['sanpham_tieude']); ?>">
                    <div class="card-body">
                        <h5 class="card-title">Tên sản phẩm : <?php echo htmlspecialchars($result['sanpham_tieude']); ?>
                        </h5>
                        <p class="card-text"> Giá bán : <?php echo number_format($result['sanpham_gia']); ?> đ</p>
                        <a href="view_product.php?sanpham_id=<?php echo $result['sanpham_id']; ?>"
                            class="btn btn-primary">Xem
                            chi tiết</a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <?php else: ?>
        <p>Không tìm thấy kết quả nào.</p>
        <?php endif; ?>
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