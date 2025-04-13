<?php
require_once('../../classes/Authentication.php');
require_once('../../classes/Order.php');

use Classes\Order;
use Classes\Authentication;

Authentication::requirePostMethod();

$ord = new Order();
$orderId = $_POST['orderid'] ?? null;
$status = $_POST['status'] ?? null;

$error = [];
if (empty($orderId)) {
    $error['orderId'] = "Order id is required.";
}

if (empty($status)) {
    $error['status'] = "Status is required.";
}

if ($error) {
    $_SESSION['invalid_input'] = $error;
    header('Location: /admin/order');
    exit;
}

$response = [];
if ($ord->updateStatus($orderId, $status)) {
    $response = [
        'result' => true,
        'message' => "Successfully updated status $status of order id $orderId",
        'class' => 'success'
    ];
} else {
    $response = [
        'result' => false,
        'message' => $status . " has not been updated",
        'class' => 'danger'
    ];
}
echo json_encode($response);
