$(document).ready(function() {

    /*
    Column Filter
    */

    cf = $('#column-filter').DataTable({
        "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
            "<'table-responsive'tr>" +
            "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
        headerCallback:function(e, a, t, n, s) {
            e.getElementsByTagName("th")[0].innerHTML='<label class="new-control new-checkbox checkbox-primary m-auto">\n<input type="checkbox" class="new-control-input chk-parent select-customers-info" id="customer-all-info">\n<span class="new-control-indicator"></span><span style="visibility:hidden">c</span>\n</label>'
        },
        columnDefs:[ {
            targets:0, width:"30px", className:"", orderable:!1, render:function(e, a, t, n) {
                return'<label class="new-control new-checkbox checkbox-primary" style="height: 21px; margin-bottom: 0; margin-right: 0">\n<input type="checkbox" class="new-control-input child-chk select-customers-info" id="customer-all-info">\n <span class="new-control-indicator"></span>\n</label>'
            }
        }],
        "oLanguage": {
            "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
            "sInfo": "Showing page _PAGE_ of _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Search...",
            "sLengthMenu": "Results :  _MENU_",
        },
        "stripeClasses": [],
        "lengthMenu": [7, 10, 20, 50],
        "pageLength": 7
    });

    multiCheck(cf);


    /*
        Individual Column Search
    */

    // Setup - add a text input to each footer cell
    $('#individual-col-search tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" class="form-control" placeholder="Search '+title+'" />' );
    } );

    // DataTable
    var table = $('#individual-col-search').DataTable({
        "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
            "<'table-responsive'tr>" +
            "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
        "oLanguage": {
            "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
            "sInfo": "Showing page _PAGE_ of _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Search...",
            "sLengthMenu": "Results :  _MENU_",
        },
        "stripeClasses": [],
        "lengthMenu": [7, 10, 20, 50],
        "pageLength": 7
    });

    // Apply the search
    table.columns().every( function () {
        var that = this;

        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );

    var table = $('#medical_reports_table_new_design').DataTable( {
        dom: "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-12'f>>" +
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
                text: trans('Branch'),
                className: 'btn btn-primary btn-sm toggle-vis mb-1',
                action: function(e, dt, node, config ) {
                    var column = table.column( 2 );
                    column.visible( ! column.visible() );
                }
            },
            // {
            //     text: trans('Created By'),
            //     className: 'btn btn-primary btn-sm toggle-vis mb-1',
            //     action: function(e, dt, node, config ) {
            //         var column = table.column( 3 );
            //         column.visible( ! column.visible() );
            //     }
            // },
            {
                text: trans('Contract'),
                className: 'btn btn-primary btn-sm toggle-vis mb-1',
                action: function(e, dt, node, config ) {
                    var column = table.column( 3 );
                    column.visible( ! column.visible() );
                }
            },
            // {
            //     text: trans('Barcode'),
            //     className: 'btn btn-primary btn-sm toggle-vis mb-1',
            //     action: function(e, dt, node, config ) {
            //         var column = table.column( 4 );
            //         column.visible( ! column.visible() );
            //     }
            // },
            {
                text: trans('Patient Code'),
                className: 'btn btn-primary btn-sm toggle-vis mb-1',
                action: function(e, dt, node, config ) {
                    var column = table.column( 4 );
                    column.visible( ! column.visible() );
                }
            },
            {
                text: trans('Patient Name'),
                className: 'btn btn-primary btn-sm toggle-vis mb-1',
                action: function(e, dt, node, config ) {
                    var column = table.column( 5 );
                    column.visible( ! column.visible() );
                }
            },
            // {
            //     text: trans('Gender'),
            //     className: 'btn btn-primary btn-sm toggle-vis mb-1',
            //     action: function(e, dt, node, config ) {
            //         var column = table.column( 8 );
            //         column.visible( ! column.visible() );
            //     }
            // },
            // {
            //     text: trans('Age'),
            //     className: 'btn btn-primary btn-sm toggle-vis mb-1',
            //     action: function(e, dt, node, config ) {
            //         var column = table.column( 9 );
            //         column.visible( ! column.visible() );
            //     }
            // },
            {
                text: trans('Phone'),
                className: 'btn btn-primary btn-sm toggle-vis mb-1',
                action: function(e, dt, node, config ) {
                    var column = table.column( 6 );
                    column.visible( ! column.visible() );
                }
            },
            {
                text: trans('Done'),
                className: 'btn btn-primary btn-sm toggle-vis mb-1',
                action: function(e, dt, node, config ) {
                    var column = table.column( 9 );
                    column.visible( ! column.visible() );
                }
            },
            {
                text: trans('signed'),
                className: 'btn btn-primary btn-sm toggle-vis mb-1',
                action: function(e, dt, node, config ) {
                    var column = table.column( 10 );
                    column.visible( ! column.visible() );
                }
            },

        ],

        "stripeClasses": [],
        "lengthMenu": [7, 10, 20, 50, 100, 500, 1000],
        "pageLength": 10,
        "serverSide": true,
        "order": [
            [1, "desc"]
        ],
        "ajax": {
            url: url("new-design/admin/medical_reports"),
            data: function(data) {
                data.filter_status = $('#filter_status').val();
                data.filter_barcode = $('#filter_barcode').val();
                data.filter_date = $('#filter_date').val();
                data.filter_created_by = $('#filter_created_by').val();
                data.filter_signed_by = $('#filter_signed_by').val();
                data.filter_contract = $('#filter_contract').val();
            }
        },
        "columns": [
            { data: "bulk_checkbox", orderable: false, sortable: false },
            { data: "id", orderable: true, sortable: true },
            { data: "branch.name", searchable: true, orderable: false, sortable: false },
            // { data: "created_by_user.name", orderable: false, sortable: false },
            { data: "contract.title", orderable: false, sortable: false },
            // { data: "barcode", orderable: false, sortable: false },
            { data: "patient.code", orderable: false, sortable: false },
            { data: "patient.name", orderable: false, sortable: false },
            // { data: "patient.gender", orderable: false, sortable: false },
            // { data: "patient.age", searchable: false, orderable: false, sortable: false },
            { data: "patient.phone", orderable: false, sortable: false },
            { data: "tests", searchable: false, orderable: false, sortable: false },
            { data: "created_at", searchable: true, orderable: true, sortable: true },
            { data: "done", searchable: false, sortable: false, orderable: false },
            { data: "signed", searchable: false, sortable: false, orderable: false },
            { data: "signed_by_user.name", orderable: false, sortable: false },
            { data: "action", searchable: false, sortable: false, orderable: false },
        ],

    } );

    $('#filter_status').on('change', function() {
        table.draw();
    });

    $('#filter_barcode').on('input', function() {
        table.draw();
    });

    // filter date
    var ranges = {};
    ranges[trans('Today')] = [moment(), moment()];
    ranges[trans('Yesterday')] = [moment().subtract('days', 1), moment().subtract('days', 1)];
    ranges[trans('Last 7 Days')] = [moment().subtract('days', 6), moment()];
    ranges[trans('Last 30 Days')] = [moment().subtract('days', 29), moment()];
    ranges[trans('This Month')] = [moment().startOf('month'), moment().endOf('month')];
    ranges[trans('Last Month')] = [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')];
    ranges[trans('This Year')] = [moment().startOf('year'), moment().endOf('year')];
    ranges[trans('Last Year')] = [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')];

    $('#filter_date').daterangepicker({
            locale: {
                format: 'YYYY/MM/DD',
                "applyLabel": trans("Save"),
                "cancelLabel": trans("Cancel"),
            },
            ranges,
            startDate: moment(),
            endDate: moment()
        },
        function(start, end) {
            $('#dateRange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        });

    $('#filter_date').on('cancel.daterangepicker', function() {
        $(this).val('');
    });

    $('#filter_date').on('cancel.daterangepicker', function() {
        $(this).val('');
        table.draw();
    });

    $('#filter_date').on('apply.daterangepicker', function() {
        table.draw();
    });

    $('#filter_date').val('');

    $('#filter_created_by').on('change', function() {
        table.draw();
    });

    $('#filter_signed_by').on('change', function() {
        table.draw();
    });

    $('#filter_contract').select2({
        multiple: true,
        width: "100%",
        placeholder: trans("Contract"),
        ajax: {
            beforeSend: function() {
                $('.preloader').show();
                $('.loader').show();
            },
            url: ajax_url('get_contracts'),
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.title,
                            id: item.id
                        }
                    })
                };
            },
            complete: function() {
                $('.preloader').hide();
                $('.loader').hide();
            }
        }
    });

    //filter datatable by contract
    $('#filter_contract').on('change', function() {
        console.log('gggggggggg')
        table.draw();
    });

    $(document).on('change', '.filter_today_of_branch', function(e) {
        e.preventDefault();

        var this_value = this.value;
        // add value to local storage
        localStorage.setItem('filter_today_of_branch', this_value);

        $('#medical_reports_table_new_design').dataTable().fnFilter(this.value);

    })

} );
