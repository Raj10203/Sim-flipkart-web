let count = 0;
$(document).ready(function () {
    showCartItems();
    $(document).on('click', '.view-items-btn', function () {
        const button = $(this);
        const orderId = button.data('order-id');
        const container = button.closest('.order-summary').find('.order-items-container');
        console.log(container);
        
        if (container.is(':visible')) {
            container.slideUp();
            return;
        }
        $.ajax({
            url: '/admin/ordet-item/get-order-items.php', // Your endpoint to fetch order items
            method: 'POST',
            data: { orderID: orderId },
            success: function (response) {
                let items = JSON.parse(response);
                console.log(items);
                if (items.length === 0) {
                    container.html('<div class="text-muted">No items found.</div>');
                    return;
                }

                let html = '';
                items.forEach(item => {
                    html += `
                    <div class="row mb-3 border-bottom pb-2">
                        <div class="col-md-2">
                            <img src="${item.image_path}" alt="${item.name}" class="img-fluid">
                        </div>
                        <div class="col-md-6">
                            <div class="fw-bold">${item.name}</div>
                            <div>Quantity: ${item.quantity}</div>
                            <div>Price: ₹${parseFloat(item.price).toFixed(2)}</div>
                        </div>
                        <div class="col-md-4 text-end">
                            <div>Subtotal: ₹${(item.price * item.quantity).toFixed(2)}</div>
                        </div>
                    </div>
                `;
                });
                container.html(html);
                container.hide().slideDown();
            },
            error: function () {
                container.html('<div class="text-danger">Failed to load items.</div>').slideDown();
            }
        });
    });
});
function showCartItems() {
    $.ajax({
        type: "post",
        url: "admin/order/getOrdersByUserId.php",
        success: function (response) {
            response = JSON.parse(response);
            $('#cart-count').text(response.length);
            let container = document.getElementById('cart-items-container');
            container.innerHTML = '';
            count = response.length;
            if (count == 0) {
                console.log(count);
                $('#empty-cart-message').removeClass('d-none');
                return;
            }
            response.forEach(order => {
                let itemElement = document.createElement('div');
                itemElement.innerHTML = `
                <div class="col-md-12">
                <div class="row order-summary m-0 mt-2 mb-2 p-3 bg-white border rounded shadow-sm">
                    <div class="col-md-2 text-center d-flex flex-column justify-content-center">
                        <div class="fw-bold">${order.id}</div>
                        <div class="text-muted small">${new Date(order.created_at).toLocaleString()}</div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-1"><strong>Status:</strong> <span class="text-success text-capitalize">${order.status}</span></div>
                        <div><strong>Payment ID:</strong> <span class="text-muted">${order.payment_id}</span></div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-1"><strong>Total Items:</strong> ${order.total_products}</div>
                        <div><strong>Total Price:</strong> ₹${parseFloat(order.total_price).toFixed(2)}</div>
                    </div>
                    <div class="col-md-3 text-end d-flex flex-column justify-content-between">
                        <button class="btn btn-outline-primary mb-2 view-items-btn" data-order-id="${order.id}">View Items</button>
                        <small class="text-muted">Updated: ${new Date(order.updated_at).toLocaleString()}</small>
                    </div>
                    <div class="col-12 order-items-container mt-3 " style="display: none;   "></div>
                    </div>
                </div>`;
                container.appendChild(itemElement);
            });
        }
    });
}
