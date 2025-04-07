<?php
require_once('../../authentication/backend_authenticate.php');
require_once('../../classes/traits/ItemOperations.php');
require_once('../../classes/Database.php');
require_once('../../classes/Cart.php');

use Admin\Classes\Database;
use Admin\Classes\Cart;

session_start();

$db = new Database;
$cart = new Cart($db);

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
