$(document).ready(function() {

     var table = $('#adjustments_table').DataTable( {
         dom: "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row'<'col-sm-4'i><'col-sm-8'p>>",
         "oLanguage": {
             "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
             "sInfo": "Showing page _PAGE_ of _PAGES_",
             "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
             "sSearchPlaceholder": "Search...",
            "sLengthMenu": "Results :  _MENU_",
         },
         buttons: [
             { extend: 'copy', className: 'btn btn-sm mb-2' },
             { extend: 'csv', className: 'btn btn-sm mb-2' },
             { extend: 'excel', className: 'btn btn-sm mb-2' },
             { extend: 'print', className: 'btn btn-sm mb-2' },

            {
                 text: trans('Date'),
                 className: 'btn btn-primary btn-sm toggle-vis mb-1',
                 action: function(e, dt, node, config ) {
                     var column = table.column( 2 );
                     column.visible( ! column.visible() );
                 }
             },
             {
                 text: trans('Branch'),
                 className: 'btn btn-primary btn-sm toggle-vis mb-1',
                 action: function(e, dt, node, config ) {
                     var column = table.column( 3 );
                     column.visible( ! column.visible() );
                 }
             },

         ],

         "stripeClasses": [],
         "lengthMenu": [7, 10, 20, 50],
         "pageLength": 10,
         "ajax": {
             url: url("new-design/admin/inventory/products")
         },
         columns: [

            {data:"id",sortable:true,orderable:true},
            {data:'date',sortable:true,orderable:true},
            {data:"branch.name",sortable:false,orderable:false},
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
     } );

    //delete patient
    $(document).on('click','.delete_adjustment',function(e){
        e.preventDefault();
        var el=$(this);
        swal({
            title: trans("Are you sure to delete adjustment ?"),
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


    //add product
    $(document).on('click','.add_product',function(){
        products_count++;
        $('#products_table tbody').append(`
        <tr>
            <td>
                <div class="form-group">
                    <select name="products[`+products_count+`][id]" id="product_name_`+products_count+`" class="form-control product_id" required>
                    </select>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <input type="number" name="products[`+products_count+`][quantity]" class="form-control quantity"  id="product_quantity_`+products_count+`"  value="0" min="0" required>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <select class="form-control" name="products[`+products_count+`][type]" id="product_type_`+products_count+`" required>
                        <option value="" disabled selected>`+trans('Type')+`</option>
                        <option value="1">`+trans('In')+`</option>
                        <option value="2">`+trans('Out')+`</option>
                    </select>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <textarea name="products[`+products_count+`][note]" class="form-control"  id="product_note_`+products_count+`" rows="2" placeholder="`+trans('note')+`"></textarea>
                </div>
            </td>
            <td>
                <button type="button" class="btn btn-danger delete_product">
                    <i class="fa fa-times"></i>
                </button>
            </td>
        </tr>
        `);

        //select2 product
        $('.product_id').select2({
            width:"100%",
            placeholder:trans("Select product"),
            ajax: {
            beforeSend:function()
            {
                $('.preloader').show();
                $('.loader').show();
            },
            url: ajax_url('get_products_select2'),
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
    });

    //delete product
    $(document).on('click','.delete_product',function(){
        $(this).closest('tr').remove();

        calculate_order();
    });

    //select2 branch
    $('#branch_id').select2({
        width:"100%",
        placeholder:trans("Select branch"),
        ajax: {
        beforeSend:function()
        {
            $('.preloader').show();
            $('.loader').show();
        },
        url: ajax_url('get_branches_select2'),
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


    //select2 product
    $('.product_id').select2({
        width:"100%",
        placeholder:trans("Select product"),
        ajax: {
        beforeSend:function()
        {
            $('.preloader').show();
            $('.loader').show();
        },
        url: ajax_url('get_products_select2'),
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

    //validate form has products
    // $(document).on('submit','#adjustments_form',function(e){
    //     var count_submited_products=$('.product_id').length;
    //     if(!count_submited_products)
    //     {
    //         toastr.error(trans('Please add at least one product'),trans('Failed'));
    //         return false;
    //     }
    // });

})(jQuery);

