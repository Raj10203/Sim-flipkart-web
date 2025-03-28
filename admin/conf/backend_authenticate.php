<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('location: /admin/pages/login.php');
}