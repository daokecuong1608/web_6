<?php

// // Define root path
define('__ROOT__', dirname(__FILE__));
require_once(__ROOT__ . '/class/user.php');
// // Kiểm tra đường dẫn
// echo 'User class path: ' . realpath(__ROOT__ . '/class/user.php') . '<br>';

Session::init();
$user = new user();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $check_login = $user->check_login($email, $password);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

    <section class="vh-100" style="background-color: #9A616D;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-none d-md-block">
                                <img src="./images/login/logo.webp" alt="login form" class="img-fluid"
                                    style="border-radius: 1rem 0 0 1rem;" />
                            </div>
                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">

                                    <form action="login.php" method="POST">

                                        <div class="d-flex align-items-center justify-content-center mb-3 pb-1">
                                            <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                                            <span class="h1 fw-bold mb-0">Logo</span>
                                        </div>

                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <label class="form-label" for="form2Example17">Email address :</label>
                                            <input type="email" name="email" id="form2Example17"
                                                class="form-control form-control-lg" />
                                        </div>

                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <label class="form-label" for="form2Example27">Password :</label>
                                            <input type="password" name="password" id="form2Example27"
                                                class="form-control form-control-lg" />
                                        </div>

                                        <div class="pt-1 mb-4 d-flex justify-content-center">
                                            <button data-mdb-button-init data-mdb-ripple-init
                                                class="btn btn-dark btn-lg btn-block w-60" type="submit" name="login"
                                                style="width: 60%;">Login</button>
                                        </div>

                                        <?php
                                    if (isset($check_login)) {
                                        echo '<div class="alert alert-danger text-center" role="alert">' . $check_login . '</div>';
                                    }
                                    ?>


                                        <a class="small text-muted" href="#!">Forgot password?</a>
                                        <div class="d-flex justify-content-between mt-4">
                                            <a href="register.php" class="btn btn-primary" herf="register.php">Register
                                                here</a>
                                            <a href="index.php" class="btn btn-secondary">Quay lại trang chủ</a>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>

</body>

</html>