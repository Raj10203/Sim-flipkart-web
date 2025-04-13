<?php
require_once('../../classes/Authentication.php');
require_once('../../classes/Order.php');

use Classes\Order;
use Classes\Authentication;

Authentication::requirePostMethod();

$ord = new Order();
$orderId = $_POST['orderid'] ?? null;
$status = $_POST['status'] ?? null;

$errors = [];

if (empty($orderId)) {
    $errors['orderId'] = "Order ID is required.";
}

if (empty($status)) {
    $errors['status'] = "Status is required.";
}

if (!empty($errors)) {
    echo json_encode([
        'success' => false,
        'error' => 'validation_error',
        'message' => 'Validation failed. Please correct the highlighted errors.',
        'data' => $errors
    ]);
    exit;
}

try {
    $updated = $ord->updateStatus($orderId, $status);

    if ($updated) {
        echo json_encode([
            'success' => true,
            'message' => "Successfully updated status to '$status' for order ID $orderId"
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'update_failed',
            'message' => "Order status '$status' was not updated."
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => 'server_error',
        'message' => 'An unexpected error occurred while updating the order status.'
    ]);
}
