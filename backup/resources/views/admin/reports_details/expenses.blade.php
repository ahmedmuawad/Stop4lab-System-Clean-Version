@extends('layouts.app')

@section('title')
    {{ __('Expenses Report') }}
@endsection
@section('breadcrumb')
          <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
          <li class="breadcrumb-item active">{{__('Expenses Report')}}</li>
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
                    <form method="get" action="{{ route('admin.reports.expenses') }}">
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

                                    {{-- category --}}
                                    <div class="col-lg-3">

                                        <div class="form-group">

                                            <label for="filter_category">{{ __('Category') }}</label>

                                            <select name="category" id="filter_category" class="form-control select2">
                                                <option selected disabled>{{ __('Select') }}</option>
                                                @foreach ($expense_categories as $category)
                                                    <option value="{{ $category['id'] }}" @if(isset($category_input) && $category['id'] == $category_input ) selected @endif>{{ $category['name'] }}</option>
                                                @endforeach
                                            </select>

                                        </div>

                                    </div>
                                    {{-- category --}}
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

                <div class="card-header">
                    <h3 class="card-title">{{ __('Expenses') }}</h3>
                </div>
                <div class="card-body">

                    <div class="tab-content" id="custom-tabs-one-tabContent">
                        <div class="tab-pane fade active show" id="custom-tabs-one-invoices" role="tabpanel"
                            aria-labelledby="custom-tabs-one-invoices-tab">
                            <div class="row">
                                <div class="col-lg-12 table-responsive">


                                    <table class="table table-striped  table-bordered datatable">
                                        <thead>
                                            <tr>
                                                <th width="10px">#</th>
                                                <th>{{ __('Category') }}</th>
                                                <th>{{ __('Date') }}</th>
                                                <th>{{ __('Amount') }}</th>
                                                <th>{{ __('Payment method') }}</th>
                                                <th>{{ __('Created By') }}</th>
                                                <th>{{ __('Notes') }}</th>
                                                <th>{{ __('Branch') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($expenses as $expense)
                                                <tr>
                                                    <td>{{ $expense['id'] }}</td>
                                                    <td>{{ $expense['category']['name'] }}</td>
                                                    <td>{{ date('Y-m-d', strtotime($expense['date'])) }}</td>
                                                    <td>{{ formated_price($expense['amount']) }}</td>
                                                    <td>
                                                        {{ $expense['payment_method']['name'] }}
                                                    </td>
                                                    <td>
                                                        @if (isset($expense['doctor']))
                                                            {{ $expense['doctor']['name'] }}
                                                        @endif

                                                    </td>
                                                    <td>
                                                        {{ strip_tags($expense['notes']) }}
                                                    </td>
                                                    <td>
                                                        {{ $expense['branch']['name'] }}
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
        $('#reports_expenses').addClass('active');
    </script>
@endsection
