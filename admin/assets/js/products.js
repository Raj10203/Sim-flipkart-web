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
                                                return window.location.origin + imagePath;
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
                                                return window.location.origin + imagePath;
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
                                                return window.location.origin + imagePath;
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
            url: "./products/dt-fetch-products",
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
            $('.select').select2({
                minimumResultsForSearch: Infinity,
                width: 'resolve'
            });
            removeEventListenersByClassName('event');
            $(".edit").each(function () {
                $(this)[0].addEventListener("click", function () {
                    $.ajax({
                        type: "post",
                        url: "./products/get-product",
                        data: {
                            id: this.dataset.id
                        },
                        success: function (response) {
                            response = JSON.parse(response);
                            if (handleApiResponse(response)) {
                                response = response.data;
                                $('#editProductId').val(response.id);
                                $('#editProductName').val(response.name);
                                $('#previewImage').attr('src', response.image_path);
                                $('#editCategory').val(response.category_id);
                                $('#editPrice').val(response.price);
                                $('#editDiscount').val(response.discount);
                                $('#editDescription').val(response.description);
                                $('#editModal').modal('show');
                            }
                        }
                    });
                });
            });

            $(".delete").each(function () {
                $(this)[0].addEventListener("click", function () {
                    $.ajax({
                        type: "post",
                        url: "./products/delete-product",
                        data: {
                            id: this.dataset.id
                        },
                        success: function (response) {
                            response = JSON.parse(response);
                            if (handleApiResponse(response)) {
                                table.ajax.reload(null, false);
                            }
                        },
                        error: function (jqXHR) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: "Failed to delete product: " + (jqXHR.responseJSON?.error || "Server error"),
                                confirmButtonColor: '#d33'
                            });
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
                type: "GET",
                url: "/admin/categories/get-all-categories",
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
                url: "./products/add-edit-product",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    response = JSON.parse(response);
                    if (handleApiResponse(response)) {
                        table.ajax.reload(null, false);
                    }
                    $('#addModal').modal('hide');
                },
                error: function (jqXHR) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: "Failed to add product: " + (jqXHR.responseJSON?.error || "Server error"),
                        confirmButtonColor: '#d33'
                    });
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
                url: "./products/add-edit-product",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    response = JSON.parse(response);
                    if (handleApiResponse(response)) {
                        table.ajax.reload(null, false);
                    }
                    $('#editModal').modal('hide');
                },
                error: function (jqXHR) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: "Failed to edit product: " + (jqXHR.responseJSON?.error || "Server error"),
                        confirmButtonColor: '#d33'
                    });
                }
            });
            form.reset();
            $('#showImg').hide();
        }
    });

    $('#editProductForm').submit(function (e) {
        e.preventDefault();
    });
});