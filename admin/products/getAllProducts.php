<?php

use Classes\Product;

require_once('../../classes/traits/ItemOperations.php');
require_once('../../classes/Database.php');
require_once('../../classes/Product.php');

$prod = new Product();
$products = $prod->getAllItems($prod->getTableName());
echo json_encode($products);
