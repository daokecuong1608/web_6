<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang quản lý dành cho ADMIN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="css/admin_dashboard.css" rel="stylesheet"> <!-- Liên kết tệp CSS -->

</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block sidebar">
                <div class="sidebar-sticky">
                    <h4>Quản lý cửa hàng</h4>
                    <a href="../index.php">Trang chủ</a> <!-- Cập nhật liên kết -->
                    <a href="../product/productlist.php">Quản lý sản phẩm</a>
                    <a href="../product/orderlistall.php">Quản lý đơn hàng</a>
                    <a href="../person/listuser.php">Quản lý khách hàng</a>
                    <a href="../product/stafflist.php">Quản lý nhân viên</a>
                    <a href="../product/sizesanphamlists.php">Quản lý Size</a>
                    <a href="../product/anhsanphamlists.php">Quản lý Ảnh</a>
                    <a href="../product/colorlist.php">Quản lý Màu</a>
                    <a href="../product/categorylist.php">Quản lý danh mục</a>
                    <a href="../product/brandlist.php">Quản lý loại sản phẩm </a>
                    <a href="../product/report.php">Báo cáo</a>
                    <a href="../handle/logout.php">Đăng xuất</a>
                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 content">
                <h1 class="h2">Dashboard</h1>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Sản phẩm</h5>
                                <p class="card-text">Quản lý các sản phẩm trong cửa hàng.</p>
                                <a href="../product/productlist.php" class="btn btn-primary">Quản lý sản phẩm</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Đơn hàng</h5>
                                <p class="card-text">Quản lý các đơn hàng của khách hàng.</p>
                                <a href="../product/orderlistall.php" class="btn btn-primary">Quản lý đơn hàng</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Khách hàng</h5>
                                <p class="card-text">Quản lý thông tin khách hàng.</p>
                                <a href="../person/listuser.php" class="btn btn-primary">Quản lý khách hàng</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Size</h5>
                                <p class="card-text">Quản lý các size sản phẩm .</p>
                                <a href="../product/sizesanphamlists.php" class="btn btn-primary">Quản lý size</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Ảnh</h5>
                                <p class="card-text">Quản lý các ảnh của sản phẩm .</p>
                                <a href="../product/anhsanphamlists.php" class="btn btn-primary">Quản lý ảnh</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Màu</h5>
                                <p class="card-text">Quản lý các màu của sản phẩm .</p>
                                <a href="../product/colorlist.php" class="btn btn-primary">Quản lý màu </a>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Danh mục</h5>
                                <p class="card-text">Quản lý danh mục sản phẩm .</p>
                                <a href="../product/categorylist.php" class="btn btn-primary">Quản lý danh mục </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Loại sản phẩm</h5>
                                <p class="card-text">Quản lý Loại sản phẩm .</p>
                                <a href="../product/brandlist.php" class="btn btn-primary">Quản lý loại sản phẩm </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Nhân viên</h5>
                                <p class="card-text">Quản lý Loại nhân viên .</p>
                                <a href="../product/stafflist.php" class="btn btn-primary">Quản lý nhân viên </a>
                            </div>
                        </div>
                    </div>

                </div>

        </div>
        </main>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>

</body>

</html>