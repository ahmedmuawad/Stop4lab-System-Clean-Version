(function($) {

  "use strict";

      //datatable
      table=$('#vault_table').DataTable( {
          "lengthMenu": [[10, 25, 50,100,500,1000, -1], [10, 25, 50,100,500,1000 ,"All"]],
          dom: "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-4'i><'col-sm-8'p>>",

          "processing": true,
          "serverSide": true,
          "order": [
            [0, "desc"]
          ],
            "ajax": {
                url:url("admin/get_vault")
            },
            // orderCellsTop: true,
            fixedHeader: true,
            "columns": [
              // {data:"bulk_checkbox",searchable:false,sortable:false,orderable:false},
              {data:"id",sortable:true,orderable:true},
              {data:"user.name",sortable:true,orderable:true},
              {data:"start_date",sortable:true,orderable:true},
              {data:"end_date",sortable:true,orderable:true},
              {data:"begin_cash",sortable:true,orderable:true},
              {data:"end_cash",sortable:true,orderable:true,render : function (data , full , all){
                
                if(parseInt(all['end_cash']) < parseInt(all['begin_cash'])  ){
                  return '<span class="btn btn-danger">' + all['end_cash'] + '</span>'; 
                }else{
                  return all['end_cash'];
                }
              }},

              {data:"branch.name",sortable:true,orderable:true},
              {data:"cash",sortable:false,orderable:false},
              {data:"notes",sortable:false,orderable:false,render : function (data , full , all){
                  if(data != null){
                      return '<span class="btn btn-danger">' + data + '</span>'; 
                  }
                  
              }},
              // {data:"action",sortable:false,searchable:false,orderable:false}
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

})(jQuery);
