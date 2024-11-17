<?php
include 'header.php';
include_once(__ROOT__ . "/class/staff.php");

$staff = new staff();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $staff_email = $_POST['staff_email'];
    $password = $_POST['password'];

    $login_check = $staff->login_staff($staff_email, $password);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập nhân viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="css/login.css" rel="stylesheet"> <!-- Liên kết tệp CSS -->
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2>Đăng nhập nhân viên</h2>
                <?php
                if (isset($login_check)) {
                    echo "<div class='alert alert-danger'>$login_check</div>";
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="staff_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="staff_email" name="staff_email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary">Đăng nhập</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>