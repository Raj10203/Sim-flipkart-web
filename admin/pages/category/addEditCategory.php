<?php
require_once('../../classes/Category.php');
require_once('../../classes/Database.php');
use Admin\Classes\Database;
use Admin\Classes\Category;
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
$db = new Database;
$category = new Category($db);

$response = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryName = $_POST['categoryName'] ?? '';
    $categoryDiscription = $_POST['categoryDescription'] ?? '';
    if (isset($_POST['id'])) {
        try {
        $response['result'] = $category->editCategory($_POST['id'], $categoryName, $categoryDiscription);
        $response['message'] = "Successfully edited category $categoryName";
        $response['class'] = 'success';
        } catch (Exception $e) {
            $response['result'] = false;
            $response['error'] = $e->getMessage();
            $response['message'] = $categoryName . " has not been edited";
            $response['class'] = 'danger';
        }
    } else {
        try {
            $response['result'] = $category->addCategory($categoryName, $categoryDiscription);
            $response['message'] = "Successfully added category $categoryName";
            $response['class'] = 'success';
        } catch (Exception $e) {
            $response['result'] = false;
            $response['error'] = $e->getMessage();
            $response['message'] = $categoryName . " has not been added";
            $response['class'] = 'danger';
        }
    }
    echo json_encode($response);
}
