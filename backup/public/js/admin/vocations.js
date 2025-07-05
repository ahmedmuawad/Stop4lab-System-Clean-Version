(function($){

    "use strict";

    //datatable
    table=$('#reports_table').DataTable( {
        "lengthMenu": [[10, 25, 50,100,500,1000, -1], [10, 25, 50,100,500,1000 ,"All"]],
        dom: "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-4'i><'col-sm-8'p>>",

        "processing": true,
        "serverSide": true,
        "bSort" : true,
          "ajax": {
              url:url("admin/get_vocations")
          },
          // orderCellsTop: true,
          fixedHeader: true,
          "columns": [
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
