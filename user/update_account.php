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
    $username = $_POST['username'];
    $email = $_POST['email'];

    $result = $user_model->update_account($user_id, $username, $email);
    if ($result) {
        header("Location: account_settings.php?status=success");
        exit();
    } else {
        echo "Update failed.";
    }
}
?>