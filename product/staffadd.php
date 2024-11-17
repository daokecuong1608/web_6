<?php
include_once "../class/staff.php"; // Bao gồm tệp chứa định nghĩa của lớp product
$staff = new staff();

if(isset($_POST['submit'])){
    $staff_name = $_POST['staff_name'];
    $staff_age = $_POST['staff_age'];
    $staff_email = $_POST['staff_email'];
    $staff_address = $_POST['staff_address'];
    $insert_staff = $staff->insert_staff($staff_name, $staff_age, $staff_email, $staff_address);
    if($insert_staff){
        echo "<script>alert('Thêm nhân viên thành công')</script>";
    }else{
        echo "<script>alert('Thêm nhân viên thất bại')</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="css/staffadd.css" rel="stylesheet"> <!-- Liên kết tệp CSS -->

</head>

<body>

    <div class="add-container">
        <h1>Thêm nhân viên</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="staff_name">Tên nhân viên</label>
                <input type="text" name="staff_name" id="staff_name" class="form-control">
            </div>
            <div class="form-group">
                <label for="staff_age">Tuổi</label>
                <input type="text" name="staff_age" id="staff_age" class="form-control">
            </div>
            <div class="form-group">
                <label for="staff_email">Email</label>
                <input type="text" name="staff_email" id="staff_email" class="form-control">
            </div>
            <div class="form-group">
                <label for="staff_address">Địa chỉ</label>
                <input type="text" name="staff_address" id="staff_address" class="form-control">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>
            <div>
                <input type="submit" name="submit" value="Thêm nhân viên" class="btn btn-primary">
            </div>
        </form>
    </div>
</body>

</html>