<?php

use Classes\Category;

require_once('../../authentication/backend_authenticate.php');
require_once('../../classes/traits/ItemOperations.php');
require_once('../../classes/Database.php');
require_once('../../classes/Category.php');

$category = new Category();
$response = [];
if (!isset($_POST['id'])) {
    echo json_encode([
        "error" => "Id is required",
        "message" => 'id is required to delete category'
    ]);
    die;
}

try {
    $response['result'] = $category->deleteItem($category->getTableName(), "id", $_POST['id']);
    $response['message'] = "Successfully deleted category";
    $response['class'] = 'success';
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
    $response['message'] = " Error occured while deleting";
    $response['class'] = 'danger';
}
echo json_encode($response);
