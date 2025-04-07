<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once('../vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable('/var/www/projects/Sim-flipkart-web/');
$dotenv->load();
// Stripe API key
\Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

// Read the incoming payload
$event = null;

// This is your endpoint's secret key (use the one from your dashboard)
$endpoint_secret = 'whsec_5PxfM4GOceW4l3U85XLt6JefLcXg1rnG';
$input = @file_get_contents("php://input");
// Log the raw input and signature for debugging purposes
file_put_contents('webhook_log.txt', "Input: " . $input . "\n", FILE_APPEND);
file_put_contents('webhook_log.txt', "Signature: " . $_SERVER['HTTP_STRIPE_SIGNATURE'] . "\n", FILE_APPEND);

try {
    // Verify the webhook signature
    $event = \Stripe\Webhook::constructEvent(
        $input,
        $_SERVER['HTTP_STRIPE_SIGNATURE'],
        $endpoint_secret
    );
} catch (\UnexpectedValueException $e) {
    // Invalid payload
    http_response_code(400);
    exit();
} catch (\Stripe\Exception\SignatureVerificationException $e) {
    // Invalid signature
    http_response_code(404);
    exit();
}

// Handle the payment success event
if ($event->type == 'checkout.session.completed') {
    try {
        // Prepare the data to be saved to the JSON file
        $data = [
            'timestamp' => date('Y-m-d H:i:s'),
            'event_type' => $event->type,
            'event_data' => $event->data->object // This contains the payment data
        ];

        // Specify the file where the event data will be stored
        $file = 'webhook_data.json';

        // Open the file in append mode, or create it if it doesn't exist
        $fileHandle = fopen($file, 'a');

        if ($fileHandle) {
            // Write the data to the file with a timestamp for reference
            fwrite($fileHandle, json_encode($data, JSON_PRETTY_PRINT) . PHP_EOL);
            fclose($fileHandle);
            echo 'Webhook data has been saved to the file.';
        } else {
            echo 'Unable to open file to write data.';
        }

    } catch (Exception $e) {
        // Handle exceptions if any occur while saving the data
        echo 'Error saving webhook data: ' . $e->getMessage();
    }

    // Respond with a success message to Stripe
    http_response_code(200);
} else {
    // Unexpected event type
    http_response_code(400);
    exit();
}
