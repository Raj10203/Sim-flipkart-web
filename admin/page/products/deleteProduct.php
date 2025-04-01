<?php
include_once('../../authentication/backend_authenticate.php');
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
    unlink("/var/www/html/flipkart/Sim-flipkart-web" . $oldProduct['image_path']);

    $response['result'] = $prod->deleteItem($prod->getTableName(), $_POST['id']);
    $response['message'] = "Successfully deleted category";
    $response['class'] = 'success';
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
    $response['message'] = " Error occured while deleting";
    $response['class'] = 'danger';
}
echo json_encode($response);
