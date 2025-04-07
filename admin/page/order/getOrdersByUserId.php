<?php

require_once('../../authentication/backend_authenticate.php');
require_once('../../classes/traits/ItemOperations.php');
require_once('../../classes/Database.php');
require_once('../../classes/Order.php');
session_start();

use Admin\Classes\Order;
use Admin\Classes\Database;

$db = new Database();
$ord = new Order($db);
$orders = $ord->getOrderByUserId($_SESSION['user_id']);
echo json_encode($orders);
