<?php
define('__ROOT__', dirname(dirname(__FILE__))); // Định nghĩa hằng số __ROOT__
include_once __ROOT__ . "/helper/format.php";
include_once __ROOT__ . "/lib/database.php";

class category{
    private $db;
    private $fm;
public function __construct()
{
    $this->db = new Database();
}

}
?>