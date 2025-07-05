@php
    use App\Models\Patient;
    use App\Models\GroupTest;
@endphp

@extends('layouts.pdf')

@section('content')
    <style>
        .receipt_title td,
        th {
            border-color: white;
        }

        .receipt_title .total {
            background-color: #ddd;
        }

        .table th {
            color: {{ $reports_settings['test_head']['color'] }} !important;
            font-size: {{ $reports_settings['test_head']['font-size'] }} !important;
            font-family: {{ $reports_settings['test_head']['font-family'] }} !important;
        }

        tr,
        td {

            font-size: 16px;
            font-weight: 400;

        }

        .total {
            font-family: {{ $reports_settings['test_head']['font-family'] }} !important;
        }

        .due_date {
            font-family: {{ $reports_settings['test_head']['font-family'] }} !important;
        }
        .cont{
            margin-top:50px !important;padding-top: 50px;
        }
        .test_name {
            color: {{ $reports_settings['test_name']['color'] }} !important;
            font-size: {{ $reports_settings['test_name']['font-size'] }} !important;
            font-family: {{ $reports_settings['test_name']['font-family'] }} !important;
        }

        .text-center {
            text-align: center;
        }

        .demTable {
            width: 100%;
            border: 1px dashed #b3adad;
            border-collapse: collapse;
            padding: 5px;
        }

        .demTable th {
            border: 1px dashed #b3adad;
            padding: 5px;
            background: #f0f0f0;
            color: #313030;
        }

        .demTable td {
            border: 1px dashed #b3adad;
            text-align: left;
            padding: 5px;
            background: #ffffff;
            color: #313030;
        }


        .demoTable {
            width: 100%;
            border: 1px solid #b3adad;
            border-collapse: collapse;
            padding: 5px;
        }

        .tableWithBorder,
        .parientTable {
            border: 2px solid #000;
            border-radius: 20px;
            margin-bottom: 10px;
            padding: 13px;
            padding-top:0px;
            margin-top:0px;
        }

        .workData {
            color: red;
            text-decoration: underline;
            font-size: 20px;
            float: left;
            margin-bottom: 0px;margin-top: 0 !important;
            padding-top:4px !important;
        }

        .demoTable th {
            border: 1px solid #b3adad;
            padding: 5px;
            background: #f0f0f0;
            color: #313030;
        }

        .testsTable thead {}

        .testsTable thead tr th {
            background-color: #ddd;
            text-align: cenetr;
            background-color: #ddd;
            padding: 5px;
        }

        .demoTable td {
            border: 1px solid #b3adad;
            text-align: center;
            padding: 5px;
            background: #ffffff;
            color: #313030;
        }



        table.minimalistBlack {
            border: 1px solid #000000;
            width: 100%;
            text-align: left;
            border-collapse: collapse;
        }

        table.minimalistBlack td,
        table.minimalistBlack th {
            border: 1px solid #000000;
            padding: 5px 5px;
        }

        table.minimalistBlack tbody td {
            font-size: 14px;
            color: #000000;
        }

        table.minimalistBlack tfoot td {
            font-size: 14px;
        }

        tr {
            border: 1px solid #000;
        }
      .center {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 20%;
          }
    </style>

    {{-- condition here --}}

    @if (setting('medical')['wokingPaper_layout'] == 'layout2')
        <x-job-order :group="$group" />
    @else
<div class="center" style="padding-top:-120px;">
 <img src="https://nbdlab.stop4labs.com/img/logo-new.png" alt="" max-height="150" min-height="150">
</div>
        <div class="invoice" style="padding-top:-20px;">
            <h2 class="text-center">Working paper</h2>
            @if (isset($group['patient']))
                <table class="minimalistBlack">
                    <tfoot>
                        <tr>
                            <td width="45%"></td>
                            <td width="10%"></td>
                            <td width="45%"></td>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr>
                            <td>Date:
                                {{ get_system_date() }}
                            </td>
                            <td></td>
                            <td>Sample collection :
                                {{ $group['sample_collection_date'] }}
                            </td>
                        </tr>
                        <tr>
                            <td>Barcode:
                                {{ $group['barcode'] }}
                            </td>
                            <td></td>
                            <td>Order id:
                                {{ $group['id'] }}
                            </td>
                        </tr>
                        <tr>
                            <td>Patient Name:
                                @if (isset($group['patient']))
                                    {{ $group['patient']['name'] }}
                                @endif
                            </td>
                            <td></td>
                            <td>Patient Code:
                                @if (isset($group['patient']))
                                    {{ $group['patient']['code'] }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Gender:
                                @if (isset($group['patient']))
                                    {{ __($group['patient']['gender']) }}
                                @endif
                            </td>
                            <td></td>
                            <td>Age:
                                @if (isset($group['patient']))
                                    {{ $group['patient']['age'] }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Phone Number:
                                @if (isset($group['patient']))
                                    {{ __($group['patient']['phone']) }}
                                @endif
                            </td>
                            <td></td>
                            <td>Contract Price:
                                @if (isset($group['contract']))
                                    {{ $group['contract']['title'] }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Branch:
                                {{ $group['branch']['name'] }}
                            </td>
                            <td></td>
                            <td>Employee Name:
                                {{ auth()->guard('admin')->user()->name }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="minimalistBlack">
                    <tbody width="100%">
                        <tr style="text-align:center !important;">
                            <td width="45%">
                                @if ($group['user_id'] == null)
                                    Doctor
                                @else
                                    Lab
                                @endif
                            </td>
                            <td width="10%"></td>
                            <td width="45%" rowspan="2">
                                <table width="100%">
                                    <tbody width="100%">
                                        <tr>
                                            <td>Net Due</td>
                                            <td>Paid</td>
                                            <td>Due</td>
                                        </tr>
                                        <tr>
                                            <td>{{ formated_price($group['total']) }}</td>
                                            <td>
                                                @if (count($group['payments']))
                                                    {{ formated_price($group['paid']) }}
                                                @else
                                                    {{ formated_price(0) }}
                                                @endif
                                            </td>
                                            <td>{{ formated_price($group['due']) }}</td>
                                        </tr>
                                    </tbody>

                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @if ($group['user_id'] == null)
                                    @if (isset($group['doctor']))
                                        Dr. {{ $group['doctor']['name'] }}
                                    @elseif(isset($group['normalDoctor']))
                                        Dr. {{ $group['normalDoctor']['name'] }}
                                    @endif
                                @else
                                    {{ $group['user']['name'] }}
                                @endif
                            </td>
                            <td></td>

                        </tr>
                    </tbody>

                </table>
                <table class="minimalistBlack">

                    <tbody width="100%">
                        <tr>
                            <td width="45%">ملاحظات</td>
                            <td width="10%"> الصيام</td>
                            <td width="45%" rowspan="2">
                                <table width="100%" height="100%">
                                    <tbody width="100%">
                                        <tr>
                                            <td width="25%">
                                                @if (isset($group['patient']) && $group['patient']['fluid_patient'] == 1)
                                                    {{ __('Hemophilia') }}
                                                @endif
                                            </td>
                                            <td width="25%">
                                                @if (isset($group['patient']) && $group['patient']['diabetic'] == 1)
                                                    {{ __('Diabetic') }}
                                                @endif
                                            </td>
                                            <td width="25%">
                                                @if (isset($group['patient']) && $group['patient']['gland'] == 1)
                                                    {{ __('gland') }}
                                                @endif
                                            </td>
                                            <td width="25%">
                                                @if (isset($group['patient']) && $group['patient']['tumors'] == 1)
                                                    {{ __('tumors') }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="25%">
                                                @if (isset($group['patient']) && $group['patient']['antibiotic'] == 1)
                                                    {{ __('antibiotic') }}
                                                @endif
                                            </td>
                                            <td width="25%">
                                                @if (isset($group['patient']) && $group['patient']['iron'] == 1)
                                                    {{ __('iron') }}
                                                @endif
                                            </td>
                                            <td width="25%">
                                                @if (isset($group['patient']) && $group['patient']['cortisone'] == 1)
                                                    {{ __('cortisone') }}
                                                @endif
                                            </td>
                                            <td width="25%">
                                                @if (isset($group['patient']) && $group['patient']['liver_patient'] == 1)
                                                    {{ __('Liver Patient') }}
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>{{ $group['patient']['answer_other'] }}</td>
                            <td>{{ __($group['patient']['hours_fasting']) }} ساعات</td>

                        </tr>
                    </tbody>
                </table>
                </br>
                <h4 style="text-align: center;">{{ __('Required tests') }}</h4>
                </br>

                @if ($group->all_tests->isNotEmpty() || $group->all_cultures->isNotEmpty())
                    <table class="demTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Test ID</th>
                                <th>Test Name</th>
                                <th>S. Type</th>
                                <th>S/C</th>
                                <th>Result</th>
                                <th>Signature</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($group['all_tests'] as $key => $test)
                                <tr>
                                    <td class="workingpapertd">{{ $key + 1 }}</td>
                                    <td class="workingpapertd">{{ $test['test']['id'] }}</td>
                                    <td class="workingpapertd">{{ $test['test']['name'] }}</td>
                                    <td class="workingpapertd">{{ $test['test']['sample_type'] }}</td>
                                    <td class="workingpapertd">{{ $test->check_test ? 'yes' : 'no' }}</td>
                                    <td class="workingpapertd">&nbsp;</td>
                                    <td class="workingpapertd">&nbsp;</td>
                                </tr>
                            @endforeach
                            @foreach ($group['all_cultures'] as $key => $culture)
                                <tr>
                                    <td class="workingpapertd">{{ $key + 1 }}</td>
                                    <td class="workingpapertd">{{ $culture['culture']['id'] }}</td>
                                    <td class="workingpapertd"> {{ $culture['culture']['name'] }}</td>
                                    <td class="workingpapertd"> {{ $culture['culture']['sample_type'] }}</td>
                                    <td class="workingpapertd">yes</td>
                                    <td class="workingpapertd">&nbsp;</td>
                                    <td class="workingpapertd">&nbsp;</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

                @if ($group->rays->isNotEmpty())
                    <table class="demTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Ray ID</th>
                                <th>Ray Name</th>
                                <th>Shortcut</th>
                                <th>Result</th>
                                <th>Signature</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($group['rays'] as $key => $ray)
                                <tr>
                                    <td class="workingpapertd">{{ $key + 1 }}</td>
                                    <td class="workingpapertd">{{ $ray['ray']['id'] }}</td>
                                    <td class="workingpapertd"> {{ $ray['ray']['name'] }}</td>
                                    <td class="workingpapertd"> {{ $ray['ray']['shortcut'] }}</td>
                                    <td class="workingpapertd">&nbsp;</td>
                                    <td class="workingpapertd">&nbsp;</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

                @isset($group->questions)
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="demTable">
                                <tbody>
                                    <tr>
                                        <td>{{ __('Questions') }}</td>
                                        <td>{{ __('Answer') }}</td>
                                    </tr>
                                    @foreach ($group->questions as $question)
                                        <tr>
                                            <td>{{ $question->question->question }}</td>
                                            <td>{{ $question->answer }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endisset


                @php
                    
                    $testsIds = [];
                    foreach ($group['tests'] as $key => $test) {
                        array_push($testsIds, $test['test']['id']);
                    }
                    
                    $patientGroups = Patient::with('groups.all_tests')
                        ->find($group['patient']['id'])
                        ->groups()
                        ->with('all_tests')
                        ->where('id', '<', $group['id'])
                        ->where('done', 1)
                        ->orderBy('created_at', 'desc')
                        ->get();
                    
                    foreach ($patientGroups as $group) {
                        $group->tests = $group->all_tests->whereIn('test_id', $testsIds);
                    }
                    
                    $testId = [];
                    $idsOfTest = [];
                    
                    foreach ($patientGroups as $group) {
                        foreach ($group->tests as $test) {
                            if (!in_array($test->test_id, $testId)) {
                                array_push($testId, $test->test_id);
                                array_push($idsOfTest, $test->id);
                            }
                        }
                    }
                    
                    $resultes = GroupTest::with('results.component', 'test.components', 'group')
                        ->whereIn('id', $idsOfTest)
                        ->get();
                    
                @endphp

                @foreach ($resultes as $res)
                    <h5>Test Name: {{ $res->test->name }} - invoice(#ID:{{ $res->group->id }}) - Date:
                        {{ $res->group->created_at }}</h5>

                    @if ($res['test_id'] == 473)
                        <table class="demoTable">
                            <thead>
                                <tr>
                                    <th>HB</span></th>
                                    <th>RBCs</th>
                                    <th>PLT</th>
                                    <th>WBCs</th>
                                    <th>Lymphocytes</th>
                                    <th>Monocytes</th>
                                    <th>Eosinophils</th>
                                    <th>Basophils</th>
                                    <th>Neutrophil </th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach ($res['results'] as $result)
                                        @if (
                                            $result['component']['id'] == 1248 ||
                                                $result['component']['id'] == 1249 ||
                                                $result['component']['id'] == 1255 ||
                                                $result['component']['id'] == 1257 ||
                                                $result['component']['id'] == 1261 ||
                                                $result['component']['id'] == 1262 ||
                                                $result['component']['id'] == 1263 ||
                                                $result['component']['id'] == 1264 ||
                                                $result['component']['id'] == 1266)
                                            <td>{{ $result['result'] }}</td>
                                        @endif
                                    @endforeach

                                </tr>
                            </tbody>
                        </table>
                    @elseif($res['test_id'] == 1025)
                        <table class="demoTable">
                            <thead>
                                <tr>
                                    @foreach ($res['results'] as $result)
                                        @if (
                                            $result['component']['id'] == 1458 ||
                                                $result['component']['id'] == 1457 ||
                                                $result['component']['id'] == 1461 ||
                                                $result['component']['id'] == 1462 ||
                                                $result['component']['id'] == 1464)
                                            <th>{{ $result['component']['name'] }}</th>
                                        @endif
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach ($res['results'] as $result)
                                        @if (
                                            $result['component']['id'] == 1458 ||
                                                $result['component']['id'] == 1457 ||
                                                $result['component']['id'] == 1461 ||
                                                $result['component']['id'] == 1462 ||
                                                $result['component']['id'] == 1464)
                                            <td>{{ $result['result'] }}</td>
                                        @endif
                                    @endforeach

                                </tr>
                            </tbody>
                        </table>
                    @elseif($res['test_id'] == 1203)
                        <table class="demoTable">
                            <thead>
                                <tr>
                                    @foreach ($res['results'] as $result)
                                        @if (
                                            $result['component']['id'] == 1442 ||
                                                $result['component']['id'] == 1441 ||
                                                $result['component']['id'] == 1443 ||
                                                $result['component']['id'] == 1444)
                                            <th>{{ $result['component']['name'] }}</th>
                                        @endif
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach ($res['results'] as $result)
                                        @if (
                                            $result['component']['id'] == 1442 ||
                                                $result['component']['id'] == 1441 ||
                                                $result['component']['id'] == 1443 ||
                                                $result['component']['id'] == 1444)
                                            <td>{{ $result['result'] }}</td>
                                        @endif
                                    @endforeach

                                </tr>
                            </tbody>
                        </table>
                    @else
                        <table class="demoTable">
                            <thead>
                                <tr>
                                    @foreach ($res['results'] as $result)
                                        <th>{{ $result['component']['name'] }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach ($res['results'] as $result)
                                        <td>{{ $result['result'] }}</td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    @endif
                @endforeach
            @endif

        </div>
    @endif


    {{-- endcontiot --}}
   
@endsection
