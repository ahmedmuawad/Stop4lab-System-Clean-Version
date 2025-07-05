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



    /*
        Show Hide column
    */

    var table = $('#groups_table_new_design').DataTable( {
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
                text: 'بواسطة',
                className: 'btn btn-primary btn-sm toggle-vis mb-1 ',
                action: function(e, dt, node, config ) {
                    var column = table.column( 2 );
                    column.visible( ! column.visible() );
                }
            },
            {
                text: 'كود المريض',
                className: 'btn btn-primary btn-sm toggle-vis mb-1',
                action: function(e, dt, node, config ) {
                    var column = table.column( 3 );
                    column.visible( ! column.visible() );
                }
            },
            {
                text: 'اسم المريض',
                className: 'btn btn-primary btn-sm toggle-vis mb-1',
                action: function(e, dt, node, config ) {
                    var column = table.column( 4 );
                    column.visible( ! column.visible() );
                }
            },
            {
                text: 'المجموع الفرعى',
                className: 'btn btn-primary btn-sm toggle-vis mb-1',
                action: function(e, dt, node, config ) {
                    var column = table.column( 5 );
                    column.visible( ! column.visible() );
                }
            },
            {
                text: 'المجموع',
                className: 'btn btn-primary btn-sm toggle-vis mb-1',
                action: function(e, dt, node, config ) {
                    var column = table.column( 6 );
                    column.visible( ! column.visible() );
                }
            },
            {
                text: 'المدفوع',
                className: 'btn btn-primary btn-sm toggle-vis mb-1',
                action: function(e, dt, node, config ) {
                    var column = table.column( 7 );
                    column.visible( ! column.visible() );
                }
            },
            {
                text: 'المتبقى',
                className: 'btn btn-primary btn-sm toggle-vis mb-1',
                action: function(e, dt, node, config ) {
                    var column = table.column( 8 );
                    column.visible( ! column.visible() );
                }
            },
            {
                text: 'التاريخ',
                className: 'btn btn-primary btn-sm toggle-vis mb-1',
                action: function(e, dt, node, config ) {
                    var column = table.column( 9 );
                    column.visible( ! column.visible() );
                }
            },
            {
                text: 'الفرع',
                className: 'btn btn-primary btn-sm toggle-vis mb-1',
                action: function(e, dt, node, config ) {
                    var column = table.column( 10 );
                    column.visible( ! column.visible() );
                }
            },
            {
                text: 'الحالة',
                className: 'btn btn-primary btn-sm toggle-vis mb-1',
                action: function(e, dt, node, config ) {
                    var column = table.column( 11 );
                    column.visible( ! column.visible() );
                }
            },

        ],

        "stripeClasses": [],
        "lengthMenu": [7, 10, 20, 50],
        "pageLength": 10,
        "processing": true,
        "serverSide": true,
        "order": [
            [1, "desc"]
        ],
        "ajax": {
            url: url("new-design/admin/get_groups"),
            data: function(data) {
                data.filter_status = $('#filter_status').val();
                data.filter_barcode = $('#filter_barcode').val();
                data.filter_date = $('#filter_date').val();
                data.filter_created_by = $('#filter_created_by').val();
                data.filter_contract = $('#filter_contract').val();
            }
        },
        columns: [
            { data: "bulk_checkbox", searchable: false, sortable: false, orderable: false },
            { data: "id", sortable: false, orderable: true },
            { data: "created_by_user.name", sortable: true, orderable: true },
            // { data: "barcode", orderable: false, sortable: false },
            { data: "patient.code", orderable: true, sortable: false },
            { data: "patient.name", orderable: true, sortable: false },
            // { data: "contract.title", orderable: false, sortable: false },
            { data: "subtotal", orderable: true, sortable: false },
            // { data: "discount", orderable: false, sortable: false },
            { data: "total", orderable: true, sortable: false },
            { data: "paid", orderable: true, sortable: false },
            { data: "due", orderable: true, sortable: false },
            { data: "delayed_money", orderable: false, sortable: false },
            { data: "created_at", searchable: true, sortable: true, orderable: false },
            { data: "branch.name", searchable: true, sortable: true, orderable: false },
            { data: "done", searchable: false, orderable: false, sortable: false }, //done
            { data: "action", searchable: false, orderable: false, sortable: false } //action
        ],
        "drawCallback": function(settings) {

            let total_amount = 0;
            $('.bulk_checkbox').change(function() {
                if(this.checked) {
                    if (typeof $(this).data('delayed_money') != 'string') {
                        total_amount += parseInt($(this).data('delayed_money'))
                    }
                } else {
                    if (typeof $(this).data('delayed_money') != 'string') {
                        if(total_amount - parseInt($(this).data('delayed_money')) <= 0) {
                            total_amount = 0
                        } else {
                            total_amount -=parseInt($(this).data('delayed_money'))
                        }
                    }
                }
                $('#total_delayed_money').text(total_amount)
            });

        },
    } );

} );
