<?php
require_once('../../classes/traits/ItemOperations.php');
require_once('../../classes/Authentication.php');
require_once('../../classes/Database.php');
require_once('../../classes/Cart.php');

use Classes\Cart;
use Classes\Authentication;

Authentication::requirePostMethod();

$cart = new Cart();
$userId = $_SESSION['user_id'];
$productId = (int) $_POST['productId'] ?? null;

if (empty($productId)) {
    echo json_encode(["class" => 'error', "message" => "product id required"]);
    exit;
}

$response = $cart->addToCart($userId, $productId);
echo json_encode($response);
