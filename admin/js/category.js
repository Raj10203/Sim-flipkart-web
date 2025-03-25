$(document).ready(function () {
    let table = $("#myTable").DataTable({
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
                sorting:false,
                render: function (data) {
                    let editBtn = `
                    <div class="btn-group">
                        <button class="btn btn-success" data-toggle="modal" data-target="#editModal" data-id="+`+ data + `+">
                            <i class="fas fa-edit"></i>
                        </button>
                         <button class="btn btn-danger" data-id="'+data+'">
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
                            console.log(params);
                            
                        },
                        // action: function (e, dt, node, config) {
                        //     // alert('Button activated');
                        //     console.log(node);
                            
                        // }
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
            url: "fetchCategory.php",
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
                width: '10%'
            },
            {
                data: "description",
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