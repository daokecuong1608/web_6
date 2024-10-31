<?php
define("DB_HOST", "localhost:3307");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "website_ivy");

?>
<?php
$connect = mysqli_connect('localhost:3307', 'root', '', 'website_ivy');
if (mysqli_error($connect)) {
    die("Kết nối thất bại ! " . mysqli_error($connect));
}
?>