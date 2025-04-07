<?php

use Admin\Classes\Product;
use Admin\Classes\Cart;

require_once('../../authentication/backend_authenticate.php');
require_once('../../classes/traits/ItemOperations.php');
require_once('../../classes/Database.php');
require_once('../../classes/Cart.php');
require_once('../../classes/Product.php');
session_start();

$cart = new Cart();
$prod = new Product();
$userId = $_SESSION['user_id'];
$cartsByUserId = $cart->gettAllCartByUserId($userId);
$_SESSION['cartDetails'] = $cartsByUserId;
echo json_encode($cartsByUserId);
