<?php
use Admin\Classes\Database;
use Admin\Classes\Order;
use Admin\Classes\OrderItems;
use Admin\Classes\Cart;

require_once('vendor/autoload.php');
require_once('admin/classes/traits/ItemOperations.php');
require_once('admin/classes/Database.php');
require_once('admin/classes/Order.php');
require_once('admin/classes/Product.php');
require_once('admin/classes/Cart.php');
require_once('admin/classes/OrderItems.php');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

\Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

$event = null;
$endpoint_secret = 'whsec_5PxfM4GOceW4l3U85XLt6JefLcXg1rnG';
$input = @file_get_contents("php://input");
try {
    $event = \Stripe\Webhook::constructEvent(
        $input,
        $_SERVER['HTTP_STRIPE_SIGNATURE'],
        $endpoint_secret
    );
} catch (\UnexpectedValueException $e) {
    http_response_code(400);
    exit();
} catch (\Stripe\Exception\SignatureVerificationException $e) {
    http_response_code(404);
    exit();
}

if ($event->type == 'checkout.session.completed') {
    try {
        $data = [
            'timestamp' => date('Y-m-d H:i:s'),
            'event_type' => $event->type,
            'event_data' => $event->data->object
        ];
        $file = 'webhook_data.json';
        $db = new Database;
        $ord = new Order($db);
        $oi = new OrderItems($db);
        $cart = new Cart($db);
        $eventData = $data['event_data'];
        $paymentid = $eventData->payment_intent;
        $cartDetails = $cart->gettAllCartByUserId(4);
        $data['cartDetails'] = $cartDetails;
        $fileHandle = fopen($file, 'a');

        if (count($cartDetails) > 0) {
            $data['inputsForOrder'] = [$paymentid, $eventData->metadata->user_id, $eventData->metadata->total_products, $eventData->amount_subtotal];
            $orderId = $ord->addOrder($paymentid, $eventData->metadata->user_id, $eventData->metadata->total_products, $eventData->amount_subtotal);
            $data['orderId'] = $orderId;
            foreach ($cartDetails as $item) {
                $finalPrice = $item['price'] - $item['price'] * $item['discount'] / 100;
                $oi->insertOrderItem($orderId, $item["productId"], $item['quantity'], $finalPrice);
                $emailItems .= '<div class="item">
                     <img src="' . $item['image_path'] . '" alt="{{name}}">
                     <div class="item-details">
                     <h4>' . $item['name'] . '</h4>
                     <p>Quantity: ' . $item['quantity'] . '</p>
                     <p>Price:  ₹' . $item['price'] . '</p>
                     </div>
                 </div>';
            }
        }
    } catch (Exception $e) {
        $errorData = [
            'timestamp' => date('Y-m-d H:i:s'),
            'error_message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ];
        $errorFile = 'webhook_errors.log';
        file_put_contents($errorFile, json_encode($errorData, JSON_PRETTY_PRINT) . PHP_EOL, FILE_APPEND);

        echo 'An error occurred while processing the webhook.';
    }
    http_response_code(200);
} else {
    http_response_code(400);
    exit();
}
