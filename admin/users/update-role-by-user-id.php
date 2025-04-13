<?php
require_once('../../classes/Authentication.php');
require_once('../../classes/User.php');

use Classes\User;
use Classes\Authentication;

Authentication::requirePostMethod();

$usr = new User();
$userId = $_POST['userId'] ?? null;
$role = $_POST['role'] ?? null;

$error = [];
if (empty($userId)) {
    $error['userId'] = "Order id is required.";
}

if (empty($role)) {
    $error['role'] = "role is required.";
}

if ($error) {
    $_SESSION['invalid_input'] = $error;
    header('Location: /admin/user');
    exit;
}

$response = [];
if ($usr->updateRole($userId, $role)) {
    $response = [
        'result' => true,
        'message' => "Successfully updated role $role of user id $userId",
        'class' => 'success'
    ];
} else {
    $response = [
        'result' => false,
        'message' => $role . " has not been updated",
        'class' => 'danger'
    ];
}
echo json_encode($response);
