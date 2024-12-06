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
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];

    $result = $user_model->change_password($user_id, $current_password, $new_password);
    if ($result) {
        header("Location: account_settings.php?status=password_changed");
        exit();
    } else {
        echo "Password change failed.";
    }
}
?>