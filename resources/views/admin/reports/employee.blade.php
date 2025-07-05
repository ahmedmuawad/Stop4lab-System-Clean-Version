@extends('layouts.app')

@section('title')
{{__('Employee report')}}
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css ">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">

@endsection
@section('breadcrumb')
          <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
          <li class="breadcrumb-item active">{{__('Employee report')}}</li>
@endsection

@section('content')
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="card-body">


            <!-- Filtering Form -->
            <div id="accordion">
                <div class="card card-info">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                        class="btn btn-primary collapsed" aria-expanded="false">
                        <i class="fas fa-filter"></i> {{__('Filters')}}
                    </a>
                    <form method="get" action="{{route('admin.reports.employee')}}">
                        <div id="collapseOne" class="panel-collapse in collapse show">
                            <div class="card-body">
                                <div class="row">
                                    <!-- date range -->
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                        <label>{{__('Date range')}}:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="date"
                                                class="form-control float-right datepickerrange"
                                                @if(request()->has('date')) value="{{request()->get('date')}}" @endif
                                            id="date" required>
                                        </div>
                                    </div>
                                    <!-- employee  -->
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                        <label>{{__('Employee')}}:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-user"></i>
                                                </span>
                                            </div>
                                            <select class="form-control float-right" name="employee_id" id="employee_id">
                                                <option disabled selected>employee</option>
                                                @foreach ($employees as $employee)
                                                    <option @if(request()->has('employee_id') && request()->employee_id == $employee->id ) selected @endif value="{{$employee->id}}">@if(isset($employee->user->name)) {{$employee->user->name}} @endif</option>
                                                @endforeach
                                            </select>
                                            {{-- <input type="text" name="employee_id"
                                                class="form-control float-right"
                                                @if(request()->has('employee_id')) value="{{request()->get('employee_id')}}" @endif
                                            id="employee_id"> --}}
                                        </div>
                                    </div>
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

            @if(request()->has('date'))
            <div class="printable">

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
                                    <div class="col-3 col-sm-4 col-xs-4">
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
                                            {{formated_price($paid)}}
                                        </h4>
                                        <span>
                                            {{__('Paid')}}
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
                                            {{formated_price($vio)}}
                                        </h4>
                                        <span>
                                            {{__('Violations')}}
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
                                <a class="nav-link active" id="custom-tabs-one-purchases-tab" data-toggle="pill"
                                    href="#custom-tabs-one-purchases" role="tab"
                                    aria-controls="custom-tabs-one-purchases"
                                    aria-selected="false">{{__('Employees')}}</a>
                            </li>
                            @if (request()->has('employee_id'))
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-payments-tab" data-toggle="pill"
                                        href="#custom-tabs-one-payments" role="tab" aria-controls="custom-tabs-one-payments"
                                        aria-selected="false">{{__('Schedule')}}</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-one-tabContent">
                            {{-- <div class="tab-pane active show" id="custom-tabs-one-purchases" role="tabpanel"
                                aria-labelledby="custom-tabs-one-purchases-tab">
                                <div class="row">
                                    <div class="col-lg-12 table-responsive">
                                        <table class="table table-striped table-bordered datatable">
                                            <thead>
                                                <tr>
                                                    <th width="10px">#</th>
                                                    <th>{{__('Employee')}}</th>
                                                    <th>{{__('Worked Hours')}}</th>
                                                    <th>{{__('Paid')}}</th>
                                                    <th>{{__('Due')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($purchases as $purchase)
                                                <tr>
                                                    <td>
                                                        {{$purchase['id']}}
                                                    </td>
                                                    <td>
                                                        {{$purchase['date']}}
                                                    </td>
                                                    <td>{{formated_price($purchase['total'])}}</td>
                                                    <td>{{formated_price($purchase['paid'])}}</td>
                                                    <td>{{formated_price($purchase['due'])}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <table
                                            class="dt-complex-header table-striped table table-bordered table-responsive dataTable no-footer"
                                            id="DataTables_Table_1" role="grid"
                                            aria-describedby="DataTables_Table_1_info" style="width: 1206px;">
                                            <thead>
                                                <tr role="row">
                                                    <th rowspan="2" class="sorting_asc" tabindex="0"
                                                        aria-controls="DataTables_Table_1" colspan="1"
                                                        aria-sort="ascending"
                                                        aria-label="Name: activate to sort column descending"
                                                        style="width: 118px;">Name</th>
                                                    <th colspan="2" rowspan="1">Contact</th>
                                                    <th colspan="3" rowspan="1">HR Information</th>
                                                    <th rowspan="2" class="sorting_disabled" colspan="1"
                                                        aria-label="Actions" style="width: 147px;">Actions</th>
                                                </tr>
                                                <tr role="row">
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="E-mail: activate to sort column ascending"
                                                        style="width: 131px;">E-mail</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="City: activate to sort column ascending"
                                                        style="width: 99px;">City</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Position: activate to sort column ascending"
                                                        style="width: 165px;">Position</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Salary: activate to sort column ascending"
                                                        style="width: 141px;">Salary</th>
                                                    <th class="cell-fit sorting" tabindex="0"
                                                        aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
                                                        aria-label="Status: activate to sort column ascending"
                                                        style="width: 50px;">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="odd">
                                                    <td valign="top" colspan="7" class="dataTables_empty">Loading...
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> --}}
                            <section id="complex-header-datatable">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header border-bottom">
                                                <h4 class="card-title">HR Report</h4>
                                            </div>
                                            <div class="card-datatable">
                                                <div id="DataTables_Table_1_wrapper"
                                                    class="dataTables_wrapper dt-bootstrap4 no-footer">

                                                    <table
                                                        class="dt-complex-header table table-bordered table-responsive no-footer"
                                                        id="employee_report_table" role="grid"
                                                        aria-describedby="DataTables_Table_1_info"
                                                        >
                                                        <thead>
                                                            <tr role="row">
                                                                <th rowspan="2" class="sorting_asc" tabindex="0"
                                                                    aria-controls="DataTables_Table_1" colspan="1"
                                                                    aria-sort="ascending"

                                                                    >{{__('Employee')}}</th>
                                                                {{-- <th rowspan="2" class="sorting_asc" tabindex="0"
                                                                    aria-controls="DataTables_Table_1" colspan="2"
                                                                    aria-sort="ascending"

                                                                    >{{__('Worked Hours')}}</th> --}}
                                                                <th colspan="2" rowspan="1">{{__('Worked Hours')}}</th>
                                                                <th colspan="2" rowspan="1">{{__('Violations')}}</th>
                                                                <th colspan="2" rowspan="1">{{__('Vocations')}}</th>
                                                                <th colspan="2" rowspan="1">{{__('OverTime')}}</th>
                                                                <th colspan="3" rowspan="1">{{__('Salary')}}</th>
                                                                <th colspan="3" rowspan="1">{{__('informations')}}</th>
                                                                {{-- <th rowspan="3" colspan="1">{{__('Salary')}}</th> --}}

                                                            </tr>
                                                            <tr role="row">
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="DataTables_Table_1" rowspan="1"
                                                                    colspan="1"

                                                                    >{{__('day')}}</th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="DataTables_Table_1" rowspan="1"
                                                                    colspan="1"

                                                                    >{{__('hours')}}</th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="DataTables_Table_1" rowspan="1"
                                                                    colspan="1"

                                                                    >{{__('day')}}</th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="DataTables_Table_1" rowspan="1"
                                                                    colspan="1"

                                                                    >{{__('pound')}}</th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="DataTables_Table_1" rowspan="1"
                                                                    colspan="1"

                                                                    >{{__('day')}}</th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="DataTables_Table_1" rowspan="1"
                                                                    colspan="1"

                                                                    >{{__('pound')}}</th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="DataTables_Table_1" rowspan="1"
                                                                    colspan="1"

                                                                    >{{__('Hours')}}</th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="DataTables_Table_1" rowspan="1"
                                                                    colspan="1"

                                                                    >{{__('pound')}}</th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="DataTables_Table_1" rowspan="1"
                                                                    colspan="1"

                                                                    >{{__('hours')}}</th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="DataTables_Table_1" rowspan="1"
                                                                    colspan="1"

                                                                    >{{__('days')}}</th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="DataTables_Table_1" rowspan="1"
                                                                    colspan="1"

                                                                    >{{__('month')}}</th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="DataTables_Table_1" rowspan="1"
                                                                    colspan="1"

                                                                    >{{__('job')}}</th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="DataTables_Table_1" rowspan="1"
                                                                    colspan="1"

                                                                    >{{__('weekends')}}</th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="DataTables_Table_1" rowspan="1"
                                                                    colspan="1"

                                                                    >{{__('total salary')}}</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            @foreach ($attendace as $employee)
                                                                <tr>
                                                                    <td>{{$employee->employee->user->name}}</td>
                                                                    <td>{{$employee->work_days}}</td>
                                                                    <td>{{(int)($employee->total_time / 60)}} : {{($employee->total_time % 60)}} H:m </td>
                                                                    <td> <span class="badge badge-pill badge-light-warning mr-1">{{$employee->daysViolations}}</span></td>
                                                                    <td> <span class="badge badge-pill badge-light-warning mr-1">{{$employee->poundViolations}} EGP</span></td>
                                                                    <td>{{$employee->dayVocations}}</td>
                                                                    <td>{{$employee->PoundVocations}} EGP</td>
                                                                    <td> <span class="badge badge-pill badge-light-success mr-1">{{$employee->overTimeHours}}</span></td>
                                                                    <td> <span class="badge badge-pill badge-light-success mr-1">{{$employee->overTimePound}} EGP</span></td>
                                                                    <td>{{$employee->hourSalary}} EGP</td>
                                                                    <td>{{$employee->daySalary}} EGP</td>
                                                                    <td>{{number_format($employee->employee->salary,2,'.',',')}} EGP</td>
                                                                    <td>{{$employee->job}}</td>
                                                                    <td>
                                                                        <ul>
                                                                            @foreach ($employee->weekends as $item)
                                                                                <li>{{$item->weekend}}</li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </td>
                                                                    <td>{{number_format($employee->totalSalary,2,'.',',')}} EGP</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            @if (request()->has('employee_id'))
                                <div class="tab-pane" id="custom-tabs-one-payments" role="tabpanel"
                                    aria-labelledby="custom-tabs-one-payments-tab">
                                    <div class="row">
                                        <div class="col-lg-12 table-resposive">
                                            <table class="display" style="width:100%" id="scheduler_table">
                                                <thead>
                                                    <tr>
                                                        <th >#</th>
                                                        <th>{{__('Name')}}</th>
                                                        <th>{{__('Start')}}</th>
                                                        <th>{{__('End')}}</th>
                                                        <th>{{__('Worked Hours')}}</th>
                                                        <th>{{__('Date')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($employeeTable as $item)
                                                        <tr>
                                                            <td>{{$item->id}}</td>
                                                            <td>{{$item->employee->user->name}}</td>
                                                            <td>@if($item->start_shift != NULL) {{date('H:i:s',strtotime($item->start_shift))}} @endif</td>
                                                            <td>@if($item->end_shift != NULL)  {{date('H:i:s',strtotime($item->end_shift))}}  @endif</td>
                                                            <td>{{(int)($item->work_mins / 60)}} : {{$item->work_mins % 60}}</td>

                                                            {{-- <td>{{date('Y-m-d',strtotime($item->start_shift))}}</td> --}}
                                                            {{-- <td>{{$item->start_shift}}</td> --}}

                                                            <td>@if($item->start_shift != NULL){{date("l",strtotime($item->start_shift))}} , {{date('Y-m-d',strtotime($item->start_shift))}}  @endif</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
                <!-- \Report Details -->
            </div>
            @endif
        </div>
    </div>
</div>

@endsection
@section('scripts')

<script src="{{url('plugins/daterangepicker/daterangepicker.js')}}"></script>
<script src="{{url('js/admin/employee_report.js')}}"></script>
@endsection
