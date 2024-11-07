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

    public function show_cart($session_id)
    {
        $query = "SELECT * FROM tbl_cart WHERE session_idA = '$session_id' ORDER BY cart_id DESC";
        $result = $this->db->select($query);
        return $result;
    }

    public function show_danhmuc()
    {
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
    public function get_anh($sanpham_id)
    {
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


    public function insert_cart($sanpham_anh, $session_idA, $sanpham_id, $sanpham_tieude, $sanpham_gia, $color_anh, $quantitys, $sanpham_size){
        $query = "INSERT INTO tbl_cart (sanpham_anh,session_idA,sanpham_id,sanpham_tieude,sanpham_gia,color_anh,quantitys,sanpham_size) VALUES 
        ('$sanpham_anh','$session_idA','$sanpham_id','$sanpham_tieude','$sanpham_gia','$color_anh','$quantitys','$sanpham_size')";
        $result = $this->db->insert($query);
        return $result;
    }

    public function delete_cart($cart_id)
    {
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

}
?>