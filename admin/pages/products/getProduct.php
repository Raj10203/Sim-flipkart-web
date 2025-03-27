<?php
require_once('../../classes/Product.php');
require_once('../../classes/Database.php');
use Admin\Classes\Database;
use Admin\Classes\Product;
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$db = new Database;
$product = new Product($db);
$id = $_POST['id'];
echo json_encode($product->getProductById($id));