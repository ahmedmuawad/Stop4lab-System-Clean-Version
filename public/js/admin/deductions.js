(function($){
    "use strict";
    //packages datatable
    table=$('#deductions_table').DataTable( {
        "lengthMenu": [[10, 25, 50,100,500,1000, -1], [10, 25, 50,100,500,1000 ,"All"]],
        dom: "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-4'i><'col-sm-8'p>>",
  
        "processing": true,
        "serverSide": true,
        "order" : [0,'asc'],
        "ajax": {
            url: url('admin/get_deductions'),
        },
        // orderCellsTop: true,
        fixedHeader: true,
        "columns": [
            {data:"bulk_checkbox",searchable:false,sortable:false,orderable:false},
            {data:"id",sortable:true,orderable:true},
            {data:"name",className:"nowrap",sortable:true,orderable:true},
            {data:"type",sortable:false,orderable:false},
           
           
            {data:"action",searchable:false,orderable:false,sortable:false,className:"nowrap"}//action
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
        },
        initComplete: function () {
            this.api().columns().every(function () {
                var column = this;
                var input = document.createElement("input");
                $(input).appendTo($(column.footer()).empty())
                .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                    column.search(val ? val : '', true, false).draw();
                });
            });
        }
    });


    //delete triage
    $(document).on('click','.delete_deductions',function(e){
        e.preventDefault();
        var el=$(this);
        swal({
            title: trans("Are you sure to delete deduction ?"),
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

    $('#deductionType').on('change' , function(event){
        let value = event.target.value;

        if(value=='flexable'){
            $('#deductionValue').attr("max" , 100);
        }
        if(value=='fixed'){
            $('#deductionValue').removeAttr("max");
        }
        // alert(value);
    });
})(jQuery);
