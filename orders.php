<?php
require_once 'classes/Authentication.php';

use Classes\Authentication;

Authentication::requireUser();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flipkart Cart</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/cart.css">
    <style>
        .order-summary {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .order-summary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <?php require_once 'includes/header.php' ?>
    <div class="container mt-3">
        <div class="row">
            <div class="col-lg-12" id="cartItems">
                <div class="cart-header">
                    <h5 class="mb-0">My Orders (<span id="cart-count"></span>)</h5>
                </div>
                <div id="cart-items-container">
                    <!-- Cart items will be added here dynamically -->
                </div>
                <div class="cart-item d-none" id="empty-cart-message">
                    <div class="empty-cart">
                        <img src="https://rukminim2.flixcart.com/www/800/800/promos/16/05/2019/d438a32e-765a-4d8b-b4a6-520b560971e8.png?q=90"
                            alt="Empty Cart">
                        <h4>Your Order List is empty!</h4>
                        <p>Add items to it now.</p>
                        <a href="/" class="btn" style="background-color: var(--flipkart-blue); color: white;">Shop
                            Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/order.js"></script>
</body>

</html>