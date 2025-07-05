@extends('layouts.app')

@section('title')
    {{ __('Employees') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Employees') }}</li>
@endsection

@section('content')
    <div class="app-content content">
        <div class="container">

            <div class="row px-2">
                <div class="card col-md-12 mt-4 px-0">
                    <div class="card-header mx-0">
                        {{__('Employee_Penlaity') }}
                    </div>
                    <div class="card-body">
                        <div id="penalities">
                            @if (isset($employee->employeePlentiy))
                                @foreach ($employee->employeePlentiy as $penlatiy)
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label" for="Value">{{ __('Value') }}</label>
                                                <input class="form-control" placeholder="{{ __('Value') }}"
                                                    @if (isset($penlatiy->value)) value="{{ $penlatiy->value }}" @endif
                                                    disabled>
                                            </div>
                                        </div>

                                        <div class="col-lg-8">
                                            <div class="form-group">
                                                <label class="form-label" for="Reason">{{ __('Reason') }}</label>
                                                <textarea type="text" disabled class="form-control" placeholder="{{ __('Reason') }}" required> @if (isset($penlatiy->reason))
{{ $penlatiy->reason }}
@endif </textarea>
                                            </div>
                                        </div>


                                    </div>
                                @endforeach
                            @endif


                        </div>

                    </div>
                </div>
            </div>

            <div class="row px-2">
                <div class="card col-md-12 mt-4 px-0">
                    <div class="card-header">

                    </div>
                    <div class="card-body">
                                          <!-- date range -->
                                          <form action="{{route('admin.checkOut')}}" method="post">
                                            @csrf
                                            <div class="form-group">
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
                                            </div>

                                        <div class="form-group col-sm-4">
                                            <input type="submit" class="btn btn-primary" value="{{__('Send')}}">
                                        </div>
                                    </form>
                    </div>
                </div>
            </div>

            @if(Session::has('object'))
                <div class="row">
              
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>{{__('Monthly_holidys')}}</label>
                                <input class="form-control" disabled value="{{Session::get('object')->Monthly_holidys}}">
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>{{__('unexpected_holidy')}}</label>
                                <input class="form-control" disabled value="{{Session::get('object')->unexpected_holidy}}">
                            </div>
                        </div>
                        
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>{{__('daily_Housr')}}</label>
                                <input class="form-control" disabled value="{{Session::get('object')->daily_Housr}}">
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>{{__('debouns')}}</label>
                                <input class="form-control" disabled value="{{number_format(Session::get('object')->debouns , 2)}}">
                            </div>
                        </div>

                    </div>
               
              @endif
            {{-- <div class="row px-2">
                <div class="card col-md-12 mt-4 px-0">
                    <div class="card-header mx-0">
                        {{ 'Penlaties' }}
                    </div>
                    <div class="card-body">
                        <div id="penalities">
                            @if (isset($employee->employeePlentiy))
                                @foreach ($employee->employeePlentiy as $penlatiy)
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label" for="Value">{{ __('Value') }}</label>
                                                <input class="form-control" placeholder="{{ __('Value') }}"
                                                    @if (isset($penlatiy->value)) value="{{ $penlatiy->value }}" @endif
                                                    disabled>
                                            </div>
                                        </div>

                                        <div class="col-lg-8">
                                            <div class="form-group">
                                                <label class="form-label" for="Reason">{{ __('Reason') }}</label>
                                                <textarea type="text" disabled class="form-control" placeholder="{{ __('Reason') }}" required> @if (isset($penlatiy->reason))
{{ $penlatiy->reason }}
@endif </textarea>
                                            </div>
                                        </div>


                                    </div>
                                @endforeach
                            @endif


                        </div>

                    </div>
                </div>
            </div> --}}



            <div class="row px-2">
                <div class="card col-md-12 mt-4 px-0">
                    <div class="card-header mx-0">
                        {{ __('Bonus') }}
                    </div>
                    <div class="card-body">
                        <div id="Bonus" class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="salary">{{ __('Salary') }}</label>
                                    <input disabled type="number" class="form-control" placeholder="{{ __('Salary') }}"
                                        id="salary"
                                        @if (isset($employee)) value="{{ $employee->salary }}" @endif required>
                                </div>
                            </div>


                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="seniority">{{ __('seniority') }}</label>
                                    <input disabled type="number" min="1" max="100" class="form-control"
                                        placeholder="{{ __('seniority') }}" id="seniority"
                                        @if (isset($employee->employeeSalary)) value="{{ $employee->employeeSalary->seniority }}" @endif
                                        required>
                                </div>
                            </div>


                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label"
                                        for="certificate_allowance">{{ __('certificate_allowance') }}</label>
                                    <input disabled type="number" min="1" max="100" class="form-control"
                                        placeholder="{{ __('certificate_allowance') }}" id="certificate_allowance"
                                        @if (isset($employee->employeeSalary)) value="{{ $employee->employeeSalary->certificate_allowance }}" @endif
                                        required>
                                </div>
                            </div>


                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label"
                                        for="Management_commitment">{{ __('Management_commitment') }}</label>
                                    <input disabled type="number" min="1" max="100" class="form-control"
                                        placeholder="{{ __('Management_commitment') }}" id="Management_commitment"
                                        @if (isset($employee->employeeSalary)) value="{{ $employee->employeeSalary->Management_commitment }}" @endif
                                        required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row px-2 d-flex justify-content-center">
                <div class="d-flex justify-content-center">
                    <p class="btn btn-success">
                        @if(Session::has('object'))
                            {{__("Total")}}:- {{number_format($netSalary - Session::get('object')->debouns , 2) }} 
                        @else
                            {{__("Total")}}:- {{$netSalary}} 
                        @endif
                        
                    </p>
                 
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ url('js/admin/employees.js') }}"></script>
    <script src="{{url('plugins/daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{url('js/admin/employee_report.js')}}"></script>
@endsection
