<?php
require_once('../../classes/Authentication.php');
require_once('../../classes/Category.php');

use Classes\Category;
use Classes\Authentication;

Authentication::requirePostMethod();

$category = new Category();

if (!isset($_POST['id'])) {
    echo json_encode([
        'success' => false,
        'error' => 'validation_error',
        'message' => 'ID is required to delete category.',
        'data' => ['id' => 'Category ID is missing.'],
    ]);
    exit;
}

try {
    $category->deleteItem($category->getTableName(), "id", $_POST['id']);
    echo json_encode([
        'success' => true,
        'message' => 'Successfully deleted category.',
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => 'server_error',
        'message' => 'An error occurred while deleting the category.',
    ]);
}
