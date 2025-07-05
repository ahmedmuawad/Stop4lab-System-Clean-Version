(function($) {

    "use strict";

    //active
    $('#contracts').addClass('menu-open');
    $('#send_to_lab').addClass('active');


    //Medical reports datatables
    table = $('#send_lab_table').DataTable({
        "lengthMenu": [
            [10, 25, 50, 100, 500, 1000, -1],
            [10, 25, 50, 100, 500, 1000, "All"]
        ],
        dom: "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-4'i><'col-sm-8'p>>",

        "processing": true,
        "serverSide": true,
        "order": [
            [0, "desc"]
        ],
        "ajax": {
            url: url("admin/send_to_lab"),
            data: function(data) {
                data.filter_status = $('#filter_status').val();
                data.filter_barcode = $('#filter_barcode').val();
                data.filter_date = $('#filter_date').val();
                data.filter_created_by = $('#filter_created_by').val();
                data.filter_signed_by = $('#filter_signed_by').val();
                data.filter_contract = $('#filter_contract').val();
            }
        },
        fixedHeader: true,
        "columns": [
          //   { data: "bulk_checkbox", orderable: false, sortable: false },
            { data: "id", orderable: true, sortable: true },
            { data: "branch.name", searchable: true, orderable: false, sortable: false },
            { data: "created_by_user.name", orderable: false, sortable: false },
            { data: "contract.title", orderable: false, sortable: false },
            { data: "barcode", orderable: false, sortable: false },
            { data: "patient.code", orderable: false, sortable: false },
            { data: "patient.name", orderable: false, sortable: false },
            { data: "patient.gender", orderable: false, sortable: false },
            { data: "patient.age", searchable: false, orderable: false, sortable: false },
            { data: "patient.phone", orderable: false, sortable: false },
            { data: "tests", searchable: false, orderable: false, sortable: false },
            { data: "cost", searchable: false, orderable: false, sortable: false },
            { data: "status", searchable: false, orderable: false, sortable: false },
            { data: "send_date", searchable: false, orderable: false, sortable: false },
            { data: "lab_out", searchable: false, orderable: false, sortable: false },
            { data: "created_at", searchable: true, orderable: true, sortable: true },
            { data: "received_date", searchable: true, orderable: true, sortable: true },
            { data: "done", searchable: false, sortable: false, orderable: false },
            { data: "signed", searchable: false, sortable: false, orderable: false },
            { data: "signed_by_user.name", orderable: false, sortable: false },
            { data: "notes", searchable: false, sortable: false, orderable: false },
        ],
        "language": {
            "sEmptyTable": trans("No data available in table"),
            "sInfo": trans("Showing") + " _START_ " + trans("to") + " _END_ " + trans("of") + " _TOTAL_ " + trans("records"),
            "sInfoEmpty": trans("Showing") + " 0 " + trans("to") + " 0 " + trans("of") + " 0 " + trans("records"),
            "sInfoFiltered": "(" + trans("filtered") + " " + trans("from") + " _MAX_ " + trans("total") + " " + trans("records") + ")",
            "sInfoPostFix": "",
            "sInfoThousands": ",",
            "sLengthMenu": trans("Show") + " _MENU_ " + trans("records"),
            "sLoadingRecords": trans("Loading..."),
            "sProcessing": trans("Processing..."),
            "sSearch": trans("Search") + ":",
            "sZeroRecords": trans("No matching records found"),
            "oPaginate": {
                "sFirst": trans("First"),
                "sLast": trans("Last"),
                "sNext": trans("Next"),
                "sPrevious": trans("Previous")
            },
        }
    });


})(jQuery);
