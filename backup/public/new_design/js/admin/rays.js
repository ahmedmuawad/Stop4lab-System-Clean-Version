(function($){

     "use strict";
     
     //active
     $('#rays').addClass('menu-open');
     // $('#prices_link').addClass('active');
     $('#rays_tests').addClass('active');
  
    //rays datatable
    table = $('#rays_table').DataTable({
     "lengthMenu": [
         [10, 25, 50, 100, 500, 1000, -1],
         [10, 25, 50, 100, 500, 1000, "All"]
     ],
     dom: "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
         "<'row'<'col-sm-12'tr>>" +
         "<'row'<'col-sm-4'i><'col-sm-8'p>>",
     buttons: [
         {
             extend:    'excelHtml5',
             text:      '<i class="fas fa-file-excel"></i> '+trans("Excel"),
             titleAttr: 'Excel'
         },
         {
             extend:    'csvHtml5',
             text:      '<i class="fas fa-file-csv"></i> '+trans("CVS"),
             titleAttr: 'CSV'
         },
         {
           extend:    'colvis',
           text:      '<i class="fas fa-eye"></i>',
           titleAttr: 'PDF'
         }  

     ],
     "processing": true,
     "serverSide": true,
     "ajax": {
         url: url("admin/get_rays")
     },
     fixedHeader: true,
     "columns": [
         { data: "bulk_checkbox", searchable: false, sortable: false, orderable: false },
         { data: "id", sortable: true, orderable: true },
         { data: "category.name", sortable: false, orderable: false },
         { data: "name", sortable: true, orderable: true },
         { data: "shortcut", sortable: false, orderable: false },
         { data: "price", sortable: false, orderable: false },
         { data: "action", searchable: false, orderable: false, sortable: false } //action
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
     //delete test
     $(document).on('click', '.delete_ray', function (e) {
        e.preventDefault();
        var el = $(this);
        swal({
            title: trans("Are you sure to delete test ?"),
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: trans("Delete"),
            cancelButtonText: trans("Cancel"),
            closeOnConfirm: false
        },
            function () {
                $(el).parent().submit();
            });
    });

        //get category select2 intialize
        $('#category').select2({
            width: "100%",
            placeholder: trans("Category"),
            ajax: {
                beforeSend: function () {
                    $('.preloader').show();
                    $('.loader').show();
                },
                url: ajax_url('get_rays_categories'),
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                },
                complete: function () {
                    $('.preloader').hide();
                    $('.loader').hide();
                }
            }
        });


 
 })(jQuery);