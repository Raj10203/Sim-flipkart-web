$('.asideMember').each(function (index, element) {
    if (element.dataset.li == 'categories') {
        $(element).addClass('active');
    } else {
        $(element).removeClass('active');
    }

});

$(document).ready(function () {
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
                targets: 1,
                className: "noVis",
            },
            {
                targets: 3,
                data: 'id',
                orderable: false,
                render: function (data) {
                    return `<div class="btn-group">
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
                        columns: ":not(.noVis)",
                        popoverTitle: "Column visibility selector",
                        className: 'btn btn-light btn-datatable',
                    },
                    {
                        extend: 'collection',
                        text: 'Export',
                        className: 'btn btn-light btn-datatable',
                        buttons: ['csv', 'excel', 'pdf']
                    },
                    {
                        text: 'Add Category',
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
            url: "./categories/fetchCategory.php",
            type: "POST",
            data: function (d) {
                d.customParam = "value";
            },
        },
        columns: [
            {
                data: "id",
                width: '10%'
            },
            {
                data: "name",
                width: '20%'
            },
            {
                data: "description",
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
                        url: "./categories/getCategory.php",
                        data: {
                            id: this.dataset.id
                        },
                        success: function (response) {
                            table.ajax.reload(null, false);
                            response = JSON.parse(response);
                            $('#categoryId').val(response.id);
                            $('#editCategoryName').val(response.name);
                            $('#editCategoryDescription').val(response.description);
                            $('#editModal').modal('show');
                        }
                    });
                });
            });
            
            $(".delete").each(function () {
                $(this)[0].addEventListener("click", function () {
                    $.ajax({
                        type: "post",
                        url: "./categories/deleteCategory.php",
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
        }
    });

    setInterval(function () {
        table.ajax.reload(null, false);
    }, 30000);

    $('#addCategoryForm').submit(function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            type: "post",
            url: "./categories/addEditCategory.php",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
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

        $.ajax({
            type: "post",
            url: "./categories/addEditCategory.php",
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