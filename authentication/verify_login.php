<?php

use Classes\User;

require_once('../authentication/backend_authenticate.php');
require_once('../classes/traits/ItemOperations.php');
require_once('../classes/Database.php');
require_once('../classes/User.php');
session_start();

$user = new User();
$email =  trim($_POST['email'] ?? null);
$password = trim($_POST['password'] ?? null);

$error = [];
if (empty($email)) {
    $error['password'] = "Email is required.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error['email'] = "Please enter a valid email address.";
}

if (empty($password)) {
    $error['password'] = "Password is required.";
}

if ($error) {
    $_SESSION['invalid_input'] = $error;
    header('Location: /login');
    exit;
}

$authentication = $user->login($email, hash('sha256', $password));
if ($authentication) {
    header('Location: /');
    exit;
}

$_SESSION['invalid_input'] = ['credentials' => 'Incorrect credentials'];
header('Location: /login');
exit;
