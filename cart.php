<?php
require_once './admin/authentication/authenticate_user.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flipkart Cart</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/cart.css">
    <!-- <link rel="stylesheet" href="./css/flipkart-web.css"> -->
</head>

<body>
    <nav class="navbar navbar-expand-lg ">
        <div class="container-fluid">
            <div class="perent-head">
                <div class="child-head child-head1">
                    <a class="logo" href="/">
                        <img src="https://static-assets-web.flixcart.com/batman-returns/batman-returns/p/images/fkheaderlogo_exploreplus-44005d.svg"
                            width="160" height="40" class="me-2" title="Flipkart">
                    </a>
                    <form class="d-flex dn2 w-100" role="search">
                        <div class="input-group flex-nowrap header-search">
                            <svg width="30" height="24" class="header-search-svg" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <title>Search Icon</title>
                                <path d="M10.5 18C14.6421 18 18 14.6421 18 10.5C18 6.35786 14.6421 3 10.5 3C6.35786 3 3 6.35786 3 10.5C3 14.6421 
                                    6.35786 18 10.5 18Z" stroke="#717478" stroke-width="1.4" stroke-linecap="round"
                                    stroke-linejoin="round">
                                </path>
                                <path d="M16 16L21 21" stroke="#717478" stroke-width="1.4" stroke-linecap="round"
                                    stroke-linejoin="round">
                                </path>
                            </svg>
                            <input type="text" class="header-search-input" id="searchFlipkart" name="searchFlipkart"
                                placeholder="Search for Product, Brands and More" aria-label="Search">
                        </div>
                    </form>
                </div>
                <div class="child-head child-head2">
                    <ul class="navbar-child2 me-auto mb-2 mb-lg-0">
                        <div class="header-li-custom">
                            <li class="nav-item login-li header-li-child">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-person-circle" viewBox="0 0 16 16" width="24" height="24">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                    <path fill-rule="evenodd"
                                        d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0
                                        0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                                </svg>
                                <div class="dropdown">
                                    <a data-bs-toggle="dropdown" aria-expanded="false" class="nav-link header-li-child dn" href="#">Profile

                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="/admin/page/login"><i class="fa-solid fa-user icons"></i>Profile</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="/admin/page/register"><i class="fa-solid fa-box-open icons"></i>Orders</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="/admin/page/logout"><i class="fa-solid fa-right-from-bracket icons" ></i>Logout</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </div>
                        <li class="nav-item login-li">
                            <i class="fa-solid fa-cart-shopping "></i>
                            <a class="nav-link active header-li-child dn" aria-current="page" href="#">Cart</a>
                        </li>
                        <li class="nav-item login-li">
                            <img src="https://static-assets-web.flixcart.com/batman-returns/batman-returns/p/images/Store-9eeae2.svg"
                                alt="Become a Seller" class="_1XmrCc">
                            <a class="nav-link header-li-child dn" aria-disabled="true" href="#">Become a Seller</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <div class="container mt-3">
        <div class="row">

            <div class="col-lg-8" id="cartItems">
                <div class="cart-header">
                    <h5 class="mb-0">My Cart (<span id="cart-count"></span>)</h5>
                </div>

                <div id="cart-items-container">
                    <!-- Cart items will be added here dynamically -->
                </div>

                <div class="cart-item d-none" id="empty-cart-message">
                    <div class="empty-cart">
                        <img src="https://rukminim2.flixcart.com/www/800/800/promos/16/05/2019/d438a32e-765a-4d8b-b4a6-520b560971e8.png?q=90"
                            alt="Empty Cart">
                        <h4>Your cart is empty!</h4>
                        <p>Add items to it now.</p>
                        <a href="index.html" class="btn" style="background-color: var(--flipkart-blue); color: white;">Shop
                            Now</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4" id="placeOrder">
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
    <script src="./js/cart.js"></script>
</body>

</html>