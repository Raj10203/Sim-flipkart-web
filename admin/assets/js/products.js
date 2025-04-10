$('.asideMember').each(function (index, element) {
    if (element.dataset.li == 'products') {
        $(element).addClass('active');
    } else {
        $(element).removeClass('active');
    }
});
$(document).ready(function () {


    $(".imageInput").each(function (index, element) {
        element.addEventListener("change", function (e) {
            let file = e.target.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    $(element.previousElementSibling).attr("src", e.target.result).removeClass('d-none');
                };
                reader.readAsDataURL(file);
            }
        });
    });

    $(".imageInput").change(function (event) {
        let file = event.target.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function (e) {
                $("#imagePreview").attr("src", e.target.result).show();
            };
            reader.readAsDataURL(file);
        }
    });

    let table = $("#myTable").DataTable({
        responsive: true,
        scrollY: '70vh',
        scrollCollapse: true,
        scrollX: true,
        columnDefs: [
            {
                className: "dt-center",
                targets: "_all"
            },
            {
                targets: 2,
                data: 'image_path',
                orderable: false,
                render: function (data) {
                    return `<img class="tableImage" src="` + data + `" alt="product_image" srcset="">`;
                }
            },
            {
                targets: 7,
                data: 'id',
                orderable: false,
                render: function (data) {
                    return `
                    <div class="btn-group">
                        <button class="btn btn-success edit event" data-id="`+ data + `">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-danger delete event" data-id="`+ data + `">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>`;
                }
            }
        ],
        search: {
            return: true,
        },
        layout: {
            topStart: {
                buttons: [
                    {
                        extend: 'pageLength',
                        className: 'btn btn-light btn-datatable',
                    },
                    {
                        extend: "colvis",
                        popoverTitle: "Column visibility",
                        className: 'btn btn-light btn-datatable',
                    },
                    {
                        extend: 'collection',
                        text: 'Export',
                        className: 'btn btn-light btn-datatable',
                        buttons: [
                            {
                                extend: 'excelHtml5',
                                text: 'Excel',
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4, 5, 6],
                                    modifier: {
                                        page: 'all'
                                    },
                                    format: {
                                        body: function (data, row, column, node) {
                                            if (column === 2) {
                                                let imagePath = $(node).find('img').attr('src');
                                                return "httpflipkart-web.com" + imagePath;
                                            }
                                            return data;
                                        }
                                    }
                                }
                            },
                            {
                                extend: 'csvHtml5',
                                text: 'CSV',
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4, 5, 6],
                                    modifier: {
                                        page: 'all'
                                    },
                                    format: {
                                        body: function (data, row, column, node) {
                                            if (column === 2) {
                                                let imagePath = $(node).find('img').attr('src');
                                                return "flipkart-web.com" + imagePath;
                                            }
                                            return data;
                                        }
                                    }
                                }
                            }
                            ,
                            {
                                extend: 'pdfHtml5',
                                text: 'PDF',
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4, 5, 6],
                                    modifier: {
                                        page: 'all'
                                    },
                                    format: {
                                        body: function (data, row, column, node) {
                                            if (column === 2) {
                                                let imagePath = $(node).find('img').attr('src');
                                                return "http://13.201.228.54/" + imagePath;
                                            }
                                            return data;
                                        }
                                    }
                                }
                            }
                        ]
                    },
                    {
                        text: 'Add Product',
                        className: 'btn btn-light btn-datatable',
                        action: function (e, node, config) {
                            $('#addModal').modal('show');
                        }
                    },
                ]
            },
            topEnd: {
                buttons: [
                    {
                        text: "<span>Refresh </span>",
                        className: 'btn btn-light btn-datatable',
                        action: function (e, dt, node, config) {
                            dt.ajax.reload(null, false);
                        }
                    }
                ],
                search: {
                    placeholder: 'Search'
                },
            },
            bottomEnd: {
                paging: {
                    buttons: 5,
                },
            },
        },
        processing: true,
        serverSide: true,
        ajax: {
            url: "./products/fetchProducts.php",
            type: "POST",
        },
        columns: [
            { data: "id" },
            { data: "name" },
            { data: "image_path" },
            { data: "description" },
            { data: "price" },
            { data: "discount" },
            { data: "category_name" },
            { data: "id" },
        ],
        drawCallback: function () {
            removeEventListenersByClassName('event');
            $(".edit").each(function () {
                $(this)[0].addEventListener("click", function () {
                    $.ajax({
                        type: "post",
                        url: "./products/getProduct.php",
                        data: {
                            id: this.dataset.id
                        },
                        success: function (response) {
                            response = JSON.parse(response);
                            $('#editProductId').val(response.id);
                            $('#editProductName').val(response.name);
                            $('#previewImage').attr('src', response.image_path);
                            $('#editCategory').val(response.category_id);
                            $('#editPrice').val(response.price);
                            $('#editDiscount').val(response.discount);
                            $('#editDescription').val(response.description);
                            $('#editModal').modal('show');
                        }
                    });
                });
            });

            $(".delete").each(function () {
                $(this)[0].addEventListener("click", function () {
                    $.ajax({
                        type: "post",
                        url: "./products/deleteProduct.php",
                        data: {
                            id: this.dataset.id
                        },
                        success: function (response) {
                            table.ajax.reload(null, false);
                            response = JSON.parse(response);
                            notify(response['message'], response['class']);
                        },
                        error: function (jqXHR) {
                            alert("Failed to delete category: " + (jqXHR.responseJSON?.error || "Server error"));
                        }
                    });
                });
            });
        },
        initComplete: function () {
            let api = this.api();
            let column = api.column(6);
            let categoryList = $('#categoryList');
            $.ajax({
                type: "post",
                url: "/admin/categories/getAllCategories",
                dataType: "json",
                success: function (response) {
                    response.forEach(function (category) {
                        $(".select").each(function (index, element) {
                            $(element).append(`<option value="${category.id}">${category.name}</option>`);
                        });
                        let listItem = $('<li class="category-checkbox-li btn-light"></li>');
                        listItem.html(`
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input category-checkbox" id="category-${category.id}" value="${category.name}">
                                    <label class="form-check-label w-100" for="category-${category.id}">${category.name}</label>
                                </div>
                            `);
                        categoryList.append(listItem);
                    });
                    $('.category-checkbox').on('change', function () {
                        let selectedCategories = [];
                        $('.category-checkbox:checked').each(function () {
                            selectedCategories.push($(this).val());
                        });
                        let searchString = selectedCategories.length ? selectedCategories.join('|') : '';
                        column.search(searchString, true, false).draw();
                    });
                    $('.category-checkbox-li').click(function (e) {
                        e.stopPropagation();
                    });
                }
            });
        }
    });
    $('#myTable_processing').removeClass('card');
    setInterval(function () {
        table.ajax.reload(null, false);
    }, 30000);

    $('#addProductForm').validate({
        rules: {
            productName: {
                required: true,
            },
            image: {
                required: true,
            },
            category: {
                required: true,
            },
            price: {
                min: 50,
                required: true,
            },
            discount: {
                required: true,
                min: 0,
                max: 100
            },
            description: {
                required: true,
            }
        },
        submitHandler: function (form) {
            let formData = new FormData(form);
            let files = $('#addImage')[0].files;
            formData.append('image', files[0]);
            $.ajax({
                type: "post",
                url: "./products/addEditProduct.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    response = JSON.parse(response);
                    console.log(response);
                    let error = response['errors'];
                    if (error) {
                        for (let key in error) {
                            response['message'] += "<br>" + error[key];
                            console.log(key + error[key]);
                        }
                    }
                    notify(response['message'], response['class']);
                    table.ajax.reload(null, false);
                    $('#addModal').modal('hide');
                },
                error: function (jqXHR) {
                    alert("Failed to add product: " + (jqXHR.responseJSON?.error || "Server error"));
                }
            });
            form.reset();
            $('#showImg').hide();
        }
    });
    $('#addProductForm').submit(function (e) {
        e.preventDefault();
    });

    $('#editProductForm').validate({
        rules: {
            productName: {
                required: true,
            },
            category: {
                required: true,
            },
            price: {
                min: 50,
                required: true,
            },
            discount: {
                required: true,
                min: 0,
                max: 100
            },
            description: {
                required: true,
            }
        },
        submitHandler: function (form) {
            let formData = new FormData(form);
            let files = $('#editImage')[0].files;
            formData.append('image', files[0]);
            $.ajax({
                type: "post",
                url: "./products/addEditProduct.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    response = JSON.parse(response);
                    console.log(response);
                    let error = response['errors'];
                    if (error) {
                        for (let key in error) {
                            response['message'] += "<br>" + error[key];
                            console.log(key + error[key]);

                        }
                    }
                    notify(response['message'], response['class']);
                    table.ajax.reload(null, false);
                    $('#editModal').modal('hide');
                },
                error: function (jqXHR) {
                    alert("Failed to add product: " + (jqXHR.responseJSON?.error || "Server error"));
                }
            });
            form.reset();
            $('#showImg').hide();
        }
    });

    $('#editProductForm').submit(function (e) {
        e.preventDefault();
    });

    function notify(message, type) {
        let notification = $(`<div></div>`).html(message + `
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        `).addClass('sufee-alert alert with-close alert-' + type + ' alert-dismissible fade show m-0');
        $('.notifications').append(notification);
        setTimeout(() => {
            notification.fadeOut(500, function () {
                $(this).remove();
            });
        }, 5000);
    }

    function removeEventListenersByClassName(className) {
        const elements = document.querySelectorAll(`.${className}`);
        elements.forEach(element => {
            const newElement = element.cloneNode(true);
            element.parentNode.replaceChild(newElement, element);
        });
    }

});