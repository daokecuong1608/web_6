<?php
include_once "../class/brand.php"; // Bao gồm tệp chứa định nghĩa của lớp product
$brand = new brand(); // Đảm bảo tên lớp là Brand với chữ B viết hoa

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $color_ten = $_POST['color_ten'];
    $file_name = $_FILES['color_anh']['name'];
    $file_temp = $_FILES['color_anh']['tmp_name'];
    $file_error = $_FILES['color_anh']['error'];

    if ($file_error === UPLOAD_ERR_OK) {
        if (!empty($file_name)) {
            $div = explode('.', $file_name);
            $file_ext = strtolower(end($div));
            $allowed_extensions = array("jpg", "jpeg", "png", "gif");

            if (in_array($file_ext, $allowed_extensions)) {
                $color_anh = substr(md5(time()), 0, 10) . '.' . $file_ext;
                $upload_dir = realpath(__DIR__ . '/../images/color') . DIRECTORY_SEPARATOR;
                $upload_image = $upload_dir . $color_anh;

                // Kiểm tra và tạo thư mục nếu chưa tồn tại
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }

                if (move_uploaded_file($file_temp, $upload_image)) {
                    echo "Tệp đã được tải lên thành công.";
                } else {
                    echo "Không thể di chuyển tệp đến thư mục chỉ định.";
                    exit();
                }
            } else {
                echo "Định dạng ảnh không hợp lệ. Vui lòng tải lên các tệp có định dạng jpg, jpeg, png, hoặc gif.";
                exit();
            }
        } else {
            $color_anh = $result['color_anh']; // Giữ nguyên ảnh cũ nếu không có ảnh mới
        }

        // Lưu đường dẫn tương đối vào cơ sở dữ liệu
        $color_anh_relative_path = "images/color/" . $color_anh;
        $update_color = $brand->insert_color($color_ten, $color_anh_relative_path);
        if ($update_color) {
            header('Location: colorlist.php');
            exit();
        } else {
            echo "Cập nhật màu thất bại.";
        }
    } else {
        echo "Lỗi tải lên tệp: " . $file_error;
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Thêm màu mới
    </title>
    <link href="css/coloradd.css" rel="stylesheet"> <!-- Liên kết tệp CSS -->

</head>

<body>

    <div class="add-color-content-right">
        <h2>Thêm màu mới</h2>
        <div class="subcartegory-add-content">
            <form action="" method="POST" enctype="multipart/form-data">
                <label for="">Tên màu sắc<span style="color: red;">*</span></label> <br>
                <input class="subcartegory-input" type="text" name="color_ten"> <br>
                <label for="">Ảnh đại diện<span style="color: red;">*</span></label> <br>
                <input required type="file" name="color_anh"> <br>
                <button class="admin-btn" type="submit">Gửi</button>
                <a href="colorlist.php" class="admin-btn">Quay lại</a>

            </form>
        </div>
    </div>

</body>

</html>