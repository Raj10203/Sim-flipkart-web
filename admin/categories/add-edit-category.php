<?php
require_once('../../classes/Authentication.php');
require_once('../../classes/Category.php');

use Classes\Category;
use Classes\Authentication;

Authentication::requirePostMethod();
$category = new Category();

$categoryName = trim($_POST['categoryName'] ?? '');
$categoryDescription = trim($_POST['categoryDescription'] ?? '');

$errors = [];

if (empty($categoryName)) {
    $errors['categoryName'] = 'Category name is required.';
} elseif (strlen($categoryName) < 3) {
    $errors['categoryName'] = 'Category name must be at least 3 characters.';
}

if (empty($categoryDescription)) {
    $errors['categoryDescription'] = 'Category description is required.';
} elseif (strlen($categoryDescription) < 10) {
    $errors['categoryDescription'] = 'Category description must be at least 10 characters.';
}

if (!empty($errors)) {
    echo json_encode([
        'success' => false,
        'error' => 'validation_error',
        'message' => 'Validation failed.',
        'data' => $errors
    ]);
    exit;
}

try {
    if (!empty($_POST['categoryId'])) {
        $category->editCategory($_POST['categoryId'], $categoryName, $categoryDescription);
        echo json_encode([
            'success' => true,
            'message' => "Category '$categoryName' updated successfully."
        ]);
    } else {
        $category->addCategory($categoryName, $categoryDescription);
        echo json_encode([
            'success' => true,
            'message' => "Category '$categoryName' added successfully."
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => 'server_error',
        'message' => "An error occurred while processing the category.",
    ]);
}
