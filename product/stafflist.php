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

include_once "../helper/format.php";
include_once "../class/staff.php"; // Bao gồm tệp chứa định nghĩa của lớp product

$staff = new staff(); // Đảm bảo tên lớp là Product với chữ P viết hoa
$show_staff = $staff->show_staff();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách nhân viên</title>
    <link href="css/stafflist.css" rel="stylesheet"> <!-- Liên kết tệp CSS -->
</head>

<body>

    <div class="container">
        <div class="form-wrapper">
            <h2 class="form-title">Danh sách nhân viên</h2>
            <div class="container-top">
                <a href="../admin/admin_dashboard.php" class="btn">Quay lại trang quản lý</a>
                <a href="staffadd.php" class="btn btn-primary">Thêm nhân viên mới</a>
            </div>
            <div class="table-wrapper">
                <table class="staff-table">
                    <tr>
                        <th>Stt</th>
                        <th>Tên</th>
                        <th>Tuổi</th>
                        <th>Địa chỉ</th>
                        <th>Email</th>
                        <th>Tùy chỉnh</th>
                    </tr>

                    <?php
                    if($show_staff){
                        $i = 0;
                        while($result = $show_staff->fetch_assoc()){
                            $i++;
                            // echo "<script>
                            // console.log('Staff ID: " . $result['staff_id'] . "');
                            // </script>";
                    ?>

                    <tr>

                        <td><?php echo $i; ?></td>
                        <td><?php echo $result['staff_name']; ?></td>
                        <td><?php echo $result['staff_age']; ?></td>
                        <td><?php echo $result['staff_address']; ?></td>
                        <td><?php echo $result['staff_email']; ?></td>
                        <td>
                            <a href="staffedit.php?staff_id=<?php echo $result['staff_id']; ?>"
                                class="btn btn-info">Sửa</a>
                            <a href="staffdelete.php?staff_id=<?php echo $result['staff_id']; ?>" class="btn btn-danger"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa nhân viên này không?');">Xóa</a>
                        </td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>

</body>

</html>