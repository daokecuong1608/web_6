<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>

    <link href="css/header.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">


</head>

<body>

    <!-- start header-->
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="https://bizweb.dktcdn.net/100/462/587/themes/880841/assets/logo.png?1724310613023"
                    alt="Bootstrap" height="24">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="/#">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Combo giảm giá</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">Thể loại</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/#">Áo</a></li>
                            <li><a class="dropdown-item" href="/#">Váy</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="/#">Danh sách thể loại</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">Thương hiệu</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/#2">Chic-Land</a></li>
                            <li><a class="dropdown-item" href="/#">Elise</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="/#">Danh sách thương hiệu</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link disabled">Hết hàng</a></li>
                </ul>

                <form class="d-flex m-2" role="search" style="margin: 10px !important;">
                    <input class="form-control me-2" type="search" name="searchQuery" placeholder="Nội dung tìm kiếm"
                        aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">
                        <i class="bi bi-search"></i> <!-- Bootstrap search icon -->
                    </button>
                </form>

                <!-- Thêm nút "Xem giỏ hàng" vào trang JSP -->
                <button class="btn btn-cart">
                    <a><i class="bi bi-cart"></i></a>
                </button>

                <a class="btn btn-login" href="login.php" style="white-space: nowrap;">
                    <i class="bi bi-person"></i> <!-- Bootstrap person icon -->
                </a>
            </div>
        </div>
    </nav>
    <!--end header-->


    <script src="./js/header.js"></script>

</body>

</html>