<?php
include_once('../../authentication/backend_authenticate.php');
require_once('../../classes/Database.php');
require_once('../../classes/Product.php');
use Admin\Classes\Database;
use Admin\Classes\Product;

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
$db = new Database;
$product = new Product($db);

$response = [];

$name = $_POST['addProductName'] ?? '';
$image = $_FILES['addImage'] ?? [];
$category = $_POST['addCategory'] ?? '';
$price = $_POST['addPrice'] ?? '';
$disciption = $_POST['addDescription'] ?? '';
$imagePath = '';
if (!empty($image['name'])) {

    $uploadDir = '../../uploads/product-images';

    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $uploadFile = $uploadDir . '/' . basename($image['name']);
    if (move_uploaded_file($image['tmp_name'], $uploadFile)) {
        $imagePath = '/admin/uploads/product-images/' . basename($image['name']);
    }
}

try {
    if (isset($_POST['id'])) {
        $response['result'] = $product->editProduct($_POST['id'], $name, $image, $category, $price, $disciption);
        $response['message'] = "Successfully edited product $name";
    } else {
        $response['result'] = $product->addProduct($name, $imagePath, $category, $price, $disciption);
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
?>
