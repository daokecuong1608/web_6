<?php
session_start(); // Khởi tạo session
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
include_once "../class/product.php"; 
$product = new product(); 
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $sanpham_id = $_POST['sanpham_id'];
    //lấy tên gốc của tệp
    $file_name = $_FILES['sanpham_anh']['name'];
    //lây tên tạm của tệp trên máy chủ
    $file_temp = $_FILES['sanpham_anh']['tmp_name'];
    $file_error = $_FILES['sanpham_anh']['error'];

    if ($file_error === UPLOAD_ERR_OK) {
        if (!empty($file_name)) {
            //tach duoi file
            $div = explode('.', $file_name);
            //chuyển đổi đuôi file thành chữ thường
            $file_ext = strtolower(end($div));
            //mảng chứa các đuôi file được phép tải lên
            $allowed_extensions = array("jpg", "jpeg", "png", "gif");

            if (in_array($file_ext, $allowed_extensions)) {
              //SD chuỗi hàm băm MD5 để tạo tên file mới để tránh trùng lặp
                $sanpham_anh = substr(md5(time()), 0, 10) . '.' . $file_ext;
                //đường dẫn thư mục lưu file
                $upload_dir = realpath(__DIR__ . '/../images/product') . DIRECTORY_SEPARATOR;
                //đường dẫn file sau khi tải lên
                $upload_image = $upload_dir . $sanpham_anh;

                // Kiểm tra và tạo thư mục nếu chưa tồn tại
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }
                 //lưu file vào thư mục chỉ định
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
            $sanpham_anh = $result['sanpham_anh']; // Giữ nguyên ảnh cũ nếu không có ảnh mới
        }

        // Lưu đường dẫn tương đối vào cơ sở dữ liệu
        $sanpham_anh_relative_path = "images/product/" . $sanpham_anh;
        $update_image = $product->insert_anhsp($sanpham_id, $sanpham_anh_relative_path);
        if ($update_image) {
            header('Location: anhsanphamlists.php');
            exit();
        } else {
            echo "Cập nhật ảnh thất bại.";
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
    <title>Thêm ảnh sản phẩm </title>
    <link href="css/anhsanphamadd.css" rel="stylesheet"> <!-- Liên kết tệp CSS -->
</head>

<body>

    <div class="add-anh-content-right">
        <div class="subcartegory-add-content">
            <h2>Thêm ảnh sản phẩm</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <label for="sanpham_id">Chọn mã sản phẩm<span style="color: red;">*</span></label> <br>
                <select required="required" name="sanpham_id" id="sanpham_id">
                    <option value="">--Chọn--</option>
                    <?php
                        $show_product = $product ->show_product();
                        if($show_product){
                            while($result=$show_product->fetch_assoc())   {
                        ?>
                    <option value="<?php echo $result['sanpham_id'] ?>"><?php echo $result['sanpham_ma'] ?></option>
                    <?php
                        }
                    }
                        ?>
                </select> <br>
                <label for="sanpham_anh">Ảnh Sản phẩm<span style="color: red;">*</span></label> <br>
                <input required type="file" name="sanpham_anh" id="sanpham_anh"> <br>
                <button class="admin-btn" type="submit">Gửi</button>
                <a href="anhsanphamlists.php" class="admin-btn">Quay lại</a>
            </form>
        </div>
    </div>

</body>

</html>