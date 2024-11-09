<?php
include_once "../class/staff.php"; // Bao gồm tệp chứa định nghĩa của lớp product

$staff = new staff();
if(isset($_GET['staff_id'])){
    $staff_id = $_GET['staff_id'];
    $delete_staff = $staff->delete_staff($staff_id);
    header('Location: stafflist.php');
}

?>