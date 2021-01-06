$(document).ready(function () {
    const BranchContainer = $('#branch');
    const BranchDatatable = $('#branch-table', BranchContainer);

    let t = BranchDatatable.DataTable({
        processing: true,
        serverSide: true,
        deferRender: true,
        ajax: {
            url: BranchDatatable.data('route'),
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center', width: "30px"},
            {data: 'name', name: 'name'},
            {data: 'address', name: 'address'},
            {data: 'description', name: 'description'},
            {data: 'status', name: 'status',},
            {data: 'action', name: 'action',className: 'w-12', searchable: false, orderable: false},
        ],
    });
});