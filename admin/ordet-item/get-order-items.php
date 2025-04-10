<?php

use Classes\OrderItems;
use Classes\Product;

require_once('../../authentication/backend_authenticate.php');
require_once('../../classes/traits/ItemOperations.php');
require_once('../../classes/Database.php');
require_once('../../classes/OrderItems.php');
require_once('../../classes/Product.php');
session_start();

$oi = new OrderItems();

if (!isset($_POST['orderID'])) {
    echo json_encode([
        "error" => "orderID is required",
        "message" => 'orderID is required to get order items'
    ]);
    die;
}
$orders = $oi->getItemsByOrderId($_POST['orderID']);
echo json_encode($orders);