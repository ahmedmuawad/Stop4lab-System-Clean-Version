@extends('layouts.app')

@section('title')
    {{ __('Print medical report') }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ url('css/print.css') }}">
    <style>
        .card-tools{
            display: none;
        }
        {{-- CBC Style --}} table,
        th,
        td {
            border: 1px solid #e7e7e7;
            border-collapse: collapse;
            height: 15px;
            color: #000;
        }

        td {
            border: 1px solid #e7e7e7;
            padding: 2px;
            color: #000;
        }

        .pinfo {
            border-collapse: collapse;
            border-radius: 10px;
            height: 20px;
            width: 100%;
            color: #000;
        }

        .theadcbc {
            border: 1px solid #e7e7e7;
            background-color: #b4e4f7;
            color: #00658c;
            font-weight: bold;
            font-size: 12px;
            height: 20px;
        }

        .relativeh {
            border: 1px solid #e7e7e7;
            background-color: #b4e4f7;
            color: #00658c;
            font-weight: bold;
            font-size: 12px;
            height: 20px;
        }

        .absolutetd {
            border: 1px solid #e7e7e7;
            background-color: #b4e4f7;
            color: #00658c;
            font-weight: bold;
            font-size: 12px;
            height: 20px;
        }

        .tleft {
            float: left;
            width: 50%;
            padding-bottom: 10px;
        }

        .tright {
            float: right;
            width: 49%;
            padding-bottom: 10px;
        }

        {{-- another test Style --}} .ttable {
            width: 100%;
        }

        .testtable {
            border: 1px solid #e7e7e7;
            border-collapse: collapse;
            height: 20px;
            width: 100%;

        }

        .tdtest {
            background-color: #f8f8f8;
            padding: 2px;
            height: 20px;
            font-size: 12px;
            text-align: center;
        }


        .theadtest {
            border: 1px solid #e7e7e7;
            background-color: #b4e4f7;
            color: #00658c;
            font-weight: bold;
            font-size: 10px;
            height: 20px;
            text-align: center;
        }

        .ttitle {
            background-color: #f4f4f4;
            font-weight: 600;
            text-align: center;
        }

        .tsthead {
            color: #00658c;
            text-align: left;
            text-decoration: underline;

        }

        .category_title {
            color: #000;
            text-align: center;
            text-decoration: underline;

        }

        .comment {
            padding: 5px;
            text-align: left;
            font-size: 10px;
        }

        .commentb {
            padding: 5px;
            text-align: left;
            font-size: 10px;
        }
    </style>
@endsection

@section('breadcrumb')

                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('admin.medical_reports.index') }}">{{ __('Medical reports') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('Show medical report') }}</li>

@endsection

@section('css')
    <link rel="stylesheet" href="{{ url('css/print.css') }}">
    <style>
        {{-- CBC Style --}} table,
        th,
        td {
            border: 1px solid #e7e7e7;
            border-collapse: collapse;
            height: 15px;
            color: #000;
        }

        td {
            border: 1px solid #e7e7e7;
            padding: 2px;
            color: #000;
        }

        .pinfo {
            border-collapse: collapse;
            border-radius: 10px;
            height: 20px;
            width: 100%;
            color: #000;
        }

        .theadcbc {
            border: 1px solid #e7e7e7;
            background-color: #b4e4f7;
            color: #00658c;
            font-weight: bold;
            font-size: 12px;
            height: 20px;
        }

        .relativeh {
            border: 1px solid #e7e7e7;
            background-color: #b4e4f7;
            color: #00658c;
            font-weight: bold;
            font-size: 12px;
            height: 20px;
        }

        .absolutetd {
            border: 1px solid #e7e7e7;
            background-color: #b4e4f7;
            color: #00658c;
            font-weight: bold;
            font-size: 12px;
            height: 20px;
        }

        .tleft {
            float: left;
            width: 50%;
            padding-bottom: 10px;
        }

        .tright {
            float: right;
            width: 49%;
            padding-bottom: 10px;
        }

        {{-- another test Style --}} .ttable {
            width: 100%;
        }

        .testtable {
            border: 1px solid #e7e7e7;
            border-collapse: collapse;
            height: 20px;
            width: 100%;

        }

        .tdtest {
            background-color: #f8f8f8;
            padding: 2px;
            height: 20px;
            font-size: 12px;
            text-align: center;
        }


        .theadtest {
            border: 1px solid #e7e7e7;
            background-color: #b4e4f7;
            color: #00658c;
            font-weight: bold;
            font-size: 10px;
            height: 20px;
            text-align: center;
        }

        .ttitle {
            background-color: #f4f4f4;
            font-weight: 600;
            text-align: center;
        }

        .tsthead {
            color: #00658c;
            text-align: left;
            text-decoration: underline;

        }

        .category_title {
            color: #000;
            text-align: center;
            text-decoration: underline;

        }

        .comment {
            padding: 5px;
            text-align: left;
            font-size: 10px;
        }

        .commentb {
            padding: 5px;
            text-align: left;
            font-size: 10px;
        }
    </style>
@endsection



@section('content')


    @can('view_medical_report')
        <div class="row mb-3">
            <div class="col-lg-12">
                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#patient_modal">
                    <i class="fas fa-user-injured"></i> {{ __('Patient info') }}
                </button>
                <a @if (isset($previous)) href="{{ route('admin.medical_reports.show', $previous['id']) }}" @endif
                    class="btn btn-info @if (!isset($previous)) disabled @endif">
                    <i class="fa fa-backward mr-2"></i>
                    {{ __('Previous') }}
                </a>
                <a @if (isset($next)) href="{{ route('admin.medical_reports.show', $next['id']) }}" @endif
                    class="btn btn-success @if (!isset($next)) disabled @endif">
                    {{ __('Next') }}
                    <i class="fa fa-forward ml-2"></i>
                </a>
            </div>
        </div>
    @endcan

    <form method="POST" action="{{ route('admin.medical_reports.pdf', $group['id']) }}" id="print_form">
        @csrf
        <!-- patient code -->
        <input type="hidden" id="patient_code"
            @if (isset($group['patient'])) value="{{ $group['patient']['code'] }}" @endif>

        @if ($group['uploaded_report'])
            <div class="row mb-3">
                <div class="col-lg-12">
                    <a href="{{ $group['report_pdf'] }}" class="btn btn-danger float-right" target="_blank">
                        <i class="fa fa-file-pdf"></i>
                        {{ __('Print uploaded report') }}
                    </a>
                </div>
            </div>
        @else
            <div class="row mb-3">
                <div class="col-lg-3">
                    <h6 class="text-info">
                        {{ __('Select tests and cultures to be printed in the report') }}
                    </h6>
                </div>
                <div class="col-lg-9">

                    <button type="submit" class="btn btn-primary float-right d-inline">
                        <i class="fa fa-print"></i>
                        {{ __('Print') }}
                    </button>



                    <button type="button" id="withoutHeaders"
                        data-action="{{ route('admin.medical_reports.print_report_2', $group['id']) }}"
                        class="btn btn-primary float-right d-inline" style="margin-right: 7px">
                        <i class="fa fa-print"></i>
                        {{ __('Print Without Head') }}

                    </button>


                    <button type="button" class="btn btn-danger deselect_all float-right d-inline mr-2">
                        <i class="fa fa-times-circle"></i>
                        {{ __('Deselect all') }}
                    </button>

                    <button type="button" class="btn btn-success select_all float-right d-inline mr-2">
                        <i class="fas fa-check-square"></i>
                        {{ __('Select all') }}
                    </button>

                    <button type="button" data-url="{{ route('admin.medical_report.include.history', $group->id) }}"
                        class="btn btn-info include_history float-right d-inline mr-2">
                        {{-- @if (session()->has('history') && session()->get('history') == $group->id)<i class="fas fa-check-square"></i> @endif --}}
                        @if (session()->get('history') == $group->id)
                            <i id="icon_history" class="fas fa-check-square"></i>
                        @else
                            <i id="icon_history" class="fas "></i>
                        @endif

                        {{ __('Include History') }}
                    </button>

                </div>
            </div>
        @endif

        <div class="row">
            <!-- Tests -->
            <div class="col-lg-12">
                <div class="card card-primary">
                    <div class="card-header">

                        <div class="row">
                            <div class="col-lg-10">
                                <h3 class="card-title">{{ __('Tests') }}</h3>
                            </div>
                            <div class="n-chk">
                                <label class="new-control new-radio radio-primary">
                                  <input type="radio" class="new-control-input report_design" name="report_design" value="1"checked>
                                  <span class="new-control-indicator"></span>{{__('Design 1') }}
                                </label>
                            </div>
                            <div class="n-chk">
                                <label class="new-control new-radio radio-primary">
                                  <input type="radio" class="new-control-input report_design" name="report_design" value="2">
                                  <span class="new-control-indicator"></span>{{__('Design 2') }}
                                </label>
                            </div>
                            <!-- input radio  -->
                            {{--  <div class="form-group">
                                <div style="display: inline-block;">

                                    <label class="form-check-label" for="d1">
                                      {{__('Design 1') }}
                                    </label>
                                    <input class="form-control report_design" type="radio" name="report_design" checked
                                        id="d1" value="1">
                                </div>
                                <div style="display: inline-block;">

                                    <label class="form-check-label" for="d2">
                                        {{__('Design 2') }}
                                    </label>
                                    <input class="form-control report_design" type="radio" name="report_design"
                                        id="d2" value="2">
                                </div>

                            </div>  --}}
                        </div>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div id="accordion">
                            <div class="row">
                                <div class="col-lg-12 table-responsive">
                                    <table width="100%">
                                        <tbody id="analysis_titles_sort">
                                            @if (!count($group['all_tests']))
                                                <tr class="nosort">
                                                    <td class="text-center">
                                                        {{ __('No data available') }}
                                                    </td>
                                                </tr>
                                            @endif
                                            @foreach ($group['all_tests']->sortBy(function($test){return $test->test->category_id;}) as $test)
                                                <tr>
                                                    <td>
                                                        <div class="card card-primary card-outline collapsed-card"
                                                            id="card_{{ $test['id'] }}">

                                                            <div class="card-header">
                                                                <h4 class="card-title">
                                                                    <input type="number" style="width: 50px;"
                                                                    name="sort_test[{{ $test['id']  }}]"
                                                                    value="{{ $test['sort'] }}">
                                                                    @if (!$group['uploaded_report'])
                                                                        <input type="checkbox" class="get_tests analyses_select"
                                                                            id="test_{{ $test['id'] }}" name="tests[]"
                                                                            value="{{ $test['id'] }}">
                                                                    @endif
                                                                    @if ($test['done'])
                                                                        <i class="fa fa-check text-success"></i>
                                                                    @endif
                                                                    <label for="test_{{ $test['id'] }}">
                                                                        @if (isset($test['test']))
                                                                            {{ $test['test']['name'] }} ( {{ $test['test']['category']['name'] }} )
                                                                        @endif
                                                                    </label>

                                                                </h4>
                                                                <label for="new_line[{{ $test['id'] }}]">

                                                                    {{ __('Print in seperate page') }}

                                                                </label>
                                                            <input type="checkbox" class="newline"
                                                            name="new_line_test[{{ $test['id'] }}]"
                                                            id="new_line[{{ $test['id'] }}]"
                                                            value="1"
                                                            @if($test['new_line'] == '1' ) checked @endif
                                                            >
                                                        </div>
                                                                <div class="card-tools">
                                                                    <button type="button" class="btn btn-tool"
                                                                        data-card-widget="collapse"><i
                                                                            class="fas fa-plus"></i>
                                                                    </button>
                                                                    <button type="button" class="btn btn-tool"
                                                                        data-card-widget="remove"><i
                                                                            class="fas fa-times"></i>
                                                                    </button>

                                                            </div>

                                                            <div class="card-body p-0">
                                                                <!--CBC Report ID 473-->


                                                                @if ($test['test']['id'] == 473)
                                                                    <table width="100%">
                                                                        <thead>
                                                                            <tr>
                                                                                <td class="theadcbc">Test </td>
                                                                                <td class="theadcbc">Result</td>

                                                                                <td class="theadcbc">Unit</td>
                                                                                @if (session('report_design') == '1')
                                                                                    <td class="theadcbc">Status</td>
                                                                                @endif
                                                                                <td class="theadcbc">Normal Range</td>

                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($test['results'] as $result)
                                                                                @if (isset($result['component']))
                                                                                    @if ($result['component']['id'] == 1261 ||
                                                                                        $result['component']['id'] == 1262 ||
                                                                                        $result['component']['id'] == 1263 ||
                                                                                        $result['component']['id'] == 1264 ||
                                                                                        $result['component']['id'] == 1266 ||
                                                                                        $result['component']['id'] == 1267 ||
                                                                                        $result['component']['id'] == 1268 ||
                                                                                        $result['component']['id'] == 1419 ||
                                                                                        $result['component']['id'] == 1420 ||
                                                                                        $result['component']['id'] == 1421 ||
                                                                                        $result['component']['id'] == 1422 ||
                                                                                        $result['component']['id'] == 1424 ||
                                                                                        $result['component']['id'] == 1425 ||
                                                                                        $result['component']['id'] == 1426 ||
                                                                                        $result['component']['id'] == 1258 ||
                                                                                        $result['component']['id'] == 1260 ||
                                                                                        $result['component']['id'] == 1265 ||
                                                                                        $result['component']['id'] == 1418 ||
                                                                                        $result['component']['id'] == 1423)
                                                                                    @else
                                                                                        <tr>
                                                                                            <td> {{ $result['component']['name'] }}
                                                                                            </td>
                                                                                            <td> {{ $result['result'] }}
                                                                                            </td>

                                                                                            <td>{{ $result['component']['unit'] }}
                                                                                            </td>
                                                                                            @if (session('report_design') == '1')
                                                                                                <td> {{ $result['status'] }}
                                                                                                </td>
                                                                                            @endif
                                                                                            <td>
                                                                                                @php
                                                                                                    $component_new = App\Models\Test::find($result['component']['id']);
                                                                                                    $new_reference = $component_new
                                                                                                        ->reference_range_new_component()
                                                                                                        ->where('group_id', $group['id'])
                                                                                                        ->first();
                                                                                                @endphp
                                                                                                <!--{{ $component_new->reference_range_new_component }}-->
                                                                                                {!! $component_new->reference_range_new_component && $new_reference
                                                                                                    ? $new_reference->referance_range
                                                                                                    : $result['component']['reference_range'] !!}
                                                                                                <!--{!! $result['component']['reference_range'] !!}-->
                                                                                            </td>


                                                                                        </tr>
                                                                                    @endif
                                                                                @endif
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>

                                                                    <br>
                                                                    <div class="tleft" width="50%">
                                                                        <table width="100%">
                                                                            <thead>
                                                                                <tr>
                                                                                    <td class="relativeh" width="50%">
                                                                                        Test</td>
                                                                                    <td class="relativeh" width="25%">
                                                                                        Relative Count %</td>
                                                                                    <td class="relativeh" width="25%">
                                                                                        Normal Range</td>
                                                                                </tr>
                                                                            </thead>
                                                                            @foreach ($test['results'] as $result)
                                                                                @if (isset($result['component']))
                                                                                    @if ($result['component']['id'] == 1261 ||
                                                                                        $result['component']['id'] == 1262 ||
                                                                                        $result['component']['id'] == 1263 ||
                                                                                        $result['component']['id'] == 1264 ||
                                                                                        $result['component']['id'] == 1266 ||
                                                                                        $result['component']['id'] == 1267 ||
                                                                                        $result['component']['id'] == 1268)
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td>{{ $result['component']['name'] }}
                                                                                                </td>
                                                                                                <td>{{ $result['result'] }}
                                                                                                </td>
                                                                                                <td>
                                                                                                    @php
                                                                                                        $component_new = App\Models\Test::find($result['component']['id']);
                                                                                                        $new_reference = $component_new
                                                                                                            ->reference_range_new_component()
                                                                                                            ->where('group_id', $group['id'])
                                                                                                            ->first();
                                                                                                    @endphp
                                                                                                    <!--{{ $component_new->reference_range_new_component }}-->
                                                                                                    {!! $component_new->reference_range_new_component && $new_reference
                                                                                                        ? $new_reference->referance_range
                                                                                                        : $result['component']['reference_range'] !!}
                                                                                                    <!--{!! $result['component']['reference_range'] !!}-->
                                                                                                </td>
                                                                                            </tr>
                                                                                                    @endif
                                                                                                @endif
                                                                                            @endforeach
                                                                                        </tbody>

                                                                                        </table>
                                                                                        </div>
                                                                        <div class="tright" width="50%">
                                                                            <table width="100%">
                                                                                <thead>
                                                                                    <tr>

                                                                                        <td class="absolutetd" width="50%">Absolute Count 10³/µl</td>
                                                                                        <td class="absolutetd" width="100%">Normal Range</td>
                                                                                    </tr>
                                                                                </thead>

                                                                                <tbody>
                                                                                    @foreach ($test['results'] as $result)
                                                                                        @if (isset($result['component']))
                                                                                            @if ($result['component']['id'] == 1419 ||
                                                                                                $result['component']['id'] == 1420 ||
                                                                                                $result['component']['id'] == 1421 ||
                                                                                                $result['component']['id'] == 1422 ||
                                                                                                $result['component']['id'] == 1424 ||
                                                                                                $result['component']['id'] == 1425 ||
                                                                                                $result['component']['id'] == 1426)
                                                                                                <tr>

                                                                                                    <td>{{ $result['result'] }}</td>
                                                                                                    <td>
                                                                                                        @php
                                                                                                            $component_new = App\Models\Test::find($result['component']['id']);
                                                                                                            $new_reference = $component_new
                                                                                                                ->reference_range_new_component()
                                                                                                                ->where('group_id', $group['id'])
                                                                                                                ->first();
                                                                                                        @endphp
                                                                                                        <!--{{ $component_new->reference_range_new_component }}-->
                                                                                                        {!! $component_new->reference_range_new_component && $new_reference
                                                                                                            ? $new_reference->referance_range
                                                                                                            : $result['component']['reference_range'] !!}
                                                                                                        <!--{!! $result['component']['reference_range'] !!}-->
                                                                                                    </td>

                                                                                                </tr>
                                                                                            @endif
                                                                                        @endif
                                                                                    @endforeach
                                                                                </tbody>

                                                                            </table>
                                </div>
                                <!-- Comment -->

                                @if (isset($test['comment']))
                                    <br>
                                    <table class="comment" width="100%">
                                        <tbody>
                                            <tr>
                                                <td width="10px" nowrap="nowrap"><b>Comment:</b></td>
                                                <td class="commentb">
                                                    {!! str_replace("\n", '<br />', $test['comment']) !!}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                @endif
                                <!-- /comment -->
                                <!--/ end CBC Report ID 473-->
                            @else
                                <table class="table table-striped table-bordered table-sm">
                                    <thead>
                                        <tr class="analysis_head">
                                            <th width="30%">{{ __('Test') }}</th>
                                            <th width="10%" class="text-center">{{ __('Result') }}</th>
                                            <th width="20%" class="text-center">{{ __('Unit') }}</th>
                                            <th width="30%" class="text-center">{{ __('Normal Range') }}</th>
                                            <th width="10%" class="text-center">{{ __('Status') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($test['results'] as $result)
                                            @if (isset($result['component']))
                                                <!-- Title -->
                                                @if ($result['component']['title'])
                                                    <tr>
                                                        <td colspan="5" class="title">
                                                            <b>{{ $result['component']['name'] }}</b>
                                                        </td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td>{{ $result['component']['name'] }}</td>
                                                        <td class="text-center">{{ $result['result'] }}</td>
                                                        <td class="text-center">{{ $result['component']['unit'] }}</td>
                                                        <td class="text-center">
                                                            {!! $result['component']['reference_range'] !!}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $result['status'] }}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endif
                                        @endforeach
                                        @if (isset($test['comment']))
                                            <tr>
                                                <td colspan="5">
                                                    <table width="100%">
                                                        <tbody>
                                                            <tr class="comment">
                                                                <th width="90px">{{ __('Comment') }} :</th>
                                                                <td>
                                                                    {!! str_replace("\n", '<br />', $test['comment']) !!}
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>

                                </table>
                                @endif
                            </div>
                        </div>
                        </td>
                        </tr>
                        @endforeach

                        </tbody>

                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.card-body -->
        </div>
        </div>
        <!-- \Tests -->

        <!-- Cultures -->
        <div class="col-lg-12">
            <div class="card card-primary">
                <div class="card-header">

                    <div class="row">
                        <div class="col-lg-10">
                            <h3 class="card-title">{{ __('Cultures') }}</h3>
                        </div>
                    </div>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div id="accordion">
                        <div class="row">
                            <div class="col-lg-12 table-responsive">
                                @if (!count($group['all_cultures']))
                                    <p class="text-center">
                                        {{ __('No data available') }}
                                    </p>
                                @endif
                                @foreach ($group['all_cultures'] as $culture)
                                    <div class="card card-primary card-outline collapsed-card">
                                        <div class="card-header">
                                            <div class="card-title">
                                                @if (!$group['uploaded_report'])
                                                    <input type="number" style="width: 50px;"
                                                        name="sort_culture[{{ $culture['id']  }}]"
                                                        value="{{ $culture['sort'] }}">
                                                    <input type="checkbox" class="analyses_select get_cultures"
                                                        id="culture_{{ $culture['id'] }}" name="cultures[]"
                                                        value="{{ $culture['id'] }}">
                                                @endif
                                                @if ($culture['done'])
                                                    <i class="fa fa-check text-success"></i>
                                                @endif
                                                <label for="culture_{{ $culture['id'] }}">
                                                    {{ $culture['culture']['name'] }} ( {{ $culture['culture']['category']['name'] }} )
                                                </label>
                                                <div>
                                                <label for="new_line[{{ $culture['id'] }}]">

                                                    {{ __('Print in seperate page') }}

                                                </label>
                                            <input type="checkbox" class="newline"
                                            name="new_line_culture[{{ $culture['id'] }}]"
                                            id="new_line[{{ $culture['id'] }}]"
                                            value="1"
                                            @if($culture['new_line'] == '1' ) checked @endif
                                            >
                                                </div>
                                            </div>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool"
                                                    data-card-widget="collapse"><i class="fas fa-plus"></i>
                                                </button>
                                                <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                                        class="fas fa-times"></i>
                                                </button>

                                            </div>
                                        </div>
                                        <div class="card-body p-0">
                                            <!-- culture options -->
                                            <table width="100%">
                                                <tbody>
                                                    @foreach ($culture['culture_options'] as $culture_option)
                                                        @if (isset($culture_option['value']) && isset($culture_option['culture_option']))
                                                            <tr>
                                                                <th class="no-border nowrap" width="10px"
                                                                    nowrap="nowrap">
                                                                    <span
                                                                        class="option_title">{{ $culture_option['culture_option']['value'] }}
                                                                        :</span>
                                                                </th>
                                                                <td class="no-border">
                                                                    {{ $culture_option['value'] }}
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <!-- /culture options -->

                                            <!-- sensitivity -->
                                            <table class="table table-bordered" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>{{ __('Name') }}</th>
                                                        <th>{{ __('Sensitivity') }}</th>
                                                        <th>{{ __('Commercial name') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($culture['high_antibiotics'] as $antibiotic)
                                                        <tr>
                                                            <td width="200px" nowrap="nowrap" align="left">
                                                                {{ $antibiotic['antibiotic']['name'] }}
                                                            </td>
                                                            <td width="120px" nowrap="nowrap" align="center">
                                                                {{ $antibiotic['sensitivity'] }}
                                                            </td>
                                                            <td>
                                                                {{ $antibiotic['antibiotic']['commercial_name'] }}
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                    @foreach ($culture['moderate_antibiotics'] as $antibiotic)
                                                        <tr>
                                                            <td width="200px" nowrap="nowrap" align="left">
                                                                {{ $antibiotic['antibiotic']['name'] }}
                                                            </td>
                                                            <td width="120px" nowrap="nowrap" align="center">
                                                                {{ $antibiotic['sensitivity'] }}
                                                            </td>
                                                            <td>
                                                                {{ $antibiotic['antibiotic']['commercial_name'] }}
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                    @foreach ($culture['resident_antibiotics'] as $antibiotic)
                                                        <tr>
                                                            <td width="200px" nowrap="nowrap" align="left">
                                                                {{ $antibiotic['antibiotic']['name'] }}
                                                            </td>
                                                            <td width="120px" nowrap="nowrap" align="center">
                                                                {{ $antibiotic['sensitivity'] }}
                                                            </td>
                                                            <td>
                                                                {{ $antibiotic['antibiotic']['commercial_name'] }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                            <!-- Comment -->
                                            @if (isset($culture['comment']))
                                                <table width="100%" class="comment">
                                                    <tbody>
                                                        <tr>
                                                            <td width="100px" nowrap="nowrap">
                                                                <b>{{ __('Comment') }}</b> :
                                                            </td>
                                                            <td>{{ $culture['comment'] }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            @endif
                                            <!-- /comment -->
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <!-- \Cultures -->

        <!-- Rays -->
        @if (isset($group['rays']) && count($group['rays']))
            <div class="col-lg-12">
                <div class="card card-primary">
                    <div class="card-header">

                        <div class="row">
                            <div class="col-lg-10">
                                <h3 class="card-title">{{ __('Rays') }}</h3>
                            </div>
                        </div>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div id="accordion">
                            <div class="row">
                                <div class="col-lg-12 table-responsive">
                                    @if (!count($group['rays']))
                                        <p class="text-center">
                                            {{ __('No data available') }}
                                        </p>
                                    @endif
                                    @foreach ($group['rays'] as $ray)
                                        <div class="card card-primary card-outline collapsed-card">
                                            <div class="card-header">
                                                <div class="card-title">
                                                    @if (!$group['uploaded_report'])
                                                        <input type="checkbox" class="analyses_select get_rays"
                                                            id="ray_{{ $ray['id'] }}" name="rays[]"
                                                            value="{{ $ray['id'] }}">
                                                    @endif
                                                    @if ($ray['checked'])
                                                        <i class="fa fa-check text-success"></i>
                                                    @endif
                                                    <label for="ray_{{ $ray['id'] }}">
                                                        {{ $ray['ray']['name'] }}
                                                    </label>
                                                </div>

                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        @endif
        <!-- \Rays -->
        </div>

        @if ($group['uploaded_report'])
            <div class="row mb-3">
                <div class="col-lg-12">
                    <a href="{{ $group['report_pdf'] }}" class="btn btn-danger float-right" target="_blank">
                        <i class="fa fa-file-pdf"></i>
                        {{ __('Print uploaded report') }}
                    </a>
                </div>
            </div>
        @else
            <div class="row mb-3">
                <div class="col-lg-3">
                    <h6 class="text-info">
                        {{ __('Select tests and cultures to be printed in the report') }}
                    </h6>
                </div>
                <div class="col-lg-9">

                    <button type="submit" class="btn btn-primary float-right d-inline">
                        <i class="fa fa-print"></i>
                        {{ __('Print') }}
                    </button>


                    <button type="button" class="btn btn-danger deselect_all float-right d-inline mr-2">
                        <i class="fa fa-times-circle"></i>
                        {{ __('Deselect all') }}
                    </button>

                    <button type="button" class="btn btn-success select_all float-right d-inline mr-2">
                        <i class="fas fa-check-square"></i>
                        {{ __('Select all') }}
                    </button>

                </div>
            </div>
        @endif
    </form>

    @can('view_medical_report')
        <div class="row mb-3">
            <div class="col-lg-12">
                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#patient_modal">
                    <i class="fas fa-user-injured"></i> {{ __('Patient info') }}
                </button>
                <a @if (isset($previous)) href="{{ route('admin.medical_reports.show', $previous['id']) }}" @endif
                    class="btn btn-info @if (!isset($previous)) disabled @endif">
                    <i class="fa fa-backward mr-2"></i>
                    {{ __('Previous') }}
                </a>
                <a @if (isset($next)) href="{{ route('admin.medical_reports.show', $next['id']) }}" @endif
                    class="btn btn-success @if (!isset($next)) disabled @endif">
                    {{ __('Next') }}
                    <i class="fa fa-forward ml-2"></i>
                </a>
            </div>
        </div>
    @endcan

    @include('admin.medical_reports._patient_modal')
@endsection
@section('scripts')
    <script src="{{ url('plugins/ekko-lightbox/ekko-lightbox.js') }}"></script>
    <script src="{{ url('js/admin/medical_reports.js') }}"></script>


    <script>
        $('body').on('click', '#withoutHeaders', function(e) {
            e.preventDefault();
            let url = this.getAttribute('data-action');

            var tests = $('.get_tests:checked');
            var cultures = $('.get_cultures:checked');
            var rays = $('.get_rays:checked');

            // get all selected tests
            var tests_ids = [];
            tests.each(function(index, element) {
                tests_ids.push(element.value);
            });

            var report_design = $('.report_design:checked').val();

            // get all selected cultures
            var cultures_ids = [];
            cultures.each(function(index, element) {
                cultures_ids.push(element.value);
            });

            // get all selected rays
            var rays_ids = [];
            rays.each(function(index, element) {
                rays_ids.push(element.value);
            });

            // send tests and cultures with window open
            window.open(url + '?tests=' + tests_ids + '&cultures=' + cultures_ids + '&rays=' + rays_ids +
                '&report_design=' + report_design, '_blank');

            //window.open(url, '_blank);

        });

        // click include_history
        $('body').on('click', '.include_history', function(e) {
            e.preventDefault();
            var url = $(this).attr('data-url');

            //send request ajax
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // tost message
                    toastr.success(data.message);
                    if (data.code == 200) {
                        $('#icon_history').addClass('fa-check-square');
                    } else {
                        $('#icon_history').removeClass('fa-check-square');
                    }

                }
            });

        });
    </script>
@endsection
