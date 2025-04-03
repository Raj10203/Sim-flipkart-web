<?php
include_once('../../authentication/backend_authenticate.php');
require_once('../../classes/traits/ItemOperations.php');
require_once('../../classes/Database.php');
require_once('../../classes/User.php');

session_start();

use Admin\Classes\User;
use Admin\Classes\Database;

$db = new Database;
$user = new User($db);

$email = $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ?: "";
$password = hash("sha256", $_POST['password']);
$userDetail = $user->login($email, $password);
if (isset($userDetail['id'])) {
    $_SESSION['email'] = $email;
    $_SESSION['user_id'] = $userDetail['id'];
    $_SESSION['user_name'] = $userDetail['first_name'];
    header('location: /');
} else {
    $_SESSION['invalid-input'] = 'Incorrenct credentials';
    header('location: /admin/page/login.php');
}
