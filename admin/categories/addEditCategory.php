<?php

use Classes\Category;

require_once('../../authentication/backend_authenticate.php');
require_once('../../classes/traits/ItemOperations.php');
require_once('../../classes/Database.php');
require_once('../../classes/Category.php');

$category = new Category();
$response = [];
$categoryName = trim($_POST['categoryName'] ?? null);
$categoryDescription = trim($_POST['categoryDescription'] ?? null);

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
        'result' => false,
        'errors' => $errors,
        'class' => 'danger',
        'message' => 'Validation failed. Please check your input.'
    ]);
    exit;
}

try {
    if (!empty($_POST['categoryId'])) {
        $response = [
            'result' => $category->editCategory($_POST['categoryId'], $categoryName, $categoryDescription),
            'message' => "Successfully edited category $categoryName"
        ];
    } else {
        $response = [
            'result' => $category->addCategory($categoryName, $categoryDescription),
            'message' => "Successfully added category $categoryName"
        ];
    }
    $response['class'] = 'success';
} catch (Exception $e) {
    $response = [
        'result' => false,
        'error' => $e->getMessage(),
        'message' => $categoryName . " has not been " . (isset($_POST['id']) ? " edited" : " added") . $e->getMessage(),
        'class' => 'danger'
    ];
}

echo json_encode($response);
