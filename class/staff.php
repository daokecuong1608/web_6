<?php
define('__ROOT__', dirname(dirname(__FILE__))); // Định nghĩa hằng số __ROOT__
include_once __ROOT__ . "/helper/format.php";
include_once __ROOT__ . "/lib/database.php";

class staff{
    private $db;
    private $fm;
public function __construct()
{
    $this->db = new Database();
}

public function show_staff(){
    $query = "SELECT * FROM tbl_staff ORDER BY staff_id DESC";
    $result = $this->db->select($query);
    return $result;
}

public function get_staff($staff_id){
    $query = "SELECT * FROM tbl_staff WHERE staff_id = '$staff_id'";
    $result = $this -> db ->select($query);
    return $result;
}

public function insert_staff($staff_name, $staff_age, $staff_email, $staff_address){
    $query = "INSERT INTO tbl_staff(staff_name, staff_age, staff_email, staff_address) VALUES('$staff_name', '$staff_phone', '$staff_email', '$staff_address')";
    $result = $this->db->insert($query);
    header('Location: stafflist.php');
    return $result;
}

public function update_staff($staff_name, $staff_age, $staff_email, $staff_address, $staff_id){
    $query = "UPDATE tbl_staff SET staff_name = '$staff_name', staff_age = '$staff_age', staff_email = '$staff_email', staff_address = '$staff_address' WHERE staff_id = '$staff_id'";
    $result = $this->db->update($query);
    header('Location: stafflist.php');
    return $result;
}

public function delete_staff($staff_id){
    $query = "DELETE FROM tbl_staff WHERE staff_id = '$staff_id'";
    $result = $this->db->delete($query);
    return $result;

}
}
?>