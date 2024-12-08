<?php
@ob_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Kiểm tra trạng thái đăng nhập trước khi khởi tạo phiên
if (isset($_COOKIE['PHPSESSID']) && session_status() == PHP_SESSION_NONE) {
    session_start(); // Khởi tạo phiên nếu chưa có phiên nào được khởi tạo
}

if (isset($_SESSION['login'])) {
    $login = $_SESSION['login'];
    $username = $_SESSION['username'];
    $userid = $_SESSION['user_id']; // Sử dụng $_SESSION['user_id'] để quản lý phiên đăng nhập
    $role = $_SESSION['role']; // lấy quyền người dùng từ session

} else {
    $login = "";
    $username = "";
    $userid = "";
}

if (!defined('__ROOT__')) {
    define('__ROOT__', dirname(__FILE__)); // Định nghĩa hằng số __ROOT__ nếu chưa được định nghĩa
}
require_once(__ROOT__ . '/class/index_class.php'); // Đường dẫn chính xác đến tệp index_class.php
$index = new index();

// if ($login) {
//     echo "User ID: " . $userid;
// } else {
//     echo "User not logged in.";
// }
?>


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
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Trang chủ</a>
                    </li>

                    <?php
                        $show_danhmuc = $index->show_danhmuc();
                        if ($show_danhmuc) {
                            while ($result = $show_danhmuc->fetch_assoc()) {
                    ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#"
                            id="navbarDropdown<?php echo $result['danhmuc_id']; ?>" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo $result['danhmuc_ten']; ?>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown<?php echo $result['danhmuc_id']; ?>">
                            <?php
                            $danhmuc_id = $result['danhmuc_id'];
                            $show_loaisanpham = $index->show_loaisanpham($danhmuc_id);
                            if ($show_loaisanpham) {
                                while ($result_sp = $show_loaisanpham->fetch_assoc()) {
                            ?>
                            <li><a class="dropdown-item"
                                    href="category.php?loaisanpham_id=<?php echo $result_sp['loaisanpham_id']?>"><?php echo $result_sp['loaisanpham_ten']; ?></a>
                            </li>
                            <?php
                            }
                        }
                    ?>
                        </ul>
                    </li>
                    <?php
            }
        }
        ?>
                </ul>

                <form class="d-flex m-2" role="search" style="margin: 10px !important;" method="GET"
                    action="search.php">
                    <input class="form-control me-2" type="search" name="searchQuery" placeholder="Nội dung tìm kiếm"
                        aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">
                        <i class="bi bi-search"></i> <!-- Bootstrap search icon -->
                    </button>
                </form>

                <!-- Thêm nút "Xem giỏ hàng" vào trang JSP -->
                <!-- Nút giỏ hàng -->
                <a href="cart.php" class="btn btn-cart" id="cart-button">
                    <i class="bi bi-cart"></i>
                </a>

                <?php
                    if($username ===""){
                    ?>
                <a class="btn btn-login" href="login.php" style="white-space: nowrap;">
                    <i class="bi bi-person"></i> <!-- Bootstrap person icon -->
                </a>
                <?php
                    } else{
                 ?>
                <span class="navbar-text">
                    <b> <?php echo htmlspecialchars($username); ?>!</b>
                </span>

                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userMenu" role="button" aria-expanded="false">
                            Tài khoản
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="userMenu">
                            <li><a class="dropdown-item" href="buycart.php">Xem đơn hàng đã mua</a></li>
                            <li><a class="dropdown-item" href="./user/account_settings.php">Cài đặt tài khoản</a></li>
                            <?php
                            // Kiểm tra xem người dùng có phải là admin không
                            if (isset($role) && $role === "admin") {
                            ?>
                            <li><a class="dropdown-item" href="./admin/admin_dashboard.php">Quản lý hệ thống</a></li>
                            <?php
                            }
                            ?>
                            <li><a class="dropdown-item" href="./handle/logout.php">Đăng xuất</a></li>
                        </ul>
                    </li>
                </ul>

                <?php
                }
                ?>

            </div>
        </div>
    </nav>
    <!--end header-->

    <script>
    document.getElementById('cart-button').addEventListener('click', function(event) {
        <?php if (!isset($_SESSION['user_id'])) { ?>
        event.preventDefault(); // Ngăn chặn hành động mặc định của liên kết
        window.location.href = 'login.php'; // Chuyển hướng đến trang đăng nhập
        <?php } ?>
    });
    </script>


    <script src="./js/header.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>



</body>

</html>