var system_currency = $('#system_currency').val();
var count = $('#count').val();
var option_count = 0;
var count_reference_ranges = $('#count_reference_ranges').val();
var count_comments = $('#count_comments').val();
var consumption_count=$('#consumption_count').val();

(function ($) {

    "use strict";

    //active
    $('#tests').addClass('active');

    //tests datatable
    table = $('#tests_table').DataTable({
        "lengthMenu": [
            [10, 25, 50, 100, 500, 1000, -1],
            [10, 25, 50, 100, 500, 1000, "All"]
        ],
        dom: "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-4'i><'col-sm-8'p>>",
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: url("admin/get_tests")
        },
        fixedHeader: true,
        "columns": [
            { data: "bulk_checkbox", searchable: false, sortable: false, orderable: false },
            { data: "id", sortable: true, orderable: true },
            { data: "category.name", sortable: false, orderable: false },
            { data: "name", sortable: true, orderable: true },
            { data: "shortcut", sortable: false, orderable: false },
            // { data: "sample_type", sortable: false, orderable: false },
            { data: "price", sortable: false, orderable: false },
            { data: "action", searchable: false, orderable: false, sortable: false } //action
        ],
        "language": {
            "sEmptyTable": trans("No data available in table"),
            "sInfo": trans("Showing") + " _START_ " + trans("to") + " _END_ " + trans("of") + " _TOTAL_ " + trans("records"),
            "sInfoEmpty": trans("Showing") + " 0 " + trans("to") + " 0 " + trans("of") + " 0 " + trans("records"),
            "sInfoFiltered": "(" + trans("filtered") + " " + trans("from") + " _MAX_ " + trans("total") + " " + trans("records") + ")",
            "sInfoPostFix": "",
            "sInfoThousands": ",",
            "sLengthMenu": trans("Show") + " _MENU_ " + trans("records"),
            "sLoadingRecords": trans("Loading..."),
            "sProcessing": trans("Processing..."),
            "sSearch": trans("Search") + ":",
            "sZeroRecords": trans("No matching records found"),
            "oPaginate": {
                "sFirst": trans("First"),
                "sLast": trans("Last"),
                "sNext": trans("Next"),
                "sPrevious": trans("Previous")
            },
        }
    });

    // text editor
    $('.components').find('textarea').summernote({
        tabsize: 4,
        heigt: 100,
        tooltip: false,
        dialogsFade: true,
        toolbar: []
    });

    //components

    $('.add_component').on('click', function () {
        count++;
        $('.components .items').append(`
            <tr id="component_` + count + `" num="` + count + `">
               <td>
                    <div class="form-group">
                        <input type="text" class="form-control" name="component[` + count + `][name]" placeholder="` + trans('Component') + `" required>
                    </div>
               </td>
               <td>
                    <div class="form-group">
                        <input type="text" class="form-control" name="component[` + count + `][unit]" placeholder="` + trans('Unit') + `">
                    </div>
               </td>
               <td>
                    <ul class="p-0 list-style-none">
                        <li>
                            <input class="select_type" value="text" type="radio" name="component[` + count + `][type]" id="text_` + count + `"  required> <label for="text_` + count + `">` + trans('Text') + `</label>
                        </li>
                        <li>
                            <input class="select_type" value="select" type="radio" name="component[` + count + `][type]" id="select_` + count + `"  required> <label for="select_` + count + `">` + trans('Select') + `</label>
                        </li>
                        <li>
                            <input class="select_type" value="multy" type="radio" name="component[` + count + `][type]" id="select_` + count + `"  required> <label for="select_` + count + `">` + trans('Multiple') + `</label>
                        </li>
                    </ul>
                    <div class="options">
                    </div>
               </td>
               <td colspan="7">
                  <table class="table table-bordered reference_range">
                    <thead>
                      <tr>
                        <th class="gender text-center">` + trans('Gender') + `</th>
                        <th class="age_unit text-center">` + trans('Age unit') + `</th>
                        <th class="age_from text-center">` + trans('Age') + `</th>
                        <th class="age text-center">` + trans('Critical low') + `</th>
                        <th class="age text-center">` + trans('Normal') + `</th>
                        <th class="age text-center">` + trans('Critical high') + `</th>
                        <th width="10px" class="text-center">
                          <button type="button" class="btn btn-sm btn-primary add_range">
                            <i class="fa fa-plus"></i>
                          </button>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                  <textarea class="form-control" name="component[` + count + `][reference_range]" placeholder="` + trans('Reference Range') + `"></textarea>
               </td>
               <tr>
               <td class="text-center">
                    <input class="check_separated" num="` + count + `" type="checkbox" name="component[` + count + `][separated]"> Seperate
                    <div class="component_price">
                    </div>
               </td>
               <td class="text-center">
                    <input  type="checkbox" name="component[` + count + `][status]"> Status
                </td>
                <td class="text-center">
                    <input type="number"  name="component[` + count + `][min]" value="0" required>
                </td>
                <td class="text-center">
                    <input type="number"  name="component[` + count + `][max]" value="1000" required>
                </td>
               <td>
                    <button type="button" class="btn btn-danger delete_row_component">
                        <i class="fa fa-trash"> ` + trans('Delete Component') + `</i>
                    </button>
               </td>
               </tr>
            </tr>
            `);
        //initialize text editor
        $('#component_' + count).find('textarea').summernote({
            tabsize: 4,
            heigt: 100,
            tooltip: false,
            dialogsFade: true,
            toolbar: []
        });
    });

    //add title
    $('.add_title').on('click', function () {
        count++;
        $('.components .items').append(`
          <tr num="` + count + `" id="component_` + count + `">
            <td colspan="6">
               <div class="form-group">
                    <input type="hidden" name="component[` + count + `][title]" value="true">
                    <input type="text" class="form-control" name="component[` + count + `][name]" placeholder="` + trans('Title') + `" required>
               </div>
            </td>

            <td>
                <button type="button" class="btn btn-danger delete_row">
                    <i class="fa fa-trash"></i>
                </button>
            </td>
          </tr>
        `);

        $('#component_' + count + ' input').focus();
    });

    //delete test component
    $(document).on('click', '.delete_row', function () {
        var test_id = $(this).closest('tr').attr('test_id');
        var el = $(this);

        swal({
            title: trans("Are you sure to delete component ?"),
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: trans("Delete"),
            cancelButtonText: trans("Cancel"),
            closeOnConfirm: true
        },
            function () {
                if (test_id !== undefined) {
                    $.ajax({
                        url: ajax_url('delete_test/' + test_id),
                        beforeSend: function () {
                            $('.preloader').show();
                            $('.loader').show();
                        },
                        success: function () {
                            $(el).parent().parent().remove();
                        },
                        complete: function () {
                            $('.preloader').hide();
                            $('.loader').hide();
                        }
                    });
                } else {
                    $(el).parent().parent().remove();
                }

            });

    });
    //delete test component
    $(document).on('click', '.delete_row_component', function () {
        var test_id = $(this).closest('tr').attr('test_id');
        var el = $(this);

        swal({
            title: trans("Are you sure to delete component ?"),
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: trans("Delete"),
            cancelButtonText: trans("Cancel"),
            closeOnConfirm: true
        },
            function () {
                if (test_id !== undefined) {
                    $.ajax({
                        url: ajax_url('delete_test/' + test_id),
                        beforeSend: function () {
                            $('.preloader').show();
                            $('.loader').show();
                        },
                        success: function () {
                            $(el).parent().parent().prev().remove() ;
                            $(el).parent().parent().remove() ;
                        },
                        complete: function () {
                            $('.preloader').hide();
                            $('.loader').hide();
                        }
                    });
                } else {
                  $(el).parent().parent().prev().remove() ;
                  $(el).parent().parent().remove() ;
                }

            });

    });

    //check if selected components
    $('#test_form').on('submit', function () {
        var count_components = $('.components tbody tr').length;

        if (count_components == 0) {
            toastr.error(trans('Please select at least one test component'), trans('Failed'));
            return false;
        }

    });

    //delete test
    $(document).on('click', '.delete_test', function (e) {
        e.preventDefault();
        var el = $(this);
        swal({
            title: trans("Are you sure to delete test ?"),
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: trans("Delete"),
            cancelButtonText: trans("Cancel"),
            closeOnConfirm: false
        },
            function () {
                $(el).parent().submit();
            });
    });

    //select type
    $(document).on('change', '.select_type', function () {
        option_count++;
        var type = $(this).val();
        var component_num = $(this).parent().parent().parent().parent().attr('num');
        var html = `
     <table width="100%">
        <thead>
           <tr>
             <th>` + trans('Option') + `</th>
             <th width="10px">
              <button type="button" class="btn btn-primary btn-sm add_option">
                <i class="fa fa-plus"></i>
              </button>
             </th>
           </tr>
        </head>
        <tbody>
          <tr>
            <td>
              <input type="text" name="component[` + component_num + `][options][` + option_count + `]" class="form-control" required>
            </td>
            <td>
              <button type="button" class="btn btn-danger btn-sm delete_option">
                <i class="fa fa-trash"></i>
              </button>
            </td>
          </tr>
        </tbody>
     </table>
    `;

    var html2 = `
    <table width="100%">
       <thead>
          <tr>
            <th>` + trans('Option') + ` * </th>
            <th width="10px">
             <button type="button" class="btn btn-primary btn-sm add_option">
               <i class="fa fa-plus"></i>
             </button>
            </th>
          </tr>
       </head>
       <tbody>
         <tr>
           <td>
             <input type="text" name="component[` + component_num + `][options][` + option_count + `]" class="form-control" required>
           </td>
           <td>
             <button type="button" class="btn btn-danger btn-sm delete_option">
               <i class="fa fa-trash"></i>
             </button>
           </td>
         </tr>
       </tbody>
    </table>
    <table width="100%">
       <thead>
          <tr>
            <th>` + trans('Option')  + ` 2 </th>
            <th width="10px">
             <button type="button" class="btn btn-primary btn-sm add_option2">
               <i class="fa fa-plus"></i>
             </button>
            </th>
          </tr>
       </head>
       <tbody>
         <tr>
          <td>
            <input type="text" name="component[` + component_num + `][options_additional][` + option_count + `]" class="form-control" required>
          </td>
           <td>
             <button type="button" class="btn btn-danger btn-sm delete_option">
               <i class="fa fa-trash"></i>
             </button>
           </td>
         </tr>
       </tbody>
    </table>
   `;
        if (type == 'select') {
            $(this).parent().parent().next('.options').html(html);
        }else if(type == 'multy'){
            $(this).parent().parent().next('.options').html(html2);
        } 
        else {
            $(this).parent().parent().next('.options').html('');
        }
    });



    //select lab to lab status

    $(document).on('change', '#lab_status', function () {
        var labStatus = $(this).val();
        if(labStatus == 1) {
            $('.lab_cost').removeClass('d-none').addClass('d-block');
            $('.lab_out').removeClass('d-none').addClass('d-block');
        } else {
            $('.lab_cost').addClass('d-none').removeClass('d-block');
            $('.lab_out').addClass('d-none').removeClass('d-block');
        }
    });

    //delete select option
    $(document).on("click", ".delete_option", function () {
        var option_id = $(this).closest('tr').attr('option_id');
        var option = $(this);
        swal({
            title: trans("Are you sure to delete option ?"),
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: trans("Delete"),
            cancelButtonText: trans("Cancel"),
            closeOnConfirm: true
        },
            function () {
                if (option_id !== undefined) {
                    $.ajax({
                        url: ajax_url('delete_option/' + option_id),
                        beforeSend: function () {
                            $('.preloader').show();
                            $('.loader').show();
                        },
                        success: function () {
                            $(option).parent().parent().remove();
                        },
                        complete: function () {
                            $('.preloader').hide();
                            $('.loader').hide();
                        }
                    });
                } else {
                    $(option).parent().parent().remove();
                }
            });
    });

    //add option
    $(document).on('click', '.add_option', function () {
        option_count++;
        var component_num = $(this).parent().parent().parent().parent().parent().parent().parent().attr('num');
        var html = `<tr>
                <td>
                  <input type="text" name="component[` + component_num + `][options][` + option_count + `]" class="form-control" required>
                </td>
                <td>
                  <button type="button" class="btn btn-danger btn-sm delete_option">
                    <i class="fa fa-trash"></i>
                  </button>
                </td>
              </tr>`;
        $(this).parent().parent().parent().next('tbody').append(html);
    });

    //add option2
    $(document).on('click', '.add_option2', function () {
        option_count++;
        var component_num = $(this).parent().parent().parent().parent().parent().parent().parent().attr('num');
        var html = `<tr>
                <td>
                  <input type="text" name="component[` + component_num + `][options_additional][` + option_count + `]" class="form-control" required>
                </td>
                <td>
                  <button type="button" class="btn btn-danger btn-sm delete_option">
                    <i class="fa fa-trash"></i>
                  </button>
                </td>
              </tr>`;
        $(this).parent().parent().parent().next('tbody').append(html);
    });

    //separated component
    $(document).on('change', '.check_separated', function () {
        var checked = $(this).prop('checked');
        var num = $(this).attr('num');
        if (checked) {
            $(this).next('.component_price').html(`
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h5 class="card-title">
              ` + trans('Price') + `
            </h5>
          </div>
          <div class="card-body">
            <div class="input-group form-group mb-3">
                <input type="number" class="form-control" name="component[` + num + `][price]" min="0" class="price" required>
                <div class="input-group-append">
                  <span class="input-group-text">
                      ` + system_currency + `
                  </span>
                </div>
            </div>
          </div>
        </div>
      `);
        } else {
            $(this).next('.component_price').html(``);
        }
    });

    //add new reference range
    $(document).on('click', '.add_range', function () {
        count_reference_ranges++;
        var component_num = $(this).closest('tr').closest('table').closest('tr').attr('num');

        $(this).closest('table').find('tbody').append(`
    <tr>
      <td>
          <select class="form-control" name="component[` + component_num + `][reference_ranges][` + count_reference_ranges + `][gender]" required>
              <option value="both">` + trans('Both') + `</option>
              <option value="male">` + trans('Male') + `</option>
              <option value="female">` + trans('Female') + `</option>
              <option value="pregnant">` + trans('Pregnant') + `</option>
          </select>
      </td>
      <td>
          <select class="form-control" name="component[` + component_num + `][reference_ranges][` + count_reference_ranges + `][age_unit]" required>
              <option value="day">` + trans('Days') + `</option>
              <option value="month">` + trans('Months') + `</option>
              <option value="year">` + trans('Years') + `</option>
          </select>
      </td>
      <td class="text-center">
          <input type="number" name="component[` + component_num + `][reference_ranges][` + count_reference_ranges + `][age_from]" class="form-control" required>
          :
          <input type="number" name="component[` + component_num + `][reference_ranges][` + count_reference_ranges + `][age_to]" class="form-control" required>
      </td>
      <td class="text-center">
          <input type="number" name="component[` + component_num + `][reference_ranges][` + count_reference_ranges + `][critical_low_from]" class="form-control">
      </td>
      <td class="text-center">
          <input type="number" name="component[` + component_num + `][reference_ranges][` + count_reference_ranges + `][normal_from]" class="form-control">
          :
          <input type="number" name="component[` + component_num + `][reference_ranges][` + count_reference_ranges + `][normal_to]" class="form-control">
      </td>
      <td class="text-center">
          <input type="number" name="component[` + component_num + `][reference_ranges][` + count_reference_ranges + `][critical_high_from]" class="form-control">
      </td>
      <td class="text-center">
          <button type="button" class="btn btn-sm btn-danger delete_range">
              <i class="fa fa-times"></i>
          </button>
      </td>
    </tr>
    <tr>
        <td colspan="6"><textarea name="component[${component_num}][reference_ranges][${count_reference_ranges}][comment]" style="width: 100%" rows="2"></textarea></td>
    </tr>
    `);
    });

    //delete reference range
    $(document).on('click', '.delete_range', function () {
        $(this).closest('tr').next().remove()
        $(this).closest('tr').remove()
    });

    //get category select2 intialize
    $('#category').select2({
        width: "100%",
        placeholder: trans("Category"),
        ajax: {
            beforeSend: function () {
                $('.preloader').show();
                $('.loader').show();
            },
            url: ajax_url('get_categories'),
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
            complete: function () {
                $('.preloader').hide();
                $('.loader').hide();
            }
        }
    });

    //add comment
    $(document).on('click', '.add_comment', function () {
        count_comments++;

        // send request ajax
        $.ajax({
            url: $(this).data('url'),
            type: 'get',
            data: {
                id: $(this).data('id'),
            },
            success: function (data) {

                var option = [];
                data.forEach(function (item) {
                    option += '<option value="' + item.id + '">' + item.name + '</option>';
                });

                $('#comments_table tbody').append(`
              <tr>
                  <td>
                    <div class="form-group">
                        <textarea name="comments[` + count_comments + `]" class="form-control" id="" cols="30" rows="3" required></textarea>
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                        <select class="form-control" id="" name="component_id[` + count_comments + `]">
                            ${option}
                        </select>
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                        <select class="form-control" id="" name="case[` + count_comments + `]">
                        <option value="1">Normal</option>
                        <option value="2">High</option>
                        <option value="3">Low</option>
                        <option value="4">Critical high</option>
                        <option value="5">Critical low</option>
                        </select>
                    </div>
                  </td>
                  <td>
                    <button type="button" class="btn btn-danger btn-sm delete_comment">
                        <i class="fa fa-trash"></i>
                    </button>
                  </td>
              </tr>
              `);
            }
        });



    });

    //add component
    $(document).on('click', '.add_componentid', function () {
        count_comments++;

        var This = $(this);

        // send request ajax
        $.ajax({
            url: $(this).data('url'),
            type: 'get',
            data: {
                id: $(this).data('id'),
            },
            success: function (data) {

                var option = [];
                data.forEach(function (item) {
                    option += '<option value="' + item.id + '">' + item.name + '</option>';
                });
                console.log(This);
                This.parent('td').parent('tr').find('.append_comment').next().append(`
              <tr>
                  <td>
                    <div class="form-group">
                        <select class="form-control" id="" name="component_id[` + count_comments + `]">
                            ${option}
                        </select>
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                        <select class="form-control" id="" name="case[` + count_comments + `]">
                            <option value="1">Normal</option>
                            <option value="2">High</option>
                            <option value="3">Low</option>
                            <option value="4">Critical high</option>
                            <option value="5">Critical low</option>
                        </select>
                    </div>
                  </td>
                  <td>
                    <button type="button" class="btn btn-danger btn-sm delete_componentid">
                        <i class="fa fa-trash"></i>
                    </button>
                  </td>
              </tr>
              `);
            }
        });



    });



    //delete comment
    $(document).on('click', '.delete_comment', function () {
        $(this).closest('tr').remove();
    });

    //delete component
    $(document).on('click', '.delete_componentid', function () {
        $(this).closest('tr').remove();
    });

    //consumptions
    $('.product_id').select2({
        width: "100%",
        placeholder: trans("Select product"),
        ajax: {
            beforeSend: function () {
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
            complete: function () {
                $('.preloader').hide();
                $('.loader').hide();
            }
        }
    });

  //add consumption
  $(document).on('click','.add_consumption',function(){
    consumption_count++;
    $(this).parent().parent().find('.test_consumptions').append(`
      <tr class="consumption_row">
        <td>
          <div class="form-group">
            <select class="form-control" id="consumption_product_`+consumption_count+`" name="consumptions[`+consumption_count+`][product_id]" required>
            </select>
          </div>
        </td>
        <td>
          <div class="form-group">
            <input type="number" class="form-control" name="consumptions[`+consumption_count+`][quantity]" placeholder="`+trans("Quantity")+`" value="0" required>
          </div>
        </td>
        <td>
          <button type="button" class="btn btn-sm btn-danger delete_consumption">
            <i class="fa fa-trash"></i>
          </button>
        </td>
      </tr>
    `);

    $('#consumption_product_'+consumption_count).select2({
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

  //delete consumption
  $(document).on('click','.delete_consumption',function(){
    $(this).closest('.consumption_row').remove();
  });

})(jQuery);
