<?php
require_once('../../classes/Authentication.php');
require_once('../../classes/Cart.php');

use Classes\Cart;
use Classes\Authentication;

Authentication::requirePostMethod();

$cart = new Cart();
$cartId = $_POST["id"] ?? null;
$change = $_POST["change"] ?? null;

$errors = [];
if (empty($cartId)) {
    $errors['cartId'] = 'cartId is required.';
}

if (empty($change)) {
    $errors['change'] = 'update quantity is required.';
}

if(!empty($errors)) {
    echo json_encode(
        [
            'success' => false,
            'message' => "Error Occured!",
            'error' => 'validation_error',
            'data' => $errors
        ]
    );
}

try {
    $data = $cart->changeQuanityById($cartId, $change);
    echo json_encode(
        [
            'success' => true,
            'message' => null,
            'data' => $data,
        ]
    );
} catch (Exception $e) {
    echo json_encode(
        [
            'success' => false,
            'message' => "Error Occured!",
            'error' => 'server_error',
            'data' => ['details' => $e->getMessage()]
        ]
    );
}
