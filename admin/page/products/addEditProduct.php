<?php
include_once('../../authentication/backend_authenticate.php');
require_once('../../classes/Database.php');
require_once('../../classes/Product.php');
use Admin\Classes\Database;
use Admin\Classes\Product;


$db = new Database;
$product = new Product($db);

$response = [];

$name = $_POST['productName'] ?? '';
$image = $_FILES['image'] ?? [];
$category = $_POST['category'] ?? '';
$price = $_POST['price'] ?? '';
$disciption = $_POST['description'] ?? '';
$discount = $_POST['discount'] ?? 0;

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
        $response['result'] = $product->editProduct($_POST['id'], $name, $image, $category, $price, $disciption, $discount);
        $response['message'] = "Successfully edited product $name";
    } else {
        $response['result'] = $product->addProduct($name, $imagePath, $category, $price, $disciption, $discount);
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
