$(document).ready(function () {
    $(".imageInput").each(function (index, element) {
        
        element.addEventListener("change", function (e) {
            console.log(element.previousElementSibling);
            console.log(this);
            
            let file = e.target.files[0]; // Get the selected file
            if (file) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $(element.previousElementSibling).attr("src", e.target.result).removeClass('d-none'); // Update and show preview
                };
                reader.readAsDataURL(file); // Convert file to base64 URL
            }
        });
    });
    $(".imageInput").change(function(event) {
        let file = event.target.files[0]; // Get the selected file
        if (file) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $("#imagePreview").attr("src", e.target.result).show(); // Update and show preview
            };
            reader.readAsDataURL(file); // Convert file to base64 URL
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
                    let image = `
                        <img class="tableImage" src="`+ data + `" alt="product_image" srcset="">`;
                    return image;
                }

            },
            {
                targets: 6,
                data: 'id',
                orderable: false,
                render: function (data) {
                    let editBtn = `
                    <div class="btn-group">
                        <button class="btn btn-success edit event"  data-id="`+ data + `">
                            <i class="fas fa-edit"></i>
                        </button>
                         <button class="btn btn-danger delete event" data-id="`+ data + `">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>`;
                    return editBtn;
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
                            $('#addModal').modal('show')
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
            url: "fetchCategory.php",
            type: "POST",
            data: function (d) {
                d.customParam = "value";
            },
        },
        columns: [
            {
                data: "id",
                width: '5%'
            },
            {
                data: "name",
                width: '15%'
            },
            {
                data: "image_path",
                width: '5%'
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
                width: '10%'
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
                            $('#editPrice').val(response.price);
                            $('#editDescription').val(response.description);
                            $('#editModal').modal('show');
                        }
                    });
                });
            });
            $(".delete").each(function () {
                $(this)[0].addEventListener("click", function () {
                    console.log(this.parentNode);

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
                            console.error("Error:", jqXHR.status, jqXHR.responseJSON?.error || "Unknown error");
                            alert("Failed to delete category: " + (jqXHR.responseJSON?.error || "Server error"));
                        }
                    });
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
                console.log(response);
                
                table.ajax.reload(null, false);
                response = JSON.parse(response);
                $('#addModal').modal('hide');
                notify(response['message'], response['class']);
            }
        });

    });
    $('#editCategoryForm').submit(function (e) {
        e.preventDefault();
        let id = $('#categoryId').val();
        let name = $('#editCategoryName').val();
        let description = $('#editCategoryDescription').val();
        // let formData = new FormData(this);
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