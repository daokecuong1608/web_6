<?php
if (!defined('__ROOT__')) {
    define('__ROOT__', dirname(dirname(__FILE__))); // Định nghĩa hằng số __ROOT__ nếu chưa được định nghĩa
}
include_once(__ROOT__ . "/class/user.php");

$user = new user();
$show_user = $user->show_user();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách người dùng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="css/listuser.css" rel="stylesheet"> <!-- Liên kết tệp CSS -->
</head>

<body>

    <div class="container mt-4">
        <h1 class="mb-4">Danh sách người dùng</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
            if ($show_user) {
                while ($result = $show_user->fetch_assoc()) {
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($result['username']); ?></td>
                    <td><?php echo htmlspecialchars($result['email']); ?></td>
                    <td><?php echo htmlspecialchars($result['role']); ?></td>
                    <td><?php echo htmlspecialchars($result['created_at']); ?></td>
                    <td>
                        <a href="delete_user.php?id=<?php echo $result['id']; ?>" class="btn btn-danger">Xóa</a>
                    </td>
                </tr>
                <?php
                }
            } else {
                echo "<tr><td colspan='4'>Không có người dùng nào</td></tr>";
            }
            ?>
            </tbody>
        </table>
        <div class="btn-center">
            <a href="../admin/admin_dashboard.php" class="btn btn-primary">Quay lại</a>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>

</body>

</html>