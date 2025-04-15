<?php
require_once('../../classes/Category.php');
require_once('../../classes/Authentication.php');

use Classes\Category;
use Classes\Authentication;

Authentication::requirePostMethod();

$cat = new Category();

if (!isset($_POST['id'])) {
    echo json_encode([
        'success' => false,
        'error' => 'validation_error',
        'message' => 'ID is required to fetch category.',
        'data' => ['id' => 'Category ID is missing.'],
    ]);
    exit;
}

try {
    $category = $cat->getItemById($cat->getTableName(), $_POST['id']);

    if (!$category) {
        echo json_encode([
            'success' => false,
            'error' => 'not_found',
            'message' => 'Category not found.',
        ]);
    } else {
        echo json_encode([
            'success' => true,
            'data' => $category,
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => 'server_error',
        'message' => 'An error occurred while fetching the category.',
    ]);
}
