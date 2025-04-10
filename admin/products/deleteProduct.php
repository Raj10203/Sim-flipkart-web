<?php

use Classes\Product;

require_once('../../authentication/backend_authenticate.php');
require_once('../../classes/traits/ItemOperations.php');
require_once('../../classes/Database.php');
require_once('../../classes/Product.php');

$prod = new Product();
$response = [];

if (!isset($_POST['id'])) {
    echo json_encode([
        "message" => "Id is required",
        'class' => 'danger'
    ]);
    die;
}

try {
    $oldProduct = $prod->getItemById($prod->getTableName(), $_POST['id']);
    $response = [
        'result' => $prod->deleteItem($prod->getTableName(), "id", $_POST['id']),
        'message' => "Successfully deleted category",
        'class' => 'success'
    ];
    unlink($_SERVER['DOCUMENT_ROOT'] . $oldProduct['image_path']);
} catch (Exception $e) {
    $response = [
        'result' => $e->getMessage(),
        'message' => "Error occured while deleting",
        'class' => 'danger'
    ];
}
echo json_encode($response);
