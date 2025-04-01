<?php
include_once('../../authentication/backend_authenticate.php');
require_once('../../classes/Database.php');
require_once('../../classes/User.php');

session_start();


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
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ? $_POST['email'] : "";
    $password = hash("sha256", $_POST['password']);
    $userDetail = $user->login($email,$password);
    if ($userDetail['id']) {
        $_SESSION['email'] = $email;
        $_SESSION['user_id'] = $userDetail['id'];
        header('location: /');
    } else {
        unset($_SESSION['email']);
        unset($_SESSION['user_id']);
        $_SESSION['invalid-credentials'] = 'Incorrenct credentials';
        header('location: /admin/page/login.php');
    }
}
