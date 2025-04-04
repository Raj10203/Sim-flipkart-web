<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
require_once('../../authentication/backend_authenticate.php');
require_once('../../classes/traits/ItemOperations.php');
require_once('../../classes/Database.php');
require_once('../../classes/OrderItems.php');
require_once('../../classes/Product.php');

session_start();

use Admin\Classes\OrderItems;
use Admin\Classes\Database;

$db = new Database();
$oi = new OrderItems($db);
$orders = $oi->getItemsByOrderId($_POST['orderID']);
echo json_encode($orders);