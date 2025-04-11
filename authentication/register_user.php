<?php

use Classes\User;

require_once('../authentication/backend_authenticate.php');
require_once('../classes/traits/ItemOperations.php');
require_once('../classes/Database.php');
require_once('../classes/User.php');
session_start();

$user = new User();
$firstName = trim($_POST['firstName']);
$lastName  = trim($_POST['lastName']);
$email     = trim($_POST['email']);
$password  = $_POST['password'];
$confirmPassword  = $_POST['confirmPassword'];

$error = [];
if (empty($firstName)) {
    $error['firstName'] = "First name is required.";
}

if (empty($lastName)) {
    $error['lastName'] = "Last name is required.";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error['email'] = "Please enter a valid email address.";
}

if (empty($password)) {
    $error['password'] = "Password is required.";
} elseif (strlen($password) < 6) {
    $error['password'] = "Password must be at least 6 characters.";
}

if (empty($confirmPassword)) {
    $error['confirmPassword'] = "Confirm Password is required.";
} elseif ($password != $confirmPassword) {
    $error['confirmPassword'] = "Confirm Password must same as Password.";
}

if (!empty($error)) {
    $_SESSION['invalid_input'] = $error;
    header('Location: /register');
    exit;
}

$hashedPassword = hash("sha256", $password);
if ($user->addUser($firstName, $lastName, $email, $hashedPassword)) {
    unset($_SESSION['invalid_input']);
    header('Location: /login');
} else {
    header('Location: /register');
}
