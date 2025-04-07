<?php

require_once('../../authentication/backend_authenticate.php');
require_once('../../classes/traits/ItemOperations.php');
require_once('../../classes/Database.php');
require_once('../../classes/User.php');
session_start();

use Admin\Classes\User;
use Admin\Classes\Database;

$db = new Database;
$user = new User($db);

$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ?: "";
$password = hash("sha256", $_POST['password']);
$response = $user->addUser($firstName, $lastName, $email, $password);
if(!$response['status']) {
    $_SESSION['invalid-input'] = $response['message'];
    header('location: /admin/page/register');
} else {
    unset($_SESSION['invalid-input']);
    header('location: /admin/page/login');
}
