$(document).ready(function () {
    const CustomerContainer = $('#customer');
    const CustomerDatatable = $('#customer-table', CustomerContainer);

    let t = CustomerDatatable.DataTable({
        processing: true,
        serverSide: true,
        deferRender: true,
        ajax: {
            url: CustomerDatatable.data('route'),
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center', width: "30px"},
            {data: 'name', name: 'name'},
            {data: 'phone', name: 'phone'},
            {data: 'gender', name: 'gender'},
            {data: 'dob', name: 'dob'},
            {data: 'address', name: 'address'},
            {data: 'description', name: 'description'},
            {data: 'status', name: 'status',},
            {data: 'action', name: 'action',className: 'w-12', searchable: false, orderable: false},
        ],
    });
});