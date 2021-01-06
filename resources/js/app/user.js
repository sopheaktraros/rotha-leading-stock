$(document).ready(function () {
    const userContainer = $('#user');
    const userDatatable = $('#user-table', userContainer);
    const userFilter = $('#user-filter');

    let t = userDatatable.DataTable({
        processing: true,
        serverSide: true,
        deferRender: true,
        ajax: {
            url: userDatatable.data('route'),
            data: function (d) {
                return $.extend({}, d, $.formToObject(userFilter.find('form')));
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center', width: "30px"},
            {data: 'username', name: 'username'},
            {data: 'name', name: 'name'},
            {data: 'role', name: 'role'},
            {data: 'status', name: 'status',},
            {data: 'action', name: 'action',className: 'w-12', searchable: false, orderable: false},
        ],
        // oLanguage: {
        //     oPaginate: {
        //         sNext: '<span class="pagination-default">&#x276f;</span>',
        //         sPrevious: '<span class="pagination-default">&#x276e;</span>'
        //     }
        // }
        //
        // "createdRow": function (row, data, dataIndex) {
        //     $('[data-toggle="tooltip"]', row).tooltip();
        // }
    });

    userFilter.find('form').submit(function (e) {
        e.preventDefault();
        t.ajax.reload();
    });

});


