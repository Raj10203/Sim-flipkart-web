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
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

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
$totalprice = 0;
$emailItems = "";
if (count($cartDetails) > 0) {
    $orderId  = $ord->addOrder($paymentid, $session->metadata->total_products, $session->amount_subtotal);
    foreach ($cartDetails as $item) {
        $finalPrice = $item['price'] - $item['price'] * $item['discount'] / 100;
        $oi->insertOrderItem($orderId, $item["productId"], $item['quantity'], $finalPrice);
        $emailItems .= '<div class="item">
        <img src="'.$item['image_path'] .'" alt="{{name}}">
        <div class="item-details">
        <h4>' . $item['name'] . '</h4>
        <p>Quantity: ' . $item['quantity'] . '</p>
        <p>Price:  ₹' . $item['price'] . '</p>
        </div>
    </div>';
}
    }
echo $cart->deleteItem($cart->getTableName(), 'user_id', $_SESSION['user_id']);


$mail = new PHPMailer(true);

try {
    $mail->isSMTP();                                        
    $mail->Host       = 'smtp.gmail.com';                     
    $mail->SMTPAuth   = true;                                
    $mail->Username   = 'patilricky39@gmail.com';           
    $mail->Password   = $_ENV['APPPASSWORD'];                     
    $mail->SMTPSecure = 'tls';         
    $mail->Port       = 587;                                  

    //Recipients
    $mail->setFrom('patilricky39@gmail.com', 'PHP Developer');
    $mail->addAddress('hiteshmarvadi39@gmail.com', 'Hitesh Marvadi');     //Add a recipient
    // $mail->addAddress('ellen@example.com');               //Name is optional
    $mail->addReplyTo('patilricky39@gmail.com', 'PHP Developer');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    

    //Content
    $mail->isHTML(true);                                
    $mail->Subject = 'Here is the subject';
    $emailBody = '<!DOCTYPE html>
        <html>
        <head>
        <meta charset="UTF-8">
        <title>Payment Successful</title>
        <style>
            body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            }
            .email-container {
            max-width: 600px;
            background-color: #ffffff;
            margin: 30px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }
            .header {
            text-align: center;
            background-color: rgb(76, 99, 175);
            color: white;
            padding: 20px 0;
            border-radius: 8px 8px 0 0;
            }
            .content {
            padding: 20px;
            color: #333;
            }
            .item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            }
            .item img {
            max-width: 80px;
            max-height: 80px;
            margin-right: 15px;
            border-radius: 6px;
            }
            .item-details {
            flex: 1;
            }
            .item-details h4 {
            margin: 0 0 5px 0;
            font-size: 16px;
            }
            .item-details p {
            margin: 2px 0;
            font-size: 14px;
            color: #555;
            }
            .button {
            display: inline-block;
            margin-top: 20px;
            background-color: rgb(76, 99, 175);
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 6px;
            }
            .footer {
            text-align: center;
            font-size: 12px;
            color: #aaa;
            margin-top: 30px;
            }
        </style>
        </head>
        <body>
        <div class="email-container">
            <div class="header">
            <h1>Payment Successful ✅</h1>
            </div>
            <div class="content">
            <p>Hi <strong> ' . $session->customer_email . '</strong>,</p>
            <p>Thanks for your order! Your payment of <strong> ' . $session->amount_subtotal . '</strong> has been processed successfully.</p>
            <p>Order ID: <strong>11</strong></p>

            <h3>Order Summary:</h3>

            ';
            
            $emailBody .= $emailItems . '<p><strong>Total: ' . $finalPrice . '</strong></p>
            <p><strong>Total: ${{total_amount}}</strong></p>
            <a href="{{order_link}}" class="button">View Order</a>
            <p>If you have any questions, feel free to reply to this email.</p>
            <p>Thanks again for shopping with us! 🛍️</p>
            </div>
            <div class="footer">
            &copy; {{year}} Your Company. All rights reserved.
            </div>
        </div>
        </body>
        </html>
        ';
    $mail->Body = $emailBody;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
// unset($_SESSION['cartDetails']);
// header("location: /payment-success?order_id=$orderId");