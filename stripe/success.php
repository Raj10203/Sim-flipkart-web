<?php
require_once('../vendor/autoload.php');
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use \Stripe\Stripe;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "../../");
$dotenv->load();
if (!isset($_REQUEST['provider_session_id'])) {
    die();
}

session_start();
$sessionId = $_REQUEST['provider_session_id'];
$stripe = new \Stripe\StripeClient($_ENV['STRIPE_SECRET_KEY']);
$session = $stripe->checkout->sessions->retrieve($sessionId);
$paymentid = $session->payment_intent;
echo '<pre>';
print_r($session);

unset($_SESSION['cartDetails']);
header("location: /payment-success");
