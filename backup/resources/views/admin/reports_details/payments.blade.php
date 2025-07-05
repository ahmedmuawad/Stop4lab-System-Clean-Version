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
            {{-- <div id="accordion">
                <div class="card card-info">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="btn btn-primary collapsed"
                        aria-expanded="false">
                        <i class="fas fa-filter"></i> {{ __('Filters') }}
                    </a>
                    <form method="get" action="{{ route('admin.reports.expenses') }}">
                        <div id="collapseOne" class="panel-collapse in collapse show">
                            <div class="card-body">
                                <div class="row">
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
            </div> --}}
            <!-- Filtering Form -->
            @if ($payments)
                <!-- Report Details -->

                <div class="card-header">
                    <h3 class="card-title">{{ __('Payments') }}</h3>
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
                                            <th width="10px">#{{__('Invoice')}}</th>
                                            <th>{{__('Patient')}}</th>
                                            <th>{{__('Doctor')}}</th>
                                            <th>{{__('Contract')}}</th>
                                            <th>{{__('Tests')}}</th>
                                            <th>{{__('Date')}}</th>
                                            <th>{{__('Amount')}}</th>
                                            <th>{{__('Payment method')}}</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          @foreach($payments as $payment)
                                          <tr>
                                            <td>
                                              {{$payment['id']}}
                                            </td>
                                            <td>
                                              {{$payment['group_id']}}
                                            </td>
                                            <td>
                                              {{$payment['group']['patient']['name']}}
                                            </td>
                                            <td>
                                              @isset($payment['group']['doctor'])
                                                  {{$payment['group']['doctor']['name']}}
                                              @endisset
                                              @isset($payment['group']['normalDoctor'])
                                                  {{$payment['group']['normalDoctor']['name']}}
                                              @endisset
                
                                            </td>
                                            <td>
                                              @isset($payment['group']['contract'])
                                                  {{$payment['group']['contract']['title']}}
                                              @endisset
                                            </td>
                                            <td>
                                              <ul>
                
                                                @foreach($payment['group']['all_tests'] as $test)
                                                    <li>{{ $test->test->name }}</li>
                                                @endforeach
                                                @foreach($payment['group']['all_cultures'] as $culture)
                                                    <li>{{ $culture->culture->name }}</li>
                                                @endforeach
                
                                              </ul>
                                            </td>
                                            <td>
                                              {{$payment['date']}}
                                            </td>
                                            <td>
                                              {{formated_price($payment['amount'])}}
                                            </td>
                                            <td>
                                                @if($payment['payment_method'])
                                                {{$payment['payment_method']['name']}}
                                                @endif
                
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
