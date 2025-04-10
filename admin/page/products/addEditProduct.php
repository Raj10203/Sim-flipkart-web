<?php

use Admin\Classes\Product;

require_once('../../authentication/backend_authenticate.php');
require_once('../../classes/traits/ItemOperations.php');
require_once('../../classes/Database.php');
require_once('../../classes/Product.php');

$prod = new Product();
$response = [];
$name = $_POST['productName'] ?? '';
$image = $_FILES['image'] ?? [];
$category = $_POST['category'] ?? '';
$price = $_POST['price'] ?? '';
$disciption = $_POST['description'] ?? '';
$discount = $_POST['discount'] ?? 0;

$imagePath = '';
if (!empty($image['name'])) {
    $fileName = $image["name"];
    $fileName = preg_replace('/\\.[^.\\s]{3,4}$/', '', $fileName);
    $ext = pathinfo($image["name"], PATHINFO_EXTENSION);
    $imageName = $fileName . time() . "." . $ext;
    $uploadDir = '../../uploads/product-images';

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
    if (isset($_POST['id'])) {
        $oldProduct = $prod->getItemById($prod->getTableName(), $_POST['id']);
        $response['result'] = $prod->editProduct($_POST['id'], $name, $image, $category, $price, $disciption, $discount);
        unlink($_SERVER['DOCUMENT_ROOT']. $oldProduct['image_path']);
        $response['message'] = "Successfully edited product $name";
    } else {
        $response['result'] = $prod->addProduct($name, $imagePath, $category, $price, $disciption, $discount);
        $response['message'] = "Successfully added product $name";
    }
    $response['class'] = 'success';
} catch (Exception $e) {
    $response['result'] = false;
    $response['error'] = $e->getMessage();
    $response['message'] = $name . " has not been " . (isset($_POST['id']) ? " edited" : " added");
    $response['class'] = 'danger';
}

echo json_encode($response);
