(function($){

    "use strict";

    //active
    $('#packages').addClass('active');


    //packages datatable
    table=$('#packages_table').DataTable( {
        "lengthMenu": [[10, 25, 50,100,500,1000, -1], [10, 25, 50,100,500,1000 ,"All"]],
        dom: "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-4'i><'col-sm-8'p>>",
  
        "processing": true,
        "serverSide": true,
        "order" : [0,'asc'],
        "ajax": {
            url: url('admin/packages'),
        },
        // orderCellsTop: true,
        fixedHeader: true,
        "columns": [
            {data:"bulk_checkbox",searchable:false,sortable:false,orderable:false},
            {data:"id",sortable:true,orderable:true},
            {data:"name",className:"nowrap",sortable:true,orderable:true},
            {data:"shortcut",sortable:false,orderable:false},
            {data:"tests",sortable:false,orderable:false},
            {data:"price",sortable:true,orderable:true,},
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
        // initComplete: function () {
        //     this.api().columns().every(function () {
        //         var column = this;
        //         var input = document.createElement("input");
        //         $(input).appendTo($(column.footer()).empty())
        //         .on('change', function () {
        //             var val = $.fn.dataTable.util.escapeRegex($(this).val());

        //             column.search(val ? val : '', true, false).draw();
        //         });
        //     });
        // }
    });

    //select tests
    $('#select_tests').select2({
        width:"100%",
        placeholder:trans('Tests'),
        ajax: {
           beforeSend:function()
           {
              $('.preloader').show();
              $('.loader').show();
           },
           url: ajax_url('get_tests'),
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
              complete:function()
              {
                 $('.preloader').hide();
                 $('.loader').hide();
              }
        }
    });

    //select tests
    $('#select_rays').select2({
        width:"100%",
        placeholder:trans('Rays'),
        ajax: {
           beforeSend:function()
           {
              $('.preloader').show();
              $('.loader').show();
           },
           url: ajax_url('get_rays'),
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
              complete:function()
              {
                 $('.preloader').hide();
                 $('.loader').hide();
              }
        }
    });

    //select lab_status
    $(document).on('change', '#lab_status', function () {
        var labStatus = $(this).val();
        if(labStatus == 1) {
            $('.lab_cost').removeClass('d-none').addClass('d-block')
        } else {
            $('.lab_cost').addClass('d-none').removeClass('d-block')
        }
      });

    //select cultures
    $('#select_cultures').select2({
        width:"100%",
        placeholder:trans('Cultures'),
        ajax: {
           beforeSend:function()
           {
              $('.preloader').show();
              $('.loader').show();
           },
           url: ajax_url('get_cultures'),
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
              complete:function()
              {
                 $('.preloader').hide();
                 $('.loader').hide();
              }
        }
    });

    //delete triage
    $(document).on('click','.delete_package',function(e){
        e.preventDefault();
        var el=$(this);
        swal({
            title: trans("Are you sure to delete package ?"),
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


})(jQuery);


