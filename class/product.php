<?php
define('__ROOT__', dirname(dirname(__FILE__))); // Định nghĩa hằng số __ROOT__
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


    // Phương thức  lấy  sản phẩm
    public function show_product(){
      $query = "SELECT tbl_sanpham.* , tbl_color.color_ten
      FROM tbl_sanpham 
                    INNER JOIN tbl_color ON tbl_sanpham.color_id = tbl_color.color_id
                     ORDER BY tbl_sanpham.sanpham_id DESC  ";
        $result = $this -> db ->select($query);
        return $result;
    }

    public function show_color(){
        $query = "SELECT * FROM tbl_color ORDER BY color_id DESC";
        $result = $this -> db ->select($query);
        return $result;
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


}
?>