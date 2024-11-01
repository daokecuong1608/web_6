<?php
require_once(dirname(__DIR__) . '/config/config.php'); // Đảm bảo đường dẫn chính xác đến tệp config.php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $confirm_password = htmlspecialchars($_POST['confirm_password']);

    // Kiểm tra mật khẩu và xác nhận mật khẩu
    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Mật khẩu và xác nhận mật khẩu không khớp!";
        header("Location: ../register.php");
        exit();
    }

    // // Mã hóa mật khẩu
    // $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Kết nối cơ sở dữ liệu
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    // Kiểm tra xem email đã tồn tại chưa
    $sql = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['error'] = "Email đã tồn tại!";
        header("Location: ../register.php");
        exit();
    } else {
        // Thêm người dùng mới vào cơ sở dữ liệu
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $password);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Đăng ký thành công!";
            header("Location: ../login.php");
            exit();
        } else {
            $_SESSION['error'] = "Đăng ký thất bại!";
            header("Location: ../register.php");
            exit();
        }
    }

    $stmt->close();
    $conn->close();
}
?>