<?php
require_once('../../classes/Authentication.php');
require_once('../../classes/Product.php');

use Classes\Product;
use Classes\Authentication;

Authentication::requirePostMethod();


$prod = new Product();
$response = [];
$name = $_POST['productName'] ?? null;
$image = $_FILES['image'] ?? null;
$category = $_POST['category'] ?? null;
$price = $_POST['price'] ?? null;
$description = $_POST['description'] ?? null;
$discount = $_POST['discount'] ?? null;

$errors = [];

if (empty($name)) {
    $errors['name'] = 'Product name is required.';
}

if (empty($category)) {
    $errors['category'] = 'Category is required.';
}

if (!filter_var($price, FILTER_VALIDATE_FLOAT) || $price < 0) {
    $errors['price'] = 'Please enter a valid positive price.';
}

if (!filter_var($discount, FILTER_VALIDATE_FLOAT) || $discount < 0 || $discount > 100) {
    $errors['discount'] = 'Discount must be a float between 0.00 and 100.00';
}

if (empty($description)) {
    $errors['description'] = 'Description is required.';
}

if (!empty($image['name'])) {
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $ext = strtolower(pathinfo($image["name"], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowedTypes)) {
        $errors['image'] = 'Only JPG, JPEG, PNG, GIF, or WEBP files are allowed.';
    }

    if ($image['size'] > 500 * 1024) { // 500 KB limit
        $errors['image'] = 'Image size should not exceed 500KB.';
    }
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

$imagePath = '';
if (!empty($image['name'])) {
    $fileName = $image["name"];
    $fileName = preg_replace('/\\.[^.\\s]{3,4}$/', '', $fileName);
    $ext = pathinfo($image["name"], PATHINFO_EXTENSION);
    $imageName = $fileName . time() . "." . $ext;
    $uploadDir = __DIR__ . '/../uploads/product-images';

    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $uploadFile = $uploadDir . '/' . $imageName;
    if (move_uploaded_file($image['tmp_name'], $uploadFile)) {
        $imagePath = '/admin/uploads/product-images/' . $imageName;
        $image['name'] = $imageName;
    }
}

try {
    $response['success'] = true;
    if (!empty($_POST['productId'])) {
        $oldProduct = $prod->getItemById($prod->getTableName(), $_POST['productId']);
        $response['result'] = $prod->editProduct($_POST['productId'], $name, $image, $category, $price, $description, $discount);
        if (!empty($image['name'])) {
            unlink($_SERVER['DOCUMENT_ROOT'] . $oldProduct['image_path']);
        }
        $response['message'] = "Successfully edited product $name";
    } else {
        $prod->addProduct($name, $imagePath, $category, $price, $description, $discount);
        $response['message'] = "Product '$name' added successfully.";
    }
} catch (Exception $e) {
    $response = [
        'success' => false,
        'message' => $name . " has not been " . (isset($_POST['id']) ? " edited" : " added"),
        'error' => 'server_error',
        'data' => ['details' => $e->getMessage()]
    ];
}

echo json_encode($response);
