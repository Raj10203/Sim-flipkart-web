<?php
include_once('../../authentication/backend_authenticate.php');
include_once('../../classes/Database.php');
include_once('../../classes/Cart.php');

use Admin\Classes\Database;
use Admin\Classes\Cart;

session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => false, "message" => "not_logged_in"]);
    exit;
}
$db = new Database;
$cart = new Cart($db);

$userId = $_SESSION['user_id'];
$productId = (int) $_POST['productId'];
$response = $cart->addToCart($userId, $productId);
echo json_encode($response);
