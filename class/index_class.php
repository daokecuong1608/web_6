<?php
if (!defined('__ROOT__')) {
    define('__ROOT__', dirname(dirname(__FILE__))); // Định nghĩa hằng số __ROOT__ nếu chưa được định nghĩa
}require_once(__ROOT__ . '/lib/session.php' );
require_once(__ROOT__ . '/lib/database.php' );
include_once __ROOT__ . "/helper/format.php";
?>

<?php
class index {
    private $db;
    private $fm;

    public function __construct(){
        $this->db = new Database;
        $this->fm = new Format;
    }

    public function searchProducts($searchQuery) {
        $query = "SELECT * FROM tbl_sanpham WHERE sanpham_tieude LIKE '%$searchQuery%'";
        return $this->db->select($query);
    }

    public function delete_cart($cart_id){
        $query = "DELETE  FROM tbl_cart WHERE cart_id = '$cart_id'";
        $result = $this->db->delete($query);
        if ($result) {
            $query = "SELECT * FROM tbl_cart ORDER BY cart_id";
            $resultA = $this->db->select($query);
            if ($resultA == null) {
                Session::set('SL', null);
            }
        }
        return $result;
    }
    
    public function show_carta($session_id){
        $query = "SELECT * FROM tbl_carta WHERE session_idA = '$session_id' ORDER BY cart_id DESC";
        $result = $this->db->select($query);
        return $result;
    }

    public function show_payment($session_id){
        $query = "SELECT * FROM tbl_payment WHERE session_idA = '$session_id' ORDER BY payment_id DESC LIMIT 1";
        $result = $this->db->select($query);
        return $result;
    }

    public function show_order($session_id) {
        $query = "SELECT * FROM tbl_order WHERE session_idA = '$session_id' ORDER BY order_id DESC LIMIT 1";
        $result = $this->db->selectdc($query);
        return $result;
    }

    public function show_diachi_px($quan_huyen_id) {
        $query = "SELECT DISTINCT tinh_tp,ma_tinh,quan_huyen,ma_qh,phuong_xa,ma_px FROM tbl_diachi WHERE ma_qh = '$quan_huyen_id' ORDER BY ma_px";
        $result = $this->db->selectdc($query);
        return $result;
    }

    public function show_diachi_qh($tinh) {
        $query = "SELECT DISTINCT tinh_tp,ma_tinh,quan_huyen,ma_qh FROM tbl_diachi WHERE ma_tinh = '$tinh' ORDER BY ma_qh";
        $result = $this->db->selectdc($query);
        return $result;
    }

    public function show_diachi() {
        $query = "SELECT DISTINCT tinh_tp,ma_tinh FROM tbl_diachi ORDER BY ma_tinh";
        $result = $this->db->selectdc($query);
        return $result;
    }

    public function show_cartB($session_id){
        $query = "SELECT * FROM tbl_cart WHERE session_idA = '$session_id' ORDER BY cart_id DESC";
        $result = $this->db->selectdc($query);
        return $result;
    }

    public function show_cart($session_id){
        $query = "SELECT * FROM tbl_cart WHERE session_idA = '$session_id' ORDER BY cart_id DESC";
        $result = $this->db->select($query);
        return $result;
    }

    public function show_danhmuc(){
        $query = "SELECT * FROM tbl_danhmuc ORDER BY danhmuc_id";
        $result = $this->db->select($query);
        return $result;
    }

    public function show_loaisanpham($danhmuc_id){
        $query = "SELECT * FROM tbl_loaisanpham  WHERE danhmuc_id = '$danhmuc_id' ORDER BY loaisanpham_id";
        $result = $this->db->select($query);
        return $result;
    }


    public function get_sanpham($sanpham_id){
        $query = "SELECT tbl_sanpham.*, tbl_danhmuc.danhmuc_ten,tbl_loaisanpham.loaisanpham_ten,tbl_color.color_ten,tbl_color.color_anh
        FROM tbl_sanpham INNER JOIN tbl_danhmuc ON tbl_sanpham.danhmuc_id = tbl_danhmuc.danhmuc_id
        INNER JOIN tbl_loaisanpham ON tbl_sanpham.loaisanpham_id = tbl_loaisanpham.loaisanpham_id
        INNER JOIN tbl_color ON tbl_sanpham.color_id = tbl_color.color_id
        WHERE tbl_sanpham.sanpham_id = '$sanpham_id'
        ORDER BY tbl_sanpham.sanpham_id DESC  ";
        $result = $this->db->select($query);
        return $result;
    }

    public function get_anh($sanpham_id){
        $query = "SELECT * FROM tbl_sanpham_anh WHERE sanpham_id = '$sanpham_id' ORDER BY sanpham_anh_id DESC";
        $result = $this->db->select($query);
        return $result;
    }

    public function get_size($sanpham_id){
        $query = "SELECT * FROM tbl_sanpham_size WHERE sanpham_id = '$sanpham_id' ORDER BY sanpham_size_id DESC";
        $result = $this->db->select($query);
        return $result;
    }

    public function get_sanphamlienquan($loaisanpham_id, $sanpham_id) {
        $query = "SELECT tbl_sanpham.*, tbl_danhmuc.danhmuc_ten,tbl_loaisanpham.loaisanpham_ten
        FROM tbl_sanpham INNER JOIN tbl_danhmuc ON tbl_sanpham.danhmuc_id = tbl_danhmuc.danhmuc_id
        INNER JOIN tbl_loaisanpham ON tbl_sanpham.loaisanpham_id = tbl_loaisanpham.loaisanpham_id
        WHERE tbl_sanpham.loaisanpham_id = '$loaisanpham_id' && tbl_sanpham.sanpham_id != '$sanpham_id'
        ORDER BY tbl_sanpham.sanpham_id DESC LIMIT 0,5  ";
        $result = $this->db->select($query);
        return $result;
    }

    public function insert_order(
        $session_idA,
        $loaikhach,
        $customer_name,
        $customer_phone,
        $customer_tinh,
        $customer_huyen,
        $customer_xa,
        $customer_diachi
    ) {
        $query = "SELECT * FROM tbl_order WHERE session_idA = '$session_idA' ORDER BY order_id DESC";
        $result = $this->db->select($query);
        if ($result == null) {
            $query = "INSERT INTO tbl_order (session_idA, loaikhach, customer_name, customer_phone, customer_tinh, customer_huyen, customer_xa, customer_diachi) VALUES 
            ('$session_idA', '$loaikhach', '$customer_name', '$customer_phone', '$customer_tinh', '$customer_huyen', '$customer_xa', '$customer_diachi')";
            $result = $this->db->insert($query);
            if ($result) {
                header('Location: payment.php');
                exit(); // Thêm exit() để dừng thực thi mã sau khi chuyển hướng
            } else {
                // Thêm thông báo gỡ lỗi nếu truy vấn INSERT thất bại
                echo "Failed to insert order: " . $this->db->error;
            }
        } else {
            header('Location: payment.php');
            exit(); // Thêm exit() để dừng thực thi mã sau khi chuyển hướng
        }
        return $result;
    }


    public function insert_cart($sanpham_anh, $session_idA, $sanpham_id, $sanpham_tieude, $sanpham_gia, $color_anh, $quantitys, $sanpham_size){
        $query = "INSERT INTO tbl_cart (sanpham_anh,session_idA,sanpham_id,sanpham_tieude,sanpham_gia,color_anh,quantitys,sanpham_size) VALUES 
        ('$sanpham_anh','$session_idA','$sanpham_id','$sanpham_tieude','$sanpham_gia','$color_anh','$quantitys','$sanpham_size')";
        $result = $this->db->insert($query);
        return $result;
    }


    
    public function insert_payment($session_idA, $deliver_method, $method_payment, $today)
    {
        $query = "SELECT * FROM tbl_payment WHERE session_idA = '$session_idA' ORDER BY payment_id DESC";
        $result = $this->db->select($query);
        if ($result == null) {
            $query = "SELECT * FROM tbl_cart WHERE session_idA = '$session_idA' ORDER BY cart_id DESC";
            $resultA = $this->db->select($query);
            if ($resultA) {
                while ($resultB = $resultA->fetch_assoc()) {
                    $cart_id = $resultB['cart_id'];
                    $sanpham_anh = $resultB['sanpham_anh'];
                    $sanpham_id = $resultB['sanpham_id'];
                    $sanpham_tieude = $resultB['sanpham_tieude'];
                    $sanpham_gia = $resultB['sanpham_gia'];
                    $color_anh = $resultB['color_anh'];
                    $quantitys = $resultB['quantitys'];
                    $sanpham_size = $resultB['sanpham_size'];
                    $query = "INSERT INTO tbl_carta (sanpham_anh, session_idA, sanpham_id, sanpham_tieude, sanpham_gia, color_anh, quantitys, sanpham_size) VALUES 
                    ('$sanpham_anh', '$session_idA', '$sanpham_id', '$sanpham_tieude', '$sanpham_gia', '$color_anh', '$quantitys', '$sanpham_size')";
                    $resultC = $this->db->insert($query);
                    if ($resultC) {
                        $query = "DELETE FROM tbl_cart WHERE cart_id = '$cart_id'";
                        $resultD = $this->db->delete($query);
                        Session::set('SL', null);
                    } else {
                        // Thêm thông báo gỡ lỗi nếu truy vấn INSERT thất bại
                        echo "Failed to insert into tbl_carta: " . $this->db->error;
                    }
                }
            } else {
                // Thêm thông báo gỡ lỗi nếu truy vấn SELECT thất bại
                echo "Failed to select from tbl_cart: " . $this->db->error;
            }
    
            $query = "INSERT INTO tbl_payment (session_idA, giaohang, thanhtoan, order_date) VALUES 
            ('$session_idA', '$deliver_method', '$method_payment', '$today')";
            $result = $this->db->insert($query);
            if ($result) {
                header('Location: success.php');
                exit(); // Dừng thực thi mã sau khi chuyển hướng
            } else {
                // Thêm thông báo gỡ lỗi nếu truy vấn INSERT thất bại
                echo "Failed to insert into tbl_payment: " . $this->db->error;
            }
        } else {
            $query = "SELECT * FROM tbl_cart WHERE session_idA = '$session_idA' ORDER BY cart_id DESC";
            $resultA = $this->db->select($query);
            if ($resultA) {
                while ($resultB = $resultA->fetch_assoc()) {
                    $cart_id = $resultB['cart_id'];
                    $sanpham_anh = $resultB['sanpham_anh'];
                    $sanpham_id = $resultB['sanpham_id'];
                    $sanpham_tieude = $resultB['sanpham_tieude'];
                    $sanpham_gia = $resultB['sanpham_gia'];
                    $color_anh = $resultB['color_anh'];
                    $quantitys = $resultB['quantitys'];
                    $sanpham_size = $resultB['sanpham_size'];
                    $query = "INSERT INTO tbl_carta (sanpham_anh, session_idA, sanpham_id, sanpham_tieude, sanpham_gia, color_anh, quantitys, sanpham_size) VALUES 
                    ('$sanpham_anh', '$session_idA', '$sanpham_id', '$sanpham_tieude', '$sanpham_gia', '$color_anh', '$quantitys', '$sanpham_size')";
                    $resultC = $this->db->insert($query);
                    if ($resultC) {
                        $query = "DELETE FROM tbl_cart WHERE cart_id = '$cart_id'";
                        $resultD = $this->db->delete($query);
                        Session::set('SL', null);
                    } else {
                        // Thêm thông báo gỡ lỗi nếu truy vấn INSERT thất bại
                        echo "Failed to insert into tbl_carta: " . $this->db->error;
                    }
                }
            } else {
                // Thêm thông báo gỡ lỗi nếu truy vấn SELECT thất bại
                echo "Failed to select from tbl_cart: " . $this->db->error;
            }
            header('Location: success.php');
            exit(); // Dừng thực thi mã sau khi chuyển hướng
        }
    }
}
?>