(function($){
    
    "use strict";

    //datatable
    var table = $('#vocations_table').DataTable( {
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
                text: trans('Employee'),
                className: 'btn btn-primary btn-sm toggle-vis mb-1',
                action: function(e, dt, node, config ) {
                    var column = table.column( 2 );
                    column.visible( ! column.visible() );
                }
            },
           {
                text: trans('From'),
                className: 'btn btn-primary btn-sm toggle-vis mb-1',
                action: function(e, dt, node, config ) {
                    var column = table.column( 3 );
                    column.visible( ! column.visible() );
                }
            },
           {
                text: trans('To'),
                className: 'btn btn-primary btn-sm toggle-vis mb-1',
                action: function(e, dt, node, config ) {
                    var column = table.column( 4 );
                    column.visible( ! column.visible() );
                }
            },
           {
                text: trans('Durations'),
                className: 'btn btn-primary btn-sm toggle-vis mb-1',
                action: function(e, dt, node, config ) {
                    var column = table.column( 5 );
                    column.visible( ! column.visible() );
                }
            },
           {
                text: trans('Day'),
                className: 'btn btn-primary btn-sm toggle-vis mb-1',
                action: function(e, dt, node, config ) {
                    var column = table.column( 6 );
                    column.visible( ! column.visible() );
                }
            },
           {
                text: trans('Notes'),
                className: 'btn btn-primary btn-sm toggle-vis mb-1',
                action: function(e, dt, node, config ) {
                    var column = table.column( 7 );
                    column.visible( ! column.visible() );
                }
            },
           {
                text: trans('Type'),
                className: 'btn btn-primary btn-sm toggle-vis mb-1',
                action: function(e, dt, node, config ) {
                    var column = table.column( 8 );
                    column.visible( ! column.visible() );
                }
            },
           {
                text: trans('Status'),
                className: 'btn btn-primary btn-sm toggle-vis mb-1',
                action: function(e, dt, node, config ) {
                    var column = table.column( 9 );
                    column.visible( ! column.visible() );
                }
            },
           {
                text: trans('Date'),
                className: 'btn btn-primary btn-sm toggle-vis mb-1',
                action: function(e, dt, node, config ) {
                    var column = table.column( 10 );
                    column.visible( ! column.visible() );
                }
            },
        ],

        "stripeClasses": [],
        "lengthMenu": [7, 10, 20, 50],
        "pageLength": 10,
        "ajax": {
            url:url("new-design/admin/get_vocations")
        },
        columns: [
            {data:"bulk_checkbox",searchable:false,sortable:false,orderable:false},
            {data:"id",sortable:true,orderable:true},
            {data:"employee.user.name",sortable:true,orderable:true},
            {data:"request_from",sortable:true,orderable:true},
            {data:"request_to",sortable:true,orderable:true},
            {data:"durations",sortable:true,orderable:true},
            {data:"day",sortable:true,orderable:true},
            {data:"notes",sortable:true,orderable:true},
            {data:'type',name:'type',sortable:true,orderable:true,render: function( data, type, full, meta ) {
                if(data == 0) {
                    return `<span'>permission</span>` ;
                }else{
                    return `<span>vocations</span>`;
                }
            }},
            {data:'status',name:'status', orderable: false, searchable: false,render: function( data, type, full, meta ) {
                if(data == 0) {
                    return `<span style='color:#F00'>refuse</span>` ;
                }else if(data == 1) {
                    return `<span style='color:#0F0'>accept</span>`;
                }else{
                    return trans("underaccept");
                }

            }},
            {data:'created_at',name:'created_at',sortable:false,orderable:false,render: function( data, type, full, meta ) {
                var d = new Date(data);

                var datestring = d.getDate()  + "-" + (d.getMonth()+1) + "-" + d.getFullYear() + " " +
                d.getHours() + ":" + d.getMinutes();




                return datestring ;
            }},
            {data:"action",sortable:false,searchable:false,orderable:false}
        ],
    } );


})(jQuery);
