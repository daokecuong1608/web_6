<?php
if (!defined('__ROOT__')) {
    define('__ROOT__', dirname(__FILE__)); // Định nghĩa hằng số __ROOT__ nếu chưa được định nghĩa
}
require_once(__ROOT__ . '/class/index_class.php'); // Đường dẫn chính xác đến tệp index_class.php

$index = new index();

// Nhận tham số từ VNPay callback
$vnp_ResponseCode = $_GET['vnp_ResponseCode'] ?? '';
$vnp_TxnRef = $_GET['vnp_TxnRef'] ?? '';
$vnp_Amount = isset($_GET['vnp_Amount']) ? intval($_GET['vnp_Amount']) / 100 : 0; // Chuyển về VND
$vnp_OrderInfo = $_GET['vnp_OrderInfo'] ?? '';
$vnp_TransactionNo = $_GET['vnp_TransactionNo'] ?? '';
$vnp_BankCode = $_GET['vnp_BankCode'] ?? '';
$vnp_PayDate = $_GET['vnp_PayDate'] ?? '';

$userid = $_GET['userid'] ?? '';
$deliver_method = $_GET['deliver_method'] ?? '';
$method_payment = $_GET['method_payment'] ?? '';
$today = $_GET['today'] ?? '';

$vnp_HashSecret = "TELHZGDROWAOPX2NGJAICLFCU147OZL6"; // Chuỗi bí mật
$vnp_SecureHash = $_GET['vnp_SecureHash'] ?? '';

// // Kiểm tra chữ ký hợp lệ
// $inputData = [];
// foreach ($_GET as $key => $value) {
//     if (substr($key, 0, 4) == "vnp_") {
//         $inputData[$key] = $value;
//     }
// }
// unset($inputData['vnp_SecureHashType'], $inputData['vnp_SecureHash']);
// ksort($inputData);

// $hashData = "";
// foreach ($inputData as $key => $value) {
//     $hashData .= '&' . $key . "=" . $value;
// }
// $hashData = ltrim($hashData, '&'); // Xóa ký tự & đầu tiên

// $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

// Lấy dữ liệu từ URL trả về của VNPAY
// $vnp_SecureHash = $_GET['vnp_SecureHash'];
// $amount = $_GET['vnp_Amount'];
$inputData = array();

foreach ($_GET as $key => $value) {
    if (substr($key, 0, 4) == "vnp_") {
        $inputData[$key] = $value;
    }
}

unset($inputData['vnp_SecureHash']);
ksort($inputData);
$hashData = "";

foreach ($inputData as $key => $value) {
    $hashData .= urlencode($key) . '=' . urlencode($value) . '&';
}
$hashData = rtrim($hashData, '&');

$secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VNPAY RESPONSE</title>
</head>
<body>
    <div class="container">
        <h3>VNPAY RESPONSE</h3>
        <div class="table-responsive">
            <p><strong>Mã đơn hàng:</strong> <?php echo htmlspecialchars($vnp_TxnRef) ?></p>
            <p><strong>Số tiền:</strong> <?php echo number_format($vnp_Amount) ?> VND</p>
            <p><strong>Nội dung thanh toán:</strong> <?php echo htmlspecialchars($vnp_OrderInfo) ?></p>
            <p><strong>Mã phản hồi:</strong> <?php echo htmlspecialchars($vnp_ResponseCode) ?></p>
            <p><strong>Mã GD tại VNPAY:</strong> <?php echo htmlspecialchars($vnp_TransactionNo) ?></p>
            <p><strong>Mã Ngân hàng:</strong> <?php echo htmlspecialchars($vnp_BankCode) ?></p>
            <p><strong>Thời gian thanh toán:</strong> <?php echo htmlspecialchars($vnp_PayDate) ?></p>
            <p><strong>Kết quả:</strong> 
                <?php
                echo "$vnp_SecureHash";
                echo "<br>";
                echo "$secureHash";
                // $index->insert_payment($userid, $deliver_method, $method_payment, $today);
                if ($secureHash === $vnp_SecureHash) {
                    if ($vnp_ResponseCode === '00') {
                        // Chỉ insert nếu chưa tồn tại giao dịch (tránh bị gọi nhiều lần)
                        $index->insert_payment($userid, $deliver_method, $method_payment, $today);
                        
                        echo "<span style='color:blue'>Giao dịch thành công</span>";
                    } else {
                        echo "<span style='color:red'>Giao dịch thất bại</span>";
                    }
                } else {
                    echo "<span style='color:red'>Chữ ký không hợp lệ</span>";
                }
                ?>
            </p>
        </div>
        <footer><p>&copy; VNPAY <?php echo date('Y')?></p></footer>
    </div>
</body>
</html>
