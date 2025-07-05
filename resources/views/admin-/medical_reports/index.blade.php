@extends('layouts.app')



@section('title')
    {{ __('Medical reports') }}
@endsection



@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">{{ __('Home') }}</a></li>

    <li class="breadcrumb-item active">{{ __('Medical reports') }}</li>
@endsection



@section('content')


    <div class="card card-primary card-outline">

        <div class="card-header">

            <h3 class="card-title"></h3>

        </div>

        <!-- /.card-header -->

        <div class="card-body">

            <!-- filter -->

            <div id="accordion">

                <div class="card card-info">

                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="btn btn-primary collapsed"
                        aria-expanded="false">

                        <i class="fas fa-filter"></i> {{ __('Filters') }}

                    </a>

                    <div id="collapseOne" class="panel-collapse in collapse">

                        <div class="card-body">

                            <div class="row">

                                <div class="col-lg-3">

                                    <div class="form-group">

                                        <label for="filter_date">{{ __('Date') }}</label>

                                        <input type="text" class="form-control" id="filter_date"
                                            placeholder="{{ __('Date') }}">

                                    </div>

                                </div>


                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="filter_category">{{ __('Clinical Groups') }}</label>
                                        <select class="form-control select2" name="filter_category" id="filter_category">
                                            
                                        </select>
                                       
                                    </div>

                                </div>


                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="filter_unit">{{ __('Unit') }}</label>
                                        <input class="form-control" name="filter_unit" id="filter_unit">
                                    </div>

                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="filter_test">{{ __('Test') }}</label>
                                        <select class="form-control" name="filter_test" id="filter_test">

                                        </select>
                                    </div>

                                </div>


                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="filter_culture">{{ __('Culture') }}</label>
                                        <select class="form-control" name="filter_culture" id="filter_culture">

                                        </select>
                                    </div>

                                </div>


                                {{-- <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="filter_status">{{ __('Status') }}</label>
                                        <select class="form-control" name="filter_status" id="filter_status">
                                            <option>
                                                Select Status
                                            </option>
                                            <option>

                                            </option>
                                        </select>
                                    </div>

                                </div> --}}


                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="filter_invoice_num">{{ __('Invoice Number') }}</label>
                                        <input class="form-control" name="filter_invoice_num" id="filter_invoice_num">
                                    </div>

                                </div>


                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="filter_from_num">{{ __('From Num') }}</label>
                                        <input class="form-control" name="filter_from_num" id="filter_from_num">
                                    </div>

                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="filter_to_num">{{ __('To Num') }}</label>
                                        <input class="form-control" name="filter_to_num" id="filter_to_num">
                                    </div>

                                </div>


                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="Urgent">{{ __('Gender') }}</label>
                                        <select class="form-control" name="gender" id="filter_gender">
                                            <option></option>
                                            <option value="male">
                                                {{__('Male')}}
                                            </option>

                                            <option value="female">
                                                {{__('Female')}}
                                            </option>
                                        </select>
                                    </div>

                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="Urgent">{{ __('Urgent') }}</label>
                                        <input type="checkbox" class="form-control" name="Urgent" id="Urgent">
                                    </div>

                                </div>



                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="filter_printed">{{ __('Printed') }}</label>
                                        <input type="checkbox" class="form-control" name="filter_printed" id="filter_printed">
                                    </div>
                                </div>



                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="filter_doctor">{{ __('Doctor') }}</label>
                                        <select class="form-control" name="filter_doctor" id="filter_doctor">

                                        </select>
                                    </div>

                                </div>


                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="filter_patient">{{ __('Patient') }}</label>
                                        <input class="form-control" name="filter_patient" id="filter_patient">

                                        
                                    </div>

                                </div>

                                

                                @if (auth()->guard('admin')->user()->lab_id == null)
                                    <div class="col-lg-3">

                                        <div class="form-group">

                                            <label for="filter_contract">{{ __('Contract') }}</label>

                                            <select name="filter_contract" id="filter_contract" class="form-control">

                                            </select>

                                        </div>

                                    </div>


                                    <div class="col-lg-3">

                                        <div class="form-group">

                                            <label for="filter_created_by">{{ __('Created by') }}</label>

                                            <select name="filter_created_by" id="filter_created_by"
                                                class="form-control user_id">

                                            </select>

                                        </div>

                                    </div>

                                    <div class="col-lg-3">

                                        <div class="form-group">

                                            <label for="filter_signed_by">{{ __('Signed by') }}</label>

                                            <select name="filter_signed_by" id="filter_signed_by"
                                                class="form-control user_id">

                                            </select>

                                        </div>

                                    </div>
                                @endif
                                <div class="col-lg-3">

                                    <div class="form-group">

                                        <label for="filter_status">{{ __('Status') }}</label>

                                        <select name="filter_status" id="filter_status" class="form-control select2">

                                            <option value="" selected>{{ __('All') }}</option>

                                            <option value="1">{{ __('Done') }}</option>

                                            <option value="0">{{ __('Pending') }}</option>

                                        </select>

                                    </div>

                                </div>

                                <div class="col-lg-3">

                                    <div class="form-group">

                                        <label for="filter_barcode">{{ __('Barcode') }}</label>

                                        <input type="text" class="form-control" id="filter_barcode"
                                            placeholder="{{ __('Barcode') }}">

                                    </div>

                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="filter_sorting">{{ __('Doctor') }}</label>
                                        <select class="form-control" name="filter_sorting" id="filter_sorting">
                                            <option value="">
                                                {{__('Select Option')}}
                                            </option>

                                            <option value="id">
                                                {{__('ID')}}
                                            </option>

                                            <option value="branch_id">
                                               {{(__('Branch'))}}
                                            </option>
                                            <option value='sample_collection_date'>
                                                {{__('Collection Date')}}
                                            </option>

                                            <option value='retrieve_date'>
                                                {{__('Recieve Date')}}
                                            </option>

                                            <option value='created_at'>
                                                {{__('Registration Date')}}
                                            </option>

                                        </select>
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- \filter -->

            @if (auth()->guard('admin')->user()->roles[0]->role_id != 6)
                <div class="row">

                    <div class="col-lg-6">

                        <select name="filter_today" id="filter_today"
                            class="filter_today_of_branch form-control btn btn-primary mb-5">



                            @php
                                
                                $today = date('Y-m-d');
                                
                                // get days of year
                                
                                $days = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
                                
                                $days_array = [];
                                
                                for ($i = 1; $i <= $days; $i++) {
                                    $days_array[] = date('Y') . '-' . date('m') . '-' . $i;
                                }
                                
                                $days_array = array_reverse($days_array);
                                
                            @endphp



                            <option value="" selected disabled>اختر اليوم</option>

                            @foreach ($days_array as $day)
                                <option value="{{ date('Y-m-d', strtotime($day . '-' . date('m') . '-' . date('Y'))) }}"
                                    {{ $today == date('Y-m-d', strtotime($day . '-' . date('m') . '-' . date('Y'))) ? 'selected' : '' }}>

                                    {{ $day }}</option>
                            @endforeach

                        </select>

                    </div>

                    <div class="col-lg-6">

                        <select name="filter_branch" id="filter_branch"
                            class="filter_today_of_branch form-control btn btn-primary mb-5">

                            <!-- <option value="" selected>اختر الفرع</option> -->

                            <option value="{{ session('branch_name') }}" selected>{{ session('branch_name') }}</option>

                            @foreach ($user_branches as $branch)
                                <option value="{{ $branch['branch']['name'] }}">{{ $branch['branch']['name'] }}</option>
                            @endforeach

                        </select>

                    </div>

                </div>
            @endif

            <div class="row">

                <div class="col-lg-12 table-responsive">

                    <table id="medical_reports_table" class="table table-striped table-bordered table-sm" width="100%">

                        <thead>

                            <tr>

                                <th width="10px">

                                    <input type="checkbox" class="check_all" name="" id="">

                                </th>

                                <th width="10px">#</th>

                                <th width="10px">الفرع</th>

                                {{--  <th width="10px">{{ __('Created By') }}</th>  --}}

                                <th width="10px">{{ __('Contract') }}</th>

                                {{--  <th width="10px">{{ __('Barcode') }}</th>  --}}

                                <th width="100px">{{ __('P.Code') }}</th>

                                <th>{{ __('Patient Name') }}</th>

                                {{--  <th width="50px">{{ __('Gender') }}</th> --}}


                                <th width="50px">{{ __('Age') }}</th>
                                <th width="50px">{{ __('Doctor') }}</th>
                                <th width="50px">{{ __('Phone') }}</th>

                                <th width="200px">{{ __('Tests') }}</th>
                                <th width="50px">{{ __('Action') }}</th>

                                <th width="100px">{{ __('Date') }}</th>

                                <th class="text-center" width="10px">{{ __('Done') }}</th>

                                <th class="text-center" width="10px">{{ __('Signed') }}</th>
                                <th class="text-center" width="10px">{{ __('Printed') }}</th>
                                <th class="text-center" width="10px">{{ __('Received') }}</th>
                                <th class="text-center" width="10px">{{ __('Sended WA') }}</th>
                                <th class="text-center" width="10px">{{ __('Signed By') }}</th>



                            </tr>

                        </thead>

                        <tbody>



                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        <!-- /.card-body -->

    </div>



@endsection

@section('scripts')
    <script>
        var can_delete =

            @can('delete_medical_report')

                true
            @else

                false
            @endcan ;

        var can_view =

            @can('view_medical_report')

                true
            @else

                false
            @endcan ;
    </script>

    @if ($type == 'all')
        <script src="{{ url('js/admin/medical_reports.js') }}"></script>
    @elseif($type == 'done')
        <script src="{{ url('js/admin/medical_reports_done.js') }}"></script>
    @elseif($type == 'done')
        <script src="{{ url('js/admin/medical_reports_done.js') }}"></script>
    @elseif($type == 'sample_status')
        <script src="{{ url('js/admin/medical_reports_sample_status.js') }}"></script>
    @elseif($type == 'pending')
        <script src="{{ url('js/admin/medical_reports_pending.js') }}"></script>
    @elseif($type == 'unsigned')
        <script src="{{ url('js/admin/medical_reports_unsigned.js') }}"></script>
    @endif
@endsection
