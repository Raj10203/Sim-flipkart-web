<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
require_once('../vendor/autoload.php');
session_start();
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "../..");
$dotenv->load();
echo $_ENV['STRIPE_SECRET_KEY'];
$stripe = new \Stripe\StripeClient($_ENV['STRIPE_SECRET_KEY']);
$cartDetails = $_SESSION['cartDetails'];

$lineItems = [];

foreach ($cartDetails as $item) {
    $salePrice = $item['price'] - $item['price'] * $item['discount'] / 100;
    $lineItems[] = [
        'price_data' => [
            'currency' => 'inr',
            'product_data' => [
                'name' => $item['name'],
                'metadata' => [
                    'product_id' => $item['id'],
                    'original_price' => $item['price'],
                    'discount' => $item['discount'],
                    'discounted_price' => round($salePrice, 2)
                ],
            ],
            'unit_amount' => round($salePrice * 100), // Convert to cents
        ],
        'quantity' => $item['quantity'],
        'tax_rates' => [$_ENV["TAX_RATE_ID"]]
    ];
}

$checkoutSession = $stripe->checkout->sessions->create([
    'line_items' => $lineItems,
    'mode' => 'payment',
    'success_url' => 'http://flipkart-web.com/payment-success',
    'metadata' => [
        'user_id' => $_SESSION['user_id'],
        'total_products' => count($cartDetails)
    ],
]);

header('Content-Type: application/json');
header("HTTP/1.1 303 See Other");
header("Location: " . $checkoutSession->url);
exit;
