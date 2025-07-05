var system_currency = $('#system_currency').val();
var count_component = $('#count_component').val();
var count_reference_ranges = $('#count_reference_ranges').val();
var option_count = $('#options_count').val();
var count_comments = $('#count_comments').val();
var count_consumption = $('#count_consumption').val();


// Add Component
$('.add_component').on('click', function () {

    count_component++;

    $('.test_components').append(`
 <tr id="component_${count_component}" num="${count_component}">
<td colspan="4">
<div id="accordion_${count_component}">

    <div class="card card-info">

        <a data-toggle="collapse" data-parent="#accordion_${count_component}" href="#collapseOne_${count_component}" class="btn btn-primary collapsed"

           aria-expanded="false">

            <i class="fas fa-filter"></i> ${trans('Component')}

        </a>

        <div id="collapseOne_${count_component}" class="panel-collapse in collapse">

            <div class="card-body">

                <ul class="nav nav-tabs  mb-3 mt-3" id="simpletab_${count_component}" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="data-tab_${count_component}" data-toggle="tab" href="#data_${count_component}" role="tab"
                           aria-controls="home" aria-selected="true">${trans('Details')}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="ranges-tab_${count_component}" data-toggle="tab" href="#ranges_${count_component}" role="tab"
                           aria-controls="contact" aria-selected="false">${trans('Referance Ranges')}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="mathematical-calculations-tab_${count_component}" data-toggle="tab"
                           href="#mathematical-calculations_${count_component}" role="tab"
                           aria-controls="mathematical-calculations"
                           aria-selected="false">${trans('Mathematical Calculations')}</a>
                    </li>

                </ul>
                <div class="tab-content" id="simpletabContent_${count_component}">
                    <div class="tab-pane fade show active" id="data_${count_component}" role="tabpanel"
                         aria-labelledby="data-tab">
                        <div class="row">
                            <div class="col-xl-4 col-lg-6 col-md-5 col-sm-12">
                                <label class="control-label">${trans('Component Name')}</label>
                                <input type="text" name="component[${count_component}][name]" class="form-control"
                                       value="  مكون Platelets Profile">
                            </div>
                            <div class="col-xl-4 col-lg-6 col-md-5 col-sm-12">
                                <label class="control-label">${trans('Unit')}</label>
                                <div class="input-group">
                                    <input type="text" name="component[${count_component}][unit]" class="form-control" value="g/dl">
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-md-5 col-sm-12">
                                <input type="checkbox" id="separated" class="separated" name="separated" value="separated">
                                <label class="control-label">${trans('Separate Price')}</label>

                                <input type="text" name="component[${count_component}][price]" class="form-control input-separated d-none">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4 col-lg-6 col-md-5 col-sm-12">
                                <label class="new-control new-checkbox checkbox-primary">
                                    <input type="checkbox" class="new-control-input" name="component[${count_component}][displayed]">
                                    <span class="new-control-indicator"></span>Displayed</label>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-md-5 col-sm-12">
                                <label class="new-control new-checkbox checkbox-primary">
                                    <input type="checkbox" class="new-control-input" name="component[${count_component}][enabled]">
                                    <span class="new-control-indicator"></span>Enabled</label>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-md-5 col-sm-12">
                                <label class="new-control new-checkbox checkbox-primary">
                                    <input type="checkbox" class="new-control-input" name="component[${count_component}][printed]">
                                    <span class="new-control-indicator"></span>Printed</label>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="ranges_${count_component}" role="tabpanel" aria-labelledby="ranges-tab${count_component}">
                            <button type="button" class="btn btn-warning btn-sm add_range">
                                    <i class="fa fa-plus"></i>
                                </button>
                                <label class="new-control new-checkbox checkbox-primary">
                                    <input type="checkbox" class="new-control-input" name="component[${count_component}][status]">
                                    <span class="new-control-indicator"></span>Display in report</label>
                                <br/>
                        <table class="table table-bordered components">
                            <thead>
                            <tr>
                                <th width="10%">Gender</th>
                                <th width="25%">age</th>
                                <th width="12.5%">Input Type</th>
                                <th width="12.5%">Normal</th>
                                <th width="15%">Cretical L/H</th>
                                <th width="15%">Max/Min</th>
                                <th class="text-center" width="10%">Action</th>
                            </tr>
                            </thead>
                            <tbody class="reference_ranges">

                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="mathematical-calculations_${count_component}" role="tabpanel"
                         aria-labelledby="mathematical-calculations-tab${count_component}">
                    </div>
                </div>

            </div>

        </div>

    </div>

    </div>
    </td>
     <td>
                <button class="btn btn-warning btn-sm delete_row" type="button">
                    <i class="fa fa-trash"></i></button>
            </td>
    </tr>
        `);


    //initialize text editor
    $('#component_' + count_component).find('textarea').summernote({
        tabsize: 4,
        heigt: 100,
        tooltip: false,
        dialogsFade: true,
        toolbar: []
    });
});


// show and hidden input separated
$(document).on('change', '.separated', function () {

    if ($(this).is(':checked')) {
        $('.input-separated').removeClass('d-none');
    } else {
        $('.input-separated').addClass('d-none');
    }

});



// when submit from
$("#test_form").validate({
    rules: {
        name: {
            required: true
        },
        password: {
            required: true
        }
    },
    messages: {

    },
    errorClass: "help-inline text-danger",
    errorElement: "span",
    highlight: function(element, errorClass, validClass) {
        $(element).parents('.form-group').addClass('has-error');
    },
    unhighlight: function(element, errorClass, validClass) {
        $(element).parents('.form-group').removeClass('has-error');
        $(element).parents('.form-group').addClass('has-success');
    },
    submitHandler: function(form,e) {
        e.preventDefault();
        alert('submit');
    }
})
// when submit from




//add title
$('.add_title').on('click', function () {
    count_component++;
    $('.test_components').append(`
            <tr num="${count_component}" id="component_${count_component}">
            <td>
                <input type="hidden" name="component[${count_component}][title]" value="true">
                <input type="text" class="form-control form-control-sm" name="component[${count_component}][name]"
                    value="عنوان">
            </td>
            <td><label class="new-control new-checkbox checkbox-primary">
                    <input type="checkbox" class="new-control-input" name="component[${count_component}][displayed]">
                    <span class="new-control-indicator"></span>Displayed</label>
            </td>

            <td><label class="new-control new-checkbox checkbox-primary">
                    <input type="checkbox" class="new-control-input" name="component[${count_component}][enabled]">
                    <span class="new-control-indicator"></span>Enabled</label>
            </td>
            <td><label class="new-control new-checkbox checkbox-primary">
                    <input type="checkbox" class="new-control-input" name="component[${count_component}][printed]">
                    <span class="new-control-indicator"></span>Printed</label>
            </td>
            <td>
                <button class="btn btn-warning btn-sm delete_row" type="button">
                    <i class="fa fa-trash"></i></button>
            </td>
        </tr>


        `);

    $('#component_' + count_component + ' input').focus();
});

// Remove title or component
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
    }).then(function (e) {
        if (e.value == true) {
            count_component--
            console.log(count_component)
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
        } else {
            e.dismiss;
        }


    });

});
// Add reference range
$(document).on('click', '.add_range', function () {

    count_reference_ranges++

    let ref_range = $(this).siblings('table').children('tbody')
    ref_range.append(`

        <tr>
            <td>
                <select name="component[${count_component}][reference_ranges][${count_reference_ranges}][gender]" class="form-control basic"
                    style="padding:0 !important;">
                    <option value="both">${trans('Both')}</option>
                      <option value="male">${trans('Male')}</option>
                      <option value="female">${trans('Female')}</option>
                      <option value="pregnant">${trans('Pregnant')}</option>
                </select>
            </td>
            <td>
            <div class="row" style="margin: 5px;">
                <input type="text" class="form-control" placeholder="0" name="component[${count_component}][reference_ranges][${count_reference_ranges}][age_from]"
                    aria-label="from" style="margin:2px;">
                <input type="number" class="form-control" placeholder="120" name="component[${count_component}][reference_ranges][${count_reference_ranges}][age_to]"
                style="margin:2px;">
            </div>
            <select name="component[${count_component}][reference_ranges][${count_reference_ranges}][age_unit]" class="form-control basic" style="width:96%; margin: 5px;">
                <option value="day">${trans('Days')}</option>
                <option value="month">${trans('Months')}</option>
                <option value="year">${trans('Years')}</option>
            </select>
            </td>
            <td>
                <select name="component[${count_component}][reference_ranges][${count_reference_ranges}][type]" class="form-control basic input_type" style="width:96%; margin: 5px;">
                    <option value="number" selected>Number</option>
                    <option value="select">Select</option>
                    <option value="text">Text Editor</option>
                </select>
            </td>
            <td class="input_type_number">
                <input type="number" name="component[${count_component}][reference_ranges][${count_reference_ranges}][critical_low_from]" class="form-control" placeholder="10" required> :
                <input type="number" name="component[${count_component}][reference_ranges][${count_reference_ranges}][critical_high_from]" class="form-control" placeholder="15" required>
            </td>
            <td class="input_type_number">
                <input type="number" name="component[${count_component}][reference_ranges][${count_reference_ranges}][normal_from]" class="form-control" placeholder="7" required> :
                <input type="number" name="component[${count_component}][reference_ranges][${count_reference_ranges}][normal_to]" class="form-control" placeholder="20" required>
            </td>
            <td class="input_type_number">
                <input type="number" name="component[${count_component}][reference_ranges][${count_reference_ranges}][min]" class="form-control" placeholder="0" required> :
                <input type="number" name="component[${count_component}][reference_ranges][${count_reference_ranges}][max]" class="form-control" placeholder="30" required>
            </td>

            <td class="input_type_select d-none" colspan="3">
                <table class="table options">
                    <thead>
                        <tr>
                            <th width="40%">${trans('Option')}</th>
                            <th width="40%">${trans('Status')}</th>
                            <th width="20%">
                                <button type="button" class="btn btn-success btn-sm add_option">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </th>

                        </tr>
                    </thead>
                    <tbody
                    </tbody>
                </table>

                </td>

            <td class="input_type_text d-none" colspan="3">

            </td>

            <td>
                <button type="button" class="btn btn-warning btn-sm delete_reference_range">
                    <i class="fa fa-trash"></i></button>

            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>

            <td colspan="4">

                <textarea style="width: 100%" name="component[${count_component}][reference_ranges][${count_reference_ranges}][comment]">this text will appear in normal range in report under line Normal status if filled</textarea>

            </td>
        </tr>

    `)

    // count_component++
})
// remove reference range
$(document).on('click', '.delete_reference_range', function () {
    $(this).closest('tr').next().remove()
    $(this).closest('tr').remove()
    count_reference_ranges--
    console.log(count_reference_ranges)
})

// Add reference range
$(document).on('click', '.update_range', function () {
    count_reference_ranges++
    console.log(count_reference_ranges)
    let ref_range = $(this).siblings('table').children('tbody')
    ref_range.append(`
        <tr>
            <td>
                <select name="reference_ranges[${count_reference_ranges}][gender]" class="form-control basic"
                    style="padding:0 !important;">
                    <option value="both">${trans('Both')}</option>
                      <option value="male">${trans('Male')}</option>
                      <option value="female">${trans('Female')}</option>
                      <option value="pregnant">${trans('Pregnant')}</option>
                </select>
            </td>
            <td>
            <div class="row" style="margin: 5px;">
                <input type="text" class="form-control" placeholder="0" name="reference_ranges[${count_reference_ranges}][age_from]"
                    aria-label="from" style="margin:2px;">
                <input type="number" class="form-control" placeholder="120" name="reference_ranges[${count_reference_ranges}][age_to]"
                style="margin:2px;">
            </div>
            <select name="reference_ranges[${count_reference_ranges}][age_unit]" class="form-control basic" style="width:96%; margin: 5px;">
                <option value="day">${trans('Days')}</option>
                <option value="month">${trans('Months')}</option>
                <option value="year">${trans('Years')}</option>
            </select>
            </td>
            <td>
                <select name="reference_ranges[${count_reference_ranges}][type]" class="form-control basic input_type" style="width:96%; margin: 5px;">
                    <option value="number" selected>Number</option>
                    <option value="select">Select</option>
                    <option value="text">Text Editor</option>
                </select>
            </td>
            <td class="input_type_number">
                <input type="number" name="reference_ranges[${count_reference_ranges}][critical_low_from]" class="form-control" placeholder="10" required> :
                <input type="number" name="reference_ranges[${count_reference_ranges}][critical_high_from]" class="form-control" placeholder="15" required>
            </td>
            <td class="input_type_number">
                <input type="number" name="reference_ranges[${count_reference_ranges}][normal_from]" class="form-control" placeholder="7" required> :
                <input type="number" name="reference_ranges[${count_reference_ranges}][normal_to]" class="form-control" placeholder="20" required>
            </td>
            <td class="input_type_number">
                <input type="number" name="reference_ranges[${count_reference_ranges}][min]" class="form-control" placeholder="0" required> :
                <input type="number" name="reference_ranges[${count_reference_ranges}][max]" class="form-control" placeholder="30" required>
            </td>

            <td class="input_type_select d-none" colspan="3">
                <table class="table options">
                    <thead>
                        <tr>
                            <th>${trans('Option')}</th>
                            <th>${trans('Status')}</th>
                            <th>
                                <button type="button" class="btn btn-success btn-sm update_option">
                                    <i class="fa fa-plus">${trans('Add')}</i>
                                </button>
                            </th>
                        </tr>
                    </thead>
                    <tbody
                    </tbody>
                </table>

                </td>

            <td class="input_type_text d-none" colspan="3">

            </td>

            <td>
                <button type="button" class="btn btn-warning btn-sm delete_update_reference_range">
                    <i class="fa fa-trash"></i></button>

            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>

            <td colspan="4">

                <textarea style="width: 100%" name="reference_ranges[${count_reference_ranges}][comment]">this text will appear in normal range in report under line Normal status if filled</textarea>

            </td>
        </tr>

    `)
})
// remove reference range
$(document).on('click', '.delete_update_reference_range', function () {
    $(this).closest('tr').next().remove()
    $(this).closest('tr').remove()
    count_reference_ranges--
    console.log(count_reference_ranges)
})


//select lab to lab status
$(document).on('change', '#lab_status', function () {
    var labStatus = $(this).val();

    if (labStatus == 1) {
        $('.lab_cost').removeClass('d-none').addClass('d-block')
    } else {
        $('.lab_cost').addClass('d-none').removeClass('d-block')
    }
}); //select lab to lab status

// when keyup price input price , add price to contract price
$(document).on('keyup', '#main_price', function () {

    var price = $(this).val();

    if (price == undefined) {
        $('.price_contract_keyup').val('');
    } else {
        $('.price_contract_keyup').val(price);
    }
}); //when keyup price input price , add price to contract price


$(document).on('change', '.input_type', function () {
    let input_type = $(this).val()
    if (input_type === 'select') {
        $(this).parent().siblings('.input_type_number').addClass('d-none')
        $(this).parent().siblings('.input_type_text').addClass('d-none')
        $(this).parent().siblings('.input_type_select').removeClass('d-none')
    } else if (input_type === 'number') {
        $(this).parent().siblings('.input_type_number').removeClass('d-none')
        $(this).parent().siblings('.input_type_text').addClass('d-none')
        $(this).parent().siblings('.input_type_select').addClass('d-none')
    } else if (input_type === 'text') {
        $(this).parent().siblings('.input_type_number').addClass('d-none')
        $(this).parent().siblings('.input_type_select').addClass('d-none')
        $(this).parent().siblings('.input_type_text').removeClass('d-none')
    }
})

$(document).on('click', '.add_option', function () {
    option_count++;
    let options = $(this).closest('table').children('tbody')
    options.append(`

        <tr>
            <td>
                <input type="text" name="component[${count_component}][reference_ranges][${count_reference_ranges}][options_name][]" class="form-control" placeholder="Positive" required>
            </td>
            <td>
                <select name="component[${count_component}][reference_ranges][${count_reference_ranges}][options_status][]"  class="form-control basic" required>
                    <option selected="selected" value="normal">Normal</option>
                    <option value="abnormal">Abnormal</option>
                    </select>
            </td>
            <td>
                <button type="submit" class="btn btn-warning delete_option">
                    <i class="fa fa-trash"></i>
                </button>
            </td>
        </tr>

    `)
})

$(document).on('click', '.delete_option', function () {
    $(this).closest('tr').remove()
    option_count--;
})

$(document).on('click', '.update_option', function () {
    option_count++;
    let options = $(this).closest('table').children('tbody')
    options.append(`

        <tr>
            <td>
                <input type="text" name="reference_ranges[${count_reference_ranges}][options_name][]" class="form-control" placeholder="Positive" required>
            </td>
            <td>
                <select name="reference_ranges[${count_reference_ranges}][options_status][]" class="form-control basic" required>
                    <option selected="selected" value="normal">Normal</option>
                    <option value="abnormal">Abnormal</option>
                    </select>
            </td>
            <td>
                <button type="submit" class="btn btn-warning delete_update_option">
                    <i class="fa fa-trash"></i>
                </button>
            </td>
        </tr>

    `)
})

$(document).on('click', '.delete_update_option', function () {
    $(this).closest('tr').remove()
    option_count--;
})


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
    buttons: [
        {
            extend: 'excelHtml5',
            text: '<i class="fas fa-file-excel"></i> ' + trans("Excel"),
            titleAttr: 'Excel'
        },
        {
            extend: 'csvHtml5',
            text: '<i class="fas fa-file-csv"></i> ' + trans("CVS"),
            titleAttr: 'CSV'
        },
        {
            extend: 'colvis',
            text: '<i class="fas fa-eye"></i>',
            titleAttr: 'PDF'
        }

    ],
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
        { data: "sample_type", sortable: false, orderable: false },
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

//get category select2 intialize
$('#sample_type_1_id').select2({
    width: "100%",
    placeholder: trans("Sample Type"),
    ajax: {
        beforeSend: function () {
            $('.preloader').show();
            $('.loader').show();
        },
        url: admin_ajax_url('get_sample_types'),
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

//get category select2 intialize
$('#sample_type_2_id').select2({
    width: "100%",
    placeholder: trans("Sample Type") + ' 2',
    ajax: {
        beforeSend: function () {
            $('.preloader').show();
            $('.loader').show();
        },
        url: admin_ajax_url('get_sample_types'),
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

//add consumption
console.log(count_consumption)
$(document).on('click', '.add_consumption', function () {
    count_consumption++;
    console.log(count_consumption)
    $('.test_consumptions').append(`
    <tr class="consumption_row">
        <td>
            <select class="form-control product_id consumption_product" name="consumptions[${count_consumption}][product_id]" required>
                <option value="" selected></option>
            </select>
        </td>
        <td>
            <input type="number" class="form-control" name="consumptions[${count_consumption}][quantity]" placeholder="${trans("Quantity")}" required>
        </td>
        <td>
            <button type="button"
                class="btn btn-sm btn-danger delete_consumption">
                <i class="fa fa-trash"></i>
            </button>
        </td>
    </tr>

    `);

    $('.consumption_product').select2({
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
});
$('.consumption_product').select2({
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
//delete consumption
$(document).on('click', '.delete_consumption', function () {
    $(this).closest('.consumption_row').remove();
});
