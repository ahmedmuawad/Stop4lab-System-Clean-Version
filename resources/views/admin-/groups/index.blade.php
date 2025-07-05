@extends('layouts.app')

@section('title')
    {{ __('Invoices') }}
@endsection
@section('css')
    <link rel="stylesheet" href="{{ url('css/print.css') }}">
    <style>
        input[type=checkbox] {
            height: calc(1.4em + 1.4rem + 2px) !important;
        }
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Invoices') }}</li>
@endsection
@section('content')
    <section id="advanced-search-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom">

                        @can('create_group')
                            <a href="{{ route('admin.groups.create') }}" class="t-button btn btn-primary btn-add-record ml-2">
                                <i class="fa fa-plus"></i> {{ __('Create') }}
                            </a>
                            <button class="t-button btn btn-primary btn-add-record ml-2" id="pay_delayed_money"
                                data-url="{{ route('admin.group.pay_delayed_money') }}">
                                <i class="fa fa-dollar-sign"></i> {{ __('Pay delayed money') }}
                                <span id="total_delayed_money" class="" style="font-size: 16px">0</span>
                            </button>
                        @endcan
                    </div>


                    <!-- filter -->

                    <div id="accordion" class="accordion-icons">

                        <div class="card card-info">

                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                                class="btn btn-primary collapsed" aria-expanded="false">

                                <i class="fas fa-filter"></i> {{ __('Filters') }}

                            </a>

                            <div id="collapseOne" class="panel-collapse in collapse">

                                <div class="card-body">

                                    <div class="row">

                                        <div class="col-xl-4 mb-xl-0 mb-2">

                                            <div class="form-group">

                                                <label for="filter_date">{{ __('Date') }}</label>

                                                <input class="form-control flatpickr-input active form-control-sm"
                                                    id="filter_date"placeholder="{{ __('Select Date..') }}">

                                            </div>

                                        </div>
                                        @if (auth()->guard('admin')->user()->lab_id == null)
                                            <div class="col-xl-4 mb-xl-0 mb-2">

                                                <div class="form-group">

                                                    <label for="filter_contract">{{ __('Contract') }}</label>

                                                    <select name="filter_contract" id="filter_contract"
                                                        class="form-control form-control-sm">

                                                    </select>

                                                </div>
                                            </div>


                                            <div class="col-xl-4 mb-xl-0 mb-2">

                                                <div class="form-group">

                                                    <label for="lab_to_lab">{{ __('Lab to Lab') }}</label>

                                                    <select name="lab_to_lab" id="lab_to_lab"
                                                        class="form-control form-control-sm">

                                                    </select>

                                                </div>

                                            </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-xl-4 mb-xl-0 mb-2">

                                            <div class="form-group">

                                                <label for="filter_created_by">{{ __('Created by') }}</label>

                                                <select name="filter_created_by" id="filter_created_by"
                                                    class="form-control form-control-sm-small user_id">

                                                </select>

                                            </div>

                                        </div>

                                        <div class="col-xl-4 mb-xl-0 mb-2">

                                            <div class="form-group">

                                                <label for="filter_signed_by">{{ __('Signed by') }}</label>

                                                <select name="filter_signed_by" id="filter_signed_by"
                                                    class="form-control form-control-sm user_id">

                                                </select>

                                            </div>

                                        </div>

                                        <div class="col-xl-4 mb-xl-0 mb-2">

                                            <div class="form-group">

                                                <label for="filter_status">{{ __('Status') }}</label>

                                                <select name="filter_status" id="filter_status"
                                                    class="form-control form-control-sm">

                                                    <option value="" selected>{{ __('All') }}</option>

                                                    <option value="1">{{ __('Done') }}</option>

                                                    <option value="0">{{ __('Pending') }}</option>

                                                </select>

                                            </div>

                                        </div>
                                    </div>
                                    @endif


                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- \filter -->



                    <hr class="my-0">
                    <div class="card-datatable px-2">
                        <div id="DataTables_Table_2_wrapper" class="dataTables_wrapper dt-bootstrap4 table-responsive"
                            style="width:100% !important;">
                            <div class="d-flex justify-content-between align-items-center mx-0 row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="dataTables_length" id="DataTables_Table_2_length">
                                    </div>
                                </div>
                            </div>
                            <table id="groups_table" class="table table-hover" style="width:100%">
                                <thead style="border-bottom: none;">
                                    <tr role="row">
                                        <th><input type="checkbox" class="check_all" name="" id=""></th>
                                        <th class="sorting" style="font-weight:400 ; font-size:14px;"
                                            aria-label="#: activate to sort column ascending">#</th>
                                        {{--  <th class="sorting" style="font-weight:400 ; font-size:14px;" aria-label="Created By: activate to sort column ascending"><span>{{ __('Created By') }}</span></th>  --}}
                                        <th class="sorting" style="font-weight:400 ; font-size:14px;"
                                            aria-label="Patient Code: activate to sort column ascending">
                                            <span>{{ __('P.Code') }}</span>
                                        </th>
                                        <th width="10px" class="sorting" style="font-weight:400 ; font-size:14px;"
                                            aria-label="Patient Code: activate to sort column ascending">
                                            <span>{{ __('P.Name') }}</span>
                                        </th>
                                        <th class="sorting" style="font-weight:400 ; font-size:14px;"
                                            aria-label="Action: activate to sort column ascending">
                                            <span>{{ __('Action') }}</span>
                                        </th>
                                        <th class="sorting" style="font-weight:400 ; font-size:14px;"
                                            aria-label="Subtotal: activate to sort column ascending">
                                            <span>{{ __('Subtotal') }}</span>
                                        </th>
                                        {{--  <th class="sorting" style="font-weight:400 ; font-size:14px;" aria-label="Total: activate to sort column ascending"><span>{{ __('Total') }}</span></th>  --}}
                                        <th class="sorting" style="font-weight:400 ; font-size:14px;"
                                            aria-label="Paid: activate to sort column ascending">
                                            <span>{{ __('Paid') }}</span>
                                        </th>
                                        <th class="sorting" style="font-weight:400 ; font-size:14px;"
                                            aria-label="Due: activate to sort column ascending">
                                            <span>{{ __('Due') }}</span>
                                        </th>
                                        <th class="sorting" style="font-weight:400 ; font-size:14px;"
                                            aria-label="Paid: activate to sort column ascending">
                                            <span>{{ __('Delayed') }}</span>
                                        </th>
                                        <th class="sorting" style="font-weight:400 ; font-size:14px;"
                                            aria-label="Paid: activate to sort column ascending">
                                            <span>{{ __('Patient Due') }}</span>
                                        </th>
                                        <th class="sorting" style="font-weight:400 ; font-size:14px;"
                                            aria-label="Date: activate to sort column ascending">
                                            <span>{{ __('Date') }}</span>
                                        </th>
                                        <th class="sorting" style="font-weight:400 ; font-size:14px;"
                                            aria-label="Branch: activate to sort column ascending">
                                            <span>{{ __('Branch') }}</span>
                                        </th>
                                        <th class="sorting" style="font-weight:400 ; font-size:14px;"
                                            aria-label="Status: activate to sort column ascending">
                                            <span>{{ __('Status') }}</span>
                                        </th>
                                    </tr>
                                </thead>


                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    @include('admin.groups.modals.print_barcode')
@endsection
@section('scripts')
    <script src="{{ asset('js/admin/groups.js') }}"></script>

    <script>
        var can_delete =
            @can('delete_group')
                true
            @else
                false
            @endcan ;
        var can_view =
            @can('view_group')
                true
            @else
                false
            @endcan ;

    </script>
    <script>
        $(document).on('change', '.check-test', function() {

            var checked = $(this).is(':checked');

            if (checked) {
                $(this).next().val($(this).val());
            } else {
                $(this).next().val('');
            }

        });
        $('.check_all').on('click', function(e) {
            if ($(this).is(':checked', true)) {
                $(".bulk_checkbox").prop('checked', true);
            } else {
                $(".bulk_checkbox").prop('checked', false);
            }
        });

        function add(accumulator, a) {
            return accumulator + a;
        }
        $('#pay_delayed_money').on('click', function(e) {
            var allVals = [];
            var allIds = [];
            $(".bulk_checkbox:checked").each(function() {
                if (typeof $(this).data('delayed_money') != 'string') {
                    allIds.push($(this).val());
                    allVals.push($(this).data('delayed_money'));
                }

            });
            let sum = allVals.reduce(add, 0)
            console.log(allVals, allIds, sum)

            if (allVals.length <= 0) {
                alert("Please select row.");
            } else {
                var check = confirm("Are you sure you want to pay ( " + sum + " LE)?");
                if (check) {
                    $.ajax({
                        url: $(this).data('url'),
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        },
                        data: {
                            ids: allIds,
                            values: allVals
                        },
                        success: function(data) {
                            if (data.success) {
                                alert(data.msg);
                                setTimeout(function() {
                                    window.location.reload();
                                }, 2000);
                            } else {
                                alert(data.msg)
                            }
                        }
                    });
                }

            }
        })
    </script>
    <script>
        // var formSmall = $(".form-small").select2({ tags: true });
        // formSmall.data('select2').$container.addClass('form-control-sm')
    </script>
@endsection
