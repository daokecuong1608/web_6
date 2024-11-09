<?php
session_start();
session_unset();
session_destroy();

// Kiểm tra xem phiên có thực sự bị hủy hay không
if (session_status() == PHP_SESSION_NONE) {
    echo "Session destroyed successfully.";
} else {
    echo "Failed to destroy session.";
}

header("Location: ../index.php"); // Chuyển hướng về trang đăng nhập
exit();
?>