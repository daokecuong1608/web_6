<?php
session_start();
if (file_exists(__DIR__ . '/../class/user.php')) {
    require_once __DIR__ . '/../class/user.php';
} else {
    echo "File not found: " . __DIR__ . '/../class/user.php';
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_model = new User();
    $user_id = $_SESSION['user_id'];

    $result = $user_model->delete_account($user_id);
    if ($result) {
        // Destroy the session and redirect to login page
        session_destroy();
        header("Location: /web_quan_ao/login.php?status=account_deleted");
        exit();
    } else {
        echo "Account deletion failed.";
    }
}
?>