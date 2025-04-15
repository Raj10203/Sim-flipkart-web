<?php

use Classes\Product;

require_once('../../classes/Product.php');

$prod = new Product();
$products = $prod->getAllItems($prod->getTableName());
echo json_encode($products);
