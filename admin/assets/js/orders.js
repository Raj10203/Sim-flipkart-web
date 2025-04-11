$('.asideMember').each(function (index, element) {
    if (element.dataset.li == 'orders') {
        $(element).addClass('active');
    } else {
        $(element).removeClass('active');
    }
});
$(document).ready(function () {
    const statuses = ['paid', 'pending', 'processing', 'shipped', 'delivered', 'cancelled'];
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
                width: '160px'
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
            url: "./orders/fetchOrders.php",
            type: "POST",
        },
        columns: [
            { data: "id" },
            { data: "first_name" },
            {
                data: 'status',
                render: function (data, type, row) {
                    let options = statuses.map(status => {
                        let selected = status === data ? 'selected' : '';
                        return `<option value="${status}" ${selected}>${status}</option>`;
                    }).join('');

                    return `
                        <select class="order-status-select form-control" data-order-id="${row.id}">
                            ${options}
                        </select>
                    `;
                }
            },
            { data: "total_products" },
            { data: "total_price" },
            { data: "payment_id" },
        ],
        drawCallback: function () {
            $('.order-status-select').select2({
                minimumResultsForSearch: Infinity,
                width: 'resolve'
            });
            $(document).off('change', '.order-status-select').on('change', '.order-status-select', function () {
                const orderid = $(this).data('order-id'); // or data-id, based on your setup
                const status = $(this).val();
                $.ajax({
                    url: '/admin/orders/updateStatusByOrderId',
                    method: 'POST',
                    data: {
                        orderid: orderid,
                        status: status
                    },
                    success: function (response) {
                        response = JSON.parse(response);
                        notify(response['message'], response['class'])
                    },
                    error: function () {
                        alert('Failed to update status');
                    }
                });
            });
        },
        initComplete: function () {
            let api = this.api();
            let statusColumn = api.column(2);
            let statusList = $('#statusList');

            statuses.forEach(function (status) {
                let listItem = $('<li class="status-checkbox-li btn-light"></li>');
                listItem.html(`
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input status-checkbox" id="status-${status}" value="${status}">
                        <label class="form-check-label w-100" for="status-${status}">${status}</label>
                    </div>
                `);;
                statusList.append(listItem);
            });
            $(document).on('change', '.status-checkbox-li', function () {
                let selectedStatuses = [];
                $('.status-checkbox:checked').each(function () {
                    selectedStatuses.push($(this).val());
                });

                let searchString = selectedStatuses.length ? selectedStatuses.join('|') : '';
                statusColumn.search(searchString, true, false).draw();
            });
            $('.status-checkbox-li').click(function (e) {
                e.stopPropagation();
            });
        }
    });
    $('#myTable_processing').removeClass('card');
});