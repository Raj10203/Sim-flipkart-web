<?php

use Admin\Classes\Order;

require_once('../../authentication/backend_authenticate.php');
require_once('../../classes/traits/ItemOperations.php');
require_once('../../classes/Database.php');
require_once('../../classes/Order.php');
session_start();

$ord = new Order();
$orders = $ord->getOrderByUserId($_SESSION['user_id']);
echo json_encode($orders);
