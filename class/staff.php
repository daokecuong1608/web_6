<?php
if (!defined('__ROOT__')) {
    define('__ROOT__', dirname(dirname(__FILE__))); // Định nghĩa hằng số __ROOT__ nếu chưa được định nghĩa
}include_once __ROOT__ . "/helper/format.php";
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

public function insert_staff($staff_name, $staff_age, $staff_email, $staff_address , $password){
    $query = "INSERT INTO tbl_staff(staff_name, staff_age, staff_email, staff_address , password) VALUES('$staff_name', '$staff_age', '$staff_email', '$staff_address' , '$password')";
    $result = $this->db->insert($query);
    header('Location: stafflist.php');
    return $result;
}

public function update_staff($staff_name, $staff_age, $staff_email, $staff_address,$password ,$staff_id){
    $query = "UPDATE tbl_staff SET staff_name = '$staff_name', staff_age = '$staff_age', staff_email = '$staff_email', staff_address = '$staff_address' , password ='password' WHERE staff_id = '$staff_id'";
    $result = $this->db->update($query);
    header('Location: stafflist.php');
    return $result;
}

public function delete_staff($staff_id){
    $query = "DELETE FROM tbl_staff WHERE staff_id = '$staff_id'";
    $result = $this->db->delete($query);
    return $result;

}


public function get_staff_count() {
    $query = "SELECT COUNT(*) as staff_count FROM tbl_staff";
    $result = $this->db->select($query);
    $row = $result->fetch_assoc();
    return $row['staff_count'];
}
public function login_staff($staff_email, $password) {
    $staff_email = $this->db->link->real_escape_string($staff_email);
    $password = $this->db->link->real_escape_string($password);

    $query = "SELECT * FROM tbl_staff WHERE staff_email = '$staff_email' AND password = '$password'";
    $result = $this->db->select($query);

    if ($result != false) {
        $value = $result->fetch_assoc();
        session_start();
        $_SESSION['staff_login'] = true;
        $_SESSION['staff_id'] = $value['staff_id'];
        $_SESSION['staff_name'] = $value['staff_name'];
        $_SESSION['staff_email'] = $value['staff_email']; // Lưu trữ staff_email trong phiên
        header('Location: dashboard.php'); // Chuyển hướng đến trang dashboard sau khi đăng nhập thành công
    } else {
        $msg = "Email hoặc mật khẩu không đúng!";
        return $msg;
    }
}
}
?>