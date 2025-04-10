<?php

use Classes\Order;

require_once('../../authentication/backend_authenticate.php');
require_once('../../classes/traits/ItemOperations.php');
require_once('../../classes/Database.php');
require_once('../../classes/Order.php');
session_start();

$ord = new Order();
if (!isset($_POST['user_id'])) {
    echo json_encode([
        "error" => "user_id is required",
        "message" => 'user_id is required to get orders.'
    ]);
    die;
}
$orders = $ord->getOrderByUserId($_SESSION['user_id']);
echo json_encode($orders);
