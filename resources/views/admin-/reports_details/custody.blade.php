@extends('layouts.app')

@section('title')
    {{ __('Custody Report') }}
@endsection
@section('breadcrumb')
          <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
          <li class="breadcrumb-item active">{{__('Custody Report')}}</li>
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
                    <form method="get" action="{{ route('admin.reports.custody') }}">
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
                                                                {{ formated_price($presonal) }}
                                                            </h4>
                                                            <span>
                                                                {{ __('Total Bank') }}
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
                                                                {{ formated_price($lab)}}
                                                            </h4>
                                                            <span>
                                                                {{ __('Total From Lab') }}
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
                                                                {{ formated_price($mainSafe)}}
                                                            </h4>
                                                            <span>
                                                                {{ __('Main Safe') }}
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
                                                                {{ formated_price($branchSafe)}}
                                                            </h4>
                                                            <span>
                                                                {{ __('Branch Safe') }}
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
                                                                {{ formated_price($lab + $presonal + $branchSafe + $mainSafe)}}
                                                            </h4>
                                                            <span>
                                                                {{ __('Total') }}
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
                                                                {{ formated_price($out)}}
                                                            </h4>
                                                            <span>
                                                                {{ __('out') }}
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
                                                <th>#</th>
                                                <th>{{__('Branch')}}</th>
                                                <th>{{__('Custody')}}</th>
                                                <th>{{__('Custody Type')}}</th>
                                                <th>{{__('Date')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($custodys->where('custody_type','!=',0) as $custody)
                                                <tr>
                                                    <td>{{ $custody->id }}</td>
                                                    <td>{{ $custody->branche->name }}</td>
                                                    <td>{{ $custody->custody }}</td>
                                                    <td> @if($custody->custody_type == '1') {{ __('Bank') }} @elseif($custody->custody_type == '2') {{ __('From Lab') }}@elseif($custody->custody_type == '3') {{ __('Maim Safe') }}@elseif($custody->custody_type == '4') {{ __('Branch Safe') }} @endif </td>
                                                    <td>{{ date('Y-m-d h:i A',strtotime($custody->created_at))  }} </td>
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
            {{-- <div class="card-footer">
                <a href="{{ request()->fullUrl() }}&pdf=true" class="btn btn-danger" target="_blank">
                    <i class="fas fa-file-pdf"></i> {{ __('PDF') }}
                </a>
            </div> --}}
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
        // $('#reports_testes_branch').addClass('active');
    </script>
@endsection
