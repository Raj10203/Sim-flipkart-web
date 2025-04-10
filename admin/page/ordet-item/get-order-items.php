<?php

use Admin\Classes\OrderItems;
use Admin\Classes\Product;

require_once('../../authentication/backend_authenticate.php');
require_once('../../classes/traits/ItemOperations.php');
require_once('../../classes/Database.php');
require_once('../../classes/OrderItems.php');
require_once('../../classes/Product.php');
session_start();

$prod = new Product();
$oi = new OrderItems();
$orders = $oi->getItemsByOrderId($_POST['orderID']);
echo json_encode($orders);