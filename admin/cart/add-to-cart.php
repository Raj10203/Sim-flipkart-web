<?php
require_once('../../classes/Authentication.php');
require_once('../../classes/Cart.php');

use Classes\Cart;
use Classes\Authentication;

Authentication::requirePostMethod();

$cart = new Cart();
$userId = $_SESSION['user_id'];
$productId = $_POST['productId'] ?? null;
$errors = [];

if (empty($userId)) {
    $errors['user'] = 'User not logged in.';
}

if (empty($productId)) {
    $errors['productId'] = 'Product ID is required.';
}

if (!empty($errors)) {
    echo json_encode([
        'success' => false,
        'error' => 'validation_error',
        'message' => 'Validation failed.',
        'data' => $errors
    ]);
    exit;
}

try {
    $result = $cart->addToCart($userId, $productId);

    if ($result['success']) {
        echo json_encode([
            'success' => true,
            'message' => $result['updated'] 
            ? 'Product quantity updated in cart.'
            : 'Product added to cart.',
            'class' => 'success'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to add product to cart.',
            'class' => 'danger',
            'error' => 'db_error'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Server error occurred.',
        'error' => 'server_error',
        'data' => ['details' => $e->getMessage()],
        'class' => 'danger'
    ]);
}
