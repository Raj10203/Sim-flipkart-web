<?php
require_once('../../classes/traits/ItemOperations.php');
require_once('../../classes/Database.php');
require_once('../../classes/Product.php');

use Admin\Classes\Product;
use Admin\Classes\Database;

$db = new Database();
$prod = new Product($db);
$products = $prod->getAllItems($prod->getTableName());
echo json_encode($products);
