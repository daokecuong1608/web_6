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
    
    public function show_carta($user_id){
        $query = "SELECT * FROM tbl_carta WHERE user_id = '$user_id' ORDER BY cart_id DESC";
        $result = $this->db->select($query);
        return $result;
    }

    public function show_payment($user_id){
        $query = "SELECT * FROM tbl_payment WHERE user_id = '$user_id' ORDER BY payment_id DESC LIMIT 1";
        $result = $this->db->select($query);
        return $result;
    }

    public function show_order($user_id) {
        $query = "SELECT * FROM tbl_order WHERE user_id = '$user_id' ORDER BY order_id DESC LIMIT 1";
        $result = $this->db->selectdc($query);
        return $result;
    }


    public function show_order_with_address($user_id) {
        $query = "
            SELECT 
                o.*,
                d.tinh_tp, 
                d.quan_huyen, 
                d.phuong_xa 
            FROM 
                tbl_order AS o
            LEFT JOIN 
                tbl_diachi AS d 
            ON 
                o.customer_tinh = d.ma_tinh 
                AND o.customer_huyen = d.ma_qh 
                AND o.customer_xa = d.ma_px
            WHERE 
                o.user_id = '$user_id'
            ORDER BY 
                o.order_id DESC 
            LIMIT 1
        ";
        $result = $this->db->selectdc($query);
        return $result;
    }
    

    public function show_order_All() {
        $query = "SELECT * FROM tbl_order ORDER BY order_id DESC";
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



   public function show_cartB($user_id) {
    $query = "SELECT * FROM tbl_cart WHERE user_id = '$user_id' AND status = 'CHỌN' ORDER BY cart_id DESC";
    $result = $this->db->selectdc($query);
    return $result;
    }


    public function show_cart($user_id){
        $query = "SELECT * FROM tbl_cart WHERE user_id = '$user_id' ORDER BY cart_id DESC";
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


    public function get_loaisanpham($loaisanpham_id)
    {
        $query = "SELECT tbl_sanpham.*, tbl_danhmuc.danhmuc_ten,tbl_loaisanpham.loaisanpham_ten
        FROM tbl_sanpham INNER JOIN tbl_danhmuc ON tbl_sanpham.danhmuc_id = tbl_danhmuc.danhmuc_id
        INNER JOIN tbl_loaisanpham ON tbl_sanpham.loaisanpham_id = tbl_loaisanpham.loaisanpham_id
        WHERE tbl_sanpham.loaisanpham_id = '$loaisanpham_id'
        ORDER BY tbl_sanpham.sanpham_id DESC  ";
        $result = $this->db->select($query);
        return $result;
    }


    public function insert_order(
        $user_id,
        $loaikhach,
        $customer_name,
        $customer_phone,
        $customer_tinh,
        $customer_huyen,
        $customer_xa,
        $customer_diachi
    ) {
        $query = "SELECT * FROM tbl_order WHERE user_id = '$user_id' ORDER BY order_id DESC";
        $result = $this->db->select($query);
        if ($result == null) {
            $query = "INSERT INTO tbl_order (user_id, loaikhach, customer_name, customer_phone, customer_tinh, customer_huyen, customer_xa, customer_diachi) VALUES 
            ('$user_id', '$loaikhach', '$customer_name', '$customer_phone', '$customer_tinh', '$customer_huyen', '$customer_xa', '$customer_diachi')";
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


    public function insert_cart($sanpham_anh, $user_id, $sanpham_id, $sanpham_tieude, $sanpham_gia, $color_anh, $quantitys, $sanpham_size){
        $query = "INSERT INTO tbl_cart (sanpham_anh,user_id,sanpham_id,sanpham_tieude,sanpham_gia,color_anh,quantitys,sanpham_size) VALUES 
        ('$sanpham_anh','$user_id','$sanpham_id','$sanpham_tieude','$sanpham_gia','$color_anh','$quantitys','$sanpham_size')";
        $result = $this->db->insert($query);
        return $result;
    }


    public function insert_payment($user_id, $deliver_method, $method_payment, $today)
    {
        // Kiểm tra nếu đã có đơn hàng trước đó
        $query = "SELECT * FROM tbl_payment WHERE user_id = '$user_id' ORDER BY payment_id DESC";
        $result = $this->db->select($query);
        
        // Nếu chưa có đơn hàng trước đó
        if ($result == null) {
            // Lấy các sản phẩm có trạng thái là 'CHON' trong giỏ hàng
            $query = "SELECT * FROM tbl_cart WHERE user_id = '$user_id' AND status = 'CHON' ORDER BY cart_id DESC";
            $resultA = $this->db->select($query);
            
            if ($resultA) {
                // Lặp qua các sản phẩm đã chọn
                while ($resultB = $resultA->fetch_assoc()) {
                    $cart_id = $resultB['cart_id'];
                    $sanpham_anh = $resultB['sanpham_anh'];
                    $sanpham_id = $resultB['sanpham_id'];
                    $sanpham_tieude = $resultB['sanpham_tieude'];
                    $sanpham_gia = $resultB['sanpham_gia'];
                    $color_anh = $resultB['color_anh'];
                    $quantitys = $resultB['quantitys'];
                    $sanpham_size = $resultB['sanpham_size'];
    
                    // Chèn thông tin sản phẩm vào bảng tbl_carta
                    $query = "INSERT INTO tbl_carta (sanpham_anh, user_id, sanpham_id, sanpham_tieude, sanpham_gia, color_anh, quantitys, sanpham_size, status) 
                            VALUES ('$sanpham_anh', '$user_id', '$sanpham_id', '$sanpham_tieude', '$sanpham_gia', '$color_anh', '$quantitys', '$sanpham_size', 'CHUA_NHAN')";
                    $resultC = $this->db->insert($query);
    
                    // Nếu insert thành công, xóa sản phẩm khỏi giỏ hàng
                    if ($resultC) {
                        // Xóa các sản phẩm đã chọn từ giỏ hàng
                        $query = "DELETE FROM tbl_cart WHERE cart_id = '$cart_id' AND status = 'CHON'";
                        $resultD = $this->db->delete($query);
    
                        // Xóa số lượng sản phẩm trong session
                        Session::set('SL', null);
                    } else {
                        // Thêm thông báo lỗi nếu truy vấn insert thất bại
                        echo "Failed to insert into tbl_carta: " . $this->db->error;
                    }
                }
            } else {
                // Thêm thông báo lỗi nếu truy vấn select thất bại
                echo "Failed to select from tbl_cart: " . $this->db->error;
            }
    
            // Thêm thông tin thanh toán vào bảng tbl_payment
            $query = "INSERT INTO tbl_payment (user_id, giaohang, thanhtoan, order_date) VALUES ('$user_id', '$deliver_method', '$method_payment', '$today')";
            $result = $this->db->insert($query);
    
            // Nếu insert thành công, chuyển hướng đến trang success
            if ($result) {
                header('Location: success.php');
                exit(); // Dừng thực thi mã sau khi chuyển hướng
            } else {
                // Thêm thông báo lỗi nếu truy vấn insert thất bại
                echo "Failed to insert into tbl_payment: " . $this->db->error;
            }
        } else {
            // Nếu đã có đơn hàng trước đó, tiếp tục xử lý giỏ hàng và thanh toán
            $query = "SELECT * FROM tbl_cart WHERE user_id = '$user_id' AND status = 'CHON' ORDER BY cart_id DESC";
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
    
                    // Chèn thông tin sản phẩm vào bảng tbl_carta với trạng thái 'CHUA_NHAN'
                    $query = "INSERT INTO tbl_carta (sanpham_anh, user_id, sanpham_id, sanpham_tieude, sanpham_gia, color_anh, quantitys, sanpham_size, status) 
                            VALUES ('$sanpham_anh', '$user_id', '$sanpham_id', '$sanpham_tieude', '$sanpham_gia', '$color_anh', '$quantitys', '$sanpham_size', 'CHUA_NHAN')";
                    $resultC = $this->db->insert($query);
    
                    // Nếu insert thành công, xóa sản phẩm khỏi giỏ hàng
                    if ($resultC) {
                        // Xóa sản phẩm khỏi giỏ hàng
                        $query = "DELETE FROM tbl_cart WHERE cart_id = '$cart_id' AND status = 'CHON'";
                        $resultD = $this->db->delete($query);
    
                        // Cập nhật số lượng sản phẩm trong session
                        Session::set('SL', null);
                    } else {
                        // Thêm thông báo lỗi nếu truy vấn insert thất bại
                        echo "Failed to insert into tbl_carta: " . $this->db->error;
                    }
                }
            } else {
                // Thêm thông báo lỗi nếu truy vấn select thất bại
                echo "Failed to select from tbl_cart: " . $this->db->error;
            }
    
            // Chuyển hướng đến trang thành công sau khi xử lý thanh toán
            header('Location: success.php');
            exit(); // Dừng thực thi mã sau khi chuyển hướng
        }
    }
    

    public function updateCartStatus($cart_id, $status) {
        // Kiểm tra giá trị của cart_id và status để bảo vệ dữ liệu
        if(empty($cart_id) || empty($status)) {
            return "Cart ID hoặc trạng thái không hợp lệ!";
        }
        // Truy vấn SQL để cập nhật trạng thái
        $query = "UPDATE tbl_cart SET status = '$status' WHERE cart_id = '$cart_id'";
        // Thực hiện truy vấn
        $result = $this->db->update($query); // Gọi phương thức update từ class Database
        // Kiểm tra kết quả thực hiện truy vấn
        if ($result) {
            return "Cập nhật trạng thái thành công!";
        } else {
            // Nếu có lỗi trong quá trình thực hiện
            return "Lỗi khi cập nhật trạng thái!";
        }
    }
    public function updateCartStatusCarta($cart_id, $status) {
        // Kiểm tra giá trị của cart_id và status để bảo vệ dữ liệu
        if(empty($cart_id) || empty($status)) {
            return "Cart ID hoặc trạng thái không hợp lệ!";
        }
        // Truy vấn SQL để cập nhật trạng thái
        $query = "UPDATE tbl_carta SET status = '$status' WHERE cart_id = '$cart_id'";
        // Thực hiện truy vấn
        $result = $this->db->update($query); // Gọi phương thức update từ class Database
        // Kiểm tra kết quả thực hiện truy vấn
        if ($result) {
            return "Cập nhật trạng thái thành công!";
        } else {
            // Nếu có lỗi trong quá trình thực hiện
            return "Lỗi khi cập nhật trạng thái!";
        }
    }

    public function update_sanpham_quantity($sanpham_id, $quantity) {
        $query = "UPDATE tbl_sanpham SET sanpham_soluong = sanpham_soluong - ? WHERE sanpham_id = ?";
        $stmt =  $this->db->link->prepare($query);
        $stmt->bind_param("ii", $quantity, $sanpham_id);
        return $stmt->execute();
    }
    

}
?>