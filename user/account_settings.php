<?php
session_start();

// Kiểm tra trạng thái đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once __DIR__ . '/../class/user.php'; // Import lớp User
$user_model = new User();

// Lấy thông tin người dùng
$user_id = $_SESSION['user_id'];
$user_info = $user_model->get_user_by_id($user_id);

if (!$user_info) {
    echo "Không thể lấy thông tin người dùng.";
    exit();
}

$username = $user_info['username'];
$email = $user_info['email'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>
    <link rel="stylesheet" href="css/account_settings.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body class="container mt-5">
    <h1>Account Settings</h1>
    <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>

    <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
    <div class="alert alert-success" role="alert">
        Update successful!
    </div>
    <?php elseif (isset($_GET['status']) && $_GET['status'] === 'password_changed'): ?>
    <div class="alert alert-success" role="alert">
        Password changed successfully!
    </div>
    <?php endif; ?>

    <!-- Section: Update Personal Info -->
    <section class="mt-4">
        <h3>Update Personal Information</h3>
        <form action="update_account.php" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" id="username" name="username" class="form-control"
                    value="<?php echo htmlspecialchars($username); ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control"
                    value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </section>

    <!-- Section: Change Password -->
    <section class="mt-4">
        <h3>Change Password</h3>
        <form action="change_password.php" method="POST">
            <div class="mb-3">
                <label for="current_password" class="form-label">Current Password:</label>
                <input type="password" id="current_password" name="current_password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="new_password" class="form-label">New Password:</label>
                <input type="password" id="new_password" name="new_password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm New Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Change Password</button>
        </form>
    </section>

    <!-- Section: Delete Account -->
    <section class="mt-4">
        <h3>Delete Account</h3>
        <form action="delete_account.php" method="POST">
            <button type="submit" class="btn btn-danger"
                onclick="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                Delete Account
            </button>
        </form>
    </section>

    <!-- Back to Home -->
    <div class="mt-4">
        <a href="/web_quan_ao/index.php" class="btn btn-secondary">Back to Home</a>
    </div>
</body>

</html>