(function($){

    "use strict";

    var currency=$('#system_currency').val();

    //active
    $('#groups').addClass('active');

    //patient groups datatable
    var table=$('#patient_groups_table').DataTable( {
      "lengthMenu": [[10, 25, 50,100,500], [10, 25, 50,100,500]],
      dom: "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-4'i><'col-sm-8'p>>",
      
      "processing": true,
      "serverSide": true,
      "order": [[ 0, "desc" ]],
      fixedHeader: true,
      "ajax": {
            url: url("patient/get_patient_groups"),
            data:function(data)
            {
               data.filter_status=$('#filter_status').val();
            },
      },
      // orderCellsTop: true,
      "columns": [
         {data:"id",orderable:true,sortable:true},
         {data:"created_at",orderable:true,sortable:true},
         {data:"tests",searchable:false,orderable:false,sortable:false},
         {data:"total",orderable:false,sortable:false},
         {data:"paid",orderable:false,sortable:false},
         {data:"due",orderable:false,sortable:false},
         {data:"done",searchable:false,orderable:false,sortable:false},
         {data:"action",searchable:false,orderable:false,sortable:false},
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

 $('#filter_status').change(function(){
   table.draw();
 });

})(jQuery);

