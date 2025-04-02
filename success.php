<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
require_once('conf/stripeConf.php');
require_once('stripe-php-17.0.0/init.php');
require_once('./admin/classes/traits/ItemOperations.php');
require_once('./admin/classes/Database.php');
require_once('./admin/classes/Order.php');
require_once('./admin/classes/OrderItems.php');
require_once('./admin/classes/Cart.php');

use Admin\Classes\Database;
use Admin\Classes\Order;
use Admin\Classes\OrderItems;
use Admin\Classes\Cart;
use \Stripe\Stripe;

if (!isset($_REQUEST['provider_session_id'])) {
    die();
}

$db = new Database;
$ord = new Order($db);
$oi = new OrderItems($db);
$cart = new Cart($db);

session_start();
$sessionId = $_REQUEST['provider_session_id'];
$stripe = new \Stripe\StripeClient(STRIPE_SECRET_KEY);
$session = $stripe->checkout->sessions->retrieve($sessionId);
$paymentid = $session->payment_intent;

$cartDetails = $_SESSION['cartDetails'];
$totalPrice = 0;
if(count($cartDetails)> 0){
    $orderId  = $ord->addOrder($paymentid);
    $orderId = 1;
    foreach ($cartDetails as $item) {
        $finalPrice = $item['price'] - $item['price'] * $item['discount'] / 100;
        $oi->insertOrderItem($orderId,$item["productId"],$item['quantity'],$finalPrice);
    }
    $cart->deleteItem($cart->getTableName(),'user_id',$_SESSION['user_id']);
} else {
    echo "Cart Is empty";
}
echo  $orderId;
