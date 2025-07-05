@extends('layouts.app')

@section('title')
    {{ __('Calculator') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <label class="d-block">{{ __('Contract') }}</label>
                <button type="button" class="btn btn-danger btn-xs float-right cancel_contract ">
                    {{ __('Cancel') }}
                </button>
                <button type="button" class="mb-1 btn btn-success btn-xs float-right mr-1 ml-1 apply_contract ">
                    {{ __('Apply') }}
                </button>
                <input type="hidden" name="contract_id" id="contract_id"readonly>
                <select name="" id="contract_title2" data-url="{{ route('admin.calculate_contract_id') }}"
                    class="form-control" style="
        width: 60%;" required>
                    <option label="" disabled selected>select contract</option>
                    @foreach ($contracts as $contract)
                        <option value="{{ $contract->id }}">{{ $contract->title }}</option>
                    @endforeach
                </select>


            </div>
        </div>
        <div
            class="col-lg-3 lab-to-lab d-none @if (isset($group) and $group->contract != null) @if ($group->contract->type == 'lab_to_lab') d-block @endif @endif">
            <div class="form-group">
                <label for="government_id">{{ __('Government') }}</label>
                <select name="government_id" id="government_id" class="form-control">
                    <option></option>
                    @foreach ($governments as $government)
                        <option @if (isset($group)) @if ($government->id == $group->government_id) selected @endif
                            @endif value="{{ $government->id }}">{{ $government->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div
            class="col-lg-3 lab-to-lab d-none @if (isset($group) and $group->contract != null) @if ($group->contract->type == 'lab_to_lab') d-block @endif @endif">
            <div class="form-group">
                <label for="region_id">{{ __('Region') }}</label>
                <select name="region_id" id="region_id" class="form-control">
                    <option></option>
                </select>

            </div>
        </div>

        <div
            class="col-lg-3 lab-to-lab d-none @if (isset($group) and $group->contract != null) @if ($group->contract->type == 'lab_to_lab') d-block @endif @endif">
            <div class="form-group">
                <label for="user_id">{{ __('Lab') }}</label>
                <select name="user_id" id="user_id" class="form-control select2">
                </select>
            </div>
        </div>

        <div
            class="col-lg-3 lab-to-lab d-none @if (isset($group) and $group->contract != null) @if ($group->contract->type == 'lab_to_lab') d-block @endif @endif">
            <div class="form-group">
                <label for="rep_id">{{ __('Representative') }}</label>
                <select name="rep_id" id="rep_id" class="form-control">
                    <option></option>
                </select>
            </div>
        </div>
    </div>

    <div class="calc_show d-none">
        <div class="row">
            <div class="col-lg-4">
                <div class="card card-primary">
                    <div class="card-header">
                        <h5 class="card-title">
                            {{ __('Tests') }}
                        </h5>
                    </div>
                    <div class="card-header">
                        <select name="" id="select_test_calc" class="form-control"></select>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th width="40%">
                                        {{ __('Name') }}
                                    </th>
                                    <th width="20%">
                                        {{ __('Category') }}
                                    </th>
                                    <th>
                                        {{ __('Price') }}
                                    </th>
                                    <th>
                                        {{ __('sample type') }}
                                    </th>
                                    <th>
                                        {{ __('days') }}
                                    </th>
                                    <th width="10px">
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="selected_tests">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card card-primary">
                    <div class="card-header">
                        <h5 class="card-title">
                            {{ __('Cultures') }}
                        </h5>
                    </div>
                    <div class="card-header">
                        <select name="" id="select_culture_calc" class="form-control"></select>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th width="50%">
                                        {{ __('Name') }}
                                    </th>
                                    <th width="30%">
                                        {{ __('Category') }}
                                    </th>
                                    <th>
                                        {{ __('Price') }}
                                    </th>
                                    <th width="10px">
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="selected_cultures">
                                @if (isset($group))
                                    @foreach ($group['cultures'] as $culture)
                                        <tr class="selected_culture" id="culture_{{ $culture['culture_id'] }}"
                                            default_price="{{ $culture['culture']['culture_price']['price'] }}">
                                            <td>
                                                {{ $culture['culture']['name'] }}
                                                <input type="hidden" class="cultures_id"
                                                    name="cultures[{{ $culture['culture_id'] }}][id]"
                                                    value="{{ $culture['culture_id'] }}">
                                            </td>
                                            <td>
                                                {{ $culture['culture']['category']['name'] }}
                                            </td>
                                            <td class="culture_price">
                                                {{ $culture['price'] }}
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm delete_selected_row">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                            <input type="hidden" class="price"
                                                name="cultures[{{ $culture['culture_id'] }}][price]"
                                                value="{{ $culture['price'] }}">
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card card-primary">
                    <div class="card-header">
                        <h5 class="card-title">
                            {{ __('Packages') }}
                        </h5>
                    </div>
                    <div class="card-header">
                        <select name="" id="select_package_calc" class="form-control"></select>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th width="50%">
                                        {{ __('Name') }}
                                    </th>
                                    <th>
                                        {{ __('Price') }}
                                    </th>
                                    <th width="10px">
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="selected_packages_calc">
                                @if (isset($group))
                                    @foreach ($group['packages'] as $package)
                                        <tr class="selected_package" id="package_{{ $package['package_id'] }}"
                                            default_price="{{ $package['package']['package_price']['price'] }}">
                                            <td>
                                                {{ $package['package']['name'] }}
                                                <input type="hidden" class="packages_id"
                                                    name="packages[{{ $package['package_id'] }}][id]"
                                                    value="{{ $package['package_id'] }}">
                                            </td>
                                            <td class="package_price">
                                                {{ $package['price'] }}
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm delete_selected_row">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                            <input type="hidden" class="price"
                                                name="packages[{{ $package['package_id'] }}][price]"
                                                value="{{ $package['price'] }}">
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <!-- Receipt -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            {{ __('Receipt') }}
                        </h3>
                    </div>
                    <div class="card-body p-0" id="receipt">
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table  table-stripped" id="receipt_table">
                                    <tbody>

                                        <tr>
                                            <td width="100px">{{ __('Subtotal') }}</td>
                                            <td width="300px">
                                                <input type="number" id="subtotal" name="subtotal"
                                                    @if (isset($group)) value="{{ $group['subtotal'] }}" @else value="0" @endif
                                                    readonly class="form-control">
                                            </td>
                                            <td>
                                                {{ get_currency() }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>{{ __('Discount') }}</td>
                                            <td>
                                                <input type="number" class="form-control" id="discount"
                                                    name="discount"
                                                    @if (isset($group)) value="{{ $group['discount'] }}" @else value="0" @endif>
                                            </td>
                                            <td>
                                                <!-- {{ get_currency() }}-->
                                                %
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" id="discount_value"
                                                    name="discount_value"
                                                    @if (isset($group)) value="{{ $group['discount_value'] }}" @else value="0" @endif>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>{{ __('Total') }}</td>
                                            <td>
                                                <input type="number" id="total" name="total" class="form-control"
                                                    @if (isset($group)) value="{{ $group['total'] }}" @else value="0" @endif
                                                    readonly>
                                            </td>
                                            <td>
                                                {{ get_currency() }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- \Receipt -->
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <button onclick="window.print();" class="btn btn-primary form-control">{{ __('print') }}</button>
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
    <script src="{{ url('js/admin/groups.js') }}"></script>
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

            discount_value.val(subtotal / 100 * $(this).val())

        })
        $('#discount_value').keyup(function() {
            var discount = $('#discount');
            var subtotal = $('#subtotal').val();
            var total = $('#total');
            var due = $('#due');

            discount.val($(this).val() * 100 / subtotal);

            total.val(subtotal - $(this).val());
            due.val(subtotal - $(this).val());


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
@endsection
