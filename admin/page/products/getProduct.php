<?php

use Admin\Classes\Product;

require_once('../../classes/traits/ItemOperations.php');
require_once('../../classes/Database.php');
require_once('../../classes/Product.php');

$product = new Product();
$id = $_POST['id'];
echo json_encode($product->getItemById($product->getTableName(), $id));
