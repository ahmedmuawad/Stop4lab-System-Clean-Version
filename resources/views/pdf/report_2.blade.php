@php
    use App\Models\Patient;
    use App\Models\GroupTest;
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
    foreach ($patientGroups as $gro) {
        $gro->tests = $gro->all_tests->whereIn('test_id', $testsIds);
    }
    $testId = [];
    $idsOfTest = [];
    foreach ($patientGroups as $gro) {
        foreach ($gro->tests as $test) {
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

@extends('layouts.pdf')
@section('title')
    {{ __('Report') }}-#{{ $group['id'] }}-{{ date('Y-m-d') }}
@endsection
@section('content')


    <x-report-style-component />


    @if (isset($reports_settings['report_paid_stauts']) &&
            $reports_settings['report_paid_stauts'] == false &&
            $group['due'] > 0)
        <div class="category_title">
            {{ __('You Must Pay ') }} {{ $group['due'] }}
        </div>
    @else
        <div class="printable">
            @php
                $count_categories = 0;
            @endphp
            @if(!empty($categories) && is_iterable($categories))

            @foreach ($categories as $key => $category)
                @if (count($category['tests']) || count($category['cultures']))
                    @if ($count_categories > 0)
                        <pagebreak>
                        </pagebreak>
                    @endif
                    @php
                        $count_categories++;
                        $count = 0;
                    @endphp


                    <br>
                    <br>
                    <h2 class="category_title">{{ $category['name'] }}</h2>
                    @if (count($category['tests']))
                        @if (count($category['tests']) > 1)
                            <table class="ttable">
                                <thead class="testtable">
                                    <tr>
                                        <td class="theadtest" width="30%" text-align="left">Test </td>
                                        <td class="theadtest" width="20%">Result</td>
                                        <td class="theadtest" width="10%">Unit</td>

                                        @if (session('report_design') == '1')
                                            <td class="theadtest" width="15%">Status</td>
                                        @endif
                                        <td class="theadtest" width="25%">Normal Range</td>

                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($category['tests'] as $test)
                                        @foreach ($test['results'] as $result)
                                            <!-- Title -->
                                            @if (isset($result['component']))
                                                @if ($result['component']['title'])
                                                    <tr>
                                                        <td colspan="5" class="ttitle">
                                                            <b>{{ $result['component']['name'] }}</b>
                                                        </td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td class="ttitle">
                                                            {{ $result['component']['name'] }}
                                                        </td>
                                                        <td
                                                            class="tdtest @if ($result['status'] != 'Normal' && $result['status'] != null) tdtest_status @else tdtest_background @endif">
                                                            {{ $result['result'] }}
                                                            @if ($result['status'] == 'High' || $result['status'] == 'Critical high')
                                                                <span>&#8593;</span>
                                                            @elseif($result['status'] == 'Low' || $result['status'] == 'Critical low')
                                                                <span>&#8595;</span>
                                                            @endif


                                                        </td>

                                                        <td class="tdtest"> {{ $result['component']['unit'] }} </td>
                                                        @if (session('report_design') == '1')
                                                            <td class="tdtest">{{ $result['status'] }}
                                                                @if ($result['status'] == 'High' || $result['status'] == 'Critical high')
                                                                    <span>&#8593;</span>
                                                                @elseif($result['status'] == 'Low' || $result['status'] == 'Critical low')
                                                                    <span>&#8595;</span>
                                                                @endif
                                                            </td>
                                                        @endif
                                                        <td class="tdtest">
                                                            {!! $result['comment'] !!}

                                                        </td>


                                                    </tr>
                                                @endif
                                            @endif
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- Comment -->
                            @if (isset($test['comment']))
                                <br>

                                <table class="comment" width="100%">
                                    <tbody>
                                        <tr>
                                            <td width="12px" nowrap="nowrap"><b>Comment:</b></td>
                                            <td class="commentb">
                                                {!! str_replace("\n", '<br />', $test['comment']) !!}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endif
                            <!-- /comment -->
                        @else
                            @foreach ($category['tests'] as $test)
                                @php
                                    $count++;
                                @endphp
                                <!--CBC Report ID 473-->

                                @if ($test['test']['id'] == 473)
                                    <x-cbc-report-component :test="$test" :group="$group" />

                                    <!--/ Semen Examination ID 3045-->
                                @elseif($test['test']['id'] == 3045)
                                    <table class="tablesemen">
                                        <thead>
                                            <tr>
                                                <th width="35%"></th>
                                                <th width="25%">Result</th>
                                                <th width="15%">Unit</th>
                                                <th width="25%">Reference Range</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($test['results'] as $result)
                                                @if (isset($result['component']))
                                                    @if (
                                                        $result['component']['id'] == 3060 ||
                                                            $result['component']['id'] == 3061 ||
                                                            $result['component']['id'] == 3062 ||
                                                            $result['component']['id'] == 3063 ||
                                                            $result['component']['id'] == 3065 ||
                                                            $result['component']['id'] == 3066 ||
                                                            $result['component']['id'] == 3067 ||
                                                            $result['component']['id'] == 3068 ||
                                                            $result['component']['id'] == 3072 ||
                                                            $result['component']['id'] == 3073 ||
                                                            $result['component']['id'] == 3074 ||
                                                            $result['component']['id'] == 3077 ||
                                                            $result['component']['id'] == 3078 ||
                                                            $result['component']['id'] == 3079 ||
                                                            $result['component']['id'] == 3080 ||
                                                            $result['component']['id'] == 3081 ||
                                                            $result['component']['id'] == 3059 ||
                                                            $result['component']['id'] == 3064 ||
                                                            $result['component']['id'] == 3069 ||
                                                            $result['component']['id'] == 3071 ||
                                                            $result['component']['id'] == 3076)
                                                    @elseif($result['component']['id'] == 3046)
                                                        <tr>
                                                            <td colspan="4"><b>Sperm quantification and Motility:-</b>
                                                            </td>
                                                        </tr>
                                                    @elseif($result['component']['id'] == 3056)
                                                        <tr>
                                                            <td colspan="4"><b>Sperm quantification and Motility:-</b>
                                                            </td>
                                                        </tr>
                                                    @else
                                                        <tr style="border:0px solid #b3adad;">
                                                            <td width="35%">
                                                                {{ $result['component']['name'] }}
                                                            </td>
                                                            <td width="25%" align="center">
                                                                {{ $result['result'] }}
                                                                @if ($result['status'] == 'High' || $result['status'] == 'Critical high')
                                                                    <span>&#8593;</span>
                                                                @elseif($result['status'] == 'Low' || $result['status'] == 'Critical low')
                                                                    <span>&#8595;</span>
                                                                @endif
                                                            </td>

                                                            <td @if ($result['status'] != 'Normal' && $result['status'] != null) class="tdtest_status" @endif
                                                                align="center">{{ $result['component']['unit'] }} </td>

                                                            <td width="25%" align="left">
                                                                {!! $result['comment'] !!}
                                                            </td>


                                                        </tr>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{--  Motility  --}}
                                    <table class="table_inside">
                                        <thead>
                                            <tr>
                                                <th colspan="2" width="30%" align="left"><b>Motility:-</b></th>
                                                <th colspan="2" width="20%"><b>After Liqufication</b></th>
                                                <th colspan="2" width="19%"><b>After One hours</b></th>
                                                <th colspan="2" width="18%"><b>After Two hours</b></th>
                                                <th colspan="2" width="18%"><b>After three hours</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>


                                            <tr>
                                                <td colspan="2"></td>
                                                @foreach ($test['results'] as $result)
                                                    @if (isset($result['component']))
                                                        @if (
                                                            $result['component']['id'] == 3060 ||
                                                                $result['component']['id'] == 3061 ||
                                                                $result['component']['id'] == 3062 ||
                                                                $result['component']['id'] == 3063)
                                                            <td class="borderd" width="80px"> {{ $result['result'] }}
                                                                @if ($result['status'] == 'High' || $result['status'] == 'Critical high')
                                                                    <span>&#8593;</span>
                                                                @elseif($result['status'] == 'Low' || $result['status'] == 'Critical low')
                                                                    <span>&#8595;</span>
                                                                @endif
                                                            </td>
                                                            <td class="borderd"
                                                                width="20px"@if ($result['status'] != 'Normal' && $result['status'] != null) class="tdtest_status" @endif
                                                                align="center">{{ $result['component']['unit'] }} </td>
                                                        @endif
                                                    @endif
                                                @endforeach
                                    </table>
                                    {{--  Progression   --}}
                                    <table class="table_inside">
                                        <thead>
                                            <tr>
                                                <th colspan="2" width="30%" align="left"><b>Progression :-</b></th>
                                                <th colspan="2" width="20%">Total Motility (PR+NP%)</th>
                                                <th colspan="2" width="20%">Progressive motility (PR%)</th>
                                                <th colspan="2" width="20%">Non Progressive motility (NP%)</th>
                                                <th colspan="2" width="15%">Immotile (IM%)</th>
                                            </tr>
                                        </thead>
                                        <tbody>


                                            <tr>
                                                <td colspan="2"></td>
                                                @foreach ($test['results'] as $result)
                                                    @if (isset($result['component']))
                                                        @if (
                                                            $result['component']['id'] == 3065 ||
                                                                $result['component']['id'] == 3066 ||
                                                                $result['component']['id'] == 3067 ||
                                                                $result['component']['id'] == 3068)
                                                            <td class="borderd" width="80px"> {{ $result['result'] }}
                                                                @if ($result['status'] == 'High' || $result['status'] == 'Critical high')
                                                                    <span>&#8593;</span>
                                                                @elseif($result['status'] == 'Low' || $result['status'] == 'Critical low')
                                                                    <span>&#8595;</span>
                                                                @endif
                                                            </td>
                                                            <td class="borderd"
                                                                width="20px"@if ($result['status'] != 'Normal' && $result['status'] != null) class="tdtest_status" @endif
                                                                align="center">{{ $result['component']['unit'] }} </td>
                                                        @endif
                                                    @endif
                                                @endforeach
                                    </table>
                                    {{--  Type of Abnormality   --}}
                                    <table class="table_inside">
                                        <thead>
                                            <tr>
                                                <th colspan="2" width="30%" align="left"><b>Type of
                                                        Abnormality:-</b></th>
                                                <th colspan="2" width="20%">Head defects</th>
                                                <th colspan="2" width="30%">Neckand midpiece defects</th>
                                                <th colspan="2" width="25%">Tail defects</th>
                                            </tr>
                                        </thead>
                                        <tbody>


                                            <tr>
                                                <td colspan="2"></td>
                                                @foreach ($test['results'] as $result)
                                                    @if (isset($result['component']))
                                                        @if ($result['component']['id'] == 3072 || $result['component']['id'] == 3073 || $result['component']['id'] == 3074)
                                                            <td class="borderd" width="80px"> {{ $result['result'] }}
                                                                @if ($result['status'] == 'High' || $result['status'] == 'Critical high')
                                                                    <span>&#8593;</span>
                                                                @elseif($result['status'] == 'Low' || $result['status'] == 'Critical low')
                                                                    <span>&#8595;</span>
                                                                @endif
                                                            </td>
                                                            <td class="borderd"
                                                                width="20px"@if ($result['status'] != 'Normal' && $result['status'] != null) class="tdtest_status" @endif
                                                                align="center">{{ $result['component']['unit'] }} </td>
                                                        @endif
                                                    @endif
                                                @endforeach
                                    </table>

                                    <div class="row">
                                        <div class="headleft"><b>Microscopic Examination:-</b></div>
                                        <div class="table_left">
                                            <table width="100%">
                                                <thead class="theadsemen">
                                                    <tr>
                                                        <th>Test</th>
                                                        <th>Result</th>
                                                        <th>Unit</th>
                                                        <th>R.Range</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($test['results'] as $result)
                                                        <tr>

                                                            @if ($result['component']['id'] == 3077 || $result['component']['id'] == 3078)
                                                                <td class="borderd-left">{{ $result['component']['name'] }}
                                                                </td>
                                                                <td class="borderd"> {{ $result['result'] }}
                                                                    @if ($result['status'] == 'High' || $result['status'] == 'Critical high')
                                                                        <span>&#8593;</span>
                                                                    @elseif($result['status'] == 'Low' || $result['status'] == 'Critical low')
                                                                        <span>&#8595;</span>
                                                                    @endif
                                                                </td>
                                                                <td class="borderd"@if ($result['status'] != 'Normal' && $result['status'] != null) class="tdtest_status" @endif
                                                                    align="center">{{ $result['component']['unit'] }}
                                                                </td>
                                                                <td class="borderd"> {!! $result['comment'] !!}</td>
                                                        </tr>
                                                    @endif
                                @endforeach
                                </tbody>

                                </table>
        </div>
        <div class="table_right">
            <table width="100%">
                <tr class="theadsemen">
                    <th>Test</th>
                    <th>Result</th>
                    <th>Unit</th>
                    <th>R.Range</th>
                </tr>
                <tbody>
                    @foreach ($test['results'] as $result)
                        <tr>

                            @if ($result['component']['id'] == 3079 || $result['component']['id'] == 3080)
                                <td class="borderd-left">{{ $result['component']['name'] }}</td>
                                <td class="borderd"> {{ $result['result'] }}
                                    @if ($result['status'] == 'High' || $result['status'] == 'Critical high')
                                        <span>&#8593;</span>
                                    @elseif($result['status'] == 'Low' || $result['status'] == 'Critical low')
                                        <span>&#8595;</span>
                                    @endif
                                </td>
                                <td class="borderd"@if ($result['status'] != 'Normal' && $result['status'] != null) class="tdtest_status" @endif
                                    align="center">{{ $result['component']['unit'] }} </td>
                                <td class="borderd"> {!! $result['comment'] !!}</td>

                        </tr>
                    @endif
    @endforeach
    </tbody>

    </table>
    </div>
    </div>


    <!-- Comment -->

    @if (isset($test['comment']))
        <table class="tablesemen">
            <tbody>
                <tr>
                    <td width="20%" nowrap="nowrap"><b>Comment:</b></td>
                    <td align="left" style="font-size: 14px;">
                        {!! str_replace("\n", '<br />', $test['comment']) !!}
                    </td>
                </tr>
            </tbody>
        </table>
    @endif
    <!-- /comment -->
    <!--/ end Semen Examination Report ID 3045-->
@elseif($test['test']['id'] == 1025 || $test['test']['id'] == 1203)
    <table class="ttable">
        <thead class="testtable">
            <tr>
                <td class="theadtest" width="40%">Test </td>
                <td class="theadtest" width="30%">Result</td>
                <td class="theadtest" width="30%">Normal Range</td>

            </tr>
        </thead>
        <tbody>
            @foreach ($test['results'] as $result)
                <!-- Title -->
                @if (isset($result['component']))
                    @if ($result['component']['title'])
                        <tr align="left">
                            <td class="tdtest">
                                <h3 class="tdtest">{{ $result['component']['name'] }}</h3>
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td class="tdtest" width="40%">
                                {{ $result['component']['name'] }}
                            </td>
                            <td class="tdtest @if ($result['status'] != 'Normal' && $result['status'] != null) tdtest_status @else tdtest_background @endif"
                                width="30%">{{ $result['result'] }}
                                @if ($result['status'] == 'High' || $result['status'] == 'Critical high')
                                    <span>&#8593;</span>
                                @elseif($result['status'] == 'Low' || $result['status'] == 'Critical low')
                                    <span>&#8595;</span>
                                @endif
                            </td>
                            <td class="tdtest" width="30%">
                                {!! $result['comment'] !!}

                            </td>

                        </tr>
                    @endif
                @endif
            @endforeach
        </tbody>
    </table>
    <!-- Comment -->
    @if (isset($test['comment']))
        <br>

        <table class="comment" width="100%">
            <tbody>
                <tr>
                    <td width="12px" nowrap="nowrap"><b>Comment:</b></td>
                    <td class="commentb">
                        {!! str_replace("\n", '<br />', $test['comment']) !!}
                    </td>
                </tr>
            </tbody>
        </table>
    @endif
    <!-- /comment -->
@else
    <table class="ttable">
        <thead class="testtable">
            <tr>
                <td class="theadtest" width="30%">Test </td>
                <td class="theadtest" width="20%">Result</td>


                <td class="theadtest" width="10%">Unit</td>

                @if (session('report_design') == '1')
                    <td class="theadtest" width="15%">Status</td>
                @endif
                <td class="theadtest" width="25%">Normal Range</td>

            </tr>
        </thead>
        <tbody>
            @foreach ($test['results'] as $result)
                <!-- Title -->
                @if (isset($result['component']))
                    @if ($result['component']['title'])
                        <tr align="left">
                            <td class="tdtest">
                                <h3 class="tdtest">{{ $result['component']['name'] }}</h3>
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td class="tdtest" width="25%">
                                {{ $result['component']['name'] }}
                            </td>
                            <td class="tdtest @if ($result['status'] != 'Normal' && $result['status'] != null) tdtest_status @else tdtest_background @endif"
                                width="15%">{{ $result['result'] }}
                                @if ($result['status'] == 'High' || $result['status'] == 'Critical high')
                                    <span>&#8593;</span>
                                @elseif($result['status'] == 'Low' || $result['status'] == 'Critical low')
                                    <span>&#8595;</span>
                                @endif
                            </td>

                            <td class="tdtest">
                                {{ $result['component']['unit'] }}
                            </td>

                            @if (session('report_design') == '1')
                                <td class="tdtest" width="20%">
                                    {{ $result['status'] }} @if ($result['status'] == 'High' || $result['status'] == 'Critical high')
                                        <span>&#8593;</span>
                                    @elseif($result['status'] == 'Low' || $result['status'] == 'Critical low')
                                        <span>&#8595;</span>
                                    @endif
                                </td>
                            @endif
                            <td class="tdtest" width="40%">
                                {!! $result['comment'] !!}
                            </td>

                        </tr>
                    @endif
                @endif
            @endforeach


            <!-- Comment -->
            <!-- /comment -->
        </tbody>
    </table>
    
    @if (isset($test['comment']))
        <br>

        <table class="comment" width="100%">
            <tbody>
                <tr>
                    <td width="12px" nowrap="nowrap"><b>Comment:</b></td>
                    <td class="commentb">
                        {!! str_replace("\n", '<br />', $test['comment']) !!}
                    </td>
                </tr>
            </tbody>
        </table>
    @endif
    @endif
    @endforeach
    @endif
    @endif

    @if (session()->get('history') == $group['id'])
        @foreach ($resultes as $res)
            @if ($category['id'] == $res->test->category_id)
                <h5>Test Name: {{ $res->test->name }} - invoice(#ID:{{ $res->group->id }}) - Date:
                    {{ $res->group->created_at }}</h5>

                @if ($res['test_id'] == 473)
                    <table class="ttable">
                        <thead>
                            <tr>
                                <th class="theadcbc" class="theadcbc">HB</span></th>
                                <th class="theadcbc">RBCs</th>
                                <th class="theadcbc">PLT</th>
                                <th class="theadcbc">WBCs</th>
                                <th class="theadcbc">Lymphocytes</th>
                                <th class="theadcbc">Monocytes</th>
                                <th class="theadcbc">Eosinophils</th>
                                <th class="theadcbc">Basophils</th>
                                <th class="theadcbc">Neutrophil </th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @foreach ($res['results'] as $result)
                                    @if (
                                        \Str::slug($result['component']['name']) == 'hemoglobin-hb' ||
                                            \Str::slug($result['component']['name']) == 'rbcs' ||
                                            \Str::slug($result['component']['name']) == 'platelet-count-plt' ||
                                            \Str::slug($result['component']['name']) == 'plateletplt' ||
                                            \Str::slug($result['component']['name']) == 'wbcs-leukocytes' ||
                                            \Str::slug($result['component']['name']) == 'lymphocytes' ||
                                            \Str::slug($result['component']['name']) == 'monocytes' ||
                                            \Str::slug($result['component']['name']) == 'eosinophils' ||
                                            \Str::slug($result['component']['name']) == 'basophils' ||
                                            \Str::slug($result['component']['name']) == 'neutrophil')
                                        <td
                                            class="tdtest @if ($result['status'] != 'Normal' && $result['status'] != null) tdtest_status @else tdtest_background @endif">
                                            {{ $result['result'] }}
                                            @if ($result['status'] == 'High' || $result['status'] == 'Critical high')
                                                <span>&#8593;</span>
                                            @elseif($result['status'] == 'Low' || $result['status'] == 'Critical low')
                                                <span>&#8595;</span>
                                            @endif
                                        </td>
                                    @endif
                                @endforeach

                            </tr>
                        </tbody>
                    </table>
                @elseif($res['test_id'] == 1025)
                    <table class="ttable">
                        <thead>
                            <tr>
                                @foreach ($res['results'] as $result)
                                    @if (
                                        $result['component']['id'] == 1458 ||
                                            $result['component']['id'] == 1457 ||
                                            $result['component']['id'] == 1461 ||
                                            $result['component']['id'] == 1462 ||
                                            $result['component']['id'] == 1464)
                                        <th class="theadtest">{{ $result['component']['name'] }}</th>
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
                                        <td
                                            class="tdtest @if ($result['status'] != 'Normal' && $result['status'] != null) tdtest_status @else tdtest_background @endif">
                                            {{ $result['result'] }}
                                            @if ($result['status'] == 'High' || $result['status'] == 'Critical high')
                                                <span>&#8593;</span>
                                            @elseif($result['status'] == 'Low' || $result['status'] == 'Critical low')
                                                <span>&#8595;</span>
                                            @endif
                                        </td>
                                    @endif
                                @endforeach

                            </tr>
                        </tbody>
                    </table>
                @elseif($res['test_id'] == 1203)
                    <table class="ttable">
                        <thead>
                            <tr>
                                @foreach ($res['results'] as $result)
                                    @if (
                                        $result['component']['id'] == 1442 ||
                                            $result['component']['id'] == 1441 ||
                                            $result['component']['id'] == 1443 ||
                                            $result['component']['id'] == 1444)
                                        <th class="theadtest">{{ $result['component']['name'] }}</th>
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
                                        <td
                                            class="tdtest @if ($result['status'] != 'Normal' && $result['status'] != null) tdtest_status @else tdtest_background @endif">
                                            {{ $result['result'] }}
                                            @if ($result['status'] == 'High' || $result['status'] == 'Critical high')
                                                <span>&#8593;</span>
                                            @elseif($result['status'] == 'Low' || $result['status'] == 'Critical low')
                                                <span>&#8595;</span>
                                            @endif
                                        </td>
                                    @endif
                                @endforeach

                            </tr>
                        </tbody>
                    </table>
                @else
                    <table class="ttable">
                        <thead>
                            <tr>
                                @foreach ($res['results'] as $result)
                                    <th class="theadtest">{{ $result['component']['name'] }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @foreach ($res['results'] as $result)
                                    <td
                                        class="tdtest @if ($result['status'] != 'Normal' && $result['status'] != null) tdtest_status @else tdtest_background @endif">
                                        {{ $result['result'] }}
                                        @if ($result['status'] == 'High' || $result['status'] == 'Critical high')
                                            <span>&#8593;</span>
                                        @elseif($result['status'] == 'Low' || $result['status'] == 'Critical low')
                                            <span>&#8595;</span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                @endif
            @endif
        @endforeach
    @endif

    @if (count($category['cultures']))
        @foreach ($category['cultures'] as $culture)
            @php
                $count++;
            @endphp
            @if ($count > 1)
                <pagebreak>
                </pagebreak>
            @endif
            <!-- culture title -->
            <h3 class="category_title"> {{ $culture['culture']['name'] }} </h3>

            <table class="ttable">
                <tbody>
                    @foreach ($culture['culture_options'] as $culture_option)
                        @if (isset($culture_option['value']) && isset($culture_option['culture_option']))
                            <tr>
                                <td class="theadtest">{{ $culture_option['culture_option']['value'] }}
                                    : </td>
                                <td class="tdtest">{{ $culture_option['value'] }} </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            <br>
            <table class="tableculture">
                <thead>
                    <tr>
                        <th colspan="6"><b style="text-decoration: underline;">Antibiotic Senestivity Report</b></th>
                    </tr>


                </thead>
                <tbody>
                    <tr>
                        <td width="33%">
                            <p style="text-decoration: underline;">High Senestive Antimicrobial</p>
                        </td>
                        <td width="33%">
                            <p style="text-decoration: underline;">Moderate Senestive Antimicrobial</p>
                        </td>
                        <td width="34%">
                            <p style="text-decoration: underline;">Resistant Senestive Antimicrobial</p>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" style="vertical-align:top;">
                            @foreach ($culture['high_antibiotics'] as $antibiotic)
                                <ul style="padding: 2px;">
                                    @if (count($culture['high_antibiotics']) > 0)
                                        - {{ $antibiotic['antibiotic']['name'] }}
                                    @endif
                                </ul>
                            @endforeach
                        </td>
                        {{--  <td align="left">
                                        @foreach ($culture['high_antibiotics'] as $antibiotic)
                                        <ul>
                                        @if (count($culture['high_antibiotics']) > 0)
                                        H @endif
                                        </ul>
                                        @endforeach
                                        </td>  --}}

                        <td align="left" style="vertical-align:top;">
                            @foreach ($culture['moderate_antibiotics'] as $antibiotic)
                                <ul style="padding: 2px;">
                                    @if (count($culture['moderate_antibiotics']) > 0)
                                        - {{ $antibiotic['antibiotic']['name'] }}
                                    @endif
                                </ul>
                            @endforeach
                        </td>
                        {{--  <td align="left">
                                        @foreach ($culture['moderate_antibiotics'] as $antibiotic)
                                        <ul>
                                        @if (count($culture['moderate_antibiotics']) > 0)
                                        M @endif
                                        </ul>
                                        @endforeach
                                        </td>  --}}

                        <td align="left" style="vertical-align:top;">
                            @foreach ($culture['resident_antibiotics'] as $antibiotic)
                                <ul style="padding: 2px;">
                                    @if (count($culture['resident_antibiotics']) > 0)
                                        - {{ $antibiotic['antibiotic']['name'] }}
                                    @endif
                                </ul>
                            @endforeach
                        </td>
                        {{--  <td align="left">
                                        @foreach ($culture['resident_antibiotics'] as $antibiotic)
                                        <ul>
                                        @if (count($culture['resident_antibiotics']) > 0)
                                        R @endif
                                        </ul>
                                        @endforeach
                                        </td>  --}}
                    </tr>

                </tbody>
            </table>

            <!-- Comment -->
            @if (isset($culture['comment']))
                <table width="100%" class="comment">
                    <tbody>
                        <tr>
                            <td width="10px" nowrap="nowrap"><b>Comment:</b></td>
                            <td class="commentb">
                                {!! str_replace("\n", '<br />', $culture['comment']) !!}
                            </td>
                        </tr>
                    </tbody>
                </table>
            @endif
            <!-- /comment -->
        @endforeach
    @endif
    @endif
    @if ($key == 0)
        {{-- rays --}}
        @if (isset($category['rays']) && count($category['rays']))
            @php
                $count_categories++;
                $count = 0;
            @endphp
            @if ($count_categories > 1)
                <pagebreak>
                </pagebreak>
            @endif
            @foreach ($category['rays'] as $ray)
                {{-- @php
                                $count++;
                            @endphp
                            @if ($count > 1)
                                <pagebreak>
                            @endif --}}
                <!-- culture title -->
                <h3 class="category_title_ray"> {{ $ray['ray']['name'] }} </h3>
                <div class="row">
                    <?= $ray['result']['comment'] ?>
                </div>
                @if ($count > 1)
                    </pagebreak>
                @endif
            @endforeach
        @endif
        {{-- end rays --}}
    @endif
    @endforeach

    </div>
    @endif


@endif
    @endsection
