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



    
    public function check_login($email, $password) {
        $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
        $result = $this->db->select($query);
        if ($result != false) {
            // Hủy phiên hiện tại (nếu có)
            if (session_status() == PHP_SESSION_ACTIVE) {
                session_unset();
                session_destroy();
            }
            // Khởi tạo phiên mới
            session_start();
            $value = $result->fetch_assoc();
            $_SESSION['login'] = true;
            $_SESSION['username'] = $value['username'];
            $_SESSION['user_id'] = $value['id'];
            $_SESSION['role'] = $value['role'];
    
            if ($value['role'] == 'admin') {
                header("Location: admin/admin_dashboard.php"); // Chuyển hướng đến trang quản lý dành cho admin
            } else {
                header("Location: index.php"); // Chuyển hướng đến trang index cho user
            }
        } else {
            $msg = "Email hoặc mật khẩu không đúng";
            return $msg;
        }
    }

    public function show_user(){
            $query = "SELECT * FROM users";
            $result = $this->db->select($query);
            return $result;
        }

        public function isEmailExists(){
            $query = "SELECT email FROM users WHERE email = ?";
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

    // Lấy thông tin người dùng theo ID
    public function get_user_by_id($user_id) {
        $query = "SELECT username, email FROM users WHERE id = ?";
        $stmt = $this->db->link->prepare($query);
        if ($stmt === false) {
            die("Database error: " . $this->db->link->error);
        }
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($username, $email);
        if ($stmt->fetch()) {
            $stmt->close();
            return [
                'username' => $username,
                'email' => $email
            ];
        }
        $stmt->close();
        return false;
    }

    public function change_password($user_id, $current_password, $new_password) {
        // Kiểm tra mật khẩu hiện tại từ cơ sở dữ liệu
        $query = "SELECT password FROM users WHERE id = ?";
        $stmt = $this->db->link->prepare($query);
        if ($stmt === false) {
            return "Database error: Failed to prepare query.";
        }
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($db_password);
        if (!$stmt->fetch()) {
            $stmt->close();
            return "User not found!";
        }
        $stmt->close();
    
        // So sánh mật khẩu hiện tại với mật khẩu hash trong cơ sở dữ liệu
        if (!password_verify($current_password, $db_password)) {
            return "Current password is incorrect!";
        }
    
        // // Hash mật khẩu mới trước khi lưu vào cơ sở dữ liệu
        // $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
    
        // Cập nhật mật khẩu mới
        $query = "UPDATE users SET password = ? WHERE id = ?";
        $stmt = $this->db->link->prepare($query);
        if ($stmt === false) {
            return "Database error: Failed to prepare update query.";
        }
        $stmt->bind_param("si", $new_password, $user_id);
        $result = $stmt->execute();
        if ($stmt->error) {
            $error = $stmt->error;
        }
        $stmt->close();
    
        // Trả về kết quả
        if (isset($error)) {
            return "Failed to update password: $error";
        }
        return $result ? "Password updated successfully!" : "Failed to update password!";
    }
    
    
    public function delete_account($user_id) {
        // Xóa người dùng theo ID
        $query = "DELETE FROM users WHERE id = ?";
        $stmt = $this->db->link->prepare($query);
        if ($stmt === false) {
            die("Database error: " . $this->db->link->error);
        }
        $stmt->bind_param("i", $user_id);
        $result = $stmt->execute();
        $stmt->close();
    
        // Xóa session sau khi xóa tài khoản
        if ($result) {
            session_unset();
            session_destroy();
            return "Account deleted successfully!";
        } else {
            return "Failed to delete account!";
        }
    }

    public function update_account($user_id, $username, $email) {
        // Kiểm tra trùng email (nếu cần) 
        $query = "SELECT id FROM users WHERE email = ? AND id != ?";
        $stmt = $this->db->link->prepare($query);
        if ($stmt === false) {
            die("Database error: " . $this->db->link->error);
        }
        $stmt->bind_param("si", $email, $user_id);
        $stmt->execute();
        if ($stmt->fetch()) {
            $stmt->close();
            return "Email is already in use!";
        }
        $stmt->close();
    
        // Cập nhật thông tin
        $query = "UPDATE users SET username = ?, email = ? WHERE id = ?";
        $stmt = $this->db->link->prepare($query);
        if ($stmt === false) {
            die("Database error: " . $this->db->link->error);
        }
        $stmt->bind_param("ssi", $username, $email, $user_id);
        $result = $stmt->execute();
        $stmt->close();
    
        return $result ? "Account updated successfully!" : "Failed to update account!";
    }
    
    
    
}
?>