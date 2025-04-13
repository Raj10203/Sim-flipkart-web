<?php
require_once('../../classes/Authentication.php');
require_once('../../classes/Cart.php');

use Classes\Cart;
use Classes\Authentication;

Authentication::requirePostMethod();

$cart = new Cart();
$response = [];
if (!isset($_POST['id'])) {
    echo json_encode(["error" => "Id is required"]);
    exit;
}

try {
    $response = [
        'result' => $cart->deleteItem($cart->getTableName(), "id", $_POST['id']),
        'message' => "Successfully deleted category",
        'class' => 'success'
    ];
} catch (Exception $e) {
    $response = [
        'error' => $e->getMessage(),
        'message' => " Error occured while deleting",
        'class' => 'danger'
    ];
}
echo json_encode($response);
