(function($){

    "use strict";

    //active
    $('#activity_logs').addClass('active');

    //contracts datatable
    var table=$('#activity_logs_table').DataTable( {
      "lengthMenu": [[10, 25, 50,100,500,1000, -1], [10, 25, 50,100,500,1000 ,"All"]],
      dom: "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-4'i><'col-sm-8'p>>",
       "processing": true,
      "serverSide": true,
      "bSort" : false,
      "ajax": {
        url: url("admin/get_activity_logs"),
        data:function(data)
        {
           data.filter_user=$('#filter_user').val();
        }
      },
      // orderCellsTop: true,
      fixedHeader: true,
      "columns": [
         {data:"id"},
         {data:"description"},
         {data:"causer"},
         {data:"created_at"},
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

    $('#filter_user').change(function(){
        table.draw();
    });
})(jQuery);
