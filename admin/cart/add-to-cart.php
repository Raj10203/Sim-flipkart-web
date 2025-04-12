<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);
require_once('../../classes/traits/ItemOperations.php');
require_once('../../classes/Authentication.php');
require_once('../../classes/Database.php');
require_once('../../classes/Cart.php');

use Classes\Cart;
use Classes\Authentication;

Authentication::requirePostMethod(false);

$cart = new Cart();
$userId = $_SESSION['user_id'] ?? null;
$productId = (int) $_POST['productId'] ?? null;

if (empty($userId)) {
    echo json_encode(["class" => 'error', "message" => "not_logged_in"]);
    exit;
}

if (empty($productId)) {
    echo json_encode(["class" => 'error', "message" => "product id required"]);
    exit;
}

$response = $cart->addToCart($userId, $productId);
echo json_encode($response);
