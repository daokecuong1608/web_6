<?php
// Định nghĩa hằng số __ROOT__ nếu chưa được định nghĩa
if (!defined('__ROOT__')) {
    define('__ROOT__', dirname(__FILE__));
}

require_once(__ROOT__ . '/class/index_class.php'); // Đường dẫn chính xác đến tệp index_class.php
$index = new index();

if (isset($_GET['cart_id']) && $_GET['cart_id'] != NULL) {
    $cart_id = $_GET['cart_id'];
    $delete_cart = $index->delete_cart($cart_id);
    header('Location: cart.php');
    exit();
} else {
    header('Location: cart.php');
    exit();
}
?>