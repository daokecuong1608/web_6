<?php
if (!defined('__ROOT__')) {
    define('__ROOT__', dirname(dirname(__FILE__))); // Định nghĩa hằng số __ROOT__ nếu chưa được định nghĩa
}
include_once(__ROOT__ . "/class/user.php");

$user = new user();
if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']);
    $delete_result = $user->delete_user($user_id);

    if ($delete_result === "Xóa người dùng thành công") {
        header("Location: listuser.php?message=User deleted successfully.");
        exit();
    } else {
        header("Location: listuser.php?message=Failed to delete user.");
        exit();
    }
} else {
    header("Location: listuser.php?message=Invalid user ID.");
    exit();
}
?>