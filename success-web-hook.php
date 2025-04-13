<?php

use Classes\Order;
use Classes\OrderItems;
use Classes\Cart;

require_once('vendor/autoload.php');
require_once('classes/traits/ItemOperations.php');
require_once('classes/Database.php');
require_once('classes/Order.php');
require_once('classes/Product.php');
require_once('classes/Cart.php');
require_once('classes/OrderItems.php');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

\Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

$event = null;
$endpoint_secret = $_ENV['WEBHOOKKEY'];
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

        $ord = new Order();
        $oi = new OrderItems();
        $cart = new Cart();

        $eventData = $data['event_data'];
        $sessionId = $eventData->id;
        $paymentid = $eventData->payment_intent;
        $userId = $eventData->metadata->user_id;
        $cartDetails = $cart->gettAllCartByUserId($userId);

        $emailItems = '';
        $data['cartDetails'] = $cartDetails;
        $stripe = new \Stripe\StripeClient($_ENV['STRIPE_SECRET_KEY']);
        $session = $stripe->checkout->sessions->retrieve($sessionId);
        $lineTesms = $stripe->checkout->sessions->allLineItems(
            $sessionId,
            []
        );
        $data['session'] = $session;
        $data['lineItems'] = $lineTesms;
        if (count($cartDetails) > 0) {
            $orderId = $ord->addOrder($paymentid, $userId, $eventData->metadata->total_products, $eventData->amount_subtotal);
            $data['orderId'] = $orderId;

            foreach ($cartDetails as $index => $item) {
                $lineItem = $lineItems['data'][$index];
                $actualAmount = $lineItem['amount_total'] / 100;

                $oi->insertOrderItem($orderId, $item["productId"], $item['quantity'], $actualAmount);
                $emailItems .= '<div class="item">
                    <img src="' . $item['image_path'] . '" alt="' . htmlspecialchars($item['name']) . '">
                    <div class="item-details">
                        <h4>' . htmlspecialchars($item['name']) . '</h4>
                        <p>Quantity: ' . $item['quantity'] . '</p>
                        <p>Total: ₹' . number_format($actualAmount, 2) . '</p>
                    </div>
                </div>';
            }
            $cart->deleteItem($cart->getTableName(), "user_id", $eventData->metadata->user_id);
        }
        file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT) . PHP_EOL, FILE_APPEND);
    } catch (Exception $e) {
        $errorData = [
            'timestamp' => date('Y-m-d H:i:s'),
            'error_message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ];
        $errorFile = 'webhook_errors.log';
        file_put_contents($errorFile, json_encode($errorData, JSON_PRETTY_PRINT) . PHP_EOL, FILE_APPEND);
    }
    http_response_code(200); // Must respond to Stripe with 200
} else {
    http_response_code(400);
    exit();
}
