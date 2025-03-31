$(document).ready(function () {
    const footer = $('#footer');
    $.ajax({
        url: 'admin/page/categories/getAllCategories.php',
        method: 'GET',
        dataType: 'json',
        success: function (categories) {
            $.ajax({
                url: 'admin/page/products/getAllProducts.php',
                method: 'GET',
                dataType: 'json',
                success: function (products) {
                    let categoryMap = {};
                    $.each(categories, function (index, cat) {
                        categoryMap[cat.id] = cat;
                    });

                    $.each(categoryMap, function (catId, category) {
                        let exist = products.some(product => product.category_id == catId);

                        if (exist) {
                            let categoryName = category.name;
                            let categorySection = `
                                <section>
                                    <div class="container-fluid">
                                        <div class="p4-perent">
                                            <div class="p3-header p-2">
                                                <h2>Best Of ${categoryName}</h2>
                                            </div>
                                            <div class="d-flex p3-placeholder" id="cat-${catId}">
                                            </div>
                                        </div>
                                    </div>
                                </section>`;

                            footer.before(categorySection);
                        }
                    });

                    $.each(products, function (index, product) {
                        let categoryName = categoryMap[product.category_id]?.name;
                        if (categoryName) {
                            let productCard = `
                            <div class="item-p3">
                                <div class="card">
                                    <img src="${product.image_path}" loading="lazy" alt="Image" class="header-image">
                                    <div class="card-body">
                                        <div class="p3-item-dis">From ${product.price} only.</div>
                                        <div class="p3-item-price fw-bold ">${product.name}</div>
                                    </div>
                                      <button class="addCart btn btn-warning" data-product-id = "${product.id}"> add cart</button>
                                    <div class="dn3">
                                        <svg width="16" height="16" fill="none" viewBox="0 0 17 17" style="margin-right: 8px;">
                                            <path d="m6.627 3.749 5 5-5 5" stroke="#111112" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </div>
                                    
                                </div>
                            </div>`;

                            $(`#cat-${product.category_id}`).append(productCard);

                        }
                    });
                },
                error: function (error) {
                    console.error("Error fetching products:", error);
                }
            });
        },
        error: function (error) {
            console.error("Error fetching categories:", error);
        }
    });
    $(document).on('click', '.addCart', function () {
        let productId = this.dataset.productId; // Correct way to get data-id

        $.ajax({
            type: "POST",
            url: "./admin/page/cart/addToCart.php",
            data: {
                'productId': productId
            },
            dataType: 'JSON',
            success: function (response) {
                console.log(response);
                if (response.message === "not_logged_in") {
                    window.location.href = "admin/page/login.php"; // Redirect to login page
                } else {
                    Swal.fire({
                        title: response['class'],
                        text: response['message'],
                        icon: response['class'],
                        confirmButtonText: 'Ok'
                    })
                }
            }
        });
    });
});
