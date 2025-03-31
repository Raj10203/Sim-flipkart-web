$('.asideMember').each(function (index, element) {
    if (element.dataset.li == 'users') {
        $(element).addClass('active');
    } else {
        $(element).removeClass('active');
    }

});
$(document).ready(function () {
    $("#myTable").DataTable({
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
                targets: 5,
                data: 'id',
                sorting: false,
                render: function (data) {
                    return `
                    <div class="btn-group">
                        <button class="btn btn-success" data-toggle="modal" data-target="#editModal" data-id="+`+ data + `+">
                            <i class="fas fa-edit"></i>
                        </button>
                         <button class="btn btn-danger" data-id="'+data+'">
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
                        extend: "colvis",
                        columns: ":not(.noVis)",
                        popoverTitle: "Column visibility selector",
                        className: 'btn btn-light btn-datatable',
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-light btn-datatable',
                    },
                    {
                        extend: 'excelHtml5',
                        className: 'btn btn-light btn-datatable',
                    },
                    {
                        extend: 'pageLength',
                        className: 'btn btn-light btn-datatable',
                    },
                    {
                        text: 'Add User',
                        className: 'btn btn-light btn-datatable',
                        render: function (params) {
                            // Add user functionality
                        }
                    }
                ]
            },
            topEnd: {
                search: {
                    placeholder: 'Search'
                },
            },
            bottomEnd: {
                paging: {
                    buttons: 4,
                },
            },
        },
        processing: true,
        serverSide: true,
        ajax: {
            url: "./users/fetchUser.php",
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
                data: "first_name",
                width: '10%'
            },
            {
                data: "last_name",
                width: '10%'
            },
            {
                data: "email",
                width: '10%'
            },
            {
                data: "created_at",
                width: '10%'
            },
            {
                data: "id",
                width: '10%'
            },
        ],
    });
});
$('#dt-processing').css('display', 'block');
$('#dt-processing').css('visibility', 'visible');