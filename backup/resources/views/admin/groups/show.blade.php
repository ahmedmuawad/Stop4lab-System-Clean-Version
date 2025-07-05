@extends('layouts.app')

@section('title')
{{__('Invoice')}}
@endsection

@section('css')
    <link rel="stylesheet" href="{{url('css/print.css')}}">
@endsection


@section('content')

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">
            {{__('Invoice')}}
        </h3>
    </div>
    <!-- patient code -->
    <input type="hidden" name="patient_code" @if(isset($group['patient'])) value="{{$group['patient']['code']}}" @endif
        id="patient_code">

    <div class="card-body p-0">
        <div class="p-3 mb-3" id="invoice">
            <!-- title row -->
            <div class="row">
                <div class="col-12 table-responsive">

                    <table width="100%">
                        <thead>
                            <tr>
                                <th colspan="3">
                                    <table width="100%" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <td width="50%">
                                                    <span class="title">{{__('Barcode')}} :</span>
                                                    <span class="data">
                                                        {{$group['barcode']}}
                                                    </span>
                                                </td>
                                                <td width="50%">
                                                    <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($group['barcode'], $barcode_settings['type'])}}" alt="barcode" class="margin" width="100"/><br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="50%">
                                                    <span class="title">{{__('Patient Code')}} :</span> <span
                                                        class="data">
                                                        @if(isset($group['patient']))
                                                            {{ $group['patient']['code'] }}
                                                        @endif
                                                    </span>

                                                </td>
                                                <td width="50%">
                                                    <span class="title">{{__('Patient Name')}} :</span> <span
                                                        class="data">
                                                        @if(isset($group['patient']))
                                                            {{ $group['patient']['name'] }}
                                                        @endif
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="title">{{__('Age')}} :</span>
                                                    <span class="data">
                                                        @if(isset($group['patient']))
                                                            {{$group['patient']['age']}}
                                                        @endif
                                                    </span>

                                                </td>
                                                <td>
                                                    <span class="title">{{__('Gender')}} :</span> <span
                                                        class="data">
                                                        @if(isset($group['patient']))
                                                            {{ __($group['patient']['gender']) }}
                                                        @endif
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="title">{{__('Doctor')}} :</span> <span
                                                        class="data">
                                                        @if(isset($group['doctor']))
                                                            {{ $group['doctor']['name'] }}
                                                        @elseif(isset($group['normalDoctor']))
                                                            {{ $group['normalDoctor']['name'] }}
                                                        @endif
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="title">{{__('Contract')}} :</span> <span
                                                        class="data">
                                                        @if(isset($group['contract']))
                                                            {{ $group['contract']['title'] }}
                                                        @endif
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="title">{{__('Registration Date')}} :</span>
                                                    <span class="data">
                                                        {{ date('Y-m-d H:i',strtotime($group['created_at'])) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="title">{{__('Sample collection')}} :</span>
                                                    <span class="data">
                                                        {{ $group['sample_collection_date'] }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="title">{{__("Sample Collected")}} :</span>
                                                    <span class="data">
                                                        @if($group['is_out'])
                                                        <bdi>{{ __('Outside') }}</bdi> {{ $info['name'] }}

                                                        @else
                                                        <bdi>{{ __('Inside') }}</bdi> {{ $info['name'] }}
                                                        @endif
                                                    </span>
                                                </td>
                                                @php
                                                    $num_date = '';
                                                    $diff = '';
                                                    $created_at_report = '';
                                                    // get num_date from relationship tests
                                                    $tests = $group->tests()->whereHas('test', function ($query) {
                                                        $query->where('num_day_receive', '!=', 0);
                                                    })->get();
                                                    if(count($tests)) {
                                                        foreach ($group['tests'] as $test) {
                                                            $num_date = $test->test->orderby('num_day_receive', 'desc')->first();
                                                            $created_at_report = $test;
                                                        }

                                                        // get created_at and add day use carbon
                                                        $created_at = $created_at_report ? $created_at_report->created_at : '';
                                                        if ($created_at) {
                                                            $created_at = \Carbon\Carbon::parse($created_at);
                                                            $diff = $created_at->addDays($num_date->num_day_receive);
                                                        }
                                                    } else {
                                                        foreach ($group['tests'] as $test) {
                                                            $num_date = $test->test->orderby('num_hour_receive', 'desc')->first();
                                                            $created_at_report = $test;
                                                        }

                                                        // get created_at and add day use carbon
                                                        $created_at = $created_at_report ? $created_at_report->created_at : '';
                                                        if ($created_at) {
                                                            $created_at = \Carbon\Carbon::parse($created_at);
                                                            $diff = $created_at->addHours($num_date->num_hour_receive);
                                                        }
                                                    }

                                                @endphp

                                                @if($diff)
                                                    <td>
                                                        <span class="title"><bdi>{{ __('Result R-date') }}</bdi>:</span>
                                                        <span class="data">

                                                            {{ $diff->format('Y-m-d g:i A') }}
                                                        </span>
                                                    </td>
                                                @endif
                                            </tr>

                                        </thead>
                                    </table>
                                </th>

                            </tr>
                        </thead>

                    </table>

                </div>
                <!-- /.col -->
            </div>

            <br>

            <div class="row">
                <!-- /.col -->
                <div class="col-lg-12 table-responsive">
                    <p class="lead">{{__('Due Date')}} : {{date('d/m/Y',strtotime($group['created_at']))}}</p>
                    <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead  >
                            <tr>
                                <th colspan="2" width="85%">{{__('Test Name')}}</th>
                                <th width="15%">{{__('Price')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($group['tests'] as $test)
                            <tr>
                                <td colspan="2" class="print_title">
                                    @if(isset($test['test']))
                                        {{$test['test']['name']}}
                                    @endif
                                </td>
                                <td>{{formated_price($test['price'])}}</td>
                            </tr>
                            @endforeach

                            @foreach($group['cultures'] as $culture)
                            <tr>
                                <td colspan="2" class="print_title">
                                    @if(isset($culture['culture']))
                                        {{$culture['culture']['name']}}
                                    @endif
                                </td>
                                <td>{{formated_price($culture['price'])}}</td>
                            </tr>
                            @endforeach

                            @foreach($group['packages'] as $package)
                            <tr>
                                <td colspan="2" class="print_title">
                                    @if(isset($package['package']))
                                        {{$package['package']['name']}}
                                    @endif
                                    <ul>
                                        @foreach($package['tests'] as $test)
                                            <li>
                                                {{$test['test']['name']}}
                                            </li>
                                        @endforeach
                                        @foreach($package['cultures'] as $culture)
                                            <li>
                                                {{$culture['culture']['name']}}
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>{{formated_price($package['price'])}}</td>
                            </tr>
                            @endforeach

                            @foreach($group['rays'] as $ray)
                            <tr>
                                <td colspan="2" class="print_title">
                                    @if(isset($ray['ray']))
                                        {{$ray['ray']['name']}}
                                    @endif
                                </td>
                                <td>{{formated_price($ray['price'])}}</td>
                            </tr>
                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr class="receipt_title border-top">
                                <td width="60%" class="no-right-border"></td>
                                <td class="total">
                                    <b>{{__('Subtotal')}}</b>
                                </td>
                                <td class="total">{{formated_price($group['subtotal'])}}</td>
                            </tr>

                            <tr class="receipt_title">
                                <td width="60%" class="no-right-border"></td>
                                <td class="total">
                                    <b>
                                        {{__('Discount')}}
                                    </b>
                                </td>
                                {{-- <td class="total">{{formated_price_2($group['discount'])}}</td> --}}  <td class="total"> {{ $group['discount'] .' %'  }} </td>
                            </tr>

                            <tr class="receipt_title">
                                <td width="60%" class="no-right-border"></td>
                                <td class="total">
                                    <b>
                                        {{__('Discount_Value')}}
                                    </b>
                                </td>
                                <td class="total">{{formated_price_2($group['discount_value'])}}</td>
                            </tr>

                            <tr class="receipt_title">
                                <td width="60%" class="no-right-border"></td>
                                <td class="total">
                                    <b>{{__('Total')}}</b>
                                </td>
                                <td class="total">{{formated_price($group['total'])}}</td>
                            </tr>

                            <tr class="receipt_title">
                                <td width="60%" class="no-right-border"></td>
                                <td class="total">
                                    <b>
                                        {{__('Paid')}}
                                    </b>
                                    <br>
                                    @foreach($group['payments'] as $payment)
                                        {{formated_price($payment['amount'])}}
                                        <b>{{__('On')}}</b>
                                        {{$payment['date']}}
                                        <b>{{__('By')}}</b>
                                        {{$payment['payment_method']['name']}}
                                        <br>
                                    @endforeach
                                </td>
                                <td class="total">
                                    @if(count($group['payments']))
                                        {{formated_price($group['paid'])}}
                                    @else
                                        {{formated_price(0)}}
                                    @endif
                                </td>
                            </tr>

                            <tr class="receipt_title">
                                <td width="60%" class="no-right-border"></td>
                                <td class="total">
                                    <b>{{__('Due')}}</b>
                                </td>
                                <td class="total">{{formated_price($group['due'])}}</td>
                            </tr>
                        </tfoot>
                    </table>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
    </div>

    <div class="card-footer">
        <!-- this row will not appear when printing -->
        <div class="row no-print">
            <form id= "printer_receipt_form">
                <input type="hidden" name="pdf" value="{{$group['receipt_pdf']}}">
                <input type="hidden" name="type" value="receipt">
            </form>
            <div class="col-12">
                <a target="_blank" href="{{$group['receipt_pdf']}}" class="btn btn-danger">
                    <i class="fa fa-file-pdf"></i> {{__('Print receipt')}}
                </a>
                {{--  <a target="_blank" href="{{$group['receipt_pdf']}}" class="btn btn-danger">
                    <i class="fa fa-file-pdf"></i> {{__('Print receipt Direct')}}
                </a>  --}}

                <a style="cursor: pointer" class="btn btn-warning print_barcode" data-toggle="modal" data-target="#print_barcode_modal{{$group['id']}}" group_id="{{$group['id']}}">
                    <i class="fa fa-barcode" aria-hidden="true"></i>
                    {{__('Print barcode')}}
                </a>
                {{--  <a style="cursor: pointer" class="btn btn-warning print_barcode" data-toggle="modal" data-target="#print_barcode_modal{{$group['id']}}" group_id="{{$group['id']}}">
                    <i class="fa fa-barcode" aria-hidden="true"></i>
                    {{__('Print barcode Direct')}}
                </a>  --}}

                <a href="{{route('admin.groups.working_paper',$group['id'])}}" class="btn btn-info">
                    <i class="fas fa-file-word" aria-hidden="true"></i>
                    {{__('Working paper')}}
                </a>
                {{--  <a href="{{route('admin.groups.working_paper',$group['id'])}}" class="btn btn-info">
                    <i class="fas fa-file-word" aria-hidden="true"></i>
                    {{__('Working paper Direct')}}
                </a>  --}}

                @if($whatsapp['receipt']['active']&&isset($group['receipt_pdf']))
                    @php
                        $message=str_replace(['{patient_name}','{receipt_link}'],[$group['patient']['name'],$group['receipt_pdf']],$whatsapp['receipt']['message']);
                    @endphp
                    <a target="_blank" href="https://wa.me/{{$group['patient']['phone']}}?text={{$message}}" class="btn btn-success">
                        <i class="fab fa-whatsapp" aria-hidden="true" class="text-success"></i>
                        {{__('Send Receipt')}}
                    </a>
                @endif

                @if($email['receipt']['active']&&isset($group['receipt_pdf']))
                <form action="{{route('admin.groups.send_receipt_mail',$group['id'])}}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-primary d-inline">
                    <i class="fa fa-envelope" aria-hidden="true" class="text-success"></i>
                    {{__('Send Receipt')}}
                    </button>
                </form>
                @endif

                @can('edit_medical_report')
                    <a href="#" data-toggle="modal" class="btn btn-primary d-inline" data-target="#exampleModalCenter{{$group['id']}}">
                        <i class="fa fa-check"></i>
                        {{__('Sample Receipt')}}
                    </a>
                @endcan

                @can('edit_patient')
                    <a href="{{ route('admin.patients.edit',$group['patient']['id']) }}" class="btn btn-warning btn-sm mr-1 float-right">
                        <i class="fa fa-check"></i>
                        {{__('Edit patient')}}
                    </a>
                @endcan

            </div>
        </div>
    </div>
</div>

@php

   // get group by id
   $group = \App\Models\Group::find($group['id']);

@endphp

<div class="modal fade" id="print_barcode_modal{{$group['id']}}" aria-hidden="true">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">{{__('Print barcode')}}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        @php
            $sample_type_arr = [];
            foreach ($group->all_tests as $value) {
                if(!in_array($value->test->sample_type,$sample_type_arr)){
                    array_push($sample_type_arr,$value->test->sample_type);
                }
            }
            foreach ($group->all_cultures as $value) {
                if(!in_array($value->culture->sample_type,$sample_type_arr)){
                    array_push($sample_type_arr,$value->culture->sample_type);
                }
            }
        @endphp
        <form action="{{ route('admin.groups.print_barcode',$group['id']) }}" method="POST" id="print_barcode_form" target="_blank">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="number">{{__('Number of samples')}}</label>
                            <input type="number" id="number" name="number" placeholder="{{__('Number of samples')}}" class="form-control" value="{{ count($sample_type_arr) }}" min="1" max="{{ count($sample_type_arr) }}" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{__('Close')}}</button>
                <button type="submit" class="btn btn-primary">Print</button>
            </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


  <div class="modal fade" id="exampleModalCenter{{$group['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:1050px !important;">
       <div class="modal-content">
          <div class="modal-header">
             <h5 class="modal-title" id="exampleModalLongTitle">{{__('Check Test')}}</h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
             </button>
          </div>
          <div class="modal-body">
             <form action="{{route('admin.group.check.test' , $group['id'])}}" method="post">
                @csrf()
                @foreach($group->all_tests as $test)
                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                            <label for="">{{$test->test->name}}</label>
                            <input type="checkbox" class="form-control check-test" {{ $test->check_test == 1 ? 'checked' : '' }} name="" value="{{ $test->id }}">
                            <input type="hidden" class="form-control" name="test_id[]" value="{{$test->id}}">
                            <input type="hidden" class="form-control check_test" name="check_test[]" value="{{ $test->check_test == 1 ? $test->id : '' }}">
                        </div>
                        <div class="col-2">
                            <label for="">{{__('Rejected')}}</label>
                            <input type="checkbox" class="form-control sample_status" {{ $test->sample_status == 1 ? 'checked' : '' }}   name="sample_status_test[{{ $test['id'] }}]" value="1">
                            {{-- <input type="hidden" class="form-control check_test" name="check_test[]" value="{{ $test->check_test == 1 ? $test->id : '' }}">  --}}
                        </div>
                        <div class="col-4 ">
                            <input type="text" class="form-control" name="sample_status_notes_test[{{ $test['id'] }}]" placeholder="{{ __('Reason of rejection') }}" value="{{ $test->sample_status_notes  }}">
                        </div>
                    </div>
                </div>
                @endforeach
                @foreach($group->all_cultures as $culture)
                <div class="form-group">
                   <label for="">{{$culture->culture->name}}</label>
                   <input type="hidden" class="form-control" name="culture_id[]" value="{{$culture->id}}">
                   <input type="checkbox" class="form-control check-test" {{ $culture->check_test == 1 ? 'checked' : '' }} name="" value="{{ $culture->id }}">
                   <input type="hidden" class="form-control check_test" name="check_test[]" value="{{ $culture->check_test == 1 ? $culture->id : '' }}">
                </div>
                @endforeach
                <div class="modal-footer">
                   <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                   <button class="btn btn-primary">{{__('Save')}}</button>
                </div>
             </form>

          </div>
       </div>
    </div>
 </div>

@endsection


  @section('scripts')
    <script src="{{url('js/admin/groups.js')}}"></script>
@endsection
