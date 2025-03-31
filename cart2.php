<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flipkart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="/admin/css/theme.css" rel="stylesheet" media="all">
    <link rel="stylesheet" href="./css/flipkart-web.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.17.2/dist/sweetalert2.min.css">


</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg ">
        <div class="container-fluid">
            <div class="perent-head">
                <div class="child-head child-head1">
                    <div class="logo">
                        <img src="https://static-assets-web.flixcart.com/batman-returns/batman-returns/p/images/fkheaderlogo_exploreplus-44005d.svg"
                            width="160" height="40" class="me-2" title="Flipkart">
                    </div>
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
                                    <a class="nav-link header-li-child dn" href="#">Login
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16"
                                            id="login-down-arrow">
                                            <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0
                                                1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
                                        </svg>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="/admin/page/login"
                                                style="width: 100%;">Login</a></li>
                                        <li><a class="dropdown-item" href="/admin/page/register">Register</a></li>
                                    </ul>
                                </div>
                            </li>
                        </div>
                        <li class="nav-item login-li">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <a class="nav-link active header-li-child dn" aria-current="page" href="#">Cart</a>
                        </li>
                        <li class="nav-item login-li">
                            <img src="https://static-assets-web.flixcart.com/batman-returns/batman-returns/p/images/Store-9eeae2.svg"
                                alt="Become a Seller" class="_1XmrCc header-li-child">
                            <a class="nav-link header-li-child dn" aria-disabled="true" href="#">Become a Seller</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- fors bar for catagory -->
    <div class="container-fluid">
        <div class="row">
            <!-- Cart items column -->
            <div class="col-md-8">
                <div class="cart-container">
                    <h5 style="margin-bottom: 20px;">My Cart (<span id="cart-count">3</span>)</h5>
                    
                    <div id="cart-items-container">
                        <!-- Cart items will be added here dynamically -->
                    </div>
                    
                    <div class="cart-item d-none" id="empty-cart-message">
                        <div class="empty-cart">
                            <img src="/api/placeholder/200/200" alt="Empty Cart">
                            <h4>Your cart is empty!</h4>
                            <p style="margin-bottom: 20px;">Add items to it now.</p>
                            <a href="#" class="shop-now-btn">Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Price summary column -->
            <div class="col-md-4 cart-summary-col">
                <div class="price-summary" id="price-summary">
                    <h5 style="margin-bottom: 20px; color: #878787; font-size: 16px;">PRICE DETAILS</h5>
                    
                    <div class="summary-row">
                        <div>Price (<span id="summary-count">3</span> items)</div>
                        <div>₹<span id="total-price">0</span></div>
                    </div>
                    
                    <div class="summary-row">
                        <div>Discount</div>
                        <div style="color: #388e3c;">-₹<span id="total-discount">0</span></div>
                    </div>
                    
                    <div class="summary-row">
                        <div>Delivery Charges</div>
                        <div style="color: #388e3c;">FREE</div>
                    </div>
                    
                    <div class="summary-row total-row">
                        <div>Total Amount</div>
                        <div>₹<span id="final-price">0</span></div>
                    </div>
                    
                    <div class="savings">You will save ₹<span id="total-savings">0</span> on this order</div>
                    
                    <button class="checkout-btn">PLACE ORDER</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sample cart data (in a real app, this would come from localStorage or an API)
        const cartItems = [
            {
                id: 1,
                name: "Samsung Galaxy M14 5G (Smoky Teal, 6GB, 128GB Storage)",
                image: "/api/placeholder/100/100",
                seller: "TrendyMobiles",
                originalPrice: 16999,
                salePrice: 13990,
                quantity: 1
            },
            {
                id: 2,
                name: "boAt Rockerz 450 Bluetooth Headphone (Aqua Blue)",
                image: "/api/placeholder/100/100",
                seller: "SuperDigitech Ltd",
                originalPrice: 3999,
                salePrice: 1499,
                quantity: 1
            },
            {
                id: 3,
                name: "HP 15s Thin & Light Laptop (Intel Core i3, 8GB RAM, 512GB SSD)",
                image: "/api/placeholder/100/100",
                seller: "RetailNet",
                originalPrice: 48990,
                salePrice: 39990,
                quantity: 1
            }
        ];
        
        // Function to render cart items
        function renderCartItems() {
            const container = document.getElementById('cart-items-container');
            container.innerHTML = '';
            
            if (cartItems.length === 0) {
                document.getElementById('empty-cart-message').classList.remove('d-none');
                document.getElementById('price-summary').classList.add('d-none');
                updateCartCount();
                return;
            }
            
            document.getElementById('empty-cart-message').classList.add('d-none');
            document.getElementById('price-summary').classList.remove('d-none');
            
            cartItems.forEach(item => {
                const discountPercent = Math.round(((item.originalPrice - item.salePrice) / item.originalPrice) * 100);
                
                const itemElement = document.createElement('div');
                itemElement.className = 'cart-item';
                itemElement.innerHTML = `
                    <div class="row">
                        <div class="col-md-2 text-center">
                            <img src="${item.image}" alt="${item.name}" style="max-width: 100px; max-height: 100px;">
                        </div>
                        <div class="col-md-6">
                            <div class="product-title">${item.name}</div>
                            <div class="product-seller">Seller: ${item.seller}</div>
                            <div class="price-container">
                                <span class="current-price">₹${item.salePrice}</span>
                                <span class="original-price">₹${item.originalPrice}</span>
                                <span class="discount">${discountPercent}% off</span>
                            </div>
                            <div style="display: flex; align-items: center;">
                                <div class="quantity-selector">
                                    <button class="qty-btn minus-btn" data-id="${item.id}">-</button>
                                    <input type="text" class="qty-input" value="${item.quantity}" readonly>
                                    <button class="qty-btn plus-btn" data-id="${item.id}">+</button>
                                </div>
                                <button class="remove-btn" data-id="${item.id}">REMOVE</button>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <div style="color: #878787;">Delivery by Tomorrow</div>
                        </div>
                    </div>
                `;
                container.appendChild(itemElement);
            });
            
            // Update event listeners
            updateEventListeners();
            
            // Update cart counts and summary
            updateCartCount();
            calculateSummary();
        }
        
        // Function to update quantity
        function updateQuantity(id, change) {
            const itemIndex = cartItems.findIndex(item => item.id === id);
            if (itemIndex !== -1) {
                const newQuantity = cartItems[itemIndex].quantity + change;
                if (newQuantity > 0) {
                    cartItems[itemIndex].quantity = newQuantity;
                    renderCartItems();
                } else if (newQuantity === 0) {
                    removeItem(id);
                }
            }
        }
        
        // Function to remove an item
        function removeItem(id) {
            const itemIndex = cartItems.findIndex(item => item.id === id);
            if (itemIndex !== -1) {
                cartItems.splice(itemIndex, 1);
                renderCartItems();
            }
        }
        
        // Function to update event listeners
        function updateEventListeners() {
            // Quantity decrease buttons
            document.querySelectorAll('.minus-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const id = parseInt(this.getAttribute('data-id'));
                    updateQuantity(id, -1);
                });
            });
            
            // Quantity increase buttons
            document.querySelectorAll('.plus-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const id = parseInt(this.getAttribute('data-id'));
                    updateQuantity(id, 1);
                });
            });
            
            // Remove buttons
            document.querySelectorAll('.remove-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const id = parseInt(this.getAttribute('data-id'));
                    removeItem(id);
                });
            });
        }
        
        // Function to update cart count
        function updateCartCount() {
            const count = cartItems.length;
            document.getElementById('cart-count').textContent = count;
            document.getElementById('summary-count').textContent = count;
        }
        
        // Function to calculate summary
        function calculateSummary() {
            let totalOriginalPrice = 0;
            let totalSalePrice = 0;
            
            cartItems.forEach(item => {
                totalOriginalPrice += item.originalPrice * item.quantity;
                totalSalePrice += item.salePrice * item.quantity;
            });
            
            const totalDiscount = totalOriginalPrice - totalSalePrice;
            
            document.getElementById('total-price').textContent = totalOriginalPrice.toLocaleString();
            document.getElementById('total-discount').textContent = totalDiscount.toLocaleString();
            document.getElementById('final-price').textContent = totalSalePrice.toLocaleString();
            document.getElementById('total-savings').textContent = totalDiscount.toLocaleString();
        }
        
        // Initial render
        renderCartItems();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.17.2/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
    <script src="./js/flipkart.js"></script>
</body>

</html>