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
                                            <select class="form-control select2" name="contract" id="contract" required>
                                                @foreach ($contracts as $contract)
                                                    <option value="{{ $contract['id'] }}" @if(isset($contractSelected) &&  $contractSelected == $contract['id']  ) selected @endif>
                                                        {{ $contract['title'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!-- \Contracts -->

                                    <div class="col-lg-3 lab-to-lab d-none @if(isset($government_id)) d-block @else d-none @endif">
                                        <div class="form-group">
                                            <label for="government_id">{{__('Government')}}</label>
                                            <select name="government_id" id="government_id" class="form-control">
                                                <option></option>
                                                @foreach($governments as $government)
                                                    <option value="{{ $government->id }}">{{ $government->name }}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" id="government_name" name="government_name">
                                        </div>
                                    </div>
                
                                    <div class="col-lg-3 lab-to-lab d-none @if(isset($region_id)) d-block @else d-none @endif">
                                        <div class="form-group">
                                            <label for="region_id">{{__('Region')}}</label>
                                            <select name="region_id" id="region_id" class="form-control">
                                                <option></option>
                                                {{-- @if(isset($region_id))
                                                    <option value="{{$region_id}}" selected>{{$group->region->name}}</option>
                                                @endif --}}
                                            </select>
                                            <input type="hidden" id="region_name" name="region_name">
                
                                        </div>
                                    </div>
                
                                    <div class="col-lg-3 lab-to-lab d-none @if(isset($user_id)) d-block @else d-none @endif">
                                        <div class="form-group">
                                            <label for="user_id_lab">{{__('Lab')}}</label>
                                            <select name="user_id" id="user_id_lab" class="form-control select2">
                                                {{-- @if(isset($group)&&$group['user_id'])
                                                    @if (isset($group->user))
                                                    <option value="{{$group['user_id']}}" selected>{{$group->user->lab_code}} - {{$group->user->name}}</option>
                                                    @endif
                                                @endif --}}
                                            </select>
                                            <input type="hidden" id="user_name" name="user_name">
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
                                                                {{ $contractInvoice->data }}
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
                                                                {{ formated_price($contractInvoice->sub_total) }}
                                                            </h4>
                                                            <span>
                                                                {{ __('Total') }}
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
                                                                {{ formated_price($contractInvoice->due) }}
                                                            </h4>
                                                            <span>
                                                                {{ __('Due') }}
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
                                                                {{ formated_price($contractInvoice->delayed_money) }}
                                                            </h4>
                                                            <span>
                                                                {{ __('Delayed Money') }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- \Report summary -->
                                    

                                
                                   
                                    </div>
                                   
                            
                                    </div>
                        </div>
                    </div>
                    <div class="card card-primary card-tabs">
                        <div class="card-header p-0">
                          <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                            <li class="nav-item">
                              <a class="nav-link active" id="custom-tabs-one-invoices-tab" data-toggle="pill" href="#custom-tabs-one-invoices" role="tab" aria-controls="custom-tabs-one-invoices" aria-selected="false">{{__('Invoices')}}</a>
                            </li>
                            
                          </ul>
                        </div>
                        <div class="card-body">
                          <div class="tab-content" id="custom-tabs-one-tabContent">
                            <div class="tab-pane fade active show" id="custom-tabs-one-invoices" role="tabpanel" aria-labelledby="custom-tabs-one-invoices-tab">
                             <div class="row">
                              <div class="col-lg-12 table-responsive">
                                <table class="table table-striped table-bordered datatable">
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
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($contractInvoice->groups as $group)
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
    <script>

        

        (function($){
          "use strict";


            $(document).on('change', '#contract', function(e) {
                if ($(this).val() == '2') {
                    $('.lab-to-lab').removeClass('d-none').addClass('d-block');
                } else {
                    $('.lab-to-lab').addClass('d-none').removeClass('d-block');
                }
            });
      
            $('#government_id').change(function () {
                $.get("{{ url('admin/visits/') }}" + "/" + jQuery('#government_id').val() + "/get-regions",
                    function(response){
                        let region_base = document.getElementById('region_id')
                        region_base.innerHTML = "";
                        region_base.innerHTML += "<option></option>";
                        response.data.forEach(function(e) {
                            region_base.innerHTML += "<option value='" + e.id +"" + "'>" + e.name + "</option>";
                        })

                        // $('#government_name').val(jQuery('#government_id').val())     
                        // let rep_base = document.getElementById('rep_id')
                        // rep_base.innerHTML = "";
                        // rep_base.innerHTML += "<option></option>";
                        // response.rep.forEach(function(e) {
                        //     rep_base.innerHTML += "<option value='" + e.id +"" + "'>" + e.name + "</option>";
                        // })
                    }
                );
            })
      
            $('#region_id').change(function () {
                $.ajax({
                    type: "GET",
                    url: "{{ route('admin.visits.get-users') }}",
                    data: {'government_id': jQuery('#government_id').val(), 'region_id': jQuery('#region_id').val()},
                    success: function(response){
                        console.log(response)
                        let user_base = document.getElementById('user_id_lab')
                        user_base.innerHTML = "";
                        user_base.innerHTML += "<option></option>";
                        response.data.forEach(function(e) {
                            user_base.innerHTML += "<option value='" + e.id +"" + "'>" + e.lab_code +'-'+ e.name + "</option>";
                        })
                    }
                });
            })
      
          @if(isset($visit)&&isset($visit['patient']))
              $('#code').append('<option value="{{$visit["patient_id"]}}" selected>{{$visit["patient"]["code"]}}</option>');
              $('#code').trigger({
                  type: 'select2:select',
                  params: {
                      data:{
                          id:"{{$visit['patient_id']}}",
                          text:"{{$visit['patient']['code']}}"
                      }
                  }
              });
          @endif
        })(jQuery);
      
      
        $('#discount').keyup(function(){
          var discount_value = $('#discount_value');
          var subtotal = $('#subtotal').val();
      
          discount_value.val(Math.round(subtotal / 100 * $(this).val()))
      
        })
        $('#discount_value').keyup(function(){
          var discount= $('#discount');
          var subtotal = $('#subtotal').val();
          var total = $('#total');
          var due = $('#due');
      
          discount.val( Math.round($(this).val() * 100 / subtotal) );
      
          total.val(subtotal - Math.round($(this).val()));
          due.val(subtotal - Math.round($(this).val()));
      
      
        })
      
      
    </script>
@endsection
