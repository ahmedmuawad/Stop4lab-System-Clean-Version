$(document).ready(function() {

     var table = $('#payment_methods_table').DataTable( {
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

         ],

         "stripeClasses": [],
         "lengthMenu": [7, 10, 20, 50],
         "pageLength": 10,
         "ajax": {
             url: url("new-design/admin/payment_methods")
         },
         fixedHeader: true,
          "columns": [
            {data:"bulk_checkbox",searchable:false,sortable:false,orderable:false},
            {data:"id",searchable:true,sortable:true,orderable:false},
            {data:"name",searchable:true,sortable:true,orderable:false},
            {data:"action",sortable:false,searchable:false,orderable:false}
          ],
          "language": {
            "sEmptyTable":     trans("No data available in table"),
            "sInfo":           trans("Showing")+" _START_ "+trans("to")+" _END_ "+trans("of")+" _TOTAL_ "+trans("records"),
            "sInfoEmpty":      trans("Showing")+" 0 "+trans("to")+" 0 "+trans("of")+" 0 "+trans("records"),
            "sInfoFiltered":   "("+trans("filtered")+" "+trans("from")+" _MAX_ "+trans("total")+" "+trans("records")+")",
            "sInfoPostFix":    "",
            "sInfoThousands":  ",",
            "sLengthMenu":     trans("Show")+" _MENU_ "+trans("records"),
            "sLoadingRecords": trans("Loading..."),
            "sProcessing":     trans("Processing..."),
            "sSearch":         trans("Search")+":",
            "sZeroRecords":    trans("No matching records found"),
            "oPaginate": {
                "sFirst":    trans("First"),
                "sLast":     trans("Last"),
                "sNext":     trans("Next"),
                "sPrevious": trans("Previous")
            },
          }
    });
//active
$('#payment_methods').addClass('active');
$('#accounting_link').addClass('active');
$('#accounting').addClass('menu-open');


//delete payment_method
$(document).on('click','.delete_payment_method',function(e){
    e.preventDefault();
    var el=$(this);
    swal({
        title: trans("Are you sure to delete payment method ?"),
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: trans("Delete"),
        cancelButtonText: trans("Cancel"),
        closeOnConfirm: false
    }).then(function (e) {
        if (e.value === true) {
            $(el).parent().submit()
        } else {
            e.dismiss;
        }

    },  function (dismiss) {
        return false;
    });
});

})(jQuery);
