(function($) {

    "use strict";

    //active
    $('#labs').addClass('active');

    //labs datatable
    var table = $('#labs_table').DataTable( {
        dom: "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-4'i><'col-sm-8'p>>",
        "oLanguage": {
            "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
            "sInfo": "Showing page _PAGE_ of _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Search...",
           "sLengthMenu": "Results :  _MENU_",
        },
        buttons: [
            { extend: 'copy', className: 'btn btn-sm mb-2' },
            { extend: 'csv', className: 'btn btn-sm mb-2' },
            { extend: 'excel', className: 'btn btn-sm mb-2' },
            { extend: 'print', className: 'btn btn-sm mb-2' },

           {
                text: trans('Name'),
                className: 'btn btn-primary btn-sm toggle-vis mb-1',
                action: function(e, dt, node, config ) {
                    var column = table.column( 2 );
                    column.visible( ! column.visible() );
                }
            },
           {
                text: trans('Email'),
                className: 'btn btn-primary btn-sm toggle-vis mb-1',
                action: function(e, dt, node, config ) {
                    var column = table.column( 3 );
                    column.visible( ! column.visible() );
                }
            },
           {
                text: trans('Code'),
                className: 'btn btn-primary btn-sm toggle-vis mb-1',
                action: function(e, dt, node, config ) {
                    var column = table.column( 4 );
                    column.visible( ! column.visible() );
                }
            },
        ],

        "stripeClasses": [],
        "lengthMenu": [7, 10, 20, 50],
        "pageLength": 10,
        "ajax": {
            url: url("new-design/admin/get_labs")
        },
        columns: [
            { data: "bulk_checkbox", searchable: false, sortable: false, orderable: false },
            { data: "id", sortable: true, orderable: true },
            { data: "name", sortable: true, orderable: true },
            { data: "email", sortable: true, orderable: true },
            { data: "lab_code", sortable: true, orderable: true },
            { data: "action", searchable: false, orderable: false, sortable: false } 
        ],
    } );
    // Summernote
    $('textarea').summernote({
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
        ],
        height: 200,
    });

    //delete contract
    $(document).on('click', '.delete_lab', function(e) {
        e.preventDefault();
        var el = $(this);
        swal({
                title: trans("Are you sure to delete contract ?"),
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: trans("btn-danger"),
                confirmButtonText: trans("Delete"),
                cancelButtonText: trans("Cancel"),
                closeOnConfirm: false
            },
            function() {
                $(el).parent().submit();
            });
    });

    $(document).on('click', '.save_lab', function(e) {
        e.preventDefault();
        if ($('#lab_form').valid()) {
            $('#tests_table').DataTable().search('').draw();
            $('#tests_table').DataTable().page.len(-1).draw();
            $('#cultures_table').DataTable().search('').draw();
            $('#cultures_table').DataTable().page.len(-1).draw();
            $('#packages_table').DataTable().search('').draw();
            $('#packages_table').DataTable().page.len(-1).draw();
            $('#lab_form').submit();
        }
    });

    //tests table
    var tests_table = $("#tests_table").DataTable({
        "ordering": false,
        "lengthMenu": [
            [5, 10, 25, 50, 100, 500, 1000, -1],
            [5, 10, 25, 50, 100, 500, 1000, "All"]
        ],
        dom: "<'row'<'col-sm-2'l><'col-sm-10'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-4'i><'col-sm-8'p>>",
        "processing": true,
        "serverSide": false,
        "bSort": false,
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

    //cultures table
    var cultures_table = $("#cultures_table").DataTable({
        "ordering": false,
        "lengthMenu": [
            [5, 10, 25, 50, 100, 500, 1000, -1],
            [5, 10, 25, 50, 100, 500, 1000, "All"]
        ],
        dom: "<'row'<'col-sm-2'l><'col-sm-10'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-4'i><'col-sm-8'p>>",
        "processing": true,
        "serverSide": false,
        "bSort": false,
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

    //packages table 
    var packages_table = $("#packages_table").DataTable({
        "ordering": false,
        "lengthMenu": [
            [5, 10, 25, 50, 100, 500, 1000, -1],
            [5, 10, 25, 50, 100, 500, 1000, "All"]
        ],
        dom: "<'row'<'col-sm-2'l><'col-sm-10'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-4'i><'col-sm-8'p>>",
        "processing": true,
        "serverSide": false,
        "bSort": false,
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

    //change discount type
    $('.discount_type').change(function() {
        var discount_type = parseInt($(this).val());

        //percentage
        if (discount_type == 1) {
            $('#discount_percentage').parent().removeClass('d-none');
            $('#discount_percentage').prop('readonly', false);
            $('#discount_percentage').trigger('change');
        }
        //fixed price
        else {
            $('#discount_percentage').parent().addClass('d-none');
            $('#discount_percentage').prop('readonly', true);
            $('#discount_percentage').val(0);

            //change tests table
            var tests_discounts = tests_table.rows().data();
            tests_discounts.each(function(item) {
                var test_input = $(item[1]);
                //change html
                test_input.prop("readonly", false);
                test_input = test_input.attr("value", test_input.attr('price'));
                item[1] = test_input.prop('outerHTML');
            });
            tests_table.clear().rows.add(tests_discounts).draw();

            //change cultures table
            var cultures_discounts = cultures_table.rows().data();
            cultures_discounts.each(function(item) {
                var test_input = $(item[1]);
                //change html
                test_input.prop("readonly", false);
                test_input = test_input.attr("value", test_input.attr('price'));
                item[1] = test_input.prop('outerHTML');
            });
            cultures_table.clear().rows.add(cultures_discounts).draw();

            //change packages table
            var packages_discounts = packages_table.rows().data();
            packages_discounts.each(function(item) {
                var test_input = $(item[1]);
                //change html
                test_input.prop("readonly", false);
                test_input = test_input.attr("value", test_input.attr('price'));
                item[1] = test_input.prop('outerHTML');
            });
            packages_table.clear().rows.add(packages_discounts).draw();

        }
    });

    //change percentage
    $('#discount_percentage').change(function() {
        var discount_percentage = parseFloat($('#discount_percentage').val());

        //change tests table
        var tests_discounts = tests_table.rows().data();
        tests_discounts.each(function(item) {
            var test_input = $(item[1]);
            var price = parseFloat(test_input.attr('price'));
            //change html
            var discount = price - price * discount_percentage / 100;
            test_input.prop("readonly", true);
            test_input.attr("value", discount);
            item[1] = test_input.prop('outerHTML');
        });
        tests_table.clear().rows.add(tests_discounts).draw();

        //change cultures table
        var cultures_discounts = cultures_table.rows().data();
        cultures_discounts.each(function(item) {
            var test_input = $(item[1]);
            var price = parseFloat(test_input.attr('price'));
            //change html
            var discount = price - price * discount_percentage / 100;
            test_input.prop("readonly", true);
            test_input.attr("value", discount);
            item[1] = test_input.prop('outerHTML');
        });
        cultures_table.clear().rows.add(cultures_discounts).draw();

        //change packages table
        var packages_discounts = packages_table.rows().data();
        packages_discounts.each(function(item) {
            var test_input = $(item[1]);
            var price = parseFloat(test_input.attr('price'));
            //change html
            var discount = price - price * discount_percentage / 100;
            test_input.prop("readonly", true);
            test_input.attr("value", discount);
            item[1] = test_input.prop('outerHTML');
        });
        packages_table.clear().rows.add(packages_discounts).draw();
    });

    //edit contract
    var discount_type = parseInt($('.discount_type:checked').val());
    if (discount_type == 1) {
        $('#discount_percentage').trigger('change');
    }

})(jQuery);