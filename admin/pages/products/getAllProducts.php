<?php
require_once('../../classes/Database.php');
require_once('../../classes/Product.php');

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use Admin\Classes\Product;
use Admin\Classes\Database;
$db = new Database();
$prod = new Product($db);
$products = $prod->getAllItems($prod->getTableName());
echo json_encode($products);
?>