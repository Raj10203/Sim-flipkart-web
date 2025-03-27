<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
session_start();
require_once('../../classes/Database.php');
require_once('../../classes/User.php');
use Admin\Classes\User;
use Admin\Classes\Database;

$db = new Database;
$user = new User($db);
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = test_input($_POST['email']);
    $password = hash("sha256", $_POST['password']);
    if ($user->login($email,$password)) {
        $_SESSION['email'] = "email";
        header('location: /admin/pages/');
    } else {
        $_SESSION['invalid-credentials'] = 'Incorrenct credentials';
        header('location: /admin/pages/login.php');
    }
}
