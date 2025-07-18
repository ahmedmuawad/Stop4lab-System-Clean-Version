var count=$('#count_options').val();

(function($){

    "use strict";
    
    //cultures datatable
    table=$('#culture_options_table').DataTable( {
        "lengthMenu": [[10, 25, 50,100,500,1000, -1], [10, 25, 50,100,500,1000 ,"All"]],
        dom: "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-4'i><'col-sm-8'p>>",
        "processing": true,
        "serverSide": true,
        "bSort" : false,
        "ajax": {
          url: url("admin/get_culture_options")
        },
        // orderCellsTop: true,
        fixedHeader: true,
        "columns": [
          {data:"bulk_checkbox",searchable:false,sortable:false,orderable:false},
          {data:"id",sortable:true,orderable:true},
          {data:"value",sortable:true,orderable:true},
          {data:"action",searchable:false,orderable:false,sortable:false}//action
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
    $('#culture_options').addClass('active');

    //add option
    $('.add_option').on('click',function(){
       count++;
       $('tbody').append(`
        <tr>
            <td>
                <input type="text" name="option[`+count+`][value]" id="option_`+count+`" placeholder="`+trans("Option name")+`"  class="form-control" required>
            </td>
            <td>
                <button type="button" class="btn  btn-sm delete_row">
                    <i class="fa fa-trash"></i>
                </button>
            </td>
        </tr>
       `);

    });

    //delete culture option
    $(document).on('click','.delete_culture_option',function(e){
        e.preventDefault();
        var el=$(this);
        swal({
          title: trans("Are you sure to delete culture option ?"),
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: trans("Delete"),
          cancelButtonText: trans("Cancel"),
          closeOnConfirm: false
        },
        function(){
          $(el).parent().submit();
        });
    });

    //delete option
    $(document).on('click','.delete_row',function(){
      var confirm=window.confirm(trans('Are you sure to delete option ?'));
      if(confirm)
      {
        $(this).parent().parent().remove();
      }
    });


})(jQuery);
