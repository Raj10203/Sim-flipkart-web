<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
require_once('../vendor/autoload.php');
require_once('../admin/classes/traits/ItemOperations.php');
require_once('../admin/classes/Database.php');
require_once('../admin/classes/Order.php');
require_once('../admin/classes/Cart.php');
require_once('../admin/classes/OrderItems.php');

use Admin\Classes\Database;
use Admin\Classes\Order;
use Admin\Classes\OrderItems;
use Admin\Classes\Cart;
use \Stripe\Stripe;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "../../");
$dotenv->load();
if (!isset($_REQUEST['provider_session_id'])) {
    die();
}

$db = new Database;
$ord = new Order($db);
$oi = new OrderItems($db);
$cart = new Cart($db);

session_start();
$sessionId = $_REQUEST['provider_session_id'];
$stripe = new \Stripe\StripeClient($_ENV['STRIPE_SECRET_KEY']);
$session = $stripe->checkout->sessions->retrieve($sessionId);
$paymentid = $session->payment_intent;
echo '<pre>';
print_r($session);

$cartDetails = $_SESSION['cartDetails'];
$orderId = 0;
if (count($cartDetails) > 0) {
    $orderId  = $ord->addOrder($paymentid, $session->metadata->total_products, $session->amount_subtotal);
    foreach ($cartDetails as $item) {
        $finalPrice = $item['price'] - $item['price'] * $item['discount'] / 100;
        $oi->insertOrderItem($orderId, $item["productId"], $item['quantity'], $finalPrice);
    }
echo $cart->deleteItem($cart->getTableName(), 'user_id', $_SESSION['user_id']);
}
header("location: /payment-success?order_id=$orderId");