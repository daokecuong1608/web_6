<?php
session_start(); 
// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: /web_quan_ao/login.php");  
      exit();
}
// Kiểm tra xem người dùng có phải là admin không
if ($_SESSION['role'] !== 'admin') {
    header("Location: /web_quan_ao/index.php");  
    exit();
}
include_once "../class/staff.php"; // Bao gồm tệp chứa định nghĩa của lớp product

$staff = new staff();

if (isset($_GET['staff_id']) && $_GET['staff_id'] != NULL) {
    $staff_id = $_GET['staff_id'];
    echo "<script>console.log('Staff ID: " . $staff_id . "');</script>";
    $show_staff = $staff->get_staff($staff_id);
    if ($show_staff) {
        $result = $show_staff->fetch_assoc();
    } else {
        echo "<script>alert('Không tìm thấy nhân viên.');</script>";
        exit();
    }
} else {
    echo "<script>alert('Không có ID nhân viên.');</script>";
    exit();
}


if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $staff_name = $_POST['staff_name'];
    $staff_age = $_POST['staff_age'];
    $staff_email = $_POST['staff_email'];
    $staff_address = $_POST['staff_address'];
    $password = $_POST['password'];
    $update_staff = $staff -> update_staff($staff_name, $staff_age, $staff_email, $staff_address , $password , $staff_id );
    if($update_staff){
        echo "<script>alert('Cập nhật nhân viên thành công')</script>";
        header('Location: stafflist.php');
    }else{
        echo "<script>alert('Cập nhật nhân viên thất bại')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật nhân viên</title>
    <link href="css/staffedit.css" rel="stylesheet"> <!-- Liên kết tệp CSS -->
</head>

<body>

    <div class="add-container">
        <h1>Cập nhật nhân viên</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="staff_name">Tên nhân viên</label>
                <input value="<?php echo $result['staff_name'] ?>" type="text" name="staff_name" id="staff_name"
                    class="form-control">
            </div>
            <div class="form-group">
                <label for="staff_age">Tuổi</label>
                <input value="<?php echo $result['staff_age'] ?>" type="text" name="staff_age" id="staff_age"
                    class="form-control">
            </div>
            <div class="form-group">
                <label for="staff_email">Email</label>
                <input value="<?php echo $result['staff_email'] ?>" type="text" name="staff_email" id="staff_email"
                    class="form-control">
            </div>
            <div class="form-group">
                <label for="staff_address">Địa chỉ</label>
                <input value="<?php echo $result['staff_address'] ?>" type="text" name="staff_address"
                    id="staff_address" class="form-control">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input value="<?php echo $result['password'] ?>" type="password" name="password" id="password"
                    class="form-control">
            </div>
            <div class="form-group">
                <input type="submit" name="submit" value="Cập nhật nhân viên" class="btn btn-primary">
                <a href="stafflist.php" class="btn btn-secondary">Quay lại</a>
            </div>
        </form>
    </div>
</body>

</html>