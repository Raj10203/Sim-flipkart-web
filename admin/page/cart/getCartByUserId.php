<?php
require_once('../../authentication/backend_authenticate.php');
require_once('../../classes/traits/ItemOperations.php');
require_once('../../classes/Database.php');
require_once('../../classes/Cart.php');
require_once('../../classes/Product.php');

use Admin\Classes\Product;
use Admin\Classes\Database;
use Admin\Classes\Cart;

session_start();
$db = new Database;
$cart = new Cart($db);
$prod = new Product($db);
$userId = $_SESSION['user_id'];
$cartsByUserId = $cart->gettAllCartByUserId($userId);
$_SESSION['cartDetails'] = $cartsByUserId;
echo json_encode($cartsByUserId);
