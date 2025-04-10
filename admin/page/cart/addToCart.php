<?php

use Admin\Classes\Cart;

require_once('../../authentication/backend_authenticate.php');
require_once('../../classes/traits/ItemOperations.php');
require_once('../../classes/Database.php');
require_once('../../classes/Cart.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => false, "message" => "not_logged_in"]);
    exit;
}
$cart = new Cart();
$userId = $_SESSION['user_id'];
$productId = (int) $_POST['productId'];
$response = $cart->addToCart($userId, $productId);
echo json_encode($response);
