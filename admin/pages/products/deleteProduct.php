<?php
include_once('../../conf/backend_authenticate.php');
require_once('../../classes/Database.php');
require_once('../../classes/Product.php');

use Admin\Classes\Database;
use Admin\Classes\Product;

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
$db = new Database;
$product = new Product($db);
$response = [];
if (!isset($_POST['id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Id is required"]);
    die;
}
try {
    $response['result'] = $product->deleteItem($product->getTableName(),$_POST['id']);
    $response['message'] = "Successfully deleted category";
    $response['class'] = 'success';
} catch (Exception $e) {
    http_response_code(500);
    $response['error'] = $e->getMessage();
    $response['message'] = " Error occured while deleting";
    $response['class'] = 'danger';
}
echo json_encode($response);
