<?php 
session_start();
if (!isset($_SESSION['user_id'])) {
    header('location: /admin/page/login');
}
?>