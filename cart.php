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
</head>

<body>
    <?php require_once 'includes/header.php' ?>
    <div class="container mt-3">
        <div class="row">
            <div class="col-xl-8" id="cartItems">
                <div class="cart-header">
                    <h5 class="mb-0">My Cart (<span id="cart-count"></span>)</h5>
                </div>

                <div id="cart-items-container">
                </div>

                <div class="cart-item d-none" id="empty-cart-message">
                    <div class="empty-cart">
                        <img src="https://rukminim2.flixcart.com/www/800/800/promos/16/05/2019/d438a32e-765a-4d8b-b4a6-520b560971e8.png?q=90"
                            alt="Empty Cart">
                        <h4>Your cart is empty!</h4>
                        <p>Add items to it now.</p>
                        <a href="/" class="btn" style="background-color: var(--flipkart-blue); color: white;">Shop
                            Now</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-4" id="placeOrder">
                <div class="price-summary" id="price-summary">
                    <h5 class="mb-3">PRICE DETAILS</h5>
                    <div class="row mb-2">
                        <div class="col-8">Price (<span id="summary-count"></span> items)</div>
                        <div class="col-4 text-end">₹<span id="total-price"></span></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-8">Discount</div>
                        <div class="col-4 text-end text-success">-₹<span id="total-discount"></span></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-8">Delivery Charges</div>
                        <div class="col-4 text-end text-success">FREE</div>
                    </div>
                    <div class="row total-row">
                        <div class="col-8">Total Amount</div>
                        <div class="col-4 text-end">₹<span id="final-price"></span></div>
                    </div>
                    <div class="savings mt-2">You will save ₹<span id="total-savings">0</span> on this order</div>
                    <form action="stripe/checkout.php" id="placeOrder">
                        <input type="submit" class="checkout-btn mt-3" value="PLACE ORDER"></input>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/js/cart.js"></script>
</body>

</html>