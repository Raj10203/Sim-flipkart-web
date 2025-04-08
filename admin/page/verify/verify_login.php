<?php

use Admin\Classes\User;

require_once('../../authentication/backend_authenticate.php');
require_once('../../classes/traits/ItemOperations.php');
require_once('../../classes/Database.php');
require_once('../../classes/User.php');
session_start();

$user = new User();
$email =  trim($_POST['email']) ?? '';
$password = $_POST['password'];
$valid = true;

$error = [];
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error['email'] = "Please enter a valid email address.";
}

if (empty($password)) {
    $error['password'] = "Password is required.";
}

if ($error) {
    $_SESSION['invalid_input'] = $error;
    header('Location: /admin/page/login.php');
    exit;
}

$authentication = $user->login($email, hash('sha256', $password));
if ($authentication) {
    header('Location: /');
    exit;
}

$_SESSION['invalid_input'] = ['credentials' => 'Incorrect credentials'];
header('Location: /admin/page/login.php');
exit;