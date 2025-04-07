<?php
require_once('../../authentication/backend_authenticate.php');
require_once('../../classes/traits/ItemOperations.php');
require_once('../../classes/Database.php');
require_once('../../classes/Product.php');

use Admin\Classes\Database;
use Admin\Classes\Product;

$db = new Database;
$prod = new Product($db);
$response = [];
if (!isset($_POST['id'])) {
    echo json_encode(["error" => "Id is required"]);
    die;
}
try {
    $oldProduct = $prod->getItemById($prod->getTableName(), $_POST['id']);
    
    $response['result'] = $prod->deleteItem($prod->getTableName(), "id", $_POST['id']);
    unlink($_SERVER['DOCUMENT_ROOT'] . $oldProduct['image_path']);
    $response['message'] = "Successfully deleted category";
    $response['class'] = 'success';
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
    $response['message'] = " Error occured while deleting";
    $response['class'] = 'danger';
}
echo json_encode($response);
