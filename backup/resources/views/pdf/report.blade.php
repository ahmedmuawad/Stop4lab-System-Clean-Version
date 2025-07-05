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

@extends('layouts.pdf_2')
@section('title')
    {{ __('Report') }}-#{{ $group['id'] }}-{{ date('Y-m-d') }}
@endsection
@section('content')
    <style>
        {{-- CBC Style --}} table,
        th,
        td {
            border: 1px solid #e7e7e7;
            border-collapse: collapse;
            height: 15px;
            color: #000;
            text-align: center;
        }

        td {
            border: 1px solid #e7e7e7;
            padding: 2px;
            text-align: center;
            color: #000;
        }

        .pinfo {
            border-collapse: collapse;
            border-radius: 10px;
            height: 20px;
            text-align: center;
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
            text-align: center;
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
            width: 100%;
        }

        .tleft {
            float: left;
            width: 50%;
            padding-bottom: 10px;
            text-align: center;
        }

        .tright {
            float: right;
            width: 49%;
            padding-bottom: 10px;
            text-align: center;
        }

        .tleftcbc {
            float: left;
            width: 70%;
            padding-bottom: 10px;
            text-align: center;
        }

        .tleftcbc_noFig {
            float: left;
            width: 100%;
            padding-bottom: 10px;
            text-align: center;
        }

        .trightcbc {
            float: right;
            width: 29%;
            padding-bottom: 10px;
            text-align: center;
        }

        {{-- another test Style --}} .ttable {
            width: 100%;
        }

        .testtable {
            border: 1px solid #e7e7e7;
            border-collapse: collapse;
            height: 20px;
            width: 100%;
            text-align: center;
        }

        span {
            content: "\2191";
        }

        .tdtest {
            /* background-color: #FFF; */
            padding-left: 15px;
            height: 20px;
            font-size: 12px;
            text-align: left;
        }

        .tdtest_background {
            background-color: #FFF;
        }

        .tdtest_status {
            background-color: #999;
        }

        .theadtest {
            border: 1px solid #e7e7e7;
            background-color: #b4e4f7;
            color: #00658c;
            font-weight: bold;
            font-size: 12px;
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
            margin-top: 20px;
            text-decoration: underline;
        }

        .category_title_ray {
            color: #000;
            text-align: center;
            font-family: cairo !important;
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
    <div class="printable">
        @php
            $count_categories = 0;
        @endphp
        @foreach ($categories as $key => $category)
            @if (count($category['tests']) || count($category['cultures']))
                @php
                    $count_categories++;
                    $count = 0;
                @endphp

                @foreach ($category['tests'] as $test)
                    @if ($test->new_line == '1')
                        <pagebreak>
                        </pagebreak>
                    @endif
                @endforeach

                @foreach ($category['cultures'] as $cul)
                    @if($cul->new_line == '1')
                        <pagebreak>
                        </pagebreak>
                    @endif
                @endforeach


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
                                                    <td class="tdtest @if ($result['status'] != 'Normal' && $result['status'] != null) tdtest_status @else tdtest_background @endif">
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
                                                        {{-- {!! $component_new->reference_range_new_component && $new_reference
                                                        ? $new_reference->referance_range
                                                        : $result['comment'] !!} --}}
                                                        {{-- @php
                                                        $component_new = App\Models\Test::find($result['component']['id']);
                                                        $new_reference = $component_new
                                                            ->reference_range_new_component()
                                                            ->where('group_id', $group['id'])
                                                            ->first();
                                                    @endphp
                                                    @if ($component_new->reference_range_new_component && $new_reference)
                                                        {!! $new_reference->referance_range !!}
                                                    @elseif(isset($result['comment']) && $result['comment'] != null )
                                                        {!! $result['comment'] !!}
                                                    @else
                                                        @if (isset($result['component']['reference_range']['comment']))
                                                            {!! $result['component']['reference_range']['comment'] !!}
                                                        @endif
                                                    @endif --}}
                                                    </td>


                                                </tr>
                                            @endif
                                        @endif
                                    @endforeach
                                @endforeach
                                <!-- Comment -->
                                @if (isset($test['comment']))
                                    <br>
                                    <tr class="comment">
                                        <td colspan="5">
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
                                        </td>
                                    </tr>
                                @endif
                                <!-- /comment -->
                            </tbody>
                        </table>
                    @else
                        @foreach ($category['tests'] as $test)
                            @php
                                $count++;
                            @endphp
                            <!--CBC Report ID 473-->

                            @if ($test['test']['id'] == 473)
                                <div class="row">
                                    <div class=" @if (isset($test->fig_1) && $test->fig_1 != null) tleftcbc @else tleftcbc_noFig @endif ">
                                        <table width="100%">
                                            <thead>
                                                <tr>
                                                    <td class="theadcbc" width="30%">Test </td>
                                                    <td class="theadcbc" width="15%">Result</td>
                                                    <td class="theadcbc" width="15%">Unit</td>
                                                    @if (session('report_design') == '1')
                                                        <td class="theadcbc" width="20%">Status</td>
                                                    @endif
                                                    <td class="theadcbc" width="20%">Normal Range</td>

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
                                                                <td class="tdtest">
                                                                    @if ($result['component']['id'] == 12490 ||
                                                                        $result['component']['id'] == 12504 ||
                                                                        $result['component']['id'] == 12503)
                                                                        <b>{{ $result['component']['name'] }}</b>
                                                                    @elseif ($result['component']['id'] == 12491 ||
                                                                        $result['component']['id'] == 12492 ||
                                                                        $result['component']['id'] == 12493 ||
                                                                        $result['component']['id'] == 12494 ||
                                                                        $result['component']['id'] == 12495 ||
                                                                        $result['component']['id'] == 12506 ||
                                                                        $result['component']['id'] == 12507)
                                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                        {{ $result['component']['name'] }}
                                                                    @else
                                                                        {{ $result['component']['name'] }}
                                                                    @endif

                                                                </td>
                                                                <td @if ($result['status'] != 'Normal' && $result['status'] != null) class="tdtest_status" @endif>
                                                                    {{ $result['result'] }}
                                                                        @if ($result['status'] == 'High' || $result['status'] == 'Critical high')
                                                                            <span>&#8593;</span>
                                                                        @elseif($result['status'] == 'Low' || $result['status'] == 'Critical low')
                                                                            <span>&#8595;</span>
                                                                        @endif
                                                                </td>

                                                                <td>{{ $result['component']['unit'] }} </td>
                                                                @if (session('report_design') == '1')
                                                                    <td> {{ $result['status'] }} @if ($result['status'] == 'High' || $result['status'] == 'Critical high')
                                                                            <span>&#8593;</span>
                                                                        @elseif($result['status'] == 'Low' || $result['status'] == 'Critical low')
                                                                            <span>&#8595;</span>
                                                                        @endif
                                                                    </td>
                                                                @endif
                                                                <td>
                                                                    {!! $result['comment'] !!}
                                                                </td>


                                                            </tr>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @if (isset($test->fig_1) && $test->fig_1 != null)
                                        <div class="trightcbc">
                                            <table>
                                                @if ($test->fig_1 != null)
                                                    @php
                                                        $fileName = 'uploads/figures/fig_1_' . $test->id . '.png';
                                                        file_put_contents($fileName, base64_decode($test->fig_1));
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            <img src="{{ url("uploads/figures/fig_1_$test->id.png") }}"
                                                                style="height: 90px; width: 200px; ">
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if ($test->fig_2 != null)
                                                    @php
                                                        $fileName = 'uploads/figures/fig_2_' . $test->id . '.png';
                                                        file_put_contents($fileName, base64_decode($test->fig_2));
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            <img src="{{ url("uploads/figures/fig_2_$test->id.png") }}"
                                                                style="height: 90px; width: 200px; ">
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if ($test->fig_3 != null)
                                                    @php
                                                        $fileName = 'uploads/figures/fig_3_' . $test->id . '.png';
                                                        file_put_contents($fileName, base64_decode($test->fig_3));
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            <img src="{{ url("uploads/figures/fig_3_$test->id.png") }}"
                                                                style="height: 90px; width: 200px; ">
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if ($test->fig_4 != null)
                                                    @php
                                                        $fileName = 'uploads/figures/fig_4_' . $test->id . '.png';
                                                        file_put_contents($fileName, base64_decode($test->fig_4));
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            <img src="{{ url("uploads/figures/fig_4_$test->id.png") }}"
                                                                style="height: 90px; width: 200px; ">
                                                        </td>
                                                    </tr>
                                                @endif

                                            </table>
                                        </div>
                                    @endif
                                </div>

                                <div class="tleft">
                                    <table>
                                        <thead>
                                            <tr>
                                                <td class="relativeh" width="25%">Test</td>
                                                <td class="relativeh" width="25%">Relative Count %</td>
                                                <td class="relativeh" width="40%">Normal Range</td>
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
                                                            <td class="tdtest">
                                                                @if ($result['component']['id'] == 12504)
                                                                    <b>{{ $result['component']['name'] }}</b>
                                                                @elseif ($result['component']['id'] == 12505 || $result['component']['id'] == 12506)
                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    {{ $result['component']['name'] }}
                                                                @else
                                                                    {{ $result['component']['name'] }}
                                                                @endif
                                                            </td>
                                                            <td @if ($result['status'] != 'Normal' && $result['status'] != null) class="tdtest_status" @endif>
                                                                {{ $result['result'] }}
                                                                @if ($result['status'] == 'High' || $result['status'] == 'Critical high')
                                                                    <span>&#8593;</span>
                                                                @elseif($result['status'] == 'Low' || $result['status'] == 'Critical low')
                                                                    <span>&#8595;</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                {!! $result['comment'] !!}
                                                            </td>
                                                        </tr>
                                                @endif
                                            @endif
                                        @endforeach
                                        </tbody>

                                    </table>
                                </div>
                                <div class="tright">
                                    <table>
                                        <thead>
                                            <tr>

                                                <td class="absolutetd">Absolute Count 10³/µl</td>
                                                <td class="absolutetd">Normal Range</td>
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

                                                            <td @if ($result['status'] != 'Normal' && $result['status'] != null) class="tdtest_status" @endif>
                                                                {{ $result['result'] }}
                                                                @if ($result['status'] == 'High' || $result['status'] == 'Critical high')
                                                                    <span>&#8593;</span>
                                                                @elseif($result['status'] == 'Low' || $result['status'] == 'Critical low')
                                                                    <span>&#8595;</span>
                                                                @endif
                                                            </td>
                                                            <td>

                                                                {!! $result['comment'] !!}
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
                            @elseif($test['test']['id'] == 1025 || $test['test']['id'] == 1203)
                                <table class="ttable">
                                    <thead class="testtable">
                                        <tr>
                                            <td class="theadtest" width="30%">Test </td>
                                            <td class="theadtest" width="20%">Result</td>
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
                                                        <td class="tdtest" width="40%">
                                                            {!! $result['comment'] !!}
                                                            {{-- @php
                                                                $component_new = App\Models\Test::find($result['component']['id']);
                                                                $new_reference = $component_new
                                                                    ->reference_range_new_component()
                                                                    ->where('group_id', $group['id'])
                                                                    ->first();
                                                            @endphp

                                                            @if ($component_new->reference_range_new_component && $new_reference)
                                                                {!! $new_reference->referance_range !!}
                                                            @elseif(isset($result['comment']) && $result['comment'] != null)
                                                                {!! $result['comment'] !!}
                                                            @else
                                                                @if (isset($result['component']['reference_range']['comment']))
                                                                    {!! $result['component']['reference_range']['comment'] !!}
                                                                @endif
                                                            @endif --}}
                                                        </td>

                                                    </tr>
                                                @endif
                                            @endif
                                        @endforeach
                                        <!-- Comment -->
                                        @if (isset($test['comment']))
                                            <tr class="comment">
                                                <td colspan="5">
                                                    <table class="comment">
                                                        <tbody>
                                                            <tr>
                                                                <th width="80px">
                                                                    <b>Comment</b>
                                                                </th>
                                                                <td colspan="4">
                                                                    {!! str_replace("\n", '<br />', $test['comment']) !!}
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        @endif
                                        <!-- /comment -->
                                    </tbody>
                                </table>
                            @else
                                <table class="ttable">
                                    <thead class="testtable">
                                        <tr>
                                            <td class="theadtest" width="30%">Test </td>
                                            <td class="theadtest" width="20%">Result</td>

                                            @if (session('report_design') == '1')
                                                <td class="theadtest" width="10%">Unit</td>
                                            @endif
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
                                                        @if (session('report_design') == '1')
                                                            <td class="tdtest">
                                                                {{ $result['component']['unit'] }}
                                                            </td>
                                                        @endif
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
                                                            {{-- @php
                                                                $component_new = App\Models\Test::find($result['component']['id']);
                                                                $new_reference = $component_new
                                                                    ->reference_range_new_component()
                                                                    ->where('group_id', $group['id'])
                                                                    ->first();
                                                            @endphp

                                                            @if ($component_new->reference_range_new_component && $new_reference)
                                                                {!! $new_reference->referance_range !!}
                                                            @elseif(isset($result['comment']) && $result['comment'] != null)
                                                                {!! $result['comment'] !!}
                                                            @else
                                                                @if (isset($result['component']['reference_range']['comment']))
                                                                    {!! $result['component']['reference_range']['comment'] !!}
                                                                @endif
                                                            @endif --}}
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
                                                <td width="10px" nowrap="nowrap"><b>Comment:</b></td>
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
                        @if ($test['test']['id'] == $res->test->id)
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
                                                @if ($result['component']['id'] == 1248 ||
                                                    $result['component']['id'] == 1249 ||
                                                    $result['component']['id'] == 1255 ||
                                                    $result['component']['id'] == 1257 ||
                                                    $result['component']['id'] == 1261 ||
                                                    $result['component']['id'] == 1262 ||
                                                    $result['component']['id'] == 1263 ||
                                                    $result['component']['id'] == 1264 ||
                                                    $result['component']['id'] == 1266)
                                                    <td
                                                        class="tdtest @if ($result['status'] != 'Normal' && $result['status'] != null) tdtest_status @else tdtest_background @endif">
                                                        {{ $result['result'] }}
                                                        @if ($result['status'] == 'High' || $result['status'] == 'Critical high')
                                                            <span>&#8593;</span>
                                                        @elseif($result['status'] == 'Low' || $result['status'] == 'Critical low')
                                                            <span>&#8595;</span>
                                                        @endif </td>
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
                                                @if ($result['component']['id'] == 1458 ||
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
                                                @if ($result['component']['id'] == 1458 ||
                                                    $result['component']['id'] == 1457 ||
                                                    $result['component']['id'] == 1461 ||
                                                    $result['component']['id'] == 1462 ||
                                                    $result['component']['id'] == 1464)
                                                    <td class="tdtest @if ($result['status'] != 'Normal' && $result['status'] != null) tdtest_status @else tdtest_background @endif">
                                                        {{ $result['result'] }}
                                                        @if ($result['status'] == 'High' || $result['status'] == 'Critical high')
                                                            <span>&#8593;</span>
                                                        @elseif($result['status'] == 'Low' || $result['status'] == 'Critical low')
                                                            <span>&#8595;</span>
                                                        @endif </td>
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
                                                @if ($result['component']['id'] == 1442 ||
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
                                                @if ($result['component']['id'] == 1442 ||
                                                    $result['component']['id'] == 1441 ||
                                                    $result['component']['id'] == 1443 ||
                                                    $result['component']['id'] == 1444)
                                                    <td class="tdtest @if ($result['status'] != 'Normal' && $result['status'] != null) tdtest_status @else tdtest_background @endif">
                                                        {{ $result['result'] }}
                                                    @if ($result['status'] == 'High' || $result['status'] == 'Critical high')
                                                        <span>&#8593;</span>
                                                    @elseif($result['status'] == 'Low' || $result['status'] == 'Critical low')
                                                        <span>&#8595;</span>
                                                    @endif </td>
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
                                                <td class="tdtest @if ($result['status'] != 'Normal' && $result['status'] != null) tdtest_status @else tdtest_background @endif">
                                                    {{ $result['result'] }}
                                                    @if ($result['status'] == 'High' || $result['status'] == 'Critical high')
                                                        <span>&#8593;</span>
                                                    @elseif($result['status'] == 'Low' || $result['status'] == 'Critical low')
                                                        <span>&#8595;</span>
                                                    @endif </td>
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

                        @if (count($culture['high_antibiotics']) > 0)
                            <table class="ttable">
                                <thead>
                                    <tr>
                                        <td class="theadtest" width="40%">Name</td>
                                        <td class="theadtest" width="60%">Sensitivity</td>


                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($culture['high_antibiotics'] as $antibiotic)
                                        <tr>
                                            <td class="tdtest" width="40%"> {{ $antibiotic['antibiotic']['name'] }}
                                            </td>
                                            <td class="tdtest" width="60%"> {{ $antibiotic['sensitivity'] }} </td>

                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        @endif
                        </br>
                        @if (count($culture['moderate_antibiotics']) > 0)
                            <table class="ttable">
                                <thead>
                                    <tr>
                                        <td class="theadtest" width="40%">Name</td>
                                        <td class="theadtest" width="60%">Sensitivity</td>


                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($culture['moderate_antibiotics'] as $antibiotic)
                                        <tr>
                                            <td class="tdtest" width="40%"> {{ $antibiotic['antibiotic']['name'] }}
                                            </td>
                                            <td class="tdtest" width="60%"> {{ $antibiotic['sensitivity'] }} </td>

                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        @endif
                        </br>
                        @if (count($culture['resident_antibiotics']) > 0)
                            <table class="ttable">
                                <thead>
                                    <tr>
                                        <td class="theadtest" width="40%">Name</td>
                                        <td class="theadtest" width="60%">Sensitivity</td>


                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($culture['resident_antibiotics'] as $antibiotic)
                                        <tr>
                                            <td class="tdtest" width="40%"> {{ $antibiotic['antibiotic']['name'] }}
                                            </td>
                                            <td class="tdtest" width="60%"> {{ $antibiotic['sensitivity'] }} </td>

                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        @endif


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
                        @if ($count > 1)
                            </pagebreak>
                        @endif
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
@endsection
