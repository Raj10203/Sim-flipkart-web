<?php

use Classes\Order;
use Classes\OrderItems;
use Classes\Cart;

use function PHPSTORM_META\type;

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

        $stripe = new \Stripe\StripeClient($_ENV['STRIPE_SECRET_KEY']);
        $session = $stripe->checkout->sessions->retrieve($sessionId);
        $lineItems = $stripe->checkout->sessions->allLineItems(
            $sessionId,
            ['expand' => ['data.price.product']]
        );
        $data['session'] = $session;
        $data['lineItems'] = $lineItems['data'];
        if (count($lineItems['data']) > 0) {
            $orderId = $ord->addOrder($paymentid, $userId, $eventData->metadata->total_products, $eventData->amount_total);
            $data['orderId'] = $orderId;
            foreach ($lineItems['data'] as $lineItem) {
                $productMeta = $lineItem['price']['product']['metadata'] ?? [];

                $productId = $productMeta['product_id'] ?? null;
                // $productName = $lineItem['description'];
                // $productImage = $productMeta['image_path'] ?? null;
                // $originalPrice = $productMeta['original_price'] ?? null;
                // $discountPercent = $productMeta['discount'] ?? null;
                // $discountedUnitPrice = $productMeta['discounted_price'] ?? null;

                $quantity = $lineItem['quantity'];
                $totalAmount = $lineItem['amount_total'] / 100;
                // $taxAmount = $lineItem['amount_tax'] / 100;

                $oi->insertOrderItem($orderId, $productId, $quantity, $totalAmount);
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
