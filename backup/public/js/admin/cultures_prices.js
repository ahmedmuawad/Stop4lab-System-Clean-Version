(function($){

    "use strict";

    //active
    $('#prices').addClass('menu-open');
    $('#prices_link').addClass('active');
    $('#cultures_prices').addClass('active');

    //change hidden cultures
    $(document).on('change','.price',function(){
        var culture_id=$(this).attr('culture_id');
        var price=$(this).val();

        $('#culture_'+culture_id).val(price);
    });

    //datatable
    var cultures_table=$('#cultures_prices_table').DataTable( {
        "lengthMenu": [[10, 25, 50,100,500,1000, -1], [10, 25, 50,100,500,1000 ,"All"]],
         dom: "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
         "<'row'<'col-sm-12'tr>>" +
         "<'row'<'col-sm-4'i><'col-sm-8'p>>",

         "processing": true,
         "serverSide": true,
         fixedHeader: true,
         "ajax": {
             url: url("admin/prices/cultures")
         },
         // orderCellsTop: true,
         fixedHeader: true,
         "columns": [
            {data:"id",sortable:true,orderable:true},
            {data:"name",sortable:false,orderable:false},
            {data:"category.name",sortable:false,orderable:false},
            {data:"price",sortable:false,orderable:false},
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

    $(document).on('change','.culture_price',function(){
       var price=$(this).val();
       if(price<0)
       {
           $(this).val(0);
           price=0;
       }
       var culture_id=$(this).attr('culture_id');
       if($('#hidden_prices').find('#culture_price_'+culture_id).length>0)
       {
            $('#hidden_prices').find('#culture_price_'+culture_id).val(price);
       }
       else{
            $('#hidden_prices').append(`
                <input type="hidden" class="hidden_price" culture_id="`+culture_id+`" name="cultures[`+culture_id+`]" value="`+price+`" id="culture_price_`+culture_id+`">
            `);
       }
    });

    cultures_table.on( 'draw', function () {
        $('#hidden_prices .hidden_price').each(function(){
            var culture_id=$(this).attr('culture_id');
            var price=$(this).val();

            $('#cultures_prices_table #culture_'+culture_id).val(price);
        });
    });


})(jQuery);
