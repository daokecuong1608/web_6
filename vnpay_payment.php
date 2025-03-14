<?php


error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Nhận dữ liệu từ URL
$vnp_TxnRef = $_GET['vnp_TxnRef'] ?? time();
$userid = $_GET['userid'] ?? '';
$deliver_method = $_GET['deliver_method'] ?? '';
$method_payment = $_GET['method_payment'] ?? '';
$today = $_GET['today'] ?? '';
$tongtien = isset($_GET['amount']) ? intval($_GET['amount']) : 0;

// Kiểm tra số tiền hợp lệ
if ($tongtien <= 0) {
    die(json_encode(["code" => "01", "message" => "Số tiền không hợp lệ: " . $tongtien]));
}

// Cấu hình VNPay
$vnp_TmnCode = "VAYSWDS8";
$vnp_HashSecret = "TELHZGDROWAOPX2NGJAICLFCU147OZL6";
$vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
// $vnp_Returnurl = "http://localhost/web_quan_ao/vnpay_return.php";
$vnp_Returnurl = "http://localhost/web_quan_ao/vnpay_return.php?" .
    "userid=" . urlencode($userid) .
    "&deliver_method=" . urlencode($deliver_method) .
    "&method_payment=" . urlencode($method_payment) .
    "&today=" . urlencode($today);


// Xử lý thời gian hết hạn
$startTime = date("YmdHis");
$expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));

// Thông tin đơn hàng
$vnp_OrderInfo = "Thanh toán đơn hàng tại cửa hàng";
$vnp_TxnRef = $today . $vnp_TxnRef;
$vnp_Amount = max(100, $tongtien * 100);
$vnp_Locale = "vn";
$vnp_BankCode = "NCB"; // Mặc định là NCB
$vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
$vnp_ExpireDate = $expire;

// Danh sách tham số gửi đi
$inputData = [
    "vnp_Version" => "2.1.0",
    "vnp_TmnCode" => $vnp_TmnCode,
    "vnp_Amount" => $vnp_Amount,
    "vnp_Command" => "pay",
    "vnp_CreateDate" => date("YmdHis"),
    "vnp_CurrCode" => "VND",
    "vnp_IpAddr" => $vnp_IpAddr,
    "vnp_Locale" => $vnp_Locale,
    "vnp_OrderInfo" => $vnp_OrderInfo,
    "vnp_OrderType" => "billpayment",
    "vnp_ReturnUrl" => $vnp_Returnurl,
    "vnp_TxnRef" => $vnp_TxnRef,
    "vnp_ExpireDate" => $vnp_ExpireDate,
];

if (isset($vnp_BankCode) && $vnp_BankCode != "") {
    $inputData['vnp_BankCode'] = $vnp_BankCode;
}

// ksort($inputData);
// $query = "";
// $i = 0;
// $hashdata = "";
// foreach ($inputData as $key => $value) {
//     if ($i == 1) {
//         $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
//     } else {
//         $hashdata .= urlencode($key) . "=" . urlencode($value);
//         $i = 1;
//     }
//     $query .= urlencode($key) . "=" . urlencode($value) . '&';
// }

// $vnp_Url = $vnp_Url . "?" . $query;
// if (isset($vnp_HashSecret)) {
//     $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
//     $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
// }

// Sắp xếp dữ liệu theo key
ksort($inputData);
$query = "";
$i = 0;
$hashdata = "";

foreach ($inputData as $key => $value) {
    if ($i == 1) {
        $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
    } else {
        $hashdata .= urlencode($key) . "=" . urlencode($value);
        $i = 1;
    }
    $query .= urlencode($key) . "=" . urlencode($value) . '&';
}

// Tạo chữ ký
$vnp_Url = $vnp_Url . "?" . $query;
if (isset($vnp_HashSecret)) {
    $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret); // Mã hóa dữ liệu
    $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
}

$returnData = array(
    'code' => '00',
    'message' => 'success',
    'data' => $vnp_Url
);

// Chuyển hướng đến trang thanh toán VNPay
header("Location: " . $vnp_Url);
exit();
?>
