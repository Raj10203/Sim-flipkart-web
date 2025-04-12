<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/Authentication.php';

use Classes\Authentication;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$userName = $_SESSION['user_name'] ?? 'Login';
?>
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <div class="perent-head">
            <div class="child-head w-100 me-4">
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
            <div class="child-head me-2">
                <ul class="navbar-child2 me-auto mb-2 mb-lg-0">
                    <div class="header-li-custom">
                        <li class="nav-item login-li">
                            <div class="dropdown d-flex align-items-center pe-2">
                                <a data-bs-toggle="dropdown" aria-expanded="false"
                                    class="nav-link d-flex align-items-center m-0" href="#">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-person-circle icons" viewBox="0 0 16 16" width="24" height="24">
                                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                        <path fill-rule="evenodd"
                                            d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0
                                        0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                                    </svg>
                                    <span class="dn"><?= $userName ?></span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="/login"><i class="fa-solid fa-user icons"></i><?= $userName ?></a></a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/orders"><i class="fa-solid fa-box-open icons"></i>Orders</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/orders"><i class="fa-solid fa-heart icons"></i>Wishlist</a>
                                    </li>
                                    <?php if (Authentication::roleHasAccess('admin')): ?>
                                        <li>
                                            <a class="dropdown-item" href="admin"><i class="fa-solid fa-user-secret icons"></i>Admin</a>
                                        </li>
                                    <?php endif; ?>
                                    <li>
                                        <a class="dropdown-item" href="logout"><i class="fa-solid fa-right-from-bracket icons"></i>Logout</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </div>
                    <li class="nav-item login-li">
                        <a class="nav-link active d-flex align-items-center pe-2" aria-current="page" href="/cart">
                            <i class="fa-solid fa-cart-shopping icons"></i>
                            <span class="dn">Cart</span>
                        </a>
                    </li>
                    <li class="nav-item login-li">
                        <img src="https://static-assets-web.flixcart.com/batman-returns/batman-returns/p/images/Store-9eeae2.svg"
                            alt="Become a Seller" class="_1XmrCc">
                        <a class="nav-link dn" aria-disabled="true" href="#">Become a Seller</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>