<?php
/**
*Session Class
**/
class Session{
    public static function init(){
     if (version_compare(phpversion(), '5.4.0', '<')) {
           if (session_id() == '') {
               session_start();
           }
       } else {
           if (session_status() == PHP_SESSION_NONE) {
               session_start();
           }
       }
    }
// Lưu trữ dữ liệu vào phiên làm việc
    public static function set($key, $val){
        $_SESSION[$key] = $val;
     }
     // Truy xuất dữ liệu từ phiên làm việc
     public static function get($key){
        if (isset($_SESSION[$key])) {
         return $_SESSION[$key];
        } else {
         return false;
        }
     }
    
     public static function checkSession(){
        self::init();
        if (self::get("user_login")== false) {
         self::destroy();
         header("Location:login.php");
        }
     }
    
     }
    ?>