<?php
require_once('../../classes/Authentication.php');
require_once('../../classes/User.php');

use Classes\User;
use Classes\Authentication;

Authentication::requirePostMethod();

$usr = new User();
$userId = $_POST['userId'] ?? null;
$role = $_POST['role'] ?? null;

$errors = [];

if (empty($userId)) {
    $errors['userId'] = "User ID is required.";
}

if (empty($role)) {
    $errors['role'] = "Role is required.";
}

if (!empty($errors)) {
    echo json_encode([
        'success' => false,
        'error' => 'validation_error',
        'message' => 'Validation failed.',
        'data' => $errors
    ]);
    exit;
}

try {
    if ($usr->updateRole($userId, $role)) {
        echo json_encode([
            'success' => true,
            'message' => "Successfully updated role to '$role' for user ID $userId"
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'update_failed',
            'message' => "Role '$role' was not updated."
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => 'server_error',
        'message' => 'An unexpected error occurred while updating the user role.'
    ]);
}
