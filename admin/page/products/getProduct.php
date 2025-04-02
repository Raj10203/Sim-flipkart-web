<?php
require_once('../../classes/Database.php');
require_once('../../classes/Product.php');

use Admin\Classes\Database;
use Admin\Classes\Product;


$db = new Database;
$product = new Product($db);
$id = $_POST['id'];
echo json_encode($product->getItemById($product->getTableName(), $id));
