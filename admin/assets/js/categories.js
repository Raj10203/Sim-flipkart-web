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
            url: "./categories/dt-fetch-category",
            type: "POST",
            data: function (d) {
                d.customParam = "value";
            },
        },
        columns: [
            { data: "id" },
            { data: "name" },
            { data: "description" },
            { data: "id" },
        ],
        drawCallback: function () {
            removeEventListenersByClassName('event');
            $(".edit").each(function () {
                $(this)[0].addEventListener("click", function () {
                    $.ajax({
                        type: "post",
                        url: "./categories/get-category",
                        data: {
                            id: this.dataset.id
                        },
                        success: function (response) {
                            response = JSON.parse(response);
                            if(handleApiResponse(response)){
                                response = response.data;
                                $('#categoryId').val(response.id);
                                $('#editCategoryName').val(response.name);
                                $('#editCategoryDescription').val(response.description);
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
                        url: "./categories/delete-category",
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
                                text:  "Failed to delete category: " + (jqXHR.responseJSON?.error || "Server error"),
                                confirmButtonColor: '#d33'
                            });
                        }
                    });
                });
            });
        }
    });
    $('#myTable_processing').removeClass('card');

    $('#editCategoryForm').submit(function (e) {
        e.preventDefault();
    });

    $('#addCategoryForm').validate({
        rules: {
            categoryName: {
                required: true,
            },
            categoryDescription: {
                required: true,
            },
        },
        submitHandler: function (form) {
            let formData = new FormData(form);
            $.ajax({
                type: "post",
                url: "./categories/add-edit-category",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    response = JSON.parse(response);
                    if (handleApiResponse(response)) {
                        table.ajax.reload(null, false);
                    }
                }
            });
            $('#addModal').modal('hide');
            form.reset();
        }
    });

    $('#addCategoryForm').submit(function (e) {
        e.preventDefault();
    });

    $('#editCategoryForm').validate({
        rules: {
            categoryName: {
                required: true,
            },
            categoryDescription: {
                required: true,
            },
        },
        submitHandler: function (form) {
            let formData = new FormData(form);
            $.ajax({
                type: "post",
                url: "./categories/add-edit-category",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    response = JSON.parse(response);
                    if (handleApiResponse(response)) {
                        table.ajax.reload(null, false);
                    }
                }
            });
            $('#editModal').modal('hide');
            form.reset();
        }
    });
});
