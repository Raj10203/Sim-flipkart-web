<?php

require_once('../../classes/Product.php');
require_once('../../classes/Authentication.php');

use Classes\Product;
use Classes\Authentication;

Authentication::requirePostMethod();
$product = new Product();
$id = $_POST['id'] ?? null;

if (!isset($_POST['id'])) {
    echo json_encode([
        'success' => false,
        'error' => 'validation_error',
        'message' => 'Validation failed.',
        'data' => ['details' => 'Product Id is required to get product']
    ]);
    die;
}

try {
    $data = $product->getItemById($product->getTableName(), $id);
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
