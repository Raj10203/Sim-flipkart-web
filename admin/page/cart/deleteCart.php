<?php

use Admin\Classes\Cart;

require_once('../../authentication/backend_authenticate.php');
require_once('../../classes/traits/ItemOperations.php');
require_once('../../classes/Database.php');
require_once('../../classes/Cart.php');
session_start();

$cart = new Cart();
$response = [];
if (!isset($_POST['id'])) {
    echo json_encode(["error" => "Id is required"]);
    exit;
}
try {
    $response['result'] = $cart->deleteItem($cart->getTableName(), "id",$_POST['id']);
    $response['message'] = "Successfully deleted category";
    $response['class'] = 'success';
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
    $response['message'] = " Error occured while deleting";
    $response['class'] = 'danger';
}
echo json_encode($response);
