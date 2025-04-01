<?php
include_once('../../authentication/backend_authenticate.php');
include_once('../../classes/Database.php');
include_once('../../classes/Cart.php');
require_once('../../classes/Product.php');
use Admin\Classes\Product;
use Admin\Classes\Database;
use Admin\Classes\Cart;

$db = new Database;
$cart = new Cart($db);
$prod = new Product($db);
$userId = $_SESSION['user_id'];
$cartsByUserId = $cart->gettAllCartByUserId($userId);
echo json_encode($cartsByUserId);