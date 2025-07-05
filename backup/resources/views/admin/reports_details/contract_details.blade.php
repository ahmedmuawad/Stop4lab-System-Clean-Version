@extends('layouts.app')

@section('title')
    {{ __('Contract Report') }}
@endsection
@section('breadcrumb')
          <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
          <li class="breadcrumb-item active">{{__('Contract Report')}}</li>
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
                    <form method="get" action="{{ route('admin.reports.contract_details') }}">
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

                                    <!-- Contracts -->
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group">
                                            <label>{{ __('Contract') }}</label>
                                            <select class="form-control select2" name="contract[]" id="contract" multiple>
                                                @foreach ($contracts as $contract)
                                                    <option value="{{ $contract['id'] }}" @if(isset($contractSelected) && in_array($contract['id'] , $contractSelected)) selected @endif>
                                                        {{ $contract['title'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!-- \Contracts -->


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
                                    {{-- <div class="card card-primary">
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
                                    </div> --}}
                                    <!-- \Report summary -->
                                    <table class="table table-striped  table-bordered ">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ __('Contract Name') }}</th>
                                                <th>{{ __('Invoices Count') }}</th>
                                                <th>{{ __('Total') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($contractInvoice as $contract)
                                            {{-- {{ dd($contract->works->toArray()) }} --}}
                                                <tr>
                                                    <td>{{ $contract->id }}</td>
                                                    <td>{{ $contract->title }}</td>
                                                    <td>
                                                       @isset($contract->data)
                                                            {{ $contract->data }}
                                                       @endisset
                                                    </td>
                                                    <td>
                                                       @isset($contract->total)
                                                            {{ $contract->total }} {{ get_currency() }}
                                                       @endisset
                                                    </td>
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
        $('#reports_contract_details').addClass('active');
    </script>
@endsection
