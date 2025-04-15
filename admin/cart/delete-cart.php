<?php
require_once('../../classes/Authentication.php');
require_once('../../classes/Cart.php');

use Classes\Cart;
use Classes\Authentication;

Authentication::requirePostMethod();

header('Content-Type: application/json');
ob_clean();

$cart = new Cart();

// Validate input
if (!isset($_POST['id']) || empty($_POST['id'])) {
    echo json_encode([
        'success' => false,
        'error' => 'validation_error',
        'message' => 'Validation failed.',
        'data' => ['id' => 'Cart ID is required.']
    ]);
    exit;
}

try {
    $cartId = $_POST['id'];
    $cart->deleteItem($cart->getTableName(), "id", $cartId);

    echo json_encode([
        'success' => true,
        'message' => "Cart item deleted successfully."
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => 'server_error',
        'message' => 'An error occurred while deleting the cart item.',
        'data' => ['details' => $e->getMessage()]
    ]);
}
