<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
require_once('../../classes/Authentication.php');
require_once('../../classes/traits/ItemOperations.php');
require_once('../../classes/Database.php');
require_once('../../classes/Product.php');
require_once('../../classes/Cart.php');

use Classes\Cart;
use Classes\Authentication;

Authentication::requirePostMethod();
session_start();

$cart = new Cart();
$userId = $_SESSION['user_id'];
$cartsByUserId = $cart->gettAllCartByUserId($userId);
$_SESSION['cartDetails'] = $cartsByUserId;
echo json_encode($cartsByUserId);
