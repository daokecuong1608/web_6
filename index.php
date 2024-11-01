<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Trang chủ</title>
</head>

<body>

    <?php
        include 'header.php';
        include 'carousel.php';
    ?>

    <div class="container mt-5">

        <div class="row">
            <?php
                // Giả sử bạn có một mảng sản phẩm
                $products = [
                    [
                        'image' => './images/product/sp1.jpg',
                        'name' => 'Sản phẩm 1',
                        'price' => '500,000 VND',
                        'cost' => '300,000 VND'
                    ],
                    [
                        'image' => './images/product/sp1.jpg',
                        'name' => 'Sản phẩm 2',
                        'price' => '700,000 VND',
                        'cost' => '400,000 VND'
                    ],
                    [
                        'image' => './images/product/sp1.jpg',
                        'name' => 'Sản phẩm 2',
                        'price' => '700,000 VND',
                        'cost' => '400,000 VND'
                    ],
                    [
                        'image' => './images/product/sp1.jpg',
                        'name' => 'Sản phẩm 2',
                        'price' => '700,000 VND',
                        'cost' => '400,000 VND'
                    ],
                    [
                        'image' => './images/product/sp1.jpg',
                        'name' => 'Sản phẩm 2',
                        'price' => '700,000 VND',
                        'cost' => '400,000 VND'
                    ],
                    [
                        'image' => './images/product/sp1.jpg',
                        'name' => 'Sản phẩm 2',
                        'price' => '700,000 VND',
                        'cost' => '400,000 VND'
                    ],
                    [
                        'image' => './images/product/sp1.jpg',
                        'name' => 'Sản phẩm 2',
                        'price' => '700,000 VND',
                        'cost' => '400,000 VND'
                    ],
                    [
                        'image' => './images/product/sp1.jpg',
                        'name' => 'Sản phẩm 2',
                        'price' => '700,000 VND',
                        'cost' => '400,000 VND'
                    ],
                    // Thêm các sản phẩm khác ở đây
                ];

                foreach ($products as $product) {
                    echo '
                    <div class="col-md-3 mb-3">
                        <div class="card">
                            <img src="' . $product['image'] . '" class="card-img-top" alt="' . $product['name'] . '">
                            <div class="card-body">
                                <h5 class="card-title">' . $product['name'] . '</h5>
                                <p class="card-text text-decoration-line-through text-muted">Giá nhập: ' . $product['cost'] . '</p>
                                <p class="card-text ms-2 ">Giá bán: ' . $product['price'] . '</p>
                                <div class="d-flex justify-content-between">
                                    <a href="#" class="btn btn-primary">Mua ngay</a>
                                    <a href="#" class="btn btn-secondary">Thêm vào giỏ hàng</a>
                                </div>
                               
                                </div>
                        </div>
                    </div>';
                }
            ?>
        </div>
    </div>

    <?php
       include 'footer.php';
    ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>

</body>

</html>