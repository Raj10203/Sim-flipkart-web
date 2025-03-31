<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
// include_once('../../authentication/backend_authenticate.php');
include_once('../../classes/Database.php');
include_once('../../classes/Cart.php');
require_once('../../classes/Product.php');
use Admin\Classes\Product;
use Admin\Classes\Database;
use Admin\Classes\Cart;

session_start();

if (!isset($_SESSION['id'])) {
    echo json_encode(["status" => false, "message" => "not_logged_in"]);
    exit;
}
$db = new Database;
$cart = new Cart($db);
$prod = new Product($db);
$userId = $_SESSION['id'];
$cartsByUserId = $cart->gettAllCartByUserId( $userId );
echo json_encode($cartsByUserId);