@extends('layouts.app')

@section('title')
{{__('Delayed Money')}}
@endsection
@section('breadcrumb')
          <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
          <li class="breadcrumb-item active">{{__('Delayed Money')}}</li>
@endsection
@section('content')
<div class="app-content content">
      <div class="card-body">

        <!-- Filtering Form -->
        <div id="accordion">
          <div class="card card-info">
              <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="btn btn-primary collapsed"
                  aria-expanded="false">
                  <i class="fas fa-filter"></i> {{__('Filters')}}
              </a>
              <form method="get" action="{{route('admin.reports.delayed_money')}}">
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

                            <!-- branch -->
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
                            <div class="col-lg-4 lab-to-lab @if(isset($labs)) d-block  @else d-none @endif">

                                <div class="form-group">
                                    <label>{{__('lab')}}</label>
                                    <select class="form-control" name="labs[]" id="lab" multiple>
                                        @if(isset($labs))
                                            @foreach($labs as $lab)
                                                <option value="{{$lab['id']}}" selected>{{$lab['name']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                            </div>
                            <!-- \branch -->

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
        @if(request()->has('date')||request()->has('contracts')||request()->has('branches'))

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
                        {{formated_price($total)}}
                      </h4>
                      <span>
                        {{__('Total')}}
                      </span>
                    </div>
                  </div>
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
                  <a class="nav-link active" id="delayed_money_table-tab" data-toggle="pill" href="#delayed_money_table" role="tab" aria-controls="delayed_money_table" aria-selected="false">{{__('Invoices')}}</a>
                </li>

              </ul>
            </div>
            <div class="card-body">
              <div class="tab-content" id="custom-tabs-one-tabContent">
                <div class="tab-pane fade active show" id="delayed_money_table" role="tabpanel" aria-labelledby="delayed_money_table-tab">
                 <div class="row">
                  <div class="col-lg-12 table-responsive">
                    <table class="table table-striped table-bordered datatable">
                      <thead>
                        <tr>
                          <td width="10px">#</td>
                          <th>{{__('Date')}}</th>
                          <th>{{__('Patient Name')}}</th>
                          <th>{{__('Contract')}}</th>
                          <th>{{__('Tests')}}</th>
                          <th>{{__('Subtotal')}}</th>
                          <th>{{__('Total')}}</th>
                          <th>{{__('Delayed Money')}}</th>
                        </tr>
                      </thead>
                      <tbody>
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
                            @if(isset($group['contract']))
                              {{$group['contract']['title']}}
                            @endif
                          </td>
                          <td>
                            <ul class="pl-2 m-0">
                              @foreach($group['tests'] as $test)
                                <li>{{$test['test']['name']}}</li>
                              @endforeach
                              @foreach($group['cultures'] as $culture)
                                <li>{{$culture['culture']['name']}}</li>
                              @endforeach
                            </ul>
                            @foreach($group['packages'] as $package)
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
                            @endforeach
                          </td>
                          <td>{{formated_price($group['subtotal'])}}</td>
                          <td>{{formated_price($group['total'])}}</td>
                          <td>{{formated_price($group['delayed_money'])}}</td>

                        </tr>
                        @endforeach
                      </tbody>
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
  </div>
</div>


@endsection
@section('scripts')
<script src="{{url('plugins/daterangepicker/daterangepicker.js')}}"></script>
<script src="{{url('plugins/print/jQuery.print.min.js')}}"></script>
<script src="{{url('js/admin/accounting_report.js')}}"></script>
@endsection
