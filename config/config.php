<?php
define("DB_HOST", "localhost:3307");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "web_quan_ao");

?>
<?php
$connect = mysqli_connect('localhost:3307', 'root', '', 'web_quan_ao');
if (mysqli_error($connect)) {
    die("Kết nối thất bại ! " . mysqli_error($connect));
}
?>