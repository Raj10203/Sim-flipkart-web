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
if (!isset($_POST['id'])) {
    echo json_encode(["status" => false, "message" => "cart id required"]);
}
echo json_encode($cart->changeQuanityById($cartId, $change));
