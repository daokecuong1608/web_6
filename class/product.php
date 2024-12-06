<?php
if (!defined('__ROOT__')) {
    define('__ROOT__', dirname(dirname(__FILE__))); // Định nghĩa hằng số __ROOT__
}
include_once __ROOT__ . "/helper/format.php";
include_once __ROOT__ . "/lib/database.php";

?>

<?php
class product{
    private $db;
    private $fm;

    public function __construct(){
        $this->db = new Database;
        $this->fm = new Format;
    }

    // Phương thức insert sản phẩm
    public function insert_anhsp($sanpham_id,$sp_anh) {
        $query = "INSERT INTO tbl_sanpham_anh (sanpham_id,sanpham_anh) VALUES ('$sanpham_id','$sp_anh')";
        $result = $this ->db ->insert($query);
        header('Location:anhsanphamlists.php');
        return $result;
    }
    public function insert_sizesp($sanpham_id,$sanpham_size){
        $query = "INSERT INTO tbl_sanpham_size (sanpham_id,sanpham_size) VALUES ('$sanpham_id','$sanpham_size')";
        $result = $this ->db ->insert($query);
        header('Location:sizesanphamlists.php');
        return $result;
    }


    public function insert_product($data , $file){
    $sanpham_tieude = $data['sanpham_tieude'];
    $sanpham_ma = $data['sanpham_ma'];
    $danhmuc_id = $data['danhmuc_id'];
    $loaisanpham_id = $data['loaisanpham_id'];
    $color_id = $data['color_id'];
    $sanpham_gia = $data['sanpham_gia'];
    $sanpham_chitiet = $data['sanpham_chitiet'];
    $sanpham_baoquan = $data['sanpham_baoquan'];

    // Lấy thông tin về tệp ảnh chính và các tệp ảnh phụ được tải lên
    $file_name = $file['sanpham_anh']['name'];
    $file_size = $file['sanpham_anh']['size'];
    $file_temp = $file['sanpham_anh']['tmp_name'];
    $filenames = $_FILES['sanpham_anhs']['name'];
    $filetmps = $_FILES['sanpham_anhs']['tmp_name'];

    // Tách đuôi file
    $div = explode('.', $file_name);
    $file_ext = strtolower(end($div));
    // Sử dụng chuỗi hàm băm MD5 để tạo tên file mới để tránh trùng lặp
    $sanpham_anh = substr(md5(time()), 0, 10) . '.' . $file_ext;
    // Đường dẫn thư mục lưu file
    $upload_dir = realpath(__DIR__ . '/../images/product') . DIRECTORY_SEPARATOR;
    // Đường dẫn file sau khi tải lên
    $upload_image = $upload_dir . $sanpham_anh;

    // Kiểm tra và tạo thư mục nếu chưa tồn tại
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    // Di chuyển tệp ảnh chính
    if (!empty($file_name)) {
        if (move_uploaded_file($file_temp, $upload_image)) {
            echo "Tệp ảnh chính đã được tải lên thành công.";
        } else {
            echo "Không thể di chuyển tệp ảnh chính đến thư mục chỉ định.";
            return false;
        }
    }
      $query = "INSERT INTO tbl_sanpham (sanpham_tieude,sanpham_ma,danhmuc_id,loaisanpham_id,color_id,sanpham_gia,sanpham_chitiet,sanpham_baoquan,sanpham_anh) 
            VALUES 
          ('$sanpham_tieude','$sanpham_ma','$danhmuc_id','$loaisanpham_id','$color_id','$sanpham_gia','$sanpham_chitiet','$sanpham_baoquan','$sanpham_anh')";
          $result = $this ->db ->insert($query);
    //Thêm các tệp ảnh phụ và kích thước sản phẩm vào cơ sở dữ liệu
    if($result){
        // lấy ID của sản phẩm vừa được thêm vào cơ sở dữ liệu.
        $query = "SELECT * FROM tbl_sanpham ORDER BY sanpham_id DESC LIMIT 1";
    $result = $this -> db ->select($query) ->fetch_assoc();
    $sanpham_id = $result['sanpham_id'];
    $filename = $_FILES['sanpham_anhs']['name'] ;
    $filetmp =  $_FILES['sanpham_anhs']['tmp_name'] ;
    foreach($filename as $key => $element){
    move_uploaded_file($filetmp[$key],$upload_dir.$element);
    $query = "INSERT INTO tbl_sanpham_anh(sanpham_id,sanpham_anh) VALUES ('$sanpham_id','$element')";
    $this -> db ->insert($query);
    }
    
    $sanpham_size = $data['sanpham_size'];
    foreach($sanpham_size as $key => $element){
    $query = "INSERT INTO tbl_sanpham_size(sanpham_id,sanpham_size) VALUES ('$sanpham_id','$element')";
    $this -> db ->insert($query);
    }
 }
    header('Location:productlist.php');
    return $result;
    }

    public function show_order_detail($order_ma){
        $query = "SELECT * FROM tbl_carta WHERE user_id = '$order_ma' ORDER BY cart_id DESC";
        $result = $this -> db ->select($query);
        return $result;
    }

public function show_orderAll(){
    $query = "SELECT tbl_order.* , tbl_payment.* , tbl_diachi.*
              FROM tbl_order 
              INNER JOIN tbl_payment ON tbl_order.user_id = tbl_payment.user_id
              INNER JOIN tbl_diachi ON tbl_order.customer_xa = tbl_diachi.ma_px  
              ORDER BY tbl_payment.payment_id DESC";
                $result = $this -> db ->select($query);
                return $result;
}

    // Phương thức  lấy  sản phẩm
    public function show_product(){
      $query = "SELECT tbl_sanpham.* ,tbl_danhmuc.danhmuc_ten,tbl_loaisanpham.loaisanpham_ten,tbl_color.color_ten
        FROM tbl_sanpham INNER JOIN tbl_danhmuc ON tbl_sanpham.danhmuc_id = tbl_danhmuc.danhmuc_id
        INNER JOIN tbl_loaisanpham ON tbl_sanpham.loaisanpham_id = tbl_loaisanpham.loaisanpham_id
        INNER JOIN tbl_color ON tbl_sanpham.color_id = tbl_color.color_id
         ORDER BY tbl_sanpham.sanpham_id DESC  ";
        $result = $this -> db ->select($query);
        return $result;
    }

// Phương thức lấy sản phẩm theo ID
    public function get_product_by_id($sanpham_id){
        // Truy vấn SQL để lấy thông tin của sản phẩm theo sanpham_id
        $query = "SELECT tbl_sanpham.*, tbl_danhmuc.danhmuc_ten, tbl_loaisanpham.loaisanpham_ten, tbl_color.color_ten
                FROM tbl_sanpham
                INNER JOIN tbl_danhmuc ON tbl_sanpham.danhmuc_id = tbl_danhmuc.danhmuc_id
                INNER JOIN tbl_loaisanpham ON tbl_sanpham.loaisanpham_id = tbl_loaisanpham.loaisanpham_id
                INNER JOIN tbl_color ON tbl_sanpham.color_id = tbl_color.color_id
                WHERE tbl_sanpham.sanpham_id = '$sanpham_id'"; // Điều kiện lọc sản phẩm theo ID
                
        $result = $this->db->select($query); // Thực thi truy vấn và lấy kết quả
        return $result;
    }



    public function show_color(){
        $query = "SELECT * FROM tbl_color ORDER BY color_id DESC";
        $result = $this -> db ->select($query);
        return $result;
    }

    public function show_danhmuc(){
        $query = "SELECT * FROM tbl_danhmuc ORDER BY danhmuc_id DESC";
        $result = $this -> db ->select($query);
        return $result;
    }

    public function show_loaisanpham(){
        $query = "SELECT * FROM tbl_loaisanpham ORDER BY loaisanpham_id DESC";
        $result = $this -> db ->select($query);
        return $result;
    }

    public function show_loaisanpham_by_danhmuc($danhmuc_id) {
        $query = "SELECT * FROM tbl_loaisanpham WHERE danhmuc_id = '$danhmuc_id'";
        $result = $this->db->select($query);
        return $result;
    }

    public function get_product_count() {
        $query = "SELECT COUNT(*) as product_count FROM tbl_sanpham";
        $result = $this->db->select($query);
        $row = $result->fetch_assoc();
        return $row['product_count'];
    }

    public function get_sanpham($sanpham_id){
        $query = "SELECT*FROM tbl_sanpham  WHERE tbl_sanpham.sanpham_id = '$sanpham_id'";
        $result = $this -> db ->select($query);
        return $result;
    }

    public function get_size($sanpham_id) {
        $query = "SELECT tbl_sanpham_size.*, tbl_sanpham.sanpham_ma
        FROM tbl_sanpham_size INNER JOIN tbl_sanpham ON tbl_sanpham_size.sanpham_id = tbl_sanpham.sanpham_id
        WHERE tbl_sanpham_size.sanpham_id = $sanpham_id
        ORDER BY tbl_sanpham_size.sanpham_size_id DESC  ";
        $result = $this -> db ->select($query);
        return $result;
    }

public function get_anh($sanpham_id){
    $query = "SELECT tbl_sanpham_anh.* , tbl_sanpham.sanpham_ma
    FROM tbl_sanpham_anh INNER JOIN tbl_sanpham ON tbl_sanpham_anh.sanpham_id = tbl_sanpham.sanpham_id
    WHERE tbl_sanpham_anh.sanpham_id = $sanpham_id
    ORDER BY tbl_sanpham_anh.sanpham_anh_id DESC  ";
    $result = $this -> db ->select($query);
    return $result;
}

public function get_all_size(){
    $query = "SELECT  tbl_sanpham_size.*,tbl_sanpham.sanpham_ma
     FROM tbl_sanpham_size 
     INNER JOIN tbl_sanpham ON tbl_sanpham_size.sanpham_id = tbl_sanpham.sanpham_id
     ORDER BY tbl_sanpham.sanpham_ma DESC";
    $result = $this -> db ->select($query);
    return $result;
}


public function get_all_anh(){
    $query = "SELECT tbl_sanpham_anh.* , tbl_sanpham.sanpham_ma
    FROM tbl_sanpham_anh INNER JOIN tbl_sanpham ON tbl_sanpham_anh.sanpham_id = tbl_sanpham.sanpham_id
    ORDER BY tbl_sanpham_anh.sanpham_anh_id DESC";
    $result = $this -> db ->select($query);
    return $result;
}

public function get_order_status($user_id) {
    $query = "SELECT status FROM tbl_payment WHERE user_id = ?";
    $stmt = $this->db->link->prepare($query);
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $stmt->bind_result($status);
    $stmt->fetch();
    $stmt->close();
    return $status;
}



// Phương thức xóa 
public function delete_size_sanpham($sanpham_size_id){
    $query = "DELETE FROM tbl_sanpham_size WHERE sanpham_size_id = '$sanpham_size_id'";
    $result = $this -> db ->delete($query);
    if($result) {
        $alert = "<span class = 'alert-style'> Delete Thành công</span> ";
         return $alert;
        } else {
            $alert = "<span class = 'alert-style'> Delete Thất bại</span>"; 
            return $alert;
        }
}



public function delete_anh_sanpham($sanpham_anh_id){
$query = "DELETE FROM tbl_sanpham_anh WHERE sanpham_anh_id = '$sanpham_anh_id'";
$result = $this -> db ->delete($query);
if($result) {
    $alert = "<span class = 'alert-style'> Delete Thành công</span> ";
     return $alert;
    } else {
        $alert = "<span class = 'alert-style'> Delete Thất bại</span>"; 
        return $alert;
    }
}

public function delete_product($sanpham_id){
    $query = "DELETE FROM tbl_sanpham WHERE sanpham_id = '$sanpham_id'";
    $result = $this -> db ->delete($query);
    if($result) {
        $alert = "<span class = 'alert-style'> Delete Thành công</span> ";
         return $alert;
        } else {
            $alert = "<span class = 'alert-style'> Delete Thất bại</span>"; 
            return $alert;
        }
}   

public function delete_product_anh($sanpham_id){
    $query = "DELETE FROM tbl_sanpham_anh WHERE sanpham_id = '$sanpham_id'";
    $result = $this -> db ->delete($query);
    if($result) {
        $alert = "<span class = 'alert-style'> Delete Thành công</span> ";
         return $alert;
        } else {
            $alert = "<span class = 'alert-style'> Delete Thất bại</span>"; 
            return $alert;
        }
}


    public function delete_payment($user_id){
        $query = "DELETE  FROM tbl_payment WHERE user_id = '$user_id'";
        $result = $this -> db ->delete($query);
        return $result;
    }
    public function delete_order($user_id){
        $query = "DELETE  FROM tbl_order WHERE user_id = '$user_id'";
        $result = $this -> db ->delete($query);
        return $result;
    }
    public function delete_cart($user_id){
        $query = "DELETE  FROM tbl_carta WHERE user_id = '$user_id'";
        $result = $this -> db ->delete($query);
        return $result;
    }


public function update_product($data, $file, $sanpham_id) {
    $sanpham_tieude = $data['sanpham_tieude'];
    $sanpham_ma = $data['sanpham_ma'];
    $danhmuc_id = $data['danhmuc_id'];
    $loaisanpham_id = $data['loaisanpham_id'];
    $color_id = $data['color_id'];
    $sanpham_gia = $data['sanpham_gia'];
    $sanpham_chitiet = $data['sanpham_chitiet'];
    $sanpham_baoquan = $data['sanpham_baoquan'];

    // Lấy thông tin về tệp ảnh chính và các tệp ảnh phụ được tải lên
    $file_name = $file['sanpham_anh']['name'];
    $file_size = $file['sanpham_anh']['size'];
    $file_temp = $file['sanpham_anh']['tmp_name'];
    $filenames = $_FILES['sanpham_anhs']['name'];
    $filetmps = $_FILES['sanpham_anhs']['tmp_name'];

    // Tách đuôi file
    $div = explode('.', $file_name);
    $file_ext = strtolower(end($div));
    // Sử dụng chuỗi hàm băm MD5 để tạo tên file mới để tránh trùng lặp
    $sanpham_anh = substr(md5(time()), 0, 10) . '.' . $file_ext;
    // Đường dẫn thư mục lưu file
    $upload_dir = realpath(__DIR__ . '/../images/product') . DIRECTORY_SEPARATOR;
    // Đường dẫn file sau khi tải lên
    $upload_image = $upload_dir . $sanpham_anh;

    // Kiểm tra và tạo thư mục nếu chưa tồn tại
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    // Di chuyển tệp ảnh chính
    if (!empty($file_name)) {
        if (move_uploaded_file($file_temp, $upload_image)) {
            echo "Tệp ảnh chính đã được tải lên thành công.";
        } else {
            echo "Không thể di chuyển tệp ảnh chính đến thư mục chỉ định.";
            return false;
        }
    }

    // Cập nhật thông tin sản phẩm
    $query = "UPDATE tbl_sanpham SET 
        sanpham_tieude = '$sanpham_tieude',
        sanpham_ma = '$sanpham_ma',
        danhmuc_id = '$danhmuc_id', 
        loaisanpham_id = '$loaisanpham_id', 
        color_id = '$color_id',
        sanpham_gia = '$sanpham_gia',
        sanpham_chitiet = '$sanpham_chitiet',
        sanpham_baoquan = '$sanpham_baoquan'";
    if (!empty($file_name)) {
        $query .= ", sanpham_anh = '$sanpham_anh'";
    }
    $query .= " WHERE sanpham_id = '$sanpham_id'";
    $result = $this->db->update($query);

    if ($result) {
        // Xóa các tệp ảnh phụ cũ liên quan đến sản phẩm
        $query = "DELETE FROM tbl_sanpham_anh WHERE sanpham_id = '$sanpham_id'";
        $this->db->delete($query);
        // Di chuyển các tệp ảnh phụ mới và thêm vào cơ sở dữ liệu
        foreach ($filenames as $key => $element) {
            if (!empty($element)) {
                $element_path = $upload_dir . $element;
                if (move_uploaded_file($filetmps[$key], $element_path)) {
                    $query = "INSERT INTO tbl_sanpham_anh (sanpham_id, sanpham_anh) VALUES ('$sanpham_id', '$element')";
                    $this->db->insert($query);
                } else {
                    echo "Không thể di chuyển tệp ảnh phụ $element đến thư mục chỉ định.";
                }
            }
        }
        header('Location: productlist.php');
        return true;
    } else {
        echo "Cập nhật sản phẩm thất bại.";
        return false;
    }
}

public function update_order_status($user_id, $new_status) {
    $query = "UPDATE tbl_payment SET status = ? WHERE user_id = ?";
    $stmt = $this->db->link->prepare($query);
    $stmt->bind_param("is", $new_status, $user_id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}

public function get_order_count() {
    $query = "SELECT COUNT(*) as order_count FROM tbl_payment WHERE status = 1 OR status = 0";
    $result = $this->db->select($query);
    $row = $result->fetch_assoc();
    return $row['order_count'];
}

public function get_total_sales() {
    $query = "SELECT SUM(quantitys) as total_sales FROM tbl_carta";
    $result = $this->db->select($query);
    $row = $result->fetch_assoc();
    return $row['total_sales'];
}
public function get_total_sales_from_carta() {
    $query = "SELECT SUM(sanpham_gia * quantitys) as total_sales FROM tbl_carta";
    $result = $this->db->select($query);
    $row = $result->fetch_assoc();
    return $row['total_sales'];
}

}
?>