@extends('layouts.app')

@section('title')
{{__('Reports')}}
@endsection
@section('breadcrumb')
          <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
          <li class="breadcrumb-item active">{{__('Accounting Report')}}</li>
@endsection
@section('content')
<div class="app-content content ">
      <div class="card-body">

        <!-- Filtering Form -->
        <div id="accordion">
          <div class="card card-info">
              <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="btn btn-primary collapsed"
                  aria-expanded="false">
                  <i class="fas fa-filter"></i> {{__('Filters')}}
              </a>
              <form method="get" action="{{route('admin.reports.accounting')}}">
                <div id="collapseOne" class="panel-collapse in collapse show">
                    <div class="card-body">
                        <div class="row">
                            <!-- date range -->
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                <label>{{__('Date range')}}:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="date" class="form-control float-right datepickerrange"
                                        @if(request()->has('date')) value="{{request()->get('date')}}" @endif id="date"
                                    required>
                                </div>
                            </div>
                            <!-- \date range -->

                            <!-- doctors -->
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                <div class="form-group">
                                    <label>{{__('Doctor')}}</label>
                                    <select class="form-control" name="doctors[]" id="doctor" multiple>
                                        @if(isset($doctors))
                                        @foreach($doctors as $doctor)
                                        <option value="{{$doctor['id']}}" selected>{{$doctor['name']}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <!-- \doctors -->

                            <!-- tests -->
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                <div class="form-group">
                                    <label>{{__('Test')}}</label>
                                    <select class="form-control" name="tests[]" id="test" multiple>
                                        @if(isset($tests))
                                        @foreach($tests as $test)
                                        <option value="{{$test['id']}}" selected>{{$test['name']}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <!-- \tests -->

                            <!-- cultures -->
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                <div class="form-group">
                                    <label>{{__('Culture')}}</label>
                                    <select class="form-control" name="cultures[]" id="culture" multiple>
                                        @if(isset($cultures))
                                        @foreach($cultures as $culture)
                                        <option value="{{$culture['id']}}" selected>{{$culture['name']}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <!-- \cultures -->

                            <!-- packages -->
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                <div class="form-group">
                                    <label>{{__('Package')}}</label>
                                    <select class="form-control" name="packages[]" id="package" multiple>
                                        @if(isset($packages))
                                        @foreach($packages as $package)
                                        <option value="{{$package['id']}}" selected>{{$package['name']}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <!-- \packages -->

                            <!-- contracts -->
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                <div class="form-group">
                                    <label>{{__('Contract')}}</label>
                                    <select class="form-control" name="contracts[]" id="contract" multiple data-url="{{ route('admin.calculate_contract_id') }}">
                                        @if(isset($contracts))
                                            @foreach($contracts as $contract)
                                                <option value="{{$contract['id']}}" selected>{{$contract['title']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <!-- \contracts -->

                            <!-- contracts -->
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                <div class="form-group">
                                    <label>{{__('Branch')}}</label>
                                    <select class="form-control" name="branches[]" id="branch" multiple>
                                        @if(isset($branches))
                                            @foreach($branches as $branch)
                                                <option value="{{$branch['id']}}" selected>{{$branch['name']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <!-- \contracts -->

                            <!-- lab -->
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 lab-to-lab @if(isset($labs)) d-block  @else d-none @endif">
                                <div class="form-group">
                                    <label>{{__('lab')}}</label>
                                    <select class="form-control" name="labs[]" id="lab" multiple>
                                        @if(isset($labs))
                                            @foreach($labs as $lab)
                                                <option value="{{$lab['id']}}" selected>{{$lab['lab_code']}}-{{$lab['name']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <!-- \lab -->
                            <!-- rep -->
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 lab-to-lab @if(isset($reps)) d-block  @else d-none @endif">
                                <div class="form-group">
                                    <label>{{__('rep')}}</label>
                                    <select class="form-control" name="reps[]" id="rep" multiple>
                                        @if(isset($reps))
                                            @foreach($reps as $rep)
                                                <option value="{{$rep['id']}}" selected>{{$rep['name']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <!-- \rep -->
                            <!-- ray status -->
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                <div class="form-group">
                                    <label>{{__('Ray Status')}}</label>
                                    <select class="form-control" name="ray_status" id="ray_status">
                                        <option @if(isset($ray_status)) @if($ray_status == 2) selected @endif  @else selected @endif selected value="2">{{ _('All') }}</option>
                                        <option @if(isset($ray_status) && $ray_status == 1 ) selected @endif  value="1">{{ _('Without Rays') }}</option>
                                        <option @if(isset($ray_status) && $ray_status == 0 ) selected @endif  value="0">{{ _('Only Rays') }}</option>
                                    </select>
                                </div>
                            </div>
                            <!-- \ray status -->

                        </div>
                    </div>
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">
                        <i class="fas fa-cog"></i>
                        {{__('Generate')}}
                      </button>
                    </div>
                </div>
              </form>
          </div>
        </div>
        <!-- Filtering Form -->
        @if(request()->has('date')||request()->has('doctors')||request()->has('tests')||request()->has('cultures'))

          <!-- Report summary -->
          <div class="card card-primary">
            <div class="card-header">
              <h5 class="card-title">
                {{__('Summary')}}
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
                        {{formated_price($total_before_discount)}}
                      </h4>
                      <span>
                        {{__('Total Before Discount')}}
                      </span>
                    </div>
                  </div>
                </div>
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
                        {{ formated_price($discount_presentage)}}
                      </h4>
                      <span>
                        {{__('Discount Presentage')}}
                      </span>
                    </div>
                  </div>
                </div>
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
                        {{formated_price($total)}}
                      </h4>
                      <span>
                        {{__('Total After Discount')}}
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
                        {{formated_price($paid)}}
                      </h4>
                      <span>
                        {{__('paid')}}
                      </span>
                    </div>
                  </div>
                </div>
                {{-- <div class="col-lg-2 col-sm-12 col-xs-12 mt-4 mb-4 custom-secondary-box">
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
                        {{formated_price($totalCustody)}}
                      </h4>
                      <span>
                        {{__('Total Custody Of Branches')}}
                      </span>
                    </div>
                  </div>
                </div> --}}

                {{-- <div class="col-lg-2 col-sm-12 col-xs-12 mt-4 mb-4 custom-success-box">
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
                        {{formated_price($custody)}}
                      </h4>
                      <span>
                        {{__('Total After Custody')}}
                      </span>
                    </div>
                  </div>
                </div> --}}

                @foreach($payment_methods as $payment_method)
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
                          @if($payment_method->id == setting("account")['payment'])
                            {{  formated_price($payment_method->income)}}
                          @else
                            {{formated_price($payment_method->income )}}
                          @endif
                        </h4>
                        <span>
                          {{ $payment_method->name }}
                        </span>
                      </div>
                    </div>
                  </div>
                @endforeach

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
                        {{formated_price($due)}}
                      </h4>
                      <span>
                        {{__('Due')}}
                      </span>
                    </div>
                  </div>
                </div>
                <div class="col-lg-2 col-sm-12 col-xs-12 mt-4 mb-4 custom-danger-box">
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
                        {{formated_price($delayed_money)}}
                      </h4>
                      <span>
                        {{__('Delayed Money')}}
                      </span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-2 col-sm-12 col-xs-12 mt-4 mb-4 custom-danger-box">
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
                        {{formated_price($profitPaid)}}
                      </h4>
                      <span>
                        {{__('Profit Paid')}}
                      </span>
                    </div>
                  </div>
                </div>
                <div class="col-lg-2 col-sm-12 col-xs-12 mt-4 mb-4 custom-danger-box">
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
                        {{formated_price($total_expenses)}}
                      </h4>
                      <span>
                        {{__('Expenses')}}
                      </span>
                    </div>
                  </div>
                </div>
                
                <div class="col-lg-2 col-sm-12 col-xs-12 mt-4 mb-4 custom-warning-box">
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
                        {{formated_price($total_purchases)}}
                      </h4>
                      <span>
                        {{__('Purchase payments')}}
                      </span>
                    </div>
                  </div>
                </div>

                <div class="col-lg-2 col-sm-12 col-xs-12 mt-4 mb-4 custom-success-box">
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
                        {{formated_price($profit)}}
                      </h4>
                      <span>
                        {{__('Profit')}}
                      </span>
                    </div>
                  </div>
                </div>
                {{-- <div class="col-lg-2 col-sm-12 col-xs-12 mt-4 mb-4 custom-success-box">
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
                        {{formated_price($total_after_cost)}}
                      </h4>
                      <span>
                        {{__('Total After Lab To Lab Cost')}}
                      </span>
                    </div>
                  </div>
                </div>
                <div class="col-lg-2 col-sm-12 col-xs-12 mt-4 mb-4 custom-success-box">
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
                        {{formated_price($totalCustodyAll)}}
                      </h4>
                      <span>
                        {{__('Total After Lab To Lab Cost')}}
                      </span>
                    </div>
                  </div>
                </div> --}}
                
              </div>
            </div>
          </div>
          <!-- \Report summary -->

          {{-- branch summary --}}

            @foreach ($branchSummary as $branch)
              <!-- Report summary -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h5 class="card-title">
                      {{__('Summary')}} {{ $branch->name }}
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
                              {{formated_price($branch->total_before_discount)}}
                            </h4>
                            <span>
                              {{__('Total Before Discount')}}
                            </span>
                          </div>
                        </div>
                      </div>
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
                              {{round($branch->discount_persentage,2)}} %
                            </h4>
                            <span>
                              {{__('Discount Persentage')}}
                            </span>
                          </div>
                        </div>
                      </div>
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
                              {{formated_price($branch->total)}}
                            </h4>
                            <span>
                              {{__('Total After Discount')}}
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
                              {{formated_price($branch->totalPaid )}}
                            </h4>
                            <span>
                              {{ __('Total Paid ') }}
                            </span>
                          </div>
                        </div>
                      </div>
                      {{-- <div class="col-lg-2 col-sm-12 col-xs-12 mt-4 mb-4 custom-primary-box">
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
                              {{formated_price($branch->branchCustody) }}
                            </h4>
                            <span>
                              {{__('Custody Of Branch')}}
                            </span>
                          </div>
                        </div>
                      </div> --}}
                      {{-- <div class="col-lg-2 col-sm-12 col-xs-12 mt-4 mb-4 custom-primary-box">
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
                              {{formated_price($branch->custody) }}
                            </h4>
                            <span>
                              {{__('Total After Custody')}}
                            </span>
                          </div>
                        </div>
                      </div> --}}
                      

                      @foreach ($branch->paid as $payment_method)
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
                                {{formated_price($payment_method->income )}}
                              </h4>
                              <span>
                                {{ $payment_method->name }}
                              </span>
                            </div>
                          </div>
                        </div>
                      @endforeach
                      
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
                              {{formated_price($branch->due) }}
                            </h4>
                            <span>
                              {{__('Due')}}
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
                              {{formated_price($branch->expenses) }}
                            </h4>
                            <span>
                              {{__('Expenses')}}
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- \Report summary -->
            @endforeach
          {{-- branch summary --}}

           <!-- Report balanace -->
           <div class="card card-primary">
            <div class="card-header">
              <h5 class="card-title">
                {{__('Balance')}}
              </h5>
            </div>
            <div class="card-body p-0 m-0">
              <div class="row">
                <div class="col-lg-12">

                  <table class="table table-bordered table-striped m-0">
                    <thead>
                      <tr>
                        <th>
                          <h6>
                            {{__('Payment method')}}
                          </h6>
                        </th>
                        <th>
                          <h6>
                            {{__('Income')}}
                          </h6>
                        </th>
                        <th>
                          <h6>
                            {{__('Custody')}}
                          </h6>
                        </th>
                        <th>
                          <h6>
                            {{__('Expense')}}
                          </h6>
                        </th>
                        <th>
                          <h6>
                            {{__('Balance')}}
                          </h6>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($payment_methods as $payment_method)
                      <tr>
                        <td>{{$payment_method['name']}}</td>
                        <td>
                          {{formated_price($payment_method['income'])}}
                        </td>
                        <td>
                          {{formated_price($payment_method['custody'])}}
                        </td>
                        <td>
                          {{formated_price($payment_method['expense'])}}
                        </td>
                        <td>
                          {{formated_price($payment_method['balance'])}}
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>

                </div>
              </div>
            </div>
          </div>
          <!-- \Report summary -->

          <!-- Report Details -->
          <div class="card card-primary card-tabs">
            <div class="card-header p-0">
              <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="custom-tabs-one-invoices-tab" data-toggle="pill" href="#custom-tabs-one-invoices" role="tab" aria-controls="custom-tabs-one-invoices" aria-selected="false">{{__('Invoices')}}</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="custom-tabs-one-payments-tab" data-toggle="pill" href="#custom-tabs-one-payments" role="tab" aria-controls="custom-tabs-one-payments" aria-selected="false">{{__('Payments')}}</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="custom-tabs-one-expenses-tab" data-toggle="pill" href="#custom-tabs-one-expenses" role="tab" aria-controls="custom-tabs-one-expenses" aria-selected="false">{{__('Expenses')}}</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="custom-tabs-one-purchase-payments-tab" data-toggle="pill" href="#custom-tabs-one-purchase-payments" role="tab" aria-controls="custom-tabs-one-purchase-payments" aria-selected="false">{{__('Purchase payments')}}</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="custom-tabs-one-groupsDelay-tab" data-toggle="pill" href="#custom-tabs-one-groupsDelay" role="tab" aria-controls="custom-tabs-one-groupsDelay" aria-selected="false">{{__('Delayed Money')}}</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="custom-tabs-one-groupsDue-tab" data-toggle="pill" href="#custom-tabs-one-groupsDue" role="tab" aria-controls="custom-tabs-one-groupsDue" aria-selected="false">{{__('Due')}}</a>
                </li>
              </ul>
            </div>
            <div class="card-body">
              <div class="tab-content" id="custom-tabs-one-tabContent">
                <div class="tab-pane fade active show" id="custom-tabs-one-invoices" role="tabpanel" aria-labelledby="custom-tabs-one-invoices-tab">
                 <div class="row">
                  <div class="col-lg-12 table-responsive">
                    <table class="table table-striped table-bordered" id="group_reports">
                      <thead>
                        <tr>
                          <td width="10px">#</td>
                          <th>{{__('Date')}}</th>
                          <th>{{__('Patient Name')}}</th>
                          <th>{{__('Doctor')}}</th>
                          <th>{{__('Contract')}}</th>
                          <th>{{__('Tests')}}</th>
                          <th>{{__('Tests Price')}}</th>
                          <th>{{__('Subtotal')}}</th>
                          <th>{{__('Discount')}}</th>
                          <th>{{__('Total')}}</th>
                          <th>{{__('Paid')}}</th>
                          <th>{{__('Due')}}</th>
                          <th>{{__('Cost')}}</th>
                          <th>{{__('Total After Cost')}}</th>
                        </tr>
                      </thead>
                      {{-- <tbody>
                        @foreach($groups as $group)
                        <tr>
                          <td>
                            {{$group['id']}}
                          </td>
                          <td>
                            {{$group['created_at']}}
                          </td>
                          <td>
                            @if(isset($group['patient']))
                            {{$group['patient']['name']}}
                            @endif
                          </td>
                          <td>
                            @if(isset($group['doctor']))
                            {{$group['doctor']['name']}}
                            @endif
                          </td>
                          <td>
                            @if(isset($group['contract']))
                              {{$group['contract']['title']}}
                            @endif
                          </td>
                          <td>
                            <ul class="pl-2 m-0">
                              @foreach($group['tests'] as $test)
                                <li>{{$test['test']['name']}}</li>
                              @endforeach
                              @foreach($group['rays'] as $ray)
                                <li>{{$ray['ray']['name']}}</li>
                              @endforeach
                              @foreach($group['cultures'] as $culture)
                                <li>{{$culture['culture']['name']}}</li>
                              @endforeach
                            </ul>
                            @foreach($group['packages'] as $package)
                            @if (isset($package['package']))
                              <b class="p-0 m-0">
                                {{$package['package']['name']}}
                              </b>
                              <ul class="pl-4 m-0">
                                @foreach($package['tests'] as $test)
                                  <li>{{$test['test']['name']}}</li>
                                @endforeach
                                @foreach($package['cultures'] as $culture)
                                  <li>{{$culture['culture']['name']}}</li>
                                @endforeach
                              </ul>
                            @endif
                            @endforeach
                          </td>
                          <td>
                            <ul class="pl-2 m-0">
                              @foreach($group['tests'] as $test)
                                <li>{{formated_price($test->price)}}</li>
                              @endforeach
                              @foreach($group['rays'] as $ray)
                                <li>{{formated_price($ray->price)}}</li>
                              @endforeach
                              @foreach($group['cultures'] as $culture)
                                <li>{{formated_price($culture->price)}}</li>
                              @endforeach
                            </ul>
                            @foreach($group['packages'] as $package)
                            @if (isset($package['package']))
                              <b class="p-0 m-0">
                                {{ formated_price($package['package']['price']) }}
                              </b>
                              
                            @endif
                            @endforeach
                          </td>
                          <td>{{formated_price($group['subtotal'])}}</td>
                          <td>{{formated_price($group['discount'])}}</td>
                          <td>{{formated_price($group['total'])}}</td>
                          <td>{{formated_price($group['paid'])}}</td>
                          <td>{{formated_price($group['due'])}}</td>
                          <td>{{formated_price($group['cost'])}}</td>
                          <td>{{formated_price($group['total_after_cost'])}}</td>
                        </tr>
                        @endforeach
                      </tbody> --}}
                    </table>
                   </div>
                 </div>
                </div>
                <div class="tab-pane fade" id="custom-tabs-one-payments" role="tabpanel" aria-labelledby="custom-tabs-one-payments-tab">
                  <div class="row">
                    <div class="col-lg-12 table-responsive">
                      <table class="table table-striped  table-bordered" id="payments_reports">
                        <thead>
                          <tr>
                            <th width="10px">#</th>
                            <th width="10px">#{{__('Invoice')}}</th>
                            <th>{{__('Patient')}}</th>
                            <th>{{__('Doctor')}}</th>
                            <th>{{__('Contract')}}</th>
                            <th>{{__('Tests')}}</th>
                            <th>{{__('Tests Price')}}</th>
                            <th>{{__('Date')}}</th>
                            <th>{{__('Amount')}}</th>
                            <th>{{__('Payment method')}}</th>
                          </tr>
                        </thead>
                        {{-- <tbody>
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
                              <ul class="p-2">
                                  @foreach ($payment['group']['tests'] as $test)
                                      <li>{{ $test['test']['name'] }}</li>
                                  @endforeach
                                  @foreach ($payment['group']['cultures'] as $culture)
                                      <li>{{ $culture['culture']['name'] }}</li>
                                  @endforeach
                                  @foreach($payment['group']['rays'] as $ray)
                                      <li>{{$ray['ray']['name']}}</li>
                                  @endforeach
                              </ul>
                              @foreach($payment['group']['packages'] as $package)
                                  @if (isset($package['package']))
                                    <b class="p-0 m-0">
                                      {{$package['package']['name']}}
                                    </b>
                                    <ul class="pl-4 m-0">
                                      @foreach($package['tests'] as $test)
                                        <li>{{$test['test']['name']}}</li>
                                      @endforeach
                                      @foreach($package['cultures'] as $culture)
                                        <li>{{$culture['culture']['name']}}</li>
                                      @endforeach
                                    </ul>
                                  @endif
                              @endforeach
                          </td>
                          <td>
                            <ul>
        
                                @foreach($payment['group']['tests'] as $test)
                                    <li>{{ $test->price }}</li>
                                    
                                @endforeach
        
                                @foreach($payment['group']['cultures'] as $culture)
                                    <li>{{ $culture->price }}</li>
                                @endforeach
        
                                @foreach($payment['group']['packages'] as $package)
                                @if (isset($package['package']))
                                  <b >
                                    {{ formated_price($package['package']['price']) }}
                                  </b>
                                @endif
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
                        </tbody> --}}
                      </table>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="custom-tabs-one-expenses" role="tabpanel" aria-labelledby="custom-tabs-one-expenses-tab">
                 <div class="row">
                   <div class="col-lg-12 table-responsive">
                    <table class="table table-striped  table-bordered" id="expenses_reports">
                      <thead>
                        <tr>
                          <th width="10px">#</th>
                          <th>{{__('Category')}}</th>
                          <th>{{__('Date')}}</th>
                          <th>{{__('Amount')}}</th>
                          <th>{{__('Payment method')}}</th>
                          <th>{{__('Created By')}}</th>
                          <th>{{__('Notes')}}</th>
                          <th>{{__('Branch')}}</th>
                        </tr>
                      </thead>
                      {{-- <tbody>
                        @foreach($expenses as $expense)
                        <tr>
                          <td>{{$expense['id']}}</td>
                          <td>{{$expense['category']['name']}}</td>
                          <td>{{date('Y-m-d',strtotime($expense['date']))}}</td>
                          <td>{{formated_price($expense['amount'])}}</td>
                          <td>
                            {{$expense['payment_method']['name']}}
                          </td>
                          <td>
                            @if (isset($expense['doctor']))
                                {{$expense['doctor']['name']}}
                            @endif

                          </td>
                          <td>
                            {{ strip_tags($expense['notes'])}}
                          </td>
                          <td>
                            {{$expense['branch']['name']}}
                          </td>
                        </tr>
                        @endforeach
                      </tbody> --}}
                    </table>
                   </div>
                 </div>
                </div>
                <div class="tab-pane fade" id="custom-tabs-one-purchase-payments" role="tabpanel" aria-labelledby="custom-tabs-one-purchase-payments-tab">
                  <div class="row">
                    <div class="col-lg-12 table-responsive">
                      <table class="table table-striped  table-bordered report-datatable">
                        <thead>
                          <tr>
                            <th width="10px">#</th>
                            <th width="10px">#{{__('Purchase')}}</th>
                            <th>{{__('Date')}}</th>
                            <th>{{__('Amount')}}</th>
                            <th>{{__('Payment method')}}</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($purchase_payments as $payment)
                          <tr>
                            <td>
                              {{$payment['id']}}
                            </td>
                            <td>
                              {{$payment['purchase_id']}}
                            </td>
                            <td>
                              {{$payment['date']}}
                            </td>
                            <td>
                              {{formated_price($payment['amount'])}}
                            </td>
                            <td>
                              {{$payment['payment_method']['name']}}
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="custom-tabs-one-groupsDelay" role="tabpanel" aria-labelledby="custom-tabs-one-groupsDelay-tab">
                  <div class="row">
                    <div class="col-lg-12 table-responsive">
                      <table class="table table-striped table-bordered" id="delay_reports" width="100%">
                        <thead>
                          <tr>
                            <td width="10px">#</td>
                            <th>{{__('Date')}}</th>
                            <th>{{__('Patient Name')}}</th>
                            <th>{{__('Doctor')}}</th>
                            <th>{{__('Contract')}}</th>
                            <th>{{__('Tests')}}</th>
                            <th>{{__('Subtotal')}}</th>
                            <th>{{__('Discount')}}</th>
                            <th>{{__('Total')}}</th>
                            <th>{{__('Paid')}}</th>
                            <th>{{__('Due')}}</th>
                            <th>{{__('Cost')}}</th>
                            <th>{{__('Total After Cost')}}</th>
                          </tr>
                        </thead>
                        {{-- <tbody>
                          @foreach($groupsDelay as $group)
                          <tr>
                            <td>
                              {{$group['id']}}
                            </td>
                            <td>
                              {{$group['created_at']}}
                            </td>
                            <td>
                              @if(isset($group['patient']))
                              {{$group['patient']['name']}}
                              @endif
                            </td>
                            <td>
                              @if(isset($group['doctor']))
                              {{$group['doctor']['name']}}
                              @endif
                            </td>
                            <td>
                              @if(isset($group['contract']))
                                {{$group['contract']['title']}}
                              @endif
                            </td>
                            <td>
                              <ul class="pl-2 m-0">
                                @foreach($group['tests'] as $test)
                                  <li>{{$test['test']['name']}}</li>
                                @endforeach
                                @foreach($group['rays'] as $ray)
                                  <li>{{$ray['ray']['name']}}</li>
                                @endforeach
                                @foreach($group['cultures'] as $culture)
                                  <li>{{$culture['culture']['name']}}</li>
                                @endforeach
                              </ul>
                              @foreach($group['packages'] as $package)
                              @if (isset($package['package']))
                                <b class="p-0 m-0">
                                  {{$package['package']['name']}}
                                </b>
                                <ul class="pl-4 m-0">
                                  @foreach($package['tests'] as $test)
                                    <li>{{$test['test']['name']}}</li>
                                  @endforeach
                                  @foreach($package['cultures'] as $culture)
                                    <li>{{$culture['culture']['name']}}</li>
                                  @endforeach
                                </ul>
                              @endif
                              @endforeach
                            </td>
                            <td>{{formated_price($group['subtotal'])}}</td>
                            <td>{{formated_price($group['discount'])}}</td>
                            <td>{{formated_price($group['total'])}}</td>
                            <td>{{formated_price($group['paid'])}}</td>
                            <td>{{formated_price($group['due'])}}</td>
                            <td>{{formated_price($group['cost'])}}</td>
                            <td>{{formated_price($group['total_after_cost'])}}</td>
                          </tr>
                          @endforeach
                        </tbody> --}}
                      </table>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="custom-tabs-one-groupsDue" role="tabpanel" aria-labelledby="custom-tabs-one-groupsDue-tab">
                  <div class="row">
                    <div class="col-lg-12 table-responsive">
                      <table class="table table-striped table-bordered" id="due_reports" width="100%">
                        <thead>
                          <tr>
                            <td width="10px">#</td>
                            <th>{{__('Date')}}</th>
                            <th>{{__('Patient Name')}}</th>
                            <th>{{__('Doctor')}}</th>
                            <th>{{__('Contract')}}</th>
                            <th>{{__('Tests')}}</th>
                            <th>{{__('Subtotal')}}</th>
                            <th>{{__('Discount')}}</th>
                            <th>{{__('Total')}}</th>
                            <th>{{__('Paid')}}</th>
                            <th>{{__('Due')}}</th>
                            <th>{{__('Cost')}}</th>
                            <th>{{__('Total After Cost')}}</th>
                          </tr>
                        </thead>
                        {{-- <tbody>
                          @foreach($groupsDue as $group)
                          <tr>
                            <td>
                              {{$group['id']}}
                            </td>
                            <td>
                              {{$group['created_at']}}
                            </td>
                            <td>
                              @if(isset($group['patient']))
                              {{$group['patient']['name']}}
                              @endif
                            </td>
                            <td>
                              @if(isset($group['doctor']))
                              {{$group['doctor']['name']}}
                              @endif
                            </td>
                            <td>
                              @if(isset($group['contract']))
                                {{$group['contract']['title']}}
                              @endif
                            </td>
                            <td>
                              <ul class="pl-2 m-0">
                                @foreach($group['tests'] as $test)
                                  <li>{{ isset($test['test']['name'])? $test['test']['name'] : '' }}</li>
                                @endforeach
                                @foreach($group['rays'] as $ray)
                                  <li>{{$ray['ray']['name']}}</li>
                                @endforeach
                                @foreach($group['cultures'] as $culture)
                                  <li>{{$culture['culture']['name']}}</li>
                                @endforeach
                              </ul>
                              @foreach($group['packages'] as $package)
                              @if (isset($package['package']))
                                <b class="p-0 m-0">
                                  {{$package['package']['name']}}
                                </b>
                                <ul class="pl-4 m-0">
                                  @foreach($package['tests'] as $test)
                                    <li>{{$test['test']['name']}}</li>
                                  @endforeach
                                  @foreach($package['cultures'] as $culture)
                                    <li>{{$culture['culture']['name']}}</li>
                                  @endforeach
                                </ul>
                              @endif
                              @endforeach
                            </td>
                            <td>{{formated_price($group['subtotal'])}}</td>
                            <td>{{formated_price($group['discount'])}}</td>
                            <td>{{formated_price($group['total'])}}</td>
                            <td>{{formated_price($group['paid'])}}</td>
                            <td>{{formated_price($group['due'])}}</td>
                            <td>{{formated_price($group['cost'])}}</td>
                            <td>{{formated_price($group['total_after_cost'])}}</td>
                          </tr>
                          @endforeach
                        </tbody> --}}
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- \Report Details -->

        @endif
      </div>
      @if(request()->has('date'))
        <div class="card-footer">
          <a href="{{request()->fullUrl()}}&pdf=true" class="btn btn-danger" target="_blank">
            <i class="fas fa-file-pdf"></i> {{__('PDF')}}
          </a>
        </div>
    @endif
      @if(request()->has('date'))
        <div class="card-footer">
          <div class="row">
            <div class="col-md-3 my-1">
              <a href="{{request()->fullUrl()}}&group_pdf=true" class="btn btn-danger" target="_blank">
                <i class="fas fa-file-pdf"></i> {{__('Invoices PDF')}}
              </a>
            </div>
            <div class="col-md-3 my-1">
              <a href="{{request()->fullUrl()}}&payments_pdf=true" class="btn btn-danger" target="_blank">
                <i class="fas fa-file-pdf"></i> {{__('Payments PDF')}}
              </a>
            </div>
            <div class="col-md-3 my-1">
              <a href="{{request()->fullUrl()}}&expenses_pdf=true" class="btn btn-danger" target="_blank">
                <i class="fas fa-file-pdf"></i> {{__('Expenses PDF')}}
              </a>
            </div>
            <div class="col-md-3 my-1">
              <a href="{{request()->fullUrl()}}&expenses_pdf=true" class="btn btn-danger" target="_blank">
                <i class="fas fa-file-pdf"></i> {{__('Expenses PDF')}}
              </a>
            </div>
            <div class="col-md-3 my-1">
              <a href="{{request()->fullUrl()}}&delayed_money_pdf=true" class="btn btn-danger" target="_blank">
                <i class="fas fa-file-pdf"></i> {{__('Delayed Money PDF')}}
              </a>
            </div>
            <div class="col-md-3 my-1">
              <a href="{{request()->fullUrl()}}&due_pdf=true" class="btn btn-danger" target="_blank">
                <i class="fas fa-file-pdf"></i> {{__('Due Invoices PDF')}}
              </a>
            </div>
            <div class="col-md-3 my-1">
              <a href="{{request()->fullUrl()}}&delay_pdf=true" class="btn btn-danger" target="_blank">
                <i class="fas fa-file-pdf"></i> {{__('Delayed Invoices PDF')}}
              </a>
            </div>
          </div>
         
        </div>
       
      @endif
  </div>
</div>
@endsection
@section('scripts')
<script src="{{url('plugins/daterangepicker/daterangepicker.js')}}"></script>
<script src="{{url('plugins/print/jQuery.print.min.js')}}"></script>
<script src="{{url('js/admin/accounting_report.js')}}"></script>
@endsection
