@extends('layouts.app')

@section('title')
    {{ __('Testes Branch Report') }}
@endsection
@section('breadcrumb')
          <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
          <li class="breadcrumb-item active">{{__('Testes Branch Report')}}</li>
@endsection
@section('content')
    <div class="app-content content ">
        <div class="card-body">

            <!-- Filtering Form -->
            <div id="accordion">
                <div class="card card-info">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="btn btn-primary collapsed"
                        aria-expanded="false">
                        <i class="fas fa-filter"></i> {{ __('Filters') }}
                    </a>
                    <form method="get" action="{{ route('admin.reports.testes_branch') }}">
                        <div id="collapseOne" class="panel-collapse in collapse show">
                            <div class="card-body">
                                <div class="row">
                                    <!-- date range -->
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <label>{{ __('Date range') }}:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="date"
                                                class="form-control float-right datepickerrange"
                                                @if (request()->has('date')) value="{{ $date }}" @endif
                                                required>
                                        </div>
                                    </div>
                                    <!-- \date range -->

                                    <!-- branches -->
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group">
                                            <label>{{ __('Branch') }}</label>
                                            <select class="form-control" name="branches" id="branch" required>
                                                @if (isset($branches))
                                                    @foreach ($branches as $branch)
                                                        <option value="{{ $branch['id'] }}" selected>{{ $branch['name'] }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <!-- \branches -->

                                    <!-- branches -->
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group">
                                            <label>{{ __('Type Report') }}</label>
                                            <select class="form-control select2" name="type" required>
                                                <option @if (isset($type_input) && $type_input == '0') selected @endif value="0">
                                                    {{ __('Tests') }}</option>
                                                <option @if (isset($type_input) && $type_input == '1') selected @endif value="1">
                                                    {{ __('Cultures') }}</option>
                                                <option @if (isset($type_input) && $type_input == '2') selected @endif value="2">
                                                    {{ __('Packages') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- \branches -->

                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-cog"></i>
                                    {{ __('Generate') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Filtering Form -->
            @if (request()->has('date'))
                <!-- Report Details -->
                <div class="card-body">

                    <div class="tab-content" id="custom-tabs-one-tabContent">
                        <div class="tab-pane fade active show" id="custom-tabs-one-invoices" role="tabpanel"
                            aria-labelledby="custom-tabs-one-invoices-tab">
                            <div class="row">
                                <div class="col-lg-12 table-responsive">

                                    <!-- Report summary -->
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h5 class="card-title">
                                                {{ __('Summary') }}
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-2 col-sm-12 col-xs-12 mt-4 mb-4 custom-info-box">
                                                    <div class="row">
                                                        <div class="col-2 col-sm-4 col-xs-4">
                                                            <span class="icon">
                                                                <span class="text-center">
                                                                    <i class="fa fa-money-bill-wave"></i>
                                                                </span>
                                                            </span>
                                                        </div>
                                                        <div class="col-7 col-sm-8 col-xs-8">
                                                            <h4 class="m-0">
                                                                {{ $groupTests->sum('data') }}
                                                            </h4>
                                                            <span>
                                                                {{ __('Total Count') }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-sm-12 col-xs-12 mt-4 mb-4 custom-secondary-box">
                                                    <div class="row">
                                                        <div class="col-2 col-sm-4 col-xs-4">
                                                            <span class="icon">
                                                                <span class="text-center">
                                                                    <i class="fa fa-money-bill-wave"></i>
                                                                </span>
                                                            </span>
                                                        </div>
                                                        <div class="col-7 col-sm-8 col-xs-8">
                                                            <h4 class="m-0">
                                                                {{ formated_price($groupTests->sum('price')) }}
                                                            </h4>
                                                            <span>
                                                                {{ __('Total Value') }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-sm-12 col-xs-12 mt-4 mb-4 custom-primary-box">
                                                    <div class="row">
                                                        <div class="col-3 col-sm-4 col-xs-4">
                                                            <span class="icon">
                                                                <span class="text-center">
                                                                    <i class="fa fa-money-bill-wave"></i>
                                                                </span>
                                                            </span>
                                                        </div>
                                                        <div class="col-7 col-sm-8 col-xs-8">
                                                            <h4 class="m-0">
                                                                {{ count($groupTests) }}
                                                            </h4>
                                                            <span>
                                                                {{ __('Count Test') }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- \Report summary -->
                                    <table class="table table-striped  table-bordered datatable">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Test') }}</th>
                                                <th>{{ __('Count') }}</th>
                                                <th>{{ __('Value') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($groupTests as $test)
                                                <tr>
                                                    <td>{{ $test->testName }}</td>
                                                    <td>{{ $test->data }}</td>
                                                    <td>{{ $test->price }} {{ get_currency() }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- \Report Details -->
            @endif
        </div>
        @if (request()->has('date'))
            <div class="card-footer">
                <a href="{{ request()->fullUrl() }}&pdf=true" class="btn btn-danger" target="_blank">
                    <i class="fas fa-file-pdf"></i> {{ __('PDF') }}
                </a>
            </div>
        @endif
    </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ url('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ url('plugins/print/jQuery.print.min.js') }}"></script>
    <script src="{{ url('js/admin/report_details.js') }}"></script>
    <script>
        // $('#reports_work_load_month').removeClass('active');
        $('#reports_testes_branch').addClass('active');
    </script>
@endsection
