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
