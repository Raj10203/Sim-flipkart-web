$('.asideMember').each(function (index, element) {
    if (element.dataset.li == 'users') {
        $(element).addClass('active');
    } else {
        $(element).removeClass('active');
    }
});
$(document).ready(function () {
    const roles = ['user', 'admin', 'super_admin'];
    $("#myTable").DataTable({
        scrollX: true,
        lengthMenu: [[10, 25, 50, 100, 1000], [10, 25, 50, 100, 10000]],
        columnDefs: [
            {
                className: "dt-center",
                targets: "_all"
            },
            {
                targets: 1,
                className: "noVis",
            },
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
            url: "./users/dt-fetch-user",
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
                data: "first_name",
            },
            {
                data: "last_name",
            },
            {
                data: 'role',
                render: function (data, type, row) {
                    let options = roles.map(role => {
                        let selected = role === data ? 'selected' : '';
                        return `<option value="${role}" ${selected}>${role}</option>`;
                    }).join('');
                    return `
                        <select class="user-role-select form-control" data-user-id="${row.id}">
                            ${options}
                        </select>
                    `;
                }
            },
            {
                data: "email",
            },
            {
                data: "created_at",
            },

        ],
        drawCallback: function () {
            $('.user-role-select').select2({
                minimumResultsForSearch: Infinity,
                width: 'resolve'
            });
            $(document).off('change', '.user-role-select').on('change', '.user-role-select', function () {
                const userId = $(this).data('user-id');
                const role = $(this).val();
                $.ajax({
                    url: '/admin/users/update-role-by-user-id',
                    method: 'POST',
                    data: {
                        userId: userId,
                        role: role
                    },
                    success: function (response) {
                        response = JSON.parse(response);
                        handleApiResponse(response);
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: "Failed to update user role: " + (jqXHR.responseJSON?.error || "Server error"),
                            confirmButtonColor: '#d33'
                        });
                    }
                });
            });
        },
        initComplete: function () {
            let api = this.api();
            let roleColumn = api.column(3);
            let roleList = $('#roleList');

            roles.forEach(function (status) {
                let listItem = $('<li class="role-checkbox-li btn-light"></li>');
                listItem.html(`
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input role-checkbox" id="status-${status}" value="${status}">
                        <label class="form-check-label w-100" for="status-${status}">${status}</label>
                    </div>
                `);
                roleList.append(listItem);
            });
            $(document).on('change', '.role-checkbox-li', function () {
                let selectedRoles = [];
                $('.role-checkbox:checked').each(function () {
                    selectedRoles.push($(this).val());
                });

                let searchString = selectedRoles.length ? selectedRoles.join('|') : '';
                roleColumn.search(searchString, true, false).draw();
            });
            $('.role-checkbox-li').click(function (e) {
                e.stopPropagation();
            });
        }
    });
    $('#myTable_processing').removeClass('card');
});
