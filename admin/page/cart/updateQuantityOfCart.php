<?php
require_once('../../authentication/backend_authenticate.php');
require_once('../../classes/traits/ItemOperations.php');
require_once('../../classes/Database.php');
require_once('../../classes/Cart.php');

use Admin\Classes\Database;
use Admin\Classes\Cart;

session_start();
$db = new Database();
$cart = new Cart($db);
$cartId = $_POST["id"];
$change = $_POST["change"];
echo json_encode($cart->changeQuanityById($cartId, $change));
