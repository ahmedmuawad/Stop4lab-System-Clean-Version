@extends('layouts.new_layout_app')
@section('title')
    {{ __('Create invoice') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.groups.index') }}">{{ __('Invoices') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Patient Registeration') }}</li>
@endsection

@section('style')
    <link href="{{ asset('assets/plugins/smart-wizard/css/smart_wizard_all.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datetimepicker/css/classic.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datetimepicker/css/classic.time.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datetimepicker/css/classic.date.css') }}" rel="stylesheet" />
    <link rel="stylesheet"
        href="{{ asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.min.css') }}">
@endsection
<style>
    .select2-selection__rendered {
        line-height: 35px !important;
    }

    .select2-container .select2-selection--single {
        height: 40px !important;
    }

    .select2-selection__arrow {
        height: 40px !important;
    }
</style>

@section('content')
    <!-- Models -->
    <!--\Models-->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Invoices</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item"> <a href="{{ url('/reception/invoices') }}">All Invoices</li>
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx"></i></a>
                            <li class="breadcrumb-item active" aria-current="page"> Patient Registeration</li>
                        </ol>
                    </nav>
                </div>

            </div>
            <!--end breadcrumb-->

            <div class="row">
                <div class="col-xl-12 mx-auto">
                    <h6 class="mb-0 text-uppercase">Create Invoice</h6>
                    <hr />
                    <div class="card">
                        <div class="card-body">
                            <br />
                            <!-- SmartWizard html -->
                            <div id="smartwizard">
                                <ul class="nav">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#step-1"> <strong>Patient Registeration</strong>
                                            <br>Select or Create New Patient</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#step-2"> <strong>Services</strong>
                                            <br>Tests & Culture & Packages</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#step-3"> <strong>Services Info </strong>
                                            <br>Info & Precautions & Questions</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="invoiceDetails" href="#step-4"> <strong>INVOICE </strong>
                                            <br>INVOICE Details</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" href="#step-5"> <strong>Payment</strong>
                                            <br>Payment Details</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#step-6"> <strong>Operation</strong>
                                            <br>Sample Collection & Print</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#step-7"> <strong>Operation</strong>
                                            <br>Sample Handling</a>
                                    </li>

                                </ul>
                                <div class="tab-content" style="height: auto !important;">
                                    <form action="{{ route('admin.groups.store') }}" method="POST" id="group_form">
                                        @csrf
                                        @include('admin.groups.Reception.invoices._form')
                                    </form>
                                    @include('admin.groups.modals.patient_modal')
                                    @include('admin.groups.modals.edit_patient_modal')
                                    @include('admin.groups.modals.doctor_modal')
                                    @include('admin.groups.modals.normal_doctor_modal')
                                    @include('admin.groups.modals.payment_method_modal')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var test_arr = [];
        var culture_arr = [];
        var package_arr = [];

        (function($) {

            "use strict";

            @if (isset($visit))

                //selected tests
                @foreach ($visit['tests'] as $test)
                    test_arr.push('{{ $test['testable_id'] }}');
                @endforeach

                //selected cultures
                @foreach ($visit['cultures'] as $culture)
                    culture_arr.push('{{ $culture['testable_id'] }}');
                @endforeach

                //selected packages
                @foreach ($visit['packages'] as $package)
                    package_arr.push('{{ $package['testable_id'] }}');
                @endforeach
            @endif

        })(jQuery);
    </script>
    <script>
        (function($) {
            "use strict";

            $('#government_id').change(function() {
                $.get("{{ url('admin/visits/') }}" + "/" + jQuery('#government_id').val() + "/get-regions",
                    function(response) {
                        let region_base = document.getElementById('region_id')
                        region_base.innerHTML = "";
                        region_base.innerHTML += "<option></option>";
                        response.data.forEach(function(e) {
                            region_base.innerHTML += "<option value='" + e.id + "" + "'>" + e.name +
                                "</option>";
                        })

                        let rep_base = document.getElementById('rep_id')
                        rep_base.innerHTML = "";
                        rep_base.innerHTML += "<option></option>";
                        response.rep.forEach(function(e) {
                            rep_base.innerHTML += "<option value='" + e.id + "" + "'>" + e.name +
                                "</option>";
                        })
                    }
                );
            })

            $('#region_id').change(function() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('admin.visits.get-users') }}",
                    data: {
                        'government_id': jQuery('#government_id').val(),
                        'region_id': jQuery('#region_id').val()
                    },
                    success: function(response) {
                        console.log(response)
                        let user_base = document.getElementById('user_id')
                        user_base.innerHTML = "";
                        user_base.innerHTML += "<option></option>";
                        response.data.forEach(function(e) {
                            user_base.innerHTML += "<option value='" + e.id + "" + "'>" + e
                                .lab_code + '-' + e.name + "</option>";
                        })
                    }
                });
            })

            @if (isset($visit) && isset($visit['patient']))
                $('#code').append(
                    '<option value="{{ $visit['patient_id'] }}" selected>{{ $visit['patient']['code'] }}</option>'
                );
                $('#code').trigger({
                    type: 'select2:select',
                    params: {
                        data: {
                            id: "{{ $visit['patient_id'] }}",
                            text: "{{ $visit['patient']['code'] }}"
                        }
                    }
                });
            @endif
        })(jQuery);
        $('#discount').keyup(function() {
            var discount_value = $('#discount_value');
            var subtotal = $('#subtotal').val();

            discount_value.val(Math.round(subtotal / 100 * $(this).val()))

        })
        $('#discount_value').keyup(function() {
            var discount = $('#discount');
            var subtotal = $('#subtotal').val();
            var total = $('#total');
            var due = $('#due');

            discount.val(Math.round($(this).val() * 100 / subtotal));

            total.val(subtotal - Math.round($(this).val()));
            due.val(subtotal - Math.round($(this).val()));


        })
    </script>
    <script>
        // change button
        $('.check_ask').on('change', function() {

            if ($(this).is(':checked')) {
                $(this).val(1);
                // this checked
                $(this).prop('checked', true);
            } else {
                $(this).val(0);
                // this unchecked
                $(this).prop('checked', false);
            }
        });
    </script>
    <script src="{{ asset('assets/plugins/smart-wizard/js/jquery.smartWizard.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datetimepicker/js/legacy.js') }}"></script>
    <script src="{{ asset('assets/plugins/datetimepicker/js/picker.js') }}"></script>
    <script src="{{ asset('assets/plugins/datetimepicker/js/picker.time.js') }}"></script>
    <script src="{{ asset('assets/plugins/datetimepicker/js/picker.date.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-material-datetimepicker/js/moment.min.js') }}"></script>
    <script
        src="{{ asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.min.js') }}">
    </script>


    {{--  datepicker  --}}
    <script>
        $('.datepicker').pickadate({
                selectMonths: true,
                selectYears: true
            }),
            $('.timepicker').pickatime()
    </script>
    {{--  select2  --}}
    <script>
        $('.single-select').select2({
            theme: 'bootstrap4',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: Boolean($(this).data('allow-clear')),
        });
    </script>
    {{--  Toolbar Smart Wizard  --}}
    <script>
        $(document).ready(function() {
            // Toolbar extra buttons
            var btnFinish = $('<button></button>').text('Finish').addClass('btn btn-info').on('click', function() {
                alert('Finish Clicked');
            });
            var btnCancel = $('<button></button>').text('Cancel').addClass('btn btn-danger').on('click',
                function() {
                    $('#smartwizard').smartWizard("reset");
                });
            // Step show event
            $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection, stepPosition) {
                $("#prev-btn").removeClass('disabled');
                $("#next-btn").removeClass('disabled');
                if (stepPosition === 'first') {
                    $("#prev-btn").addClass('disabled');
                } else if (stepPosition === 'last') {
                    $("#next-btn").addClass('disabled');
                } else {
                    $("#prev-btn").removeClass('disabled');
                    $("#next-btn").removeClass('disabled');
                }
            });
            // Smart Wizard
            $('#smartwizard').smartWizard({
                selected: 0,
                theme: 'arrows',
                transition: {
                    animation: 'slide-horizontal', // Effect on navigation, none/fade/slide-horizontal/slide-vertical/slide-swing
                },
                toolbarSettings: {
                    toolbarPosition: 'both', // both bottom
                    toolbarExtraButtons: [btnFinish, btnCancel]
                }
            });
            // External Button Events
            $("#reset-btn").on("click", function() {
                // Reset wizard
                $('#smartwizard').smartWizard("reset");
                return true;
            });
            $("#prev-btn").on("click", function() {
                // Navigate previous
                $('#smartwizard').smartWizard("prev");
                return true;
            });
            $("#next-btn").on("click", function() {
                // Navigate next
                $('#smartwizard').smartWizard("next");
                return true;
            });
            // Demo Button Events
            $("#got_to_step").on("change", function() {
                // Go to step
                var step_index = $(this).val() - 1;
                $('#smartwizard').smartWizard("goToStep", step_index);
                return true;
            });
            $("#is_justified").on("click", function() {
                // Change Justify
                var options = {
                    justified: $(this).prop("checked")
                };
                $('#smartwizard').smartWizard("setOptions", options);
                return true;
            });
            $("#animation").on("change", function() {
                // Change theme
                var options = {
                    transition: {
                        animation: $(this).val()
                    },
                };
                $('#smartwizard').smartWizard("setOptions", options);
                return true;
            });
            $("#theme_selector").on("change", function() {
                // Change theme
                var options = {
                    theme: $(this).val()
                };
                $('#smartwizard').smartWizard("setOptions", options);
                return true;
            });
        });
    </script>
    @parent
    {{--  popover  --}}

    <script src="{{ url('js/admin/groups.js') }}"></script>

    <script>
        $(function() {
            $('[data-bs-toggle="popover"]').popover();
            $('[data-bs-toggle="tooltip"]').tooltip();
        })
    </script>
    {{--  Delete Row  --}}
    <script>
        $('input[type="button"]').click(function(e) {
            $(this).closest('tr').remove()
        })
    </script>
@endsection
