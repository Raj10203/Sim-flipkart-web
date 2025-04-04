let count = 0;
let totalPrice = 0;
let totalAmount = 0;
let cartsByUserId;
$(document).ready(function () {
    showCartItems();
});

function removeItem(id) {
    $.ajax({
        type: "post",
        url: "admin/page/cart/deleteCart.php",
        data: {
            id: id
        },
        success: function (response) {
            showCartItems();
        }
    });
}

function updateQuantity(id, change) {
    let newQuantity;
    $.ajax({
        type: "post",
        url: "admin/page/cart/updateQuantityOfCart.php",
        data: {
            id: id,
            change: change
        },
        success: function (response) {
            response = JSON.parse(response);            
            newQuantity = response.quantity;
            if (newQuantity > 0) {
                showCartItems();
            } else if (newQuantity === 0) {
                removeItem(id);
                
            }
        }
    });

}

function updateCartCount() {
    $('#cart-count').html(count);
    $('#summary-count').html(count);
}

function updateEventListeners() {
    $('.minus-btn').click(function (e) {
        e.preventDefault();
        let id = this.dataset.id;
        updateQuantity(id, -1);
    });
    $('.plus-btn').click(function (e) {
        e.preventDefault();
        let id = this.dataset.id;
        updateQuantity(id, 1);
    });
    $('.remove-btn').click(function (e) {
        e.preventDefault();
        let id = this.dataset.id;
        removeItem(id);
    });
}


function showCartItems() {
    totalPrice = 0;
    totalAmount = 0;
    
    $.ajax({
        type: "post",
        url: "admin/page/cart/getCartByUserId.php",
        success: function (response) {
            response = JSON.parse(response);
            cartsByUserId = response;
            let container = document.getElementById('cart-items-container');
            container.innerHTML = '';
            count = cartsByUserId.length;
            
            updateCartCount();
            if (count === 0) {
                $('#cartItems').removeClass('col-lg-8').addClass('col-lg-12');
                document.getElementById('empty-cart-message').classList.remove('d-none');
                $('#placeOrder').hide();
                // document.getElementById('price-summary').classList.add('d-none');
                return;
            }
            
            $('#cartItems').removeClass('col-lg-12').addClass('col-lg-8');
            document.getElementById('empty-cart-message').classList.add('d-none');
            $('#placeOrder').show();
            // document.getElementById('price-summary').classList.remove('d-none')
            cartsByUserId.forEach(item => {
                let salePrice = parseFloat((item.price - (item.price * item.discount) / 100) * item.quantity).toFixed(2);
                totalAmount = totalAmount + parseFloat(salePrice);
                totalPrice = totalPrice + parseFloat(item.price * item.quantity);                
                let itemElement = document.createElement('div');
                itemElement.className = 'cart-item';
                itemElement.innerHTML = `
                    <div class="row">
                        <div class="col-md-2 text-center">
                            <img src="${item.image_path}" alt="${item.name}" class="img-fluid">
                        </div>
                        <div class="col-md-6">
                            <div class="product-title mb-1">${item.name}</div>
                            <div class="price-container mb-2">
                                ₹${salePrice} 
                                <span class="original-price ms-2">₹${parseFloat(item.price * item.quantity).toFixed(2)}</span>
                                <span class="discount ms-2">${item.discount}% off</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="quantity-selector me-3">
                                    <button class="qty-btn minus-btn" data-id="${item.id}">-</button>
                                    <input type="text" class="qty-input" value="${item.quantity}" readonly>
                                    <button class="qty-btn plus-btn" data-id="${item.id}">+</button>
                                </div>
                                <button class="remove-btn" data-id="${item.id}">REMOVE</button>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <div class="delivery-info mb-2">Delivery by Tomorrow</div>
                        </div>
                    </div>
                `;
                container.appendChild(itemElement);
            });          
            $('#total-price').html(parseFloat(totalPrice).toFixed(2));
            $('#total-discount').html(parseFloat(totalPrice - totalAmount).toFixed(2));
            $('#total-savings').html(parseFloat(totalPrice - totalAmount).toFixed(2));
            $('#final-price').html(parseFloat(totalAmount).toFixed(2));
            updateEventListeners();
        }
    });
}
