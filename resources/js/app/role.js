$(document).ready(function () {
    const roleContainer = $('#role');
    const roleDatatable = $('#role-table', roleContainer);

    roleDatatable.DataTable({
        processing: true,
        serverSide: true,
        deferRender: true,
        ajax: {
            url: roleDatatable.data('route')
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center', width: "30px"},
            {data: 'name', name: 'name'},
            {data: 'description', name: 'description'},
            {data: 'status', name: 'status',},
            {data: 'action', name: 'action',className: 'w-12', searchable: false, orderable: false},
        ],

        "createdRow": function (row, data, dataIndex) {
            $('[data-toggle="tooltip"]', row).tooltip();
        }
    });

});
