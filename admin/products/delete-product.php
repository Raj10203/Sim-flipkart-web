<?php
require_once('../../classes/Authentication.php');
require_once('../../classes/Product.php');

use Classes\Product;
use Classes\Authentication;

Authentication::requirePostMethod();

$prod = new Product();
$response = [];

if (!isset($_POST['id'])) {
    echo json_encode([
        'success' => false,
        'error' => 'validation_error',
        'message' => 'Product Id is required.',
    ]);
    die;
}

try {
    $oldProduct = $prod->getItemById($prod->getTableName(), $_POST['id']);
    $prod->deleteItem($prod->getTableName(), "id", $_POST['id']);
    $response = [
        'success' => true,
        'message' => "Successfully deleted product",
    ];
    unlink($_SERVER['DOCUMENT_ROOT'] . $oldProduct['image_path']);
} catch (Exception $e) {
    $response = [
        'success' => false,
        'message' => "Error occured while deleting",
        'error' => 'server_error',
        'data' => ['details' => $e->getMessage()]
    ];
}
echo json_encode($response);
