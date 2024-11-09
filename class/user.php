<?php
if (!defined('__ROOT__')) {
    define('__ROOT__', dirname(dirname(__FILE__))); // Định nghĩa hằng số __ROOT__ nếu chưa được định nghĩa
}
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

    public function show_user(){
            $query = "SELECT * FROM users";
            $result = $this->db->select($query);
            return $result;
        }
        public function delete_user($userid) {
            $query = "DELETE FROM users WHERE id = ?";
            $stmt = $this->db->link->prepare($query);
            if ($stmt === false) {
                return "Xóa người dùng thất bại: " . $this->db->link->error;
            }
            $stmt->bind_param("i", $userid);
            $result = $stmt->execute();
            $stmt->close();
    
            if ($result) {
                return "Xóa người dùng thành công";
            } else {
                return "Xóa người dùng thất bại";
            }
        }
}
?>