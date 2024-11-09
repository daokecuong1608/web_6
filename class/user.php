<?php

require_once(__ROOT__ . '/lib/session.php' );
require_once(__ROOT__ . '/lib/database.php' );

// Kiểm tra đường dẫn
// echo 'Session path: ' . realpath(__ROOT__ . '/lib/session.php') . '<br>';
// echo 'Database path: ' . realpath(__ROOT__ . '/lib/database.php') . '<br>';

?>

<?php
class user{
    public $db;
    public function __construct(){
        $this->db = new Database();
    }

    public function check_login($email, $password){

        $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
        $result = $this->db->select($query);
        if($result != false){

        // Hủy phiên hiện tại (nếu có)
        if (session_status() == PHP_SESSION_ACTIVE) {
            session_unset();
            session_destroy();
        }

   // Khởi tạo phiên mới
   session_start();
            
            $value = $result->fetch_assoc();
            Session::set("login", true);
            Session::set("username", $value['username']);
            Session::set("userid", $value['id']);
            Session::set("role", $value['role']);
            if ($value['role'] == 'admin') {
                header("Location: admin/admin_dashboard.php"); // Chuyển hướng đến trang quản lý dành cho admin
            } else {
                header("Location: index.php"); // Chuyển hướng đến trang index cho user
            }        } else {
            $msg = "Email hoặc mật khẩu không đúng";
            return $msg;
        }
    }

}
?>