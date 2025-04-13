<?php
require_once('../../classes/Authentication.php');
require_once('../../classes/Category.php');

use Classes\Category;
use Classes\Authentication;

Authentication::requirePostMethod();

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
    $response = [
        'result' => $category->deleteItem($category->getTableName(), "id", $_POST['id']),
        'message' => "Successfully deleted category",
        'class' => 'success'
    ];
} catch (Exception $e) {
    $response = [
        'error' => $e->getMessage(),
        'message' => " Error occured while deleting",
        'class' => 'danger'
    ];
}
echo json_encode($response);
