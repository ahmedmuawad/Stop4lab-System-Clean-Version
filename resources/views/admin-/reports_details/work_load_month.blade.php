@extends('layouts.app')

@section('title')
    {{ __('Workload Monthly') }}
@endsection
@section('breadcrumb')
          <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
          <li class="breadcrumb-item active">{{__('Workload Monthly')}}</li>
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
                    <form method="get" action="{{ route('admin.reports.work_load_month') }}">
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
                                            <input type="text" name="date" class="form-control float-right datepickerrange"
                                                  @if(request()->has('date')) value="{{$date}}" @endif
                                             required>
                                        </div>
                                    </div>
                                    <!-- \date range -->

                                    <!-- branches -->
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group">
                                            <label>{{ __('Branch') }}</label>
                                            <select class="form-control" name="branches[]" id="branch" multiple>
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
                @foreach ($branches as $branch)
                    <div class="card-header">
                         <h3 class="card-title">{{ $branch->name}}</h3>
                    </div>
                    <div class="card-body">

                        <div class="tab-content" id="custom-tabs-one-tabContent">
                            <div class="tab-pane fade active show" id="custom-tabs-one-invoices" role="tabpanel"
                                aria-labelledby="custom-tabs-one-invoices-tab">
                                <div class="row">
                                    <div class="col-lg-12 table-responsive">

                                        @if (count($branch->works))
                                            <table class="table table-striped table-bordered datatable">
                                                <thead>
                                                    @if (count($branch->works))
                                                        <tr>
                                                            @foreach ($branch->works as $work)
                                                                <th>
                                                                    {{ __($work['monthName']) }}
                                                                </th>
                                                            @endforeach
                                                        </tr>
                                                    @endif
                                                </thead>
                                                <tbody>
                                                    @if (count($branch->works))
                                                        <tr>
                                                            @foreach ($branch->works as $work)
                                                                <td>
                                                                    {{ __('Count') }} :{{ $work['data'] }} <br>
                                                                    {{ __('Total') }} : {{ $work['total'] }} <br>
                                                                    {{ __('Total Paid') }} : {{ $work['totalPaid'] }} <br>
                                                                    {{ __('Custody Of Branch') }} : {{ $work['branchCustody'] }} <br>
                                                                    {{ __('Total After Custody') }} : {{ $work['custody'] }} <br>
                                                                    @foreach ($work->paid as $payment_method)
                                                                        {{ $payment_method->name }} : {{ $payment_method->income }} <br>
                                                                    @endforeach
                                                                    {{ __('Due') }} : {{ $work['due'] }} <br>
                                                                    {{ __('Sales Value') }} : {{ $work['discount'] }} <br>
                                                                    {{ __('Delayed Money') }} : {{ $work['delayed_money'] }} <br>
                                                                    {{ __('Expenses') }} : {{ $work['expenses'] }} <br>
                                                                </td>
                                                            @endforeach
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
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
          $('#reports_work_load_month').addClass('active');
    </script>
@endsection
