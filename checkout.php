<?php
require_once('conf/stripeConf.php');
require_once('stripe-php-17.0.0/init.php');
session_start();

$stripe = new \Stripe\StripeClient(STRIPE_SECRET_KEY);
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
        'tax_rates' => [TAX_RATE_ID]
    ];
}


$checkoutSession = $stripe->checkout->sessions->create([
    'line_items' => $lineItems,
    'mode' => 'payment',
    'success_url' => 'http://flipkart-web.com/success?provider_session_id={CHECKOUT_SESSION_ID}',
    'cancel_url' => 'http://flipkart-web.com/cart?provider_session_id={CHECKOUT_SESSION_ID}',
    'metadata' => [
        'user_id' => $_SESSION['user_id']
    ],
]);

header('Content-Type: application/json');
header("HTTP/1.1 303 See Other");
header("Location: " . $checkoutSession->url);
exit;
