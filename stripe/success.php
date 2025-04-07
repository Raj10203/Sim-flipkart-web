<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
require_once('../vendor/autoload.php');

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

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();                                        
    $mail->Host       = 'smtp.gmail.com';                     
    $mail->SMTPAuth   = true;                                
    $mail->Username   = 'patilricky39@gmail.com';           
    $mail->Password   = $_ENV['APPPASSWORD'];                     
    $mail->SMTPSecure = 'tls';         
    $mail->Port       = 587;                                  

    $mail->setFrom('patilricky39@gmail.com', 'R Square Flipkart');
    $mail->addAddress($session->customer_details->email, name: $session->customer_details->name);     //Add a recipient

    $mail->isHTML(true);                                
    $mail->Subject = 'Here is the subject';
    $template = file_get_contents('template-email.html');
    $template = str_replace(
        ['{{total}}', '{{order_id}}', '{{order_link}}', '{{items}}', '{{year}}'],
        [, $session->amount_subtotal/100, $orderId, "http://43.204.102.223/", $items_html, date('Y')],
        $template
    );
    $mail->Body = $emailBody;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
unset($_SESSION['cartDetails']);
header("location: /payment-success");
