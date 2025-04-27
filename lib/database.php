<?php
require_once(__ROOT__.'/config/config.php');

class Database {
    public $host = DB_HOST;
    public $user = DB_USER;
    public $pass = DB_PASS;
    public $dbname = DB_NAME;

    public $link;
    public $error;

    public function __construct() {
        $this->connectDB();
    }

    // Kết nối database
    public function connectDB() {
        $this->link = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
        if ($this->link->connect_error) {
            $this->error = "Connection failed: " . $this->link->connect_error;
            return false;
        }
        $this->link->set_charset('utf8mb4'); // Đặt charset ngay sau khi kết nối
    }

    // Hàm kiểm tra và tự động reconnect nếu mất kết nối
    private function checkConnection() {
        if (!$this->link->ping()) {
            $this->connectDB(); // reconnect nếu mất kết nối
        }
    }

    // SELECT
    public function select($query) {
        $this->checkConnection();
        $result = $this->link->query($query);
        if ($result && $result->num_rows > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function selectdc($query) {
        return $this->select($query); // dùng chung luôn
    }

    // INSERT
    public function insert($query) {
        $this->checkConnection();
        $insert_row = $this->link->query($query);
        if ($insert_row) {
            return $insert_row;
        } else {
            $this->error = "Insert Error: " . $this->link->error;
            return false;
        }
    }

    // UPDATE
    public function update($query) {
        $this->checkConnection();
        $update_row = $this->link->query($query);
        if ($update_row) {
            return $update_row;
        } else {
            $this->error = "Update Error: " . $this->link->error;
            return false;
        }
    }

    // DELETE
    public function delete($query) {
        $this->checkConnection();
        $delete_row = $this->link->query($query);
        if ($delete_row) {
            return $delete_row;
        } else {
            $this->error = "Delete Error: " . $this->link->error;
            return false;
        }
    }
}
?>
