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

    $.ajax({
        type: "post",
        url: "../../pages/category/getAllCategories.php",
        dataType: "json",
        success: function (response) {
            $(".select").each(function (index, element) {
                response.forEach(function (category) {
                    $(element).append(`<option value="${category.id}">${category.name}</option>`);
                });
            });
        }
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
                targets: 6,
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
                        buttons: ['csv', 'excel', 'pdf']
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
            url: "fetchProducts.php",
            type: "POST",
            data: function (d) {
                d.customParam = "value";
            },
        },
        columns: [
            {
                data: "id",
            },
            {
                data: "name",
            },
            {
                data: "image_path",
            },
            {
                data: "description",
            },
            {
                data: "price",
            },
            {
                data: "category_name",
            },
            {
                data: "id",

            },
        ],
        drawCallback: function () {
            removeEventListenersByClassName('event');
            $(".edit").each(function () {
                $(this)[0].addEventListener("click", function () {
                    $.ajax({
                        type: "post",
                        url: "getProduct.php",
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
                        url: "deleteProduct.php",
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
            this.api().columns([5]).every(function () {
                let column = this;

                let select = document.getElementById('selectCategory');

                select.addEventListener('change', function () {
                    column
                        .search(select.value, { exact: true })
                        .draw();
                });

            });
        }
    });

    setInterval(function () {
        table.ajax.reload(null, false);
    }, 30000);

    $('#addProductForm').submit(function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        let files = $('#addImage')[0].files;
        formData.append('image', files[0]);

        $.ajax({
            type: "post",
            url: "addEditProduct.php",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                table.ajax.reload(null, false);
                response = JSON.parse(response);
                $('#addModal').modal('hide');
                notify(response['message'], response['class']);
            },
            error: function (jqXHR) {
                alert("Failed to add product: " + (jqXHR.responseJSON?.error || "Server error"));
            }
        });
    });

    $('#editProductForm').submit(function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        let id = $('#editProductId').val();
        formData.append('id', id);

        let name = $('#editProductName').val();
        let category = $('#editCategory').val();
        let price = $('#editPrice').val();
        let description = $('#editDescription').val();

        formData.append('addProductName', name);
        formData.append('addCategory', category);
        formData.append('addPrice', price);
        formData.append('addDescription', description);

        let files = $('#editImage')[0].files;
        if (files.length > 0) {
            formData.append('addImage', files[0]);
        }

        $.ajax({
            type: "post",
            url: "addEditProduct.php",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                table.ajax.reload(null, false);
                response = JSON.parse(response);
                $('#editModal').modal('hide');
                notify(response['message'], response['class']);
            },
            error: function (jqXHR) {
                alert("Failed to edit product: " + (jqXHR.responseJSON?.error || "Server error"));
            }
        });
    });

    $('#editCategoryForm').submit(function (e) {
        e.preventDefault();
        let id = $('#categoryId').val();
        let name = $('#editCategoryName').val();
        let description = $('#editCategoryDescription').val();

        $.ajax({
            type: "post",
            url: "addEditCategory.php",
            data: {
                id: id,
                categoryName: name,
                categoryDescription: description
            },
            success: function (response) {
                table.ajax.reload(null, false);
                response = JSON.parse(response);
                $('#editModal').modal('hide');
                notify(response['message'], response['class']);
            }
        });
    });

    function notify(message, type) {
        let notification = $(`<div></div>`).html(message + `
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        `).addClass('sufee-alert alert with-close alert-' + type + ' alert-dismissible fade show');
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