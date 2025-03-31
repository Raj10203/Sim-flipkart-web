<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
// include_once('../../authentication/backend_authenticate.php');
include_once('../../classes/Database.php');
include_once('../../classes/Cart.php');
use Admin\Classes\Database;
use Admin\Classes\Cart;
session_start();
$db = new Database();
$cart = new Cart($db);


$cartId = $_POST["id"];
$change = $_POST["change"];

echo json_encode($cart->changeQuanityById($cartId, $change));