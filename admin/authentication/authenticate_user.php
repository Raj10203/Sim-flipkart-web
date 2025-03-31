<?php 
session_start();
if (!isset($_SESSION['id'])) {
$productId = $_SESSION['id'];
    header('location: /admin/page/login');
}
?>