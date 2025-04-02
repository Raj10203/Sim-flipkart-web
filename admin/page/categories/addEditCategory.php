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
$categoryName = $_POST['categoryName'] ?? '';
$categoryDiscription = $_POST['categoryDescription'] ?? '';
try {
    if (isset($_POST['id'])) {
        $response['result'] = $category->editCategory($_POST['id'], $categoryName, $categoryDiscription);
        $response['message'] = "Successfully edited category $categoryName";
    } else {
        $response['result'] = $category->addCategory($categoryName, $categoryDiscription);
        $response['message'] = "Successfully added category $categoryName";
    }
    $response['class'] = 'success';
} catch (Exception $e) {
    $response['result'] = false;
    $response['error'] = $e->getMessage();
    $response['message'] = $categoryName . " has not been " . isset($_POST['id']) ? " edited" : " added";
    $response['class'] = 'danger';
}


echo json_encode($response);
