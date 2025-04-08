<?php

use Classes\Cart;

require_once('../../authentication/backend_authenticate.php');
require_once('../../classes/traits/ItemOperations.php');
require_once('../../classes/Database.php');
require_once('../../classes/Cart.php');
session_start();

$cart = new Cart();
$cartId = $_POST["id"];
$change = $_POST["change"];
echo json_encode($cart->changeQuanityById($cartId, $change));
