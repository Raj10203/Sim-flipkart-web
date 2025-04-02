<?php
include_once('../../authentication/backend_authenticate.php');
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
