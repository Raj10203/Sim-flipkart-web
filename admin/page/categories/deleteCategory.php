<?php
include_once('../../authentication/backend_authenticate.php');
require_once('../../classes/traits/ItemOperations.php');
require_once('../../classes/Database.php');
require_once('../../classes/Category.php');

use Admin\Classes\Database;
use Admin\Classes\Category;

$db = new Database;
$category = new Category($db);
$response = [];
if (!isset($_POST['id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Id is required"]);
    die;
}
try {
    $response['result'] = $category->deleteItem($category->getTableName(), "id", $_POST['id']);
    $response['message'] = "Successfully deleted category";
    $response['class'] = 'success';
} catch (Exception $e) {
    http_response_code(500);
    $response['error'] = $e->getMessage();
    $response['message'] = " Error occured while deleting";
    $response['class'] = 'danger';
}
echo json_encode($response);
