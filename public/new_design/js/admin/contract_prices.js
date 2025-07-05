(function($){

     "use strict";
     
     //active
     $('#contracts').addClass('menu-open');
     $('#contract_prises').addClass('active');
  
     $("#table_contract_tests").DataTable({
         "ordering": false,
         "lengthMenu": [[5,10, 25, 50,100,500,1000, -1],[5,10, 25, 50,100,500,1000, "All"]],
         dom: "<'row'<'col-sm-2'l><'col-sm-10'f>>" +
         "<'row'<'col-sm-12'tr>>" +
         "<'row'<'col-sm-4'i><'col-sm-8'p>>",
         "processing": true,
         "serverSide": false,
         "bSort" : false,
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
     $("#table_contract_culture").DataTable({
         "ordering": false,
         "lengthMenu": [[5, 10, 25, 50,100,500,1000, -1],[5, 10, 25, 50,100,500,1000, "All"]],
         dom: "<'row'<'col-sm-2'l><'col-sm-10'f>>" +
         "<'row'<'col-sm-12'tr>>" +
         "<'row'<'col-sm-4'i><'col-sm-8'p>>",
         "processing": true,
         "serverSide": false,
         "bSort" : false,
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
     $("#table_contract_package").DataTable({
         "ordering": false,
         "lengthMenu": [[5, 10, 25, 50,100,500,1000, -1],[5, 10, 25, 50,100,500,1000, "All"]],
         dom: "<'row'<'col-sm-2'l><'col-sm-10'f>>" +
         "<'row'<'col-sm-12'tr>>" +
         "<'row'<'col-sm-4'i><'col-sm-8'p>>",
         "processing": true,
         "serverSide": false,
         "bSort" : false,
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






     $(document).on('click','.save_tests',function(e){
          e.preventDefault();

          $('#table_contract_tests').DataTable().search('').draw();
          $('#table_contract_tests').DataTable().page.len(-1).draw();
          $('#tests_form').submit();
          
     });

     $(document).on('click','.save_cultures',function(e){
          e.preventDefault();
          $('#table_contract_culture').DataTable().search('').draw();
          $('#table_contract_culture').DataTable().page.len(-1).draw();
          $('#cultures_form').submit();
     });
     
     $(document).on('click','.save_packages',function(e){
          e.preventDefault();
          $('#table_contract_package').DataTable().search('').draw();
          $('#table_contract_package').DataTable().page.len(-1).draw();
          $('#packages_form').submit();
     });
 
 
 })(jQuery);