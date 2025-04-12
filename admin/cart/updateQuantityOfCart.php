<?php
require_once('../../classes/Authentication.php');
require_once('../../classes/traits/ItemOperations.php');
require_once('../../classes/Database.php');
require_once('../../classes/Cart.php');

use Classes\Cart;
use Classes\Authentication;

Authentication::requirePostMethod();

$cart = new Cart();
$cartId = $_POST["id"] ?? null;
$change = $_POST["change"] ?? null;

$errors = [];
if (empty($cartId)) {
    $errors['cartId'] = 'cartId is required.';
} 

if (empty($change)) {
    $errors['change'] = 'update quantity is required.';
} 
echo json_encode($cart->changeQuanityById($cartId, $change));
