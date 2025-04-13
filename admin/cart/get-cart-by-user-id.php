<?php
require_once('../../classes/Authentication.php');
require_once('../../classes/Product.php');
require_once('../../classes/Cart.php');

use Classes\Cart;
use Classes\Authentication;

Authentication::requirePostMethod();

$cart = new Cart();
$userId = $_SESSION['user_id'];
$cartsByUserId = $cart->gettAllCartByUserId($userId);
$_SESSION['cartDetails'] = $cartsByUserId;
echo json_encode($cartsByUserId);
