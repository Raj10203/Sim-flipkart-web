<?php
require_once('../../classes/traits/ItemOperations.php');
require_once('../../classes/Authentication.php');
require_once('../../classes/Database.php');
require_once('../../classes/Cart.php');


use Classes\Cart;
use Classes\Authentication;

Authentication::requirePostMethod();
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => false, "message" => "not_logged_in"]);
    exit;
}
$cart = new Cart();
$userId = $_SESSION['user_id'];
$productId = (int) $_POST['productId'];
if (!isset($productId)) {
    echo json_encode(["status" => false, "message" => "product id required"]);
    exit;
}
$response = $cart->addToCart($userId, $productId);
echo json_encode($response);
