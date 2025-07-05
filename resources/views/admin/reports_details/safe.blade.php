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
                    <form method="get" action="{{ route('admin.reports.safe') }}">
                        <div id="collapseOne" class="panel-collapse in collapse show">
                            <div class="card-body">
                      
                                <div class="row">
                
                                    <div class="col-lg-3">
                
                                        <div class="form-group">
                
                                            <label for="filter_date">{{ __('Date') }}</label>
                
                                            <input type="text" class="form-control" id="filter_date" name="date"
                                            
                                            @if (request()->has('date')) value="{{ $date }}" @endif
                                            required
                                                >
                
                                        </div>
                
                                    </div>
                
                                    <div class="col-lg-3">
                
                                        <div class="form-group">
                
                                            <label for="filter_from_branch">{{ __('From Branch') }}</label>
                
                                            <select name="filter_from_branch" id="filter_from_branch" class="form-control branch_id">
                                                @if (isset($from_branch) && $from_branch != null )
                                                <option value="{{ $from_branch['id'] }}" selected>{{ $from_branch['name'] }}
                                                </option>
                                                @endif
                                            </select>
                
                                        </div>
                
                                    </div>
                
                                    <div class="col-lg-3">
                
                                        <div class="form-group">
                
                                            <label for="filter_to_branch">{{ __('To Branch') }}</label>
                
                                            <select name="filter_to_branch" id="filter_to_branch"
                
                                                class="form-control branch_id">
                                                @if (isset($to_branch) && $to_branch != null)
                                                <option value="{{ $to_branch['id'] }}" selected>{{ $to_branch['name'] }}
                                                </option>
                                                @endif
                                            </select>
                
                                        </div>
                
                                    </div>
                
                                    <div class="col-lg-3">
                
                                        <div class="form-group">
                
                                            <label for="filter_from_user">{{ __('From User') }}</label>
                
                                            <select name="filter_from_user" id="filter_from_user" class="form-control user_id">
                                                @if (isset($from_user) && $from_user != null)
                                                <option value="{{ $from_user['id'] }}" selected>{{ $from_user['name'] }}
                                                </option>
                                                @endif
                                            </select>
                
                                        </div>
                
                                    </div>
                
                                    <div class="col-lg-3">
                
                                        <div class="form-group">
                
                                            <label for="filter_to_user">{{ __('To User') }}</label>
                
                                            <select name="filter_to_user" id="filter_to_user" class="form-control user_id">
                                                @if (isset($to_user) && $to_user != null)
                                                <option value="{{ $to_user['id'] }}" selected>{{ $to_user['name'] }}
                                                </option>
                                                @endif
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
                                                                {{ formated_price($totalCach) }}
                                                            </h4>
                                                            <span>
                                                                {{ __('totalCach') }}
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
                                                                {{ formated_price($totalBeforeCustody)}}
                                                            </h4>
                                                            <span>
                                                                {{ __('totalBeforeCustody') }}
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
                                                                {{ formated_price($totalBeforeCustody - $totalCach)}}
                                                            </h4>
                                                            <span>
                                                                {{ __('custody') }}
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
                                                                {{ formated_price($totalOther)}}
                                                            </h4>
                                                            <span>
                                                                {{ __('totalOther') }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <!-- \Report summary -->
                                    <table id="" class="table table-striped table-bordered datatable"  width="100%">
                                        <thead>
                                        <tr>
                                          <th width="10px">#</th>
                                          <th>{{__('From Branch')}}</th>
                                          <th>{{__('To Branch')}}</th>
                                          <th>{{__('From User')}}</th>
                                          <th>{{__('To User')}}</th>
                                          <th>{{__('Profit Amount')}}</th>
                                          <th>{{__('day Amount')}}</th>
                                          <th>{{__('From')}} : {{ ('To') }}</th>
                                          <th>{{ __('Send Date') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($model as $safe)
                                                <tr>

                                                    <td>{{ $safe['id'] }}</td>
                                                    <td>{{ $safe['fromBrnach']['name'] }}</td>
                                                    <td>{{ $safe['toBrnach']['name'] }}</td>
                                                    <td>{{ isset($safe['fromUser']['name'])?$safe['fromUser']['name']:''  }}</td>
                                                    <td>{{ isset($safe['toUser']['name'])?$safe['toUser']['name']:'' }}</td>
                                                    <td>
                                                        <ul class="p-1">
                                                            @php
                                                                $is_cach = 0;
                                                            @endphp
                                                            @foreach($safe['payments'] as $payment)
                                                                 <li>
    
                                                                    @php
                                                                    $custody = \App\Models\Branches_custody::where('priceable_type','App\Models\SafeTransfer')->where('priceable_id',$safe->id)->sum('custody');
                                                                    @endphp
    
                                                                    
                                                                      @if ($payment->payment_method_id == setting('account')['payment'] && $is_cach == 0)
                                                                           {{ $payment->payment_method->name  }} : {{ $payment->amount-$custody }} 
                                                                            @php
                                                                                $is_cach = 1;
                                                                            @endphp
                                                                      @else
                                                                           {{ $payment->payment_method->name  }} : {{ $payment->amount }} 
                                                                      @endif  
                                                                 </li>
                                                            @endforeach
                                                       </ul>
                                                    </td>
                                                    <td>
                                                        <ul class="p-1">
                                                            @foreach($safe['payments'] as $payment)
                                                                 <li>
    
                                                                    @php($custody =0)
    
                                                                      @if ($payment->payment_method_id == setting('account')['payment'])
                                                                           {{ $payment->payment_method->name  }} : {{ $payment->amount-$custody }} 
                                                                      @else
                                                                           {{ $payment->payment_method->name  }} : {{ $payment->amount }} 
                                                                      @endif  
                                                                 </li>
                                                            @endforeach
                                                       </ul>
                                                    </td>
                                                    <td>{{ date('Y-m-d',strtotime($safe->from_date))}} : {{date('Y-m-d',strtotime($safe->to_date))  }}</td>
                                                    <td>{{ date('Y-m-d h:i A',strtotime($safe->created_at)) }}</td>
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
    <script src="{{url('js/admin/safe_transfer_all.js')}}"></script>
    <script src="{{ url('js/admin/report_details.js') }}"></script>



@endsection
