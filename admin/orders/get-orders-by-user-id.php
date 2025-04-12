<?php
require_once('../../classes/Authentication.php');
require_once('../../classes/traits/ItemOperations.php');
require_once('../../classes/Database.php');
require_once('../../classes/Order.php');

use Classes\Order;
use Classes\Authentication;

Authentication::requirePostMethod();

$ord = new Order();

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        "error" => "user_id is required",
        "message" => 'user_id is required to get orders.'
    ]);
    die;
}
$orders = $ord->getOrderByUserId($_SESSION['user_id']);
echo json_encode($orders);
