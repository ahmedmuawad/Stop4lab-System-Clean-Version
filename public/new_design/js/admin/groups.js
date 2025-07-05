//currency
var currency = $('#system_currency').val();
var patient_code = $('#patient_code').val();
var contract_id = $('#contract_id').val();
//branch
var branch_id = $('#branch_id').val();
//patient_id
var visit_patient_id = $('#visit_patient_id').val();
//payment count
var payments_count = $('#payments_count').val();
//system date
var current_date = $('#system_date').val();

(function($) {
    "use strict";

    //active
    $('#groups').addClass('active');

    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!
    var yyyy = today.getFullYear();


    // setTimeout(() => {
    //     $('#groups_table').dataTable().fnFilter($('#filter_branch').val());
    // }, 1000);

    //datepicker
    var date = new Date();
    var current_year = date.getFullYear();

    $('.payment_datepicker').datepicker({
        dateFormat: "yy-mm-dd",
        changeYear: true,
        changeMonth: true,
        yearRange: "1900:" + current_year
    });

    //admin groups datatable
    table = $('#groups_table').DataTable({
        "lengthMenu": [
            [25, 50, 100, 500, 1000, -1],
            [25, 50, 100, 500, 1000, "All"]
        ],
        dom: "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-4'i><'col-sm-8'p>>",
        buttons: [
            {
                extend:    'excelHtml5',
                text:      '<i class="fas fa-file-excel"></i> '+trans("Excel"),
                titleAttr: 'Excel'
            },
            {
                extend:    'csvHtml5',
                text:      '<i class="fas fa-file-csv"></i> '+trans("CVS"),
                titleAttr: 'CSV'
            },
            {
                extend:    'colvis',
                text:      '<i class="fas fa-eye"></i>',
                titleAttr: 'PDF'
            }
        ],
        "processing": true,
        "serverSide": true,
        "order": [
            [1, "desc"]
        ],
        "ajax": {
            url: url("admin/get_groups"),
            data: function(data) {
                data.filter_date = $('#filter_date').val();
                data.filter_created_by = $('#filter_created_by').val();
                data.filter_signed_by = $('#filter_signed_by').val();
                data.filter_status = $('#filter_status').val();
                data.filter_barcode = $('#filter_barcode').val();
                data.filter_contract = $('#filter_contract').val();
                data.labs = $('#lab').val();
                data.government_id = $('#government_id').val();
                data.region_id = $('#region_id').val();
                data.rep_id = $('#rep_id').val();
            }
        },
        // orderCellsTop: true,
        fixedHeader: true,
        "columns": [
            { data: "bulk_checkbox", sortable: false, orderable: false },
            { data: "id", sortable: true, orderable: true },
            { data: "created_by_user.name", sortable: false, orderable: false },
            // { data: "barcode", orderable: false, sortable: false },
            { data: "patient.code", orderable: false, sortable: false },
            { data: "patient.name", orderable: false, sortable: false },
            // { data: "contract.title", orderable: false, sortable: false },
            { data: "subtotal", orderable: false, sortable: false },
            // { data: "discount", orderable: false, sortable: false },
            { data: "total", orderable: false, sortable: false },
            { data: "paid", orderable: false, sortable: false },
            { data: "due", orderable: false, sortable: false },
            { data: "delayed_money", orderable: false, sortable: false },
            { data: "created_at", searchable: true, sortable: true, orderable: true },
            { data: "branch.name", searchable: true, sortable: true, orderable: true },
            { data: "done", searchable: false, orderable: false, sortable: false }, //done
            { data: "action", searchable: false, orderable: false, sortable: false } //action
        ],
        "footerCallback": function(row, data, start, end, display) {
            var api = this.api(),
                data;

            // Remove the formatting to get integer data for summation
            var intVal = function(i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            // Summary
            var subtotal = api
                .column(7)
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            var discount = api
                .column(8)
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            var total = api
                .column(9)
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            var paid = api
                .column(10)
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            var due = api
                .column(11)
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);


            // Total over this page
            $('#summary_subtotal').html(formated_price(Math.round(subtotal, 2)));
            $('#summary_discount').html(formated_price(Math.round(discount, 2)));
            $('#summary_total').html(formated_price(Math.round(total, 2)));
            $('#summary_paid').html(formated_price(Math.round(paid, 2)));
            $('#summary_due').html(formated_price(Math.round(due, 2)));
        },
        "drawCallback": function(settings) {

            let total_amount = 0;
            $('.bulk_checkbox').change(function() {
                if(this.checked) {
                    if (typeof $(this).data('delayed_money') != 'string') {
                        total_amount += parseInt($(this).data('delayed_money'))
                    }
                } else {
                    if (typeof $(this).data('delayed_money') != 'string') {
                        if(total_amount - parseInt($(this).data('delayed_money')) <= 0) {
                            total_amount = 0
                        } else {
                            total_amount -=parseInt($(this).data('delayed_money'))
                        }
                    }
                }
                $('#total_delayed_money').text(total_amount)
            });

            var row_id = [];
            this.api().cells(null, 0).every(function() {
                row_id.push(this.data());
            });
        },
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
        },
    });

    $(document).on('change', '.filter_today_of_branch', function(e) {
        e.preventDefault();

        $('#groups_table').dataTable().fnFilter(this.value);

    })

    $('#filter_status').on('change', function() {
        table.draw();
    });

    $('#filter_barcode').on('input', function() {
        table.draw();
    });

    // filter date
    var ranges = {};
    ranges[trans('Today')] = [moment(), moment()];
    ranges[trans('Yesterday')] = [moment().subtract('days', 1), moment().subtract('days', 1)];
    ranges[trans('Last 7 Days')] = [moment().subtract('days', 6), moment()];
    ranges[trans('Last 30 Days')] = [moment().subtract('days', 29), moment()];
    ranges[trans('This Month')] = [moment().startOf('month'), moment().endOf('month')];
    ranges[trans('Last Month')] = [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')];
    ranges[trans('This Year')] = [moment().startOf('year'), moment().endOf('year')];
    ranges[trans('Last Year')] = [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')];

    $('#filter_date').daterangepicker({
            locale: {
                format: 'YYYY/MM/DD',
                "applyLabel": trans("Save"),
                "cancelLabel": trans("Cancel"),
            },
            ranges,
            startDate: moment(),
            endDate: moment()
        },
        function(start, end) {
            $('#dateRange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        });

    $('#filter_date').on('cancel.daterangepicker', function() {
        $(this).val('');
        table.draw();
    });

    $('#filter_date').on('apply.daterangepicker', function() {
        table.draw();
    });

    $('#filter_date').val('');

    //get users select2 intialize
    $('.user_id').select2({
        allowClear: true,
        multiple: true,
        width: "100%",
        placeholder: trans("User"),
        ajax: {
            beforeSend: function() {
                $('.preloader').show();
                $('.loader').show();
            },
            url: ajax_url('get_users'),
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            complete: function() {
                $('.preloader').hide();
                $('.loader').hide();
            }
        }
    });

    $('#filter_created_by').on('change', function() {
        table.draw();
    });

    $('#filter_signed_by').on('change', function() {
        table.draw();
    });

    //get contracts select2 intialize
    $('#filter_contract').select2({
        multiple: true,
        width: "100%",
        placeholder: trans("Contract"),
        ajax: {
            beforeSend: function() {
                $('.preloader').show();
                $('.loader').show();
            },
            url: ajax_url('get_contracts'),
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.title,
                            id: item.id
                        }
                    })
                };
            },
            complete: function() {
                $('.preloader').hide();
                $('.loader').hide();
            }
        }
    });

    //filter datatable by contract
    $('#filter_contract').on('change', function() {
        table.draw();

        var contract_id = $(this).val();

        var url = $(this).attr('data-url');
        // send request ajax
        $.ajax({
            url: url,
            type: 'GET',
            data: {
                contract_id: contract_id[0],
            },
            beforeSend: function() {
                $('.preloader').show();
                $('.loader').show();
            },
            success: function(data) {
                if (data.status == 'success') {
                    if(data.lab_to_lab) {
                        $('.lab-to-lab').removeClass('d-none').addClass('d-block')
                    } else {
                        $('.lab-to-lab').addClass('d-none').removeClass('d-block')
                    }
                } else {
                    console.log(data.message);
                }
            },
            complete: function() {
                $('.preloader').hide();
                $('.loader').hide();
            }
        });

    });

    //get labs select2 intialize
    $('#lab').select2({
        width:"100%",
        placeholder:trans("labs"),
        multiple: true,
        ajax: {
            beforeSend:function()
            {
                $('.preloader').show();
                $('.loader').show();
            },
            url:ajax_url('get_labs'),
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.lab_code + '-' + item.name ,
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
    $('#lab').on('change', function() {table.draw();});


    //get representative select2 intialize
    $('#rep').select2({
        width:"100%",
        placeholder:trans("labs"),
        multiple: true,
        ajax: {
            beforeSend:function()
            {
                $('.preloader').show();
                $('.loader').show();
            },
            url:ajax_url('get_reps'),
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name ,
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
    $('#rep').on('change', function() {table.draw();});

    $('#government_id').on('change', function() {table.draw();});
    $('#region_id').on('change', function() {table.draw();});
    $('#rep_id').on('change', function() {table.draw();});

    //contract select2
    $('#contract_discount').select2({
        placeholder: trans("Select contract"),
        width: '100%'
    });


    if (branch_id != null) {
        $('#branch').val(branch_id);
    }

    if (!isNaN(patient_code)) {
        //QRCode
        $(".patient_qrcode").ClassyQR({
            create: true,
            size: '180',
            type: 'url',
            url: url('patient/login/' + patient_code)
        });
    }

    $('footer').addClass('no-print');


    //get doctor select2 intialize
    $('#doctor').select2({
        width: "100%",
        placeholder: trans("Doctor"),
        ajax: {
            beforeSend: function() {
                $('.preloader').show();
                $('.loader').show();
            },
            url: ajax_url('get_doctors'),
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            complete: function() {
                $('.preloader').hide();
                $('.loader').hide();
            }
        }
    });
    //get  normal doctor select2 intialize
    $('#normal_doctor').select2({
        width: "100%",
        placeholder: trans("Doctor"),
        ajax: {
            beforeSend: function() {
                $('.preloader').show();
                $('.loader').show();
            },
            url: ajax_url('get_normal_doctors'),
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.name + '-' + item.code ,
                            id: item.id
                        }
                    })
                };
            },
            complete: function() {
                $('.preloader').hide();
                $('.loader').hide();
            }
        }
    });

    //get contracts select2 intialize
    $('#patient_contract_id').select2({
        width: "84%",
        allowClear: true,
        placeholder: trans("Select contract"),
        ajax: {
            beforeSend: function() {
                $('.preloader').show();
                $('.loader').show();
            },
            url: ajax_url('get_contracts'),
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.title,
                            id: item.id
                        }
                    })
                };
            },
            complete: function() {
                $('.preloader').hide();
                $('.loader').hide();
            }
        }
    });

    //get contracts select2 intialize
    $('#edit_patient_contract_id').select2({
        width: "84%",
        allowClear: true,
        placeholder: trans("Select contract"),
        ajax: {
            beforeSend: function() {
                $('.preloader').show();
                $('.loader').show();
            },
            url: ajax_url('get_contracts'),
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.title,
                            id: item.id
                        }
                    })
                };
            },
            complete: function() {
                $('.preloader').hide();
                $('.loader').hide();
            }
        }
    });

    //get patient by code
    $('#patient_code').select2({
        width: "100%",
        placeholder: trans("Patient Code"),
        ajax: {
            beforeSend: function() {
                $('.preloader').show();
                $('.loader').show();
            },
            url: ajax_url('get_patient_by_code'),
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.code,
                            id: item.id
                        }
                    })
                };
            },
            complete: function() {
                $('.preloader').hide();
                $('.loader').hide();
            }
        }
    });

    //selected code
    $(document).on('select2:select', '#patient_code', function(e) {
        var el = $(e.target);
        var data = e.params.data;
        $.ajax({
            url: ajax_url('get_patient' + '?id=' + data.id),
            beforeSend: function() {
                $('.preloader').show();
                $('.loader').show();
            },
            success: function(patient) {
                $("#patient_name").append('<option value="' + patient.id + '">' + patient.name + '</option>');
                $("#patient_name").val(patient.id).trigger('change');
                $("#patient_phone").val(patient.phone);
                $("#patient_phone2").val(patient.phone2);
                $("#patient_email").val(patient.email);
                $("#prefix").val(patient.prefix);
                $("#gender").val(patient.gender);
                if(patient.gender != 'male' ){
                    $('.date_pms').removeClass('d-none').addClass('d-block');
                    $("#date_pms").val(patient.date_pms);
                }else{
                    $('.date_pms').addClass('d-none').removeClass('d-block');
                };

                $("#hours_fasting").val(patient.hours_fasting);
                $("#dob").val(patient.dob);
                $("#age").val(patient.age);
                $("#patient_address").val(patient.address);
                $("#patient_national_id").val(patient.national_id);
                $("#passport_no").val(patient.passport_no);
                $('#contract_id').val(patient.contract_id).trigger('change');
                //contract
                if (patient.contract !== null) {
                    $('#contract_title').prop('disabled', false);
                    $('#contract_title').val(patient.contract_id);
                    if(patient.contract.title == 'Lab to lab') {
                        $('.lab-to-lab').removeClass('d-none').addClass('d-block');
                    } else {
                        $('.lab-to-lab').addClass('d-none').removeClass('d-block');
                    }
                } else {
                    $('#contract_title').val('');
                    $('.lab-to-lab').addClass('d-none').removeClass('d-block');
                }
                //nationality
                if (patient.country !== null) {
                    $('#nationality').val(patient.country.nationality);
                } else {
                    $('#nationality').val('');
                }
                //avatar
                if (patient.avatar !== null) {
                    $('#patient_avatar').parent('a').attr('href', url('uploads/patient-avatar/' + patient.avatar));
                    $('#patient_avatar').attr('src', url('uploads/patient-avatar/' + patient.avatar));
                } else {
                    $('#patient_avatar').parent('a').attr('href', url('img/avatar.png'));
                    $('#patient_avatar').attr('src', url('img/avatar.png'));
                }
            },
        });
    });

    //get patient by name select2
    $('#patient_name').select2({
        width: "100%",
        placeholder: trans("Patient Name"),
        ajax: {
            beforeSend: function() {
                $('.preloader').show();
                $('.loader').show();
            },
            url: ajax_url('get_patient_by_name'),
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            complete: function() {
                $('.preloader').hide();
                $('.loader').hide();
            }
        }
    });

    //selected name
    $(document).on('select2:select', '#patient_name', function(e) {
        var el = $(e.target);
        var data = e.params.data;
        $.ajax({
            url: ajax_url('get_patient' + '?id=' + data.id),
            beforeSend: function() {
                $('.preloader').show();
                $('.loader').show();
            },
            success: function(patient) {
                $("#patient_code").append('<option value="' + patient.id + '">' + patient.code + '</option>');
                $("#patient_code").val(patient.id).trigger('change');
                $("#patient_phone").val(patient.phone);
                $("#patient_phone2").val(patient.phone2);
                $("#patient_email").val(patient.email);
                $("#prefix").val(patient.prefix);
                $("#gender").val(patient.gender);
                if(patient.gender != 'male' ){
                    $('.date_pms').removeClass('d-none').addClass('d-block');
                    $("#date_pms").val(patient.date_pms);
                }else{
                    $('.date_pms').addClass('d-none').removeClass('d-block');
                };
                $("#hours_fasting").val(patient.hours_fasting);
                $("#dob").val(patient.dob);
                $("#age").val(patient.age);
                $("#patient_address").val(patient.address);
                $("#patient_national_id").val(patient.national_id);
                $("#passport_no").val(patient.passport_no);
                $('#contract_id').val(patient.contract_id).trigger('change');
                if (patient.fluid_patient == 1) {
                    $('#fluid_patient').prop('checked', true);
                } else {
                    $('#fluid_patient').prop('checked', false);
                }
                if (patient.diabetic == 1) {
                    $('#diabetic').prop('checked', true);
                } else {
                    $('#diabetic').prop('checked', false);
                }
                if (patient.liver_patient == 1) {
                    $('#liver_patient').prop('checked', true);
                } else {
                    $('#liver_patient').prop('checked', false);
                }
                if (patient.pregnant == 1) {
                    $('#pregnant').prop('checked', true);
                } else {
                    $('#pregnant').prop('checked', false);
                }
                if (patient.gland == 1) {
                    $('#gland').prop('checked', true);
                } else {
                    $('#gland').prop('checked', false);
                }
                if (patient.tumors == 1) {
                    $('#tumors').prop('checked', true);
                } else {
                    $('#tumors').prop('checked', false);
                }
                if (patient.antibiotic == 1) {
                    $('#antibiotic').prop('checked', true);
                } else {
                    $('#antibiotic').prop('checked', false);
                }
                if (patient.iron == 1) {
                    $('#iron').prop('checked', true);
                } else {
                    $('#iron').prop('checked', false);
                }
                if (patient.cortisone == 1) {
                    $('#cortisone').prop('checked', true);
                } else {
                    $('#cortisone').prop('checked', false);
                }
                $('#answer_other').val(patient.answer_other);
                //contract
                if (patient.contract !== null) {
                    // enable contract
                    $('#contract_title').prop('disabled', false);
                    $('#contract_title').val(patient.contract_id);
                    $('.apply_contract').addClass('disabled');
                    $('.cancel_contract').removeClass('disabled');
                    if(patient.contract.type == 'lab_to_lab') {
                        $('.lab-to-lab').removeClass('d-none').addClass('d-block');
                    } else {
                        $('.lab-to-lab').addClass('d-none').removeClass('d-block');
                    }
                } else {
                    $('#contract_title').val('');
                    $('.apply_contract').addClass('disabled');
                    $('.cancel_contract').addClass('disabled');
                    $('.lab-to-lab').addClass('d-none').removeClass('d-block');
                }
                //nationality
                if (patient.country !== null) {
                    $('#nationality').val(patient.country.nationality);
                } else {
                    $('#nationality').val('');
                }
                //avatar
                if (patient.avatar !== null) {
                    $('#patient_avatar').parent('a').attr('href', url('uploads/patient-avatar/' + patient.avatar));
                    $('#patient_avatar').attr('src', url('uploads/patient-avatar/' + patient.avatar));
                } else {
                    $('#patient_avatar').parent('a').attr('href', url('img/avatar.png'));
                    $('#patient_avatar').attr('src', url('img/avatar.png'));
                }
            },
        });
    });


    //change gender
    $(document).on('change','#create_gender',function(){
        var gender = $('#create_gender').val();
        if(gender != 'male'){
            $('.create_date_pms').removeClass('d-none').addClass('d-block');
            // $('.gender').removeClass('col-md-4').addClass('col-md-2');
        }else{
            $('.create_date_pms').addClass('d-none').removeClass('d-block');
            // $('.gender').addClass('col-md-4').removeClass('col-md-2');
        }
    });

    //change type doctor
    $(document).on('change','#type_doctor',function(){
        var type_doctor = $('#type_doctor').val();
        if(type_doctor == '0'){
            $('.doctor').removeClass('d-none').addClass('d-block');
            $('.normal_doctor').addClass('d-none').removeClass('d-block');
            // $('.gender').removeClass('col-md-4').addClass('col-md-2');
        }else{
            $('.normal_doctor').removeClass('d-none').addClass('d-block');
            $('.doctor').addClass('d-none').removeClass('d-block');
        }
    });

    //change gender
    $(document).on('change','#edit_gender',function(){
        var gender = $('#edit_gender').val();
        if(gender != 'male'){
            $('.edit_date_pms').removeClass('d-none').addClass('d-block');
            // $('.gender').removeClass('col-md-4').addClass('col-md-2');
        }else{
            $('.edit_date_pms').addClass('d-none').removeClass('d-block');
            // $('.gender').addClass('col-md-4').removeClass('col-md-2');
        }
    });

    $(document).on('change', '#contract_title', function() {
        var patient_id = $('#patient_code').val();
        var contract_id = $(this).val();
        var url = $('#contract_title').attr('data-url');

        // send request ajax
        $.ajax({
            url: url,
            type: 'GET',
            data: {
                patient_id: patient_id,
                contract_id: contract_id,
            },
            beforeSend: function() {
                $('.preloader').show();
                $('.loader').show();
            },
            success: function(data) {
                if (data.status == 'success') {
                    toastr.success(data.message);
                    $('#contract_id').val(contract_id)
                    $('.apply_contract').addClass('disabled');
                    $('.cancel_contract').removeClass('disabled');
                    if(data.lab_to_lab) {
                        $('.lab-to-lab').removeClass('d-none').addClass('d-block')
                    } else {
                        $('.lab-to-lab').addClass('d-none').removeClass('d-block')
                    }
                } else {
                    toastr.error(data.message);
                }
            },
            complete: function() {
                $('.preloader').hide();
                $('.loader').hide();
            }
        });

    });

    $(document).on('change', '#contract_title2', function() {
        var contract_id = $(this).val();

        var url = $('#contract_title2').attr('data-url');

        // send request ajax
        $.ajax({
            url: url,
            type: 'GET',
            data: {
                contract_id: contract_id,
            },
            beforeSend: function() {
                $('.preloader').show();
                $('.loader').show();
            },
            success: function(data) {
                if (data.status == 'success') {
                    toastr.success(data.message);
                    $('#contract_id').val(contract_id);
                    $('.apply_contract').addClass('disabled');
                    $('.cancel_contract').removeClass('disabled');
                    if(data.lab_to_lab) {
                        $('.lab-to-lab').removeClass('d-none').addClass('d-block')
                    } else {
                        $('.lab-to-lab').addClass('d-none').removeClass('d-block')
                    }
                } else {
                    console.log(data.message);
                }
            },
            complete: function() {
                $('.preloader').hide();
                $('.loader').hide();
            }
        });

    });

    //contract change
    $(document).on('change', '#contract_id', function() {
        var contract_id = $(this).val();
        var tests_id = [];
        var cultures_id = [];
        var packages_id = [];

        $('.tests_id').each(function() {
            tests_id.push(parseInt($(this).val()))
        });

        $('.cultures_id').each(function() {
            cultures_id.push(parseInt($(this).val()))
        });

        $('.packages_id').each(function() {
            packages_id.push(parseInt($(this).val()))
        });

        if (contract_id !== null && contract_id !== '') {
            $.ajax({
                url: ajax_url('get_contract/' + contract_id + '?tests_id=' + tests_id + '&cultures_id=' + cultures_id + '&packages_id=' + packages_id),
                beforeSend: function() {
                    $('.preloader').show();
                    $('.loader').show();
                },
                success: function(contract) {
                    if (contract !== '' && Object.keys(contract).length > 0) {
                        if (contract.tests !== '' && contract.tests.length > 0) {
                            contract.tests.forEach(function(test) {
                                $('#test_' + test.priceable_id + ' .price').val(test.price);
                                $('#test_' + test.priceable_id + ' .test_price').text(test.price);
                            });
                        }
                        if (contract.cultures !== '' && contract.cultures.length > 0) {
                            contract.cultures.forEach(function(culture) {
                                $('#culture_' + culture.priceable_id + ' .price').val(culture.price);
                                $('#culture_' + culture.priceable_id + ' .culture_price').text(culture.price);
                            });
                        }
                        if (contract.packages !== '' && contract.packages.length > 0) {
                            contract.packages.forEach(function(contract_package) {
                                $('#package_' + contract_package.priceable_id + ' .price').val(contract_package.price);
                                $('#package_' + contract_package.priceable_id + ' .package_price').text(contract_package.price);
                            });
                        }

                        calculate_total();

                        $('.preloader').hide();
                        $('.loader').hide();
                    } else {
                        $('.selected_test').each(function() {
                            var price = $(this).attr('default_price');
                            $(this).find('.price').val(price);
                            $(this).find('.test_price').text(price);
                        });

                        $('.selected_culture').each(function() {
                            var price = $(this).attr('default_price');
                            $(this).find('.price').val(price);
                            $(this).find('.culture_price').text(price);
                        });

                        $('.selected_package').each(function() {
                            var price = $(this).attr('default_price');
                            $(this).find('.price').val(price);
                            $(this).find('.package_price').text(price);
                        });

                        $('#contract_id').val('');

                        $('.invoice-datatable').DataTable().page.len(10).draw();

                        calculate_total();

                        $('.preloader').hide();
                        $('.loader').hide();

                    }
                },
            });
        } else {
            $('.preloader').show();
            $('.loader').show();

            setTimeout(function() {
                $('.preloader').hide();
                $('.loader').hide();
            }, 1000);

            $('.selected_test').each(function() {
                var price = $(this).attr('default_price');
                $(this).find('.price').val(price);
                $(this).find('.test_price').text(price);
            });

            $('.selected_culture').each(function() {
                var price = $(this).attr('default_price');
                $(this).find('.price').val(price);
                $(this).find('.culture_price').text(price);
            });

            $('.selected_package').each(function() {
                var price = $(this).attr('default_price');
                $(this).find('.price').val(price);
                $(this).find('.package_price').text(price);
            });

            $('.invoice-datatable').DataTable().page.len(10).draw();

            calculate_total();
        }
    });

    //cancel contract
    $(document).on('click', '.cancel_contract', function() {
        if ($('#contract_id').val() !== '') {
            $('#contract_id').val('');
            $('#contract_title').val('');
            $('#contract_id').trigger('change');
            $('.apply_contract').removeClass('disabled');
            $('.cancel_contract').addClass('disabled');
        } else {
            toastr.warning(trans('This patient doesn\'t have a contract'), trans('Warning'));
        }
    });

    //apply contract
    $(document).on('click', '.apply_contract', function() {
        var patient_id = $('#patient_code').val();
        var contract_id = $('#contract_id').val();
        if (patient_id != '' && contract_id == '') {
            $.ajax({
                url: ajax_url('get_patient' + '?id=' + patient_id),
                success: function(patient) {
                    if (patient.contract != null) {
                        $('#contract_id').val(patient.contract_id);
                        $('#contract_title').val(patient.contract.title);
                        $('#contract_id').trigger('change');
                        $('.apply_contract').addClass('disabled');
                        $('.cancel_contract').removeClass('disabled');
                    } else {
                        toastr.warning(trans('This patient doesn\'t have a contract'), trans('Warning'));
                    }
                },
            });
        }
    });

    //create patient
    $('#create_patient').on('submit', function(e) {
        e.preventDefault();

        var data = $('#create_patient').serialize();

        var valid = $(this).valid();

        if (valid) {
            $.ajax({
                url: ajax_url("create_patient"),
                type: "post",
                data: data,
                beforeSend: function() {
                    $('.preloader').show();
                    $('.loader').show();
                },
                success: function(data) {
                    if (data.fluid_patient == 1) {
                        $('#fluid_patient').prop('checked', true);
                    }
                    if (data.diabetic == 1) {
                        $('#diabetic').prop('checked', true);
                    }
                    if (data.gland == 1) {
                        $('#gland').prop('checked', true);
                    } if (data.tumors == 1) {
                        $('#tumors').prop('checked', true);
                    }
                    if (data.antibiotic == 1) {
                        $('#antibiotic').prop('checked', true);
                    }
                    if (data.iron == 1) {
                        $('#iron').prop('checked', true);
                    }
                    if (data.cortisone == 1) {
                        $('#cortisone').prop('checked', true);
                    }
                    if (data.liver_patient == 1) {
                        $('#liver_patient').prop('checked', true);
                    }
                    if (data.pregnant == 1) {
                        $('#pregnant').prop('checked', true);
                    }
                    $('#answer_other').val(data.answer_other);
                    $('#patient_name').append(`<option value="` + data.id + `">` + data.name + `</option>`);
                    $('#patient_name').val(data.id);
                    $('#patient_name').trigger({
                        type: 'select2:select',
                        params: {
                            data: {
                                id: data.id,
                                text: data.name
                            }
                        }
                    });
                    $('#patient_modal').modal('hide');
                    $('#patient_modal_error').html(``);
                    $('#create_patient_inputs input').val(``);
                    $('#create_patient_inputs #create_patient_contract_id').val(``).trigger('change');
                    $('#create_patient_inputs #create_country_id').val(``).trigger('change');

                    toastr.success(trans('Patient saved successfully'), trans('Success'));
                },
                error: function(xhr, status, error) {
                    toastr.error(trans('Something went wrong'), trans('Failed'));
                    var errors = xhr.responseJSON.errors;
                    var error_html = `<div class="callout callout-danger">
                                 <h5 class="text-danger">
                                    <i class="fa fa-times"></i> ` + trans('Failed') + `
                                 </h5>
                                 <ul>`;
                    for (var key in errors) {
                        error_html += `<li>` + errors[key] + `</li>`;
                    }
                    error_html += `</ul></div>`;
                    $('#patient_modal_error').html(error_html);
                },
                complete: function() {
                    $('.preloader').hide();
                    $('.loader').hide();
                }
            });

        } else {
            return false;
        }
    });

    //create doctor
    $('#create_doctor').on('submit', function(e) {
        e.preventDefault();

        var data = $('#create_doctor').serialize();

        var valid = $(this).valid();

        if (valid) {
            $.ajax({
                url: ajax_url("create_doctor"),
                type: "post",
                data: data,
                beforeSend: function() {
                    $('.preloader').show();
                    $('.loader').show();
                },
                success: function(data) {
                    $('#doctor').append(`<option value="` + data.id + `">` + data.name + `</option>`);
                    $('#doctor').val(data.id).trigger('select2:select');
                    $('#doctor_modal').modal('hide');
                    toastr.success(trans('Patient saved successfully'), trans('Success'));
                    $('#doctor_modal_error').html(``);
                    $('#create_doctor_inputs input').val(``);
                },
                error: function(xhr, status, error) {
                    toastr.error(trans('Something went wrong'), trans('Failed'));
                    var errors = xhr.responseJSON.errors;
                    var error_html = `<div class="callout callout-danger">
                                    <h5 class="text-danger">
                                       <i class="fa fa-times"></i> ` + trans("Failed") + `
                                    </h5>
                                    <ul>`;
                    for (var key in errors) {
                        error_html += `<li>` + errors[key] + `</li>`;
                    }
                    error_html += `</ul></div>`;
                    $('#doctor_modal_error').html(error_html);
                },
                complete: function() {
                    $('.preloader').hide();
                    $('.loader').hide();
                }
            });
        }
    });
    //create doctor
    $('#create_normal_doctor').on('submit', function(e) {
        e.preventDefault();

        var data = $('#create_normal_doctor').serialize();

        var valid = $(this).valid();

        if (valid) {
            $.ajax({
                url: ajax_url("create_normal_doctor"),
                type: "post",
                data: data,
                beforeSend: function() {
                    $('.preloader').show();
                    $('.loader').show();
                },
                success: function(data) {
                    $('#normal_doctor').append(`<option value="` + data.id + `">` + data.name + `</option>`);
                    $('#normal_doctor').val(data.id).trigger('select2:select');
                    $('#normal_doctor_modal').modal('hide');
                    toastr.success(trans('Patient saved successfully'), trans('Success'));
                    $('#doctor_modal_error').html(``);
                    $('#create_doctor_inputs input').val(``);
                },
                error: function(xhr, status, error) {
                    toastr.error(trans('Something went wrong'), trans('Failed'));
                    var errors = xhr.responseJSON.errors;
                    var error_html = `<div class="callout callout-danger">
                                    <h5 class="text-danger">
                                       <i class="fa fa-times"></i> ` + trans("Failed") + `
                                    </h5>
                                    <ul>`;
                    for (var key in errors) {
                        error_html += `<li>` + errors[key] + `</li>`;
                    }
                    error_html += `</ul></div>`;
                    $('#doctor_modal_error').html(error_html);
                },
                complete: function() {
                    $('.preloader').hide();
                    $('.loader').hide();
                }
            });
        }
    });

    //create payment method
    $(document).on('submit', '#create_payment_method', function(e) {
        e.preventDefault();

        var data = $('#create_payment_method').serialize();

        var valid = $(this).valid();

        if (valid) {
            $.ajax({
                url: ajax_url("create_payment_method"),
                type: "post",
                data: data,
                beforeSend: function() {
                    $('.preloader').show();
                    $('.loader').show();
                },
                success: function(data) {
                    $('#create_payment_method_modal').modal('hide');
                    toastr.success(trans('Payment method created successfully'), trans('Success'));
                    $('#payment_method_modal_error').html(``);
                    $('#create_payment_method_inputs input').val(``);
                },
                error: function(xhr, status, error) {
                    toastr.error(trans('Something went wrong'), trans('Failed'));
                    var errors = xhr.responseJSON.errors;
                    var error_html = `<div class="callout callout-danger">
                                    <h5 class="text-danger">
                                       <i class="fa fa-times"></i> ` + trans("Failed") + `
                                    </h5>
                                    <ul>`;
                    for (var key in errors) {
                        error_html += `<li>` + errors[key] + `</li>`;
                    }
                    error_html += `</ul></div>`;
                    $('#payment_method_modal_error').html(error_html);
                },
                complete: function() {
                    $('.preloader').hide();
                    $('.loader').hide();
                }
            });
        }
    });

    //calculations
    $('#discount').on('change', function() {
        var discount = parseFloat($(this).val());
        var subtotal = parseFloat($('#subtotal').val());
        $('#contract_discount').val('').trigger('change');

        if (isNaN(discount) || discount <= 0) {
            $('#discount').val(0);
        }

        if (discount > subtotal) {
            toastr.error(trans('Discount should be less than subtotal'), trans('failed'));
            $('#discount').val(0);
        }

        calculate_total();
    });

    //paid
    $('#paid').on('change', function() {
        var paid = $(this).val();
        if (isNaN(paid) || paid <= 0) {
            $('#paid').val(0);
        }
        calculate_total();
    });

    //end calculations

    //delete group
    $(document).on('click', '.delete_group', function(e) {
        e.preventDefault();
        var el = $(this);
        swal({
                title: trans("Are you sure to delete group ?"),
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: trans("Delete"),
                cancelButtonText: trans("Cancel"),
                closeOnConfirm: false
            }).then((e) => {
                if (e.value) {
                    $(el).parent().submit();
                }
        });
    });

    //submit form
    $('#group_form').on('submit', function() {
        var count_tests = $('.selected_test').length;
        var count_cultures = $('.selected_culture').length;
        var count_packages = $('.selected_package').length;
        var count_rays = $('.selected_ray').length;

        if (!count_tests && !count_cultures && !count_packages && !count_rays) {
            toastr.error(trans('Please select at least one test'), trans('Failed'));
            return false;
        }
    });

    //home visit patient
    if (visit_patient_id != null) {
        var visit_patient_name = $('#visit_patient_id').attr('patient_name');
        var data = {
            id: visit_patient_id,
            text: visit_patient_name
        };
        var newOption = new Option(data.text, data.id, false, false);
        $('#patient_name').append(newOption).trigger('change');
        $.ajax({
            url: ajax_url('get_patient' + '?id=' + visit_patient_id),
            beforeSend: function() {
                $('.preloader').show();
                $('.loader').show();
            },
            success: function(patient) {
                $("#patient_code").append('<option value="' + patient.id + '">' + patient.code + '</option>');
                $("#patient_code").val(patient.id).trigger('change');
                $("#patient_phone").val(patient.phone);
                $("#patient_phone2").val(patient.phone);
                $("#patient_email").val(patient.email);
                $("#gender").val(patient.gender);
                $("#dob").val(patient.dob);
                $("#patient_address").val(patient.address);
            },
            complete: function() {
                $('.preloader').hide();
                $('.loader').hide();
            }
        });
    }

    //print barcode
    $(document).on('click', '.print_barcode', function() {
        var group_id = $(this).attr('group_id');
        $('#print_barcode_form').attr('action', url('admin/groups/print_barcode/' + group_id));
    });

    $(document).on('submit', '#print_barcode_form', function() {
        $('#print_barcode_modal').modal('toggle');
    });

    //add payment
    $(document).on('click', '#add_payment', function() {
        payments_count++;
        $('#payments_table tbody').append(`
         <tr>
            <td>
               <input type="date" class="form-control " name="payments[` + payments_count + `][date]" placeholder="` + trans('Date') + `" value="` + current_date + `" required>
            </td>
            <td>
               <input type="number" class="form-control amount" name="payments[` + payments_count + `][amount]" placeholder="` + trans('Amount') + `" value="0" required>
            </td>
            <td>
               <select name="payments[` + payments_count + `][payment_method_id]" class="form-control payment_method_id" required>
                  <option value="" disabled selected>` + trans('Select payment method') + `</option>
               </select>
            </td>
            <td>
               <button type="button" class="btn btn-danger delete_payment">
                  <i class="fa fa-times"></i>
               </button>
            </td>
         </tr>`);

        $('.new_datepicker').datepicker({
            dateFormat: "yy-mm-dd",
            changeYear: true,
            changeMonth: true,
            yearRange: "1900:" + current_year
        });

        //select2 payment methods
        $('.payment_method_id').select2({
            width: "100%",
            placeholder: trans("Select payment method"),
            ajax: {
                beforeSend: function() {
                    $('.preloader').show();
                    $('.loader').show();
                },
                url: ajax_url('get_payment_methods'),
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                },
                complete: function() {
                    $('.preloader').hide();
                    $('.loader').hide();
                }
            }
        });
    });

    //change amount
    $(document).on('change', '.amount', function() {
        var amount = parseFloat($(this).val());
        if (amount == '' || amount < 0) {
            $(this).val(0);
        }

        var total = parseFloat($('#total').val());
        var paid = 0;
        $('.amount').each(function() {
            paid += parseFloat($(this).val());
        });
        if (paid > total) {
            $(this).val(0);
            toastr.warning(trans('Payment amount should be less than total price'), trans('warning'));
        }
        calculate_total();
    });

    //delete payment
    $(document).on('click', '.delete_payment', function() {
        $(this).closest('tr').remove();

        calculate_total();
    });

    //select2 payment methods
    $('.payment_method_id').select2({
        width: "100%",
        placeholder: trans("Select payment method"),
        ajax: {
            beforeSend: function() {
                $('.preloader').show();
                $('.loader').show();
            },
            url: ajax_url('get_payment_methods'),
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            complete: function() {
                $('.preloader').hide();
                $('.loader').hide();
            }
        }
    });


    //edit patient
    $(document).on('click', '#edit_patient', function() {
        var patient_id = $('#patient_code').val();

        if (patient_id !== null) {
            $.ajax({
                url: ajax_url('get_patient?id=' + patient_id),
                beforeSend: function() {
                    $('.preloader').show();
                    $('.loader').show();
                },
                success: function(patient) {

                    $('#edit_patient_form').attr('action', ajax_url('edit_patient/' + patient.id));

                    $('#edit_name').val(patient.name);
                    $('#edit_national_id').val(patient.national_id);
                    $('#edit_passport_no').val(patient.passport_no);
                    $('#edit_email').val(patient.email);
                    $('#edit_phone').val(patient.phone);
                    $('#edit_phone2').val(patient.phone2);
                    $('#edit_date_pms').val(patient.date_pms);
                    $('#edit_hours_fasting').val(patient.hours_fasting);
                    $('#edit_gender').val(patient.gender);
                    if(patient.gender != 'male' ){
                        $('.edit_date_pms').removeClass('d-none').addClass('d-block');
                        $("#edit_date_pms").val(patient.date_pms);
                    }else{
                        $('.edit_date_pms').addClass('d-none').removeClass('d-block');
                    };

                    $('#edit_dob').val(patient.dob).trigger('change');
                    $('#edit_address').val(patient.address);
                    $('#edit_age').val(patient.age_splited.age);
                    $('#edit_age_unit').val(patient.age_splited.age_unit);
                    if (patient.fluid_patient == 1) {
                        $('#edit_fluid_patient').val(1);
                        $('#edit_fluid_patient').prop('checked', true);
                    } else {
                        $('#edit_fluid_patient').val(0);
                        $('#edit_fluid_patient').prop('checked', false);
                    }
                    if (patient.diabetic == 1) {
                        $('#edit_diabetic').val(1);
                        $('#edit_diabetic').prop('checked', true);
                    } else {
                        $('#edit_diabetic').val(0);
                        $('#edit_diabetic').prop('checked', false);
                    }
                    if (patient.gland == 1) {
                        $('#edit_gland').val(1);
                        $('#edit_gland').prop('checked', true);
                    } else {
                        $('#edit_gland').val(0);
                        $('#edit_gland').prop('checked', false);
                    }
                    if (patient.tumors == 1) {
                        $('#edit_tumors').val(1);
                        $('#edit_tumors').prop('checked', true);
                    } else {
                        $('#edit_tumors').val(0);
                        $('#edit_tumors').prop('checked', false);
                    }
                    if (patient.antibiotic == 1) {
                        $('#edit_antibiotic').val(1);
                        $('#edit_antibiotic').prop('checked', true);
                    } else {
                        $('#edit_antibiotic').val(0);
                        $('#edit_antibiotic').prop('checked', false);
                    }
                    if (patient.iron == 1) {
                        $('#edit_iron').val(1);
                        $('#edit_iron').prop('checked', true);
                    } else {
                        $('#edit_iron').val(0);
                        $('#edit_iron').prop('checked', false);
                    }
                    if (patient.cortisone == 1) {
                        $('#edit_cortisone').val(1);
                        $('#edit_cortisone').prop('checked', true);
                    } else {
                        $('#edit_cortisone').val(0);
                        $('#edit_cortisone').prop('checked', false);
                    }
                    if (patient.liver_patient == 1) {
                        $('#edit_liver_patient').val(1);
                        $('#edit_liver_patient').prop('checked', true);
                    } else {
                        $('#edit_liver_patient').val(0);
                        $('#edit_liver_patient').prop('checked', false);
                    }
                    if (patient.pregnant == 1) {
                        $('#edit_pregnant').val(1);
                        $('#edit_pregnant').prop('checked', true);
                    } else {
                        $('#edit_pregnant').val(0);
                        $('#edit_pregnant').prop('checked', false);
                    }
                    $('#edit_answer_other').val(patient.answer_other);
                    //contract
                    if (patient.contract !== null) {
                        $('#contract_title').prop('disabled', false);
                        $('#edit_patient_contract_id').append(`
                     <option value="` + patient.contract_id + `" selected>` + patient.contract.title + `</option>
                  `);

                        $('#edit_patient_contract_id').val(patient.contract_id).trigger('change');
                    } else {
                        $('#edit_patient_contract_id').val('').trigger('change');
                    }
                    //nationality
                    if (patient.country !== null) {
                        $('#edit_country_id').append(`
                     <option value="` + patient.country_id + `" selected>` + patient.country.name + `</option>
                  `);

                        $('#edit_country_id').val(patient.country_id).trigger('change');
                    } else {
                        $('#edit_country_id').val('').trigger('change');
                    }


                    $('#edit_patient_modal').modal('show');
                },
                complete: function() {
                    $('.preloader').hide();
                    $('.loader').hide();
                }
            });
        } else {
            toastr.error(trans('Please select patient first'));
        }
    });

    $('#edit_patient_form').on('submit', function(e) {
        e.preventDefault();

        var data = $('#edit_patient_form').serialize();

        var valid = $(this).valid();
        if (valid) {
            $.ajax({
                url: $('#edit_patient_form').attr('action'),
                type: "post",
                data: data,
                beforeSend: function() {
                    $('.preloader').show();
                    $('.loader').show();
                },
                success: function(data) {
                    $("#patient_name").select2("destroy");
                    $('#patient_name').html('');
                    $('#patient_name').append(`<option value="` + data.id + `" selected>` + data.name + `</option>`);
                    $('#patient_name').select2({
                        width: "100%",
                        placeholder: trans("Patient Name"),
                        ajax: {
                            beforeSend: function() {
                                $('.preloader').show();
                                $('.loader').show();
                            },
                            url: ajax_url('get_patient_by_name'),
                            processResults: function(data) {
                                return {
                                    results: $.map(data, function(item) {
                                        return {
                                            text: item.name,
                                            id: item.id
                                        }
                                    })
                                };
                            },
                            complete: function() {
                                $('.preloader').hide();
                                $('.loader').hide();
                            }
                        }
                    });
                    $('#patient_name').trigger({
                        type: 'select2:select',
                        params: {
                            data: {
                                id: data.id,
                                text: data.name
                            }
                        }
                    });
                    $('#edit_patient_modal').modal('hide');
                    $('#edit_patient_modal_error').html(``);
                    $('#edit_patient_inputs input').val(``);
                    $('#edit_patient_inputs #edit_patient_contract_id').val(``).trigger('change');
                    $('#edit_patient_inputs #edit_country_id').val(``).trigger('change');
                    toastr.success(trans('Patient saved successfully'), trans('Success'));
                },
                error: function(xhr, status, error) {
                    toastr.error(trans('Something went wrong'), trans('Failed'));
                    var errors = xhr.responseJSON.errors;
                    var error_html = `<div class="callout callout-danger">
                                 <h5 class="text-danger">
                                    <i class="fa fa-times"></i> ` + trans('Failed') + `
                                 </h5>
                                 <ul>`;
                    for (var key in errors) {
                        error_html += `<li>` + errors[key] + `</li>`;
                    }
                    error_html += `</ul></div>`;
                    $('#edit_patient_modal_error').html(error_html);
                },
                complete: function() {
                    $('.preloader').hide();
                    $('.loader').hide();
                }
            });

        } else {
            return false;
        }
    });

    //get age from dob
    $('#create_dob').on('change', function() {
        var dob = $(this).val();

        if (dob != '') {
            $.ajax({
                url: ajax_url('get_age/' + dob),
                beforeSend: function() {
                    $('.preloader').show();
                    $('.loader').show();
                },
                success: function(age) {
                    $('#create_age').val(age.age);
                    $('#create_age_unit').val(age.unit);
                },
                complete: function() {
                    $('.preloader').hide();
                    $('.loader').hide();
                }
            })
        }
    });

    //get dob from age
    $('#create_age').on('change', function() {
        var age_number = $('#create_age').val();
        var age_unit = $('#create_age_unit').val();
        var age = age_number + ' ' + age_unit;

        if (age_number !== null && age_unit !== null) {
            $.ajax({
                url: ajax_url('get_dob/' + age),
                beforeSend: function() {
                    $('.preloader').show();
                    $('.loader').show();
                },
                success: function(dob) {
                    $('#create_dob').val(dob);
                },
                complete: function() {
                    $('.preloader').hide();
                    $('.loader').hide();
                }
            })
        }
    });

    //get dob from age
    $('#create_age_unit').on('change', function() {
        var age_number = $('#create_age').val();
        var age_unit = $('#create_age_unit').val();
        var age = age_number + ' ' + age_unit;

        if (age_number !== null && age_unit !== null) {
            $.ajax({
                url: ajax_url('get_dob/' + age),
                beforeSend: function() {
                    $('.preloader').show();
                    $('.loader').show();
                },
                success: function(dob) {
                    $('#create_dob').val(dob);
                },
                complete: function() {
                    $('.preloader').hide();
                    $('.loader').hide();
                }
            })
        }
    });

    //country select2
    $('#create_country_id').select2({
        width: "85%",
        allowClear: true,
        placeholder: trans("Select nationality"),
        ajax: {
            beforeSend: function() {
                $('.preloader').show();
                $('.loader').show();
            },
            url: ajax_url('get_countries'),
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.nationality,
                            id: item.id
                        }
                    })
                };
            },
            complete: function() {
                $('.preloader').hide();
                $('.loader').hide();
            }
        }
    });

    //country select2
    $('#edit_country_id').select2({
        width: "85%",
        allowClear: true,
        placeholder: trans("Select nationality"),
        ajax: {
            beforeSend: function() {
                $('.preloader').show();
                $('.loader').show();
            },
            url: ajax_url('get_countries'),
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.nationality,
                            id: item.id
                        }
                    })
                };
            },
            complete: function() {
                $('.preloader').hide();
                $('.loader').hide();
            }
        }
    });

    //create avatar
    $(document).on('change', '#create_avatar', function() {
        var avatar = document.getElementById('create_avatar').files[0];
        getBase64(avatar, 'create');
    });

    //change avatar
    $(document).on('change', '#edit_avatar', function() {
        var avatar = document.getElementById('edit_avatar').files[0];
        getBase64(avatar, 'edit');
    });

    //delete patient avatar
    $(document).on('click', '#delete_patient_avatar', function() {
        var patient_id = $('#patient_name').val();
        if (patient_id !== null) {
            $.ajax({
                beforeSend: function() {
                    $('.preloader').show();
                    $('.loader').show();
                },
                url: ajax_url('delete_patient_avatar/' + patient_id),
                success: function() {
                    $('#patient_avatar').attr('src', url('img/avatar.png'));
                    toastr_success(trans('Avatar deleted successfully'));
                },
                complete: function() {
                    $('.preloader').hide();
                    $('.loader').hide();
                }
            });
        } else {
            toastr_error(trans('No patient selected'));
        }
    });

    //select ray
    $('#select_ray').select2({
        width: "100%",
        placeholder: trans("Rays"),
        ajax: {
            url: ajax_url('get_invoice_rays'),
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.id + ' - ' + item.name + ' ( ' + item.category.name + ' )',
                            id: item.id,
                        }
                    })
                };
            },
        }
    });

    //select test
    $('#select_test').select2({
        width: "100%",
        placeholder: trans("Tests"),
        ajax: {
            url: ajax_url('get_invoice_tests'),
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.id + ' - ' + item.name + ' ( ' + item.category.name + ' )',
                            id: item.id,
                        }
                    })
                };
            },
        }
    });

    //select in calculator

    //select test
    $('#select_test_calc').select2({
        width: "100%",
        placeholder: trans("Tests"),
        ajax: {
            url: ajax_url('get_invoice_tests'),
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.name + ' ( ' + item.category.name + ' )',
                            id: item.id,
                        }
                    })
                };
            },
        }
    });

    $('#select_test').on('select2:select', function() {
        var test_id = $(this).val();
        var contract_id = $('#contract_id').val();

        if ($('#selected_tests').find('#test_' + test_id).length == 0) {
            $.ajax({
                url: ajax_url('get_invoice_test?test_id=' + test_id + '&contract_id=' + contract_id),
                beforeSend: function() {
                    $('.preloader').show();
                    $('.loader').show();
                },
                success: function(test) {
                    if(test.lab_to_lab_status == 0){
                        test.lab_to_lab_status = 'In';
                    }else{
                        test.lab_to_lab_status = 'Out';
                    };
                    $('#selected_tests').append(`
                  <tr class="selected_test" id="test_` + test.id + `" default_price="` + test.price + `">
                     <td>
                        ` + test.name + `
                        <input type="hidden" class="tests_id" name="tests[` + test_id + `][id]" value="` + test_id + `">
                        <input type="hidden" class="price" name="tests[` + test_id + `][price]" value="` + test.current_price + `">
                        <input type="hidden" class="cost_lab_to_lab" name="tests[` + test_id + `][cost]" value="` + test.lab_to_lab_cost + `">
                     </td>
                     <td class="test_price">
                        ` + test.current_price + `
                     </td>
                     <td>
                        ` + test.lab_to_lab_status + `
                     </td>
                     <td>
                        ` + test.lab_to_lab_cost + `
                     </td>
                     <td>
                        <button type="button" class="btn btn-danger btn-sm delete_selected_row">
                           <i class="fa fa-trash"></i>
                        </button>
                     </td>
                  </tr>
               `);

                    calculate_total();
                },
                complete: function() {
                    $('.preloader').hide();
                    $('.loader').hide();
                },
            });
        } else {
            toastr_error(trans('This test already has been selected'));
        }
        $('#select_test').val(null).trigger('change');
    });


    $('#select_ray').on('select2:select', function() {
        var ray_id = $(this).val();
        var contract_id = $('#contract_id').val();

        if ($('#selected_rays').find('#ray_' + ray_id).length == 0) {
            $.ajax({
                url: ajax_url('get_invoice_ray?ray_id=' + ray_id + '&contract_id=' + contract_id),
                beforeSend: function() {
                    $('.preloader').show();
                    $('.loader').show();
                },
                success: function(ray) {

                    $('#selected_rays').append(`
                  <tr class="selected_ray" id="ray_` + ray.id + `" default_price="` + ray.price + `">
                     <td>
                        ` + ray.name + `
                        <input type="hidden" class="rays_id" name="rays[` + ray_id + `][id]" value="` + ray_id + `">
                        <input type="hidden" class="price" name="rays[` + ray_id + `][price]" value="` + ray.current_price + `">
                     </td>
                     <td>
                        ` + ray.category.name + `
                     </td>
                     <td class="ray_price">
                        ` + ray.current_price + `
                     </td>
                     <td>
                        <button type="button" class="btn btn-danger btn-sm delete_selected_row">
                           <i class="fa fa-trash"></i>
                        </button>
                     </td>
                  </tr>
               `);

                    calculate_total();
                },
                complete: function() {
                    $('.preloader').hide();
                    $('.loader').hide();
                },
            });
        } else {
            toastr_error(trans('This test already has been selected'));
        }
        $('#select_test').val(null).trigger('change');
    });

    $('#select_test_calc').on('select2:select', function() {
        var test_id = $(this).val();
        var contract_id = $('#contract_id').val();
        if ($('#selected_tests').find('#test_' + test_id).length == 0) {
            $.ajax({
                url: ajax_url('get_invoice_test?test_id=' + test_id + '&contract_id=' + contract_id),
                beforeSend: function() {
                    $('.preloader').show();
                    $('.loader').show();
                },
                success: function(test) {
                    $('#selected_tests').append(`
                  <tr class="selected_test" id="test_` + test.id + `" default_price="` + test.price + `">
                     <td>
                        ` + test.name + `
                        <input type="hidden" class="tests_id" name="tests[` + test_id + `][id]" value="` + test_id + `">
                        <input type="hidden" class="price" name="tests[` + test_id + `][price]" value="` + test.current_price + `">
                     </td>
                     <td class="test_price">
                        ` + test.current_price + `
                     </td>
                     <td>
                        ` + test.sample_type + `
                     </td>
                     <td>
                        ` + test.num_day_receive + `
                     </td>
                     <td>
                        <button type="button" class="btn btn-danger btn-sm delete_selected_row">
                           <i class="fa fa-trash"></i>
                        </button>
                     </td>
                  </tr>
               `);

                    calculate_total();
                },
                complete: function() {
                    $('.preloader').hide();
                    $('.loader').hide();
                },
            });
        } else {
            toastr_error(trans('This test already has been selected'));
        }
        $('#select_test_calc').val(null).trigger('change');
    });

    //select culture
    $('#select_culture').select2({
        width: "100%",
        placeholder: trans("Cultures"),
        ajax: {
            url: ajax_url('get_invoice_cultures'),
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.name + ' ( ' + item.category.name + ' )',
                            id: item.id,
                        }
                    })
                };
            },
        }
    });

    $('#select_culture').on('select2:select', function() {
        var culture_id = $(this).val();
        var contract_id = $('#contract_id').val();
        if ($('#selected_cultures').find('#culture_' + culture_id).length == 0) {
            $.ajax({
                url: ajax_url('get_invoice_culture?culture_id=' + culture_id + '&contract_id=' + contract_id),
                beforeSend: function() {
                    $('.preloader').show();
                    $('.loader').show();
                },
                success: function(culture) {
                    if(culture.lab_to_lab_status == 0){
                        culture.lab_to_lab_status = 'In';
                    }else{
                        culture.lab_to_lab_status = 'Out';
                    };
                    $('#selected_cultures').append(`
                  <tr class="selected_culture" id="culture_` + culture.id + `" default_price="` + culture.price + `">
                     <td>
                        ` + culture.name + `
                        <input type="hidden" class="cultures_id" name="cultures[` + culture_id + `][id]" value="` + culture_id + `">
                        <input type="hidden" class="price" name="cultures[` + culture_id + `][price]" value="` + culture.current_price + `">
                        <input type="hidden" class="cost_lab_to_lab" name="cultures[` + culture_id + `][cost]" value="` + culture.lab_to_lab_cost + `">
                     </td>
                     <td class="culture_price">
                        ` + culture.current_price + `
                     </td>
                     <td>
                        ` + culture.lab_to_lab_status + `
                     </td>
                     <td>
                        ` + culture.lab_to_lab_cost + `
                     </td>
                     <td>
                        <button type="button" class="btn btn-danger btn-sm delete_selected_row">
                           <i class="fa fa-trash"></i>
                        </button>
                     </td>
                  </tr>
               `);

                    calculate_total();
                },
                complete: function() {
                    $('.preloader').hide();
                    $('.loader').hide();
                },
            });
        } else {
            toastr_error(trans('This culture already has been selected'));
        }
        $('#select_culture').val(null).trigger('change');
    });


    //select culture
    $('#select_culture_calc').select2({
        width: "100%",
        placeholder: trans("Cultures"),
        ajax: {
            url: ajax_url('get_invoice_cultures'),
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.name + ' ( ' + item.category.name + ' )',
                            id: item.id,
                        }
                    })
                };
            },
        }
    });


    $(document).on('change', '.check-test', function() {

        var checked = $(this).is(':checked');

        if (checked) {
            $(this).next().val($(this).val());
        } else {
            $(this).next().val('');
        }

    });




    $('#select_culture_calc').on('select2:select', function() {
        var culture_id = $(this).val();
        var contract_id = $('#contract_id').val();
        if ($('#selected_cultures').find('#culture_' + culture_id).length == 0) {
            $.ajax({
                url: ajax_url('get_invoice_culture?culture_id=' + culture_id + '&contract_id=' + contract_id),
                beforeSend: function() {
                    $('.preloader').show();
                    $('.loader').show();
                },
                success: function(culture) {
                    $('#selected_cultures').append(`
                  <tr class="selected_culture" id="culture_` + culture.id + `" default_price="` + culture.price + `">
                     <td>
                        ` + culture.name + `
                        <input type="hidden" class="cultures_id" name="cultures[` + culture_id + `][id]" value="` + culture_id + `">
                        <input type="hidden" class="price" name="cultures[` + culture_id + `][price]" value="` + culture.current_price + `">
                        <input type="hidden" class="cost_lab_to_lab" name="cultures[` + culture_id + `][cost]" value="` + culture.lab_to_lab_cost + `">
                     </td>
                     <td>
                        ` + culture.category.name + `
                     </td>
                     <td class="culture_price">
                        ` + culture.current_price + `
                     </td>
                     <td>
                        <button type="button" class="btn btn-danger btn-sm delete_selected_row">
                           <i class="fa fa-trash"></i>
                        </button>
                     </td>
                  </tr>
               `);

                    calculate_total();
                },
                complete: function() {
                    $('.preloader').hide();
                    $('.loader').hide();
                },
            });
        } else {
            toastr_error(trans('This culture already has been selected'));
        }
        $('#select_culture').val(null).trigger('change');
    });

    //select package
    $('#select_package').select2({
        width: "100%",
        placeholder: trans("Packages"),
        ajax: {
            url: ajax_url('get_invoice_packages'),
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.name,
                            id: item.id,
                        }
                    })
                };
            },
        }
    });

    $('#select_package').on('select2:select', function() {
        var package_id = $(this).val();
        var contract_id = $('#contract_id').val();
        if ($('#selected_packages').find('#package_' + package_id).length == 0) {
            $.ajax({
                url: ajax_url('get_invoice_package?package_id=' + package_id + '&contract_id=' + contract_id),
                beforeSend: function() {
                    $('.preloader').show();
                    $('.loader').show();
                },
                success: function(selected_package) {

                    let mainTests = selected_package.tests;
                    let tests = [];

                    if (mainTests.length > 0) {
                        for (let i = 0; i < mainTests.length; i++) {
                            tests.push(mainTests[i].test.name);
                        }
                    }

                    $('#selected_packages').append(`
                  <tr class="selected_package" id="package_` + selected_package.id + `" default_price="` + selected_package.price + `">
                     <td>
                        ` + selected_package.name + ` <br>

                        ` + tests + ` <br>

                        <input type="hidden" class="packages_id" name="packages[` + package_id + `][id]" value="` + package_id + `">
                        <input type="hidden" class="price" name="packages[` + package_id + `][price]" value="` + selected_package.current_price + `">
                        <input type="hidden" class="cost_lab_to_lab" name="packages[` + package_id + `][cost]" value="` + selected_package.lab_to_lab_cost + `">
                     </td>
                     <td class="package_price">
                        ` + selected_package.current_price + `
                     </td>
                     <td>
                        ` + selected_package.lab_to_lab_status + `
                     </td>
                     <td>
                        ` + selected_package.lab_to_lab_cost + `
                     </td>
                     <td>
                        <button type="button" class="btn btn-danger btn-sm delete_selected_row">
                           <i class="fa fa-trash"></i>
                        </button>
                     </td>
                  </tr>
               `);

                    calculate_total();
                },
                complete: function() {
                    $('.preloader').hide();
                    $('.loader').hide();
                },
            });
        } else {
            toastr_error(trans('This package already has been selected'));
        }
        $('#select_package').val(null).trigger('change');
    });

    //select package
    $('#select_package_calc').select2({
        width: "100%",
        placeholder: trans("Packages"),
        ajax: {
            url: ajax_url('get_invoice_packages'),
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.name,
                            id: item.id,
                        }
                    })
                };
            },
        }
    });

    $('#select_package_calc').on('select2:select', function() {
        var package_id = $(this).val();
        var contract_id = $('#contract_id').val();
        if ($('#selected_packages_calc').find('#package_' + package_id).length == 0) {
            $.ajax({
                url: ajax_url('get_invoice_package?package_id=' + package_id + '&contract_id=' + contract_id),
                beforeSend: function() {
                    $('.preloader').show();
                    $('.loader').show();
                },
                success: function(selected_package) {

                    let mainTests = selected_package.tests;
                    let tests = [];

                    if (mainTests.length > 0) {
                        for (let i = 0; i < mainTests.length; i++) {
                            tests.push(mainTests[i].test.name);
                        }
                    }

                    $('#selected_packages_calc').append(`
                      <tr class="selected_package" id="package_` + selected_package.id + `" default_price="` + selected_package.price + `">
                         <td>
                            ` + selected_package.name + ` <br>

                            ` + tests + ` <br>

                            <input type="hidden" class="packages_id" name="packages[` + package_id + `][id]" value="` + package_id + `">
                            <input type="hidden" class="price" name="packages[` + package_id + `][price]" value="` + selected_package.current_price + `">
                            <input type="hidden" class="cost_lab_to_lab" name="packages[` + package_id + `][cost]" value="` + selected_package.lab_to_lab_cost + `">
                         </td>
                         <td class="package_price">
                            ` + selected_package.current_price + `
                         </td>
                         <td>
                            <button type="button" class="btn btn-danger btn-sm delete_selected_row">
                               <i class="fa fa-trash"></i>
                            </button>
                         </td>
                      </tr>
                   `);

                    calculate_total();
                },
                complete: function() {
                    $('.preloader').hide();
                    $('.loader').hide();
                },
            });
        } else {
            toastr_error(trans('This package already has been selected'));
        }
        $('#select_package').val(null).trigger('change');
    });

    //delete selected row
    $(document).on('click', '.delete_selected_row', function() {
        $(this).closest('tr').remove();
        calculate_total();
    });



})(jQuery);


//calculations
function calculate_total() {
    //calculate subtotal
    var subtotal = 0;
    var labCost = 0;

    $('.price').each(function() {
        var price = parseFloat($(this).val());
        subtotal += parseFloat(price);
    });

    $('.cost_lab_to_lab').each(function() {

        var cost = parseFloat($(this).val());
        labCost += parseFloat(cost);

    });


    subtotal = Math.round(parseFloat(subtotal));

    labCost = Math.round(parseFloat(labCost));

    $('#subtotal').val(subtotal);
    $('#lab_cost').val(labCost);

    //calculate discount
    // var discount = 0;


    var discount = $("#discount_value").val();
    // if (discount_percentage.val()) {
    //     discount = (subtotal * discount_percentage.val()) / 100;
    // }

    //calculate paid
    var paid = 0;
    $('#payments_table .amount').each(function() {
        paid += parseFloat($(this).val());
    });

    paid = Math.round(paid);

    //calculate total
    var total = ( parseInt(subtotal) - parseInt(discount));

    total = Math.round(total);

    $('#total').val(total);
    $('#after_lab').val(total - labCost);

    //calculate due
    $('#paid').val(paid);

    var due = total - paid - parseInt($('#delayed_money').val());

    due = Math.round(due);

    $('#due').val(due);
}

$('#delayed_money').on('change', function() {
    if ($('#subtotal').val() != 0) {

        var subtotal = 0;

        $('.price').each(function() {
            var price = parseFloat($(this).val());
            subtotal += parseFloat(price);
        });
        subtotal = Math.round(parseFloat(subtotal));

        var discount = $("#discount_value").val();

        var paid = 0;
        $('#payments_table .amount').each(function() {
            paid += parseFloat($(this).val());
        });

        //calculate total
        var total = ( parseInt(subtotal) - parseInt(discount));
        $('#due').val(Math.round(total) - Math.round(paid) - $(this).val());
    }
    // $('#due').val();
})
//delete group test
function delete_row() {
    var confirm = window.confirm(trans('Are you sure to delete group test ?'));
    return confirm;
}

function getBase64(file, type) {
    if (file == undefined || file == null) {
        $('#' + type + '_patient_avatar_hidden').val('');

        return;
    }
    var reader = new FileReader();
    reader.readAsDataURL(file);
    data = reader.onload = function() {
        $('#' + type + '_patient_avatar_hidden').val(reader.result);
    };
    reader.onerror = function(error) {
        console.log('Error: ', error);
    };
}


