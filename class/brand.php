<?php
define('__ROOT__', dirname(dirname(__FILE__))); // Định nghĩa hằng số __ROOT__
include_once __ROOT__ . "/helper/format.php";
include_once __ROOT__ . "/lib/database.php";
?>

<?php
class brand{
    private $db;
    private $fm;

    public function __construct(){
    $this->db = new Database;
    }

public function show_color(){
    $query = "SELECT * FROM tbl_color ORDER BY color_id DESC";
    $result = $this -> db ->select($query);
    return $result;
}

public function get_color($color_id){
    $query = "SELECT * FROM tbl_color WHERE color_id = '$color_id'";
    $result = $this -> db ->select($query);
    return $result;
}


public function delete_color($color_id){
    $query = "DELETE FROM tbl_color WHERE color_id = '$color_id'";
    $result = $this -> db ->delete($query);
    return $result;
}
public function update_color($color_ten, $color_anh , $color_id){
    $query = "UPDATE tbl_color SET color_ten = '$color_ten', color_anh = '$color_anh' WHERE color_id = '$color_id'";
    $result = $this -> db ->update($query);
    header('Location: colorlist.php');
    return $result;
}


public function insert_color($color_ten, $color_anh){
    $query = "INSERT INTO tbl_color (color_ten, color_anh) VALUES ('$color_ten', '$color_anh')";
    $result = $this -> db ->insert($query);
    header('Location: colorlist.php');
    return $result;
}
}
?>