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
        ->orderBy('created_at', 'desc')
        ->get();
    foreach ($patientGroups as $gro) {
        $gro->tests = $gro->all_tests->whereIn('test_id', $testsIds);
    }
    $testId = [];
    $idsOfTest = [];
    foreach ($patientGroups as $gro) {
        foreach ($gro->all_tests as $test) {
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

@extends('layouts.report_layout')
@section('title')
    {{ __('Report') }}-#{{ $group['id'] }}-{{ date('Y-m-d') }}
@endsection
@section('content')


<x-report-style-component />

@php
    $firstCon = (isset($reports_settings['report_paid_stauts']) && $reports_settings['report_paid_stauts'] == false && $group['due'] > 0) ? false : true;
    $ScondeCon = ($allow == true) ? true : false;
    $ThridCon = ($group['allow_print'] == true) ? true : false;

    if($ScondeCon || $ThridCon || $firstCon ){
        $printResulte = true;
    }else{
        $printResulte = false;
    }

@endphp

@if ($printResulte)
    <div class="printable">
        @php
            $count_categories = 0;
            $index = 0;
        @endphp
        @foreach ($categories->sortBy(function ($cate) { if($cate->tests->count() > 0 ){ return $cate->tests[0]->test->components->count();  }else{ return 0; }  }    ); as $key=> $category)

            @if (count($category['tests']) || count($category['cultures']))

                @php
                    $index ++;
                @endphp
                @if ($header == false)                    
                    @foreach ($category['tests'] as $test)
                        @if ($index != 1 &&  ($test->new_line == '1' || (isset($test->setting['new_line']) &&  $test->setting['new_line'])))
                            <newpage>
                            @php
                                break;
                            @endphp
                        @endif
                    @endforeach
                @endif

                @if ($header && $count_categories > 0)
                    <newpage>
                @endif
                @php
                    $count_categories++;
                    $count = 0;
                @endphp
                
                @if (count($category['tests']))
                    <h2 class="test_title"  style="color:{{ $category['tests'][0]['setting']['test_title']['color']  }};text-align:{{ $category['tests'][0]['setting']['test_title']['text-align']  }};font-size:{{ $category['tests'][0]['setting']['test_title']['font-size']}};padding:{{ $category['tests'][0]['setting']['test_title']['height']}};text-decoration: underline;">{{ $category['name'] }}</h2>
                    @if (count($category['tests']) > 1)
                        <table class="ttable" width="100%">
                            
                            <thead  style="color:{{ $category['tests'][0]['setting']['test_head']['color']  }};text-align:{{ $category['tests'][0]['setting']['test_head']['text-align']  }};font-size:{{ $category['tests'][0]['setting']['test_head']['font-size']}};padding:{{ $category['tests'][0]['setting']['test_head']['height']}};font-family: {{ setting('reports')['test_head']['font-family'] }} !important; }}">
                                <tr>
                                    <td style="color:{{ $category['tests'][0]['setting']['test_head']['color']  }};text-align:{{ $category['tests'][0]['setting']['test_head']['text-align']  }};font-size:{{ $category['tests'][0]['setting']['test_head']['font-size']}};padding:{{ $category['tests'][0]['setting']['test_head']['height']}};font-family: {{ setting('reports')['test_head']['font-family'] }} !important;" class="theadtest" >Test </td>
                                    <td style="color:{{ $category['tests'][0]['setting']['test_head']['color']  }};text-align:{{ $category['tests'][0]['setting']['test_head']['text-align']  }};font-size:{{ $category['tests'][0]['setting']['test_head']['font-size']}};padding:{{ $category['tests'][0]['setting']['test_head']['height']}};font-family: {{ setting('reports')['test_head']['font-family'] }} !important;" class="theadtest" >Result</td>

                                @if(isset($category['tests'][0]['setting']['show_unit']) && $category['tests'][0]['setting']['show_unit'] == true ) <td style="color:{{ $category['tests'][0]['setting']['test_head']['color']  }};text-align:{{ $category['tests'][0]['setting']['test_head']['text-align']  }};font-size:{{ $category['tests'][0]['setting']['test_head']['font-size']}};padding:{{ $category['tests'][0]['setting']['test_head']['height']}}; font-family: {{ setting('reports')['test_head']['font-family'] }} !important;" class="theadtest " >Unit</td> @endif
                                @if(isset($category['tests'][0]['setting']['show_status']) && $category['tests'][0]['setting']['show_status'] == true ) <td style="color:{{ $category['tests'][0]['setting']['test_head']['color']  }};text-align:{{ $category['tests'][0]['setting']['test_head']['text-align']  }};font-size:{{ $category['tests'][0]['setting']['test_head']['font-size']}};padding:{{ $category['tests'][0]['setting']['test_head']['height']}};font-family: {{ setting('reports')['test_head']['font-family'] }} !important;" class="theadtest " >Status</td> @endif
                                @if(isset($category['tests'][0]['setting']['show_range']) && $category['tests'][0]['setting']['show_range'] == true ) <td style="color:{{ $category['tests'][0]['setting']['test_head']['color']  }};text-align:{{ $category['tests'][0]['setting']['test_head']['text-align']  }};font-size:{{ $category['tests'][0]['setting']['test_head']['font-size']}};padding:{{ $category['tests'][0]['setting']['test_head']['height']}};font-family: {{ setting('reports')['test_head']['font-family'] }} !important;" class="theadtest" >Normal Range</td> @endif
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach ($category['tests'] as $test)
                                    @foreach ($test['results'] as $result)
                                        <!-- Title -->
                                        @if (isset($result['component']))
                                            @if ($result['component']['title'])
                                                <tr>
                                                    
                                                    <td style="color:{{ $category['tests'][0]['setting']['test_name']['color']  }};text-align:{{ $category['tests'][0]['setting']['test_name']['text-align']  }};font-size:{{ $category['tests'][0]['setting']['test_name']['font-size']}};padding:{{ $category['tests'][0]['setting']['test_name']['height']}};font-family: {{ setting('reports')['test_name']['font-family'] }} !important;"  class="tdtest">
                                                        <h3 class="">{{ $result['component']['name'] }}</h3>
                                                    </td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td style="color:{{ $category['tests'][0]['setting']['test_name']['color']  }};text-align:{{ $category['tests'][0]['setting']['test_name']['text-align']  }};font-size:{{ $category['tests'][0]['setting']['test_name']['font-size']}};padding:{{ $category['tests'][0]['setting']['test_name']['height']}};font-family: {{ setting('reports')['test_name']['font-family'] }} !important;" class="tdtest" >
                                                        {{ $result['component']['name'] }}
                                                    </td>
                                                    <td 
                                                    @if ($result['status'] != 'Normal' && $result['status'] != null && isset($test['setting']['highlite']) && $test['setting']['highlite'] == true  ) 
                                                        class="tdtest result  tdtest_status" 
                                                    @else 
                                                        style="color:{{ $category['tests'][0]['setting']['result']['color']  }};text-align:{{ $category['tests'][0]['setting']['result']['text-align']  }};font-size:{{ $category['tests'][0]['setting']['result']['font-size']}};padding:{{ $category['tests'][0]['setting']['result']['height']}};font-family: {{ setting('reports')['result']['font-family'] }} !important;"
                                                    @endif
                                                        >{{ $result['result'] }}
                                                        @if ($result['status'] == 'High' || $result['status'] == 'Critical high')
                                                            <span>&#8593;</span>
                                                        @elseif($result['status'] == 'Low' || $result['status'] == 'Critical low')
                                                            <span>&#8595;</span>
                                                        @endif
                                                    </td>

                                                    @if(isset($category['tests'][0]['setting']['show_unit']) && $category['tests'][0]['setting']['show_unit'] == true )
                                                        <td style="color:{{ $category['tests'][0]['setting']['unit']['color']  }};text-align:{{ $category['tests'][0]['setting']['unit']['text-align']  }};font-size:{{ $category['tests'][0]['setting']['unit']['font-size']}};padding:{{ $category['tests'][0]['setting']['unit']['height']}}; font-family: {{ setting('reports')['unit']['font-family'] }} !important;" class="tdtest">
                                                            {{ $result['component']['unit'] }}
                                                        </td>
                                                    @endif

                                                    @if(isset($category['tests'][0]['setting']['show_status']) && $category['tests'][0]['setting']['show_status'] == true )
                                                        <td 

                                                        @if ($result['status'] != 'Normal' && $result['status'] != null && isset($test['setting']['highlite']) && $test['setting']['highlite'] == true  ) 
                                                            class="tdtest result  tdtest_status" 
                                                        @else 
                                                            style="color:{{ $category['tests'][0]['setting']['status']['color']  }};text-align:{{ $category['tests'][0]['setting']['status']['text-align']  }};font-size:{{ $category['tests'][0]['setting']['status']['font-size']}};padding:{{ $category['tests'][0]['setting']['status']['height']}};font-family: {{ setting('reports')['status']['font-family'] }} !important;" 
                                                        @endif

                                                            
                                                            
                                                            >
                                                            {{ $result['status'] }} 
                                                            @if ($result['status'] == 'High' || $result['status'] == 'Critical high')
                                                                <span>&#8593;</span>
                                                            @elseif($result['status'] == 'Low' || $result['status'] == 'Critical low')
                                                                <span>&#8595;</span>
                                                            @endif
                                                        </td>
                                                    @endif

                                                    @if(isset($category['tests'][0]['setting']['show_range']) && $category['tests'][0]['setting']['show_range'] == true )
                                                        <td style="color:{{ $category['tests'][0]['setting']['reference_range']['color']  }};text-align:{{ $category['tests'][0]['setting']['reference_range']['text-align']  }};font-size:{{ $category['tests'][0]['setting']['reference_range']['font-size']}};padding:{{ $category['tests'][0]['setting']['reference_range']['height']}};font-family: {{ setting('reports')['reference_range']['font-family'] }} !important;" class="tdtest">
                                                            {!! $result['comment'] !!}
                                                        </td>
                                                    @endif

                                                </tr>
                                            @endif
                                        @endif
                                    @endforeach
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
                                        <td  width="12px"  nowrap="nowrap"><b>Comment:</b></td>
                                        <td class="commentb">
                                            {!! str_replace(["<p><br></p>","\n"], '<br>', $test['comment']) !!}
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

                            @if (in_array($test->test->id,setting('medical')['cbc']))
                                <x-cbc-report-component :test="$test" :group="$group"  />
                                <!--/ Semen Examination ID 3045-->
                                @elseif($test['test']['id'] == 3045)
                                    <x-semen-report-component :test="$test" :group="$group"  />
                                    {{-- {{dd(setting('medical')['semen_layout'])}} --}}
                                @elseif($test['test']['id'] == 11091)
                                    @if (setting('medical')['semen_layout']=='without_graph')
                                        <x-semen2-component :test="$test" :group="$group"  />
                                    @else 
                                        <x-semen-report-component :test="$test" :group="$group"  />

                                    @endif
                                <!-- /comment -->
                                <!--/ end Semen Examination Report ID 3045-->                                       
                            @else  
                                <table class="ttable" width="100%">
                                    <thead style="color:{{ $test['setting']['test_head']['color']  }};text-align:{{ $test['setting']['test_head']['text-align']  }};font-size:{{ $test['setting']['test_head']['font-size']}};padding:{{ $test['setting']['test_head']['height']}};font-family: {{ setting('reports')['test_head']['font-family'] }} !important; }}">
                                        <tr>
                                            <td style="color:{{ $test['setting']['test_head']['color']  }};text-align:{{ $test['setting']['test_head']['text-align']  }};font-size:{{ $test['setting']['test_head']['font-size']}};padding:{{ $test['setting']['test_head']['height']}};font-family: {{ setting('reports')['test_head']['font-family'] }} !important;" class="theadtest " >Test </td>
                                            <td style="color:{{ $test['setting']['test_head']['color']  }};text-align:{{ $test['setting']['test_head']['text-align']  }};font-size:{{ $test['setting']['test_head']['font-size']}};padding:{{ $test['setting']['test_head']['height']}};font-family: {{ setting('reports')['test_head']['font-family'] }} !important;" class="theadtest " >Result</td>

                                            @if(isset($test['setting']['show_unit']) && $test['setting']['show_unit'] == true ) <td style="color:{{ $test['setting']['test_head']['color']  }};text-align:{{ $test['setting']['test_head']['text-align']  }};font-size:{{ $test['setting']['test_head']['font-size']}};padding:{{ $test['setting']['test_head']['height']}};font-family: {{ setting('reports')['test_head']['font-family'] }} !important;" class="theadtest " >Unit</td> @endif
                                            @if(isset($test['setting']['show_status']) && $test['setting']['show_status'] == true ) <td style="color:{{ $test['setting']['test_head']['color']  }};text-align:{{ $test['setting']['test_head']['text-align']  }};font-size:{{ $test['setting']['test_head']['font-size']}};padding:{{ $test['setting']['test_head']['height']}};font-family: {{ setting('reports')['test_head']['font-family'] }} !important;" class="theadtest " >Status</td> @endif
                                            @if(isset($test['setting']['show_range']) && $test['setting']['show_range'] == true ) <td style="color:{{ $test['setting']['test_head']['color']  }};text-align:{{ $test['setting']['test_head']['text-align']  }};font-size:{{ $test['setting']['test_head']['font-size']}};padding:{{ $test['setting']['test_head']['height']}};font-family: {{ setting('reports')['test_head']['font-family'] }} !important;" class="theadtest " >Normal Range</td> @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($test['results'] as $result)
                                            <!-- Title -->
                                            @if (isset($result['component']))
                                                @if ($result['component']['title'])
                                                    <tr>
                                                        
                                                        <td style="color:{{ $test['setting']['test_name']['color']  }};text-align:{{ $test['setting']['test_name']['text-align']  }};font-size:{{ $test['setting']['test_name']['font-size']}};padding:{{ $test['setting']['test_name']['height']}};font-family: {{ setting('reports')['test_name']['font-family'] }} !important;"  class="tdtest">
                                                            <h3 class="">{{ $result['component']['name'] }}</h3>
                                                        </td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td style="color:{{ $test['setting']['test_name']['color']  }};text-align:{{ $test['setting']['test_name']['text-align']  }};font-size:{{ $test['setting']['test_name']['font-size']}};padding:{{ $test['setting']['test_name']['height']}};font-family: {{ setting('reports')['test_name']['font-family'] }} !important;" class="tdtest" >
                                                            {{ $result['component']['name'] }}
                                                        </td>
                                                        <td 
                                                        @if ($result['status'] != 'Normal' && $result['status'] != null && isset($test['setting']['highlite']) && $test['setting']['highlite'] == true  ) 
                                                            class="tdtest result  tdtest_status" 
                                                        @else 
                                                            style="color:{{ $test['setting']['result']['color']  }};text-align:{{ $test['setting']['result']['text-align']  }};font-size:{{ $test['setting']['result']['font-size']}};padding:{{ $test['setting']['result']['height']}};font-family: {{ setting('reports')['result']['font-family'] }} !important;"
                                                        @endif
                                                            
                                                            >{{ $result['result'] }}
                                                            @if ($result['status'] == 'High' || $result['status'] == 'Critical high')
                                                                <span>&#8593;</span>
                                                            @elseif($result['status'] == 'Low' || $result['status'] == 'Critical low')
                                                                <span>&#8595;</span>
                                                            @endif
                                                        </td>

                                                        @if(isset($test['setting']['show_unit']) && $test['setting']['show_unit'] == true )
                                                            <td style="color:{{ $test['setting']['unit']['color']  }};text-align:{{ $test['setting']['unit']['text-align']  }};font-size:{{ $test['setting']['unit']['font-size']}};padding:{{ $test['setting']['unit']['height']}};font-family: {{ setting('reports')['unit']['font-family'] }} !important;" class="tdtest">
                                                                {{ $result['component']['unit'] }}
                                                            </td>
                                                        @endif

                                                        @if(isset($test['setting']['show_status']) && $test['setting']['show_status'] == true )
                                                            <td 
                                                                @if ($result['status'] != 'Normal' && $result['status'] != null && isset($test['setting']['highlite']) && $test['setting']['highlite'] == true  ) 
                                                                    class="tdtest result  tdtest_status" 
                                                                @else 
                                                                    style="color:{{ $test['setting']['status']['color']  }};text-align:{{ $test['setting']['status']['text-align']  }};font-size:{{ $test['setting']['status']['font-size']}};padding:{{ $test['setting']['status']['height']}};font-family: {{ setting('reports')['status']['font-family'] }} !important;" class="tdtest" 
                                                                @endif
                                                            
                                                            >
                                                                {{ $result['status'] }} @if ($result['status'] == 'High' || $result['status'] == 'Critical high')
                                                                    <span>&#8593;</span>
                                                                @elseif($result['status'] == 'Low' || $result['status'] == 'Critical low')
                                                                    <span>&#8595;</span>
                                                                @endif
                                                            </td>
                                                        @endif

                                                        @if(isset($test['setting']['show_range']) && $test['setting']['show_range'] == true )
                                                            <td style="color:{{ $test['setting']['reference_range']['color']  }};text-align:{{ $test['setting']['reference_range']['text-align']  }};font-size:{{ $test['setting']['reference_range']['font-size']}};padding:{{ $test['setting']['reference_range']['height']}};font-family: {{ setting('reports')['reference_range']['font-family'] }} !important;" class="tdtest">
                                                                {!! $result['comment'] !!}
                                                            </td>
                                                        @endif

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
                                    @if($test['test']['id'] != 1207)
                                        

                                        <table class="comment" width="100%">
                                            <tbody>
                                                <tr>
                                                    <td width="12px" nowrap="nowrap"><b>Comment:</b></td>
                                                    <td class="commentb">
                                                        {!! str_replace(["<p><br></p>","\n"], '<br>', $test['comment']) !!}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    @else
                                        {!! $test['comment'] !!}
                                    @endif
                                @endif
                                @if($test['test']['id'] == 453)
                                <div style="margin-top: 20px;margin-left:25%;text-align:center !important" align="center" width="50%" height="200px">
                                    @php
                                        
                                        foreach ($test['results'] as $result) {
                                            if (isset($result['component'])) {
                                                if ($result['component']['name'] == 'Fasting B. Glucose') {
                                                    $val1 = $result['result'];
                                                }
                                        
                                                if ($result['component']['name'] == '60 min') {
                                                    $val2 = $result['result'];
                                                }
                                        
                                                if ($result['component']['name'] == '120 min') {
                                                    $val3 = $result['result'];
                                                }
                                            }
                                        
                                            if ($result['component']['name'] == '180 min') {
                                                $val4 = $result['result'];
                                            }
                                        }
                                        
                                        $chart2 = new QuickChart([
                                            'width' => 500,
                                            'height' => 400,
                                        ]);
                                        if (isset($val1) && isset($val2) && isset($val3)) {
                                            $chart2->setConfig("{
                                    type: 'line',
                                    
                                    data: {
                                        
                                        labels: ['Fasting B. Glucose', '60 min', '120 min', '180 min'],
                                        datasets: [{
                                        data: [$val1 ,$val2 , $val3 , $val4],
                                        label:'Fasting Blood Glucose',
                                        borderColor: 'rgb(255, 99, 132)',
                                        fill:'0'
                                        }]
                                    }
                                    }");
                                        }
                                    @endphp
                                    @if (isset($val1) && isset($val2) && isset($val3))
                                        <img align="center" src="{{ $chart2->getUrl() }}" width="100%">
                                    @endif
                                </div>
                                @endif
                            @endif
                        @endforeach
                    @endif
                @endif

                @if (!session()->get('history') == $group['id'])
                    @foreach ($resultes as $res)
                        @foreach ($category['tests'] as $test)    
                            @if ($test->test->id == $res->test_id)
                                <h4 style="margin:0px">History :-</h4>
                                <h5 style="margin:0px">Test Name: {{ $res->test->name }} - invoice(#ID:{{ $res->group->id }}) - Date:
                                    {{ $res->group->created_at }}</h5>

                                    
                                @if (in_array($res['test_id'],setting('medical')['cbc']))
                                <table class="ttable">
                                    <thead style="font-size:6px">
                                        <tr>
                                            
                                            @foreach ($res['results'] as $result)
                                            @if (
                                                (\Str::slug($result['component']['name']) == "hemoglobin-hb" ||
                                                \Str::slug($result['component']['name']) == "rbcs" ||
                                                \Str::slug($result['component']['name']) == "platelet-count-plt" ||
                                                \Str::slug($result['component']['name']) == "plateletplt" ||
                                                \Str::slug($result['component']['name']) == "mcv" ||
                                                \Str::slug($result['component']['name']) == "mch" ||
                                                \Str::slug($result['component']['name']) == "mchc" ||
                                                \Str::slug($result['component']['name']) == "rdw-cv" ||
                                                \Str::slug($result['component']['name']) == "rdw-sd" ||
                                                \Str::slug($result['component']['name']) == "mpv" ||
                                                \Str::slug($result['component']['name']) == "pdw" ||
                                                \Str::slug($result['component']['name']) == "pct" ||
                                                \Str::slug($result['component']['name']) == "p-lcr" ||
                                                \Str::slug($result['component']['name']) == "wbcs-leukocytes" ||
                                                \Str::slug($result['component']['name']) == "lymphocytes" ||
                                                \Str::slug($result['component']['name']) == "monocytes" ||
                                                \Str::slug($result['component']['name']) == "eosinophils" ||
                                                \Str::slug($result['component']['name']) == "basophils" ||
                                                \Str::slug($result['component']['name']) == "neutrophil") &&
                                                $result['component']['title'] == 0
                                                
                                                )
                                                    <th>
                                                        {{ str_replace(['(' , ')'] ,'',Str::limit($result['component']['name'] , 6 , '')) }}
                                                    </th>
                                                @endif
                                            @endforeach

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            @foreach ($res['results'] as $result)
                                            @if (
                                                (\Str::slug($result['component']['name']) == "hemoglobin-hb" ||
                                                \Str::slug($result['component']['name']) == "rbcs" ||
                                                \Str::slug($result['component']['name']) == "platelet-count-plt" ||
                                                \Str::slug($result['component']['name']) == "plateletplt" ||
                                                \Str::slug($result['component']['name']) == "mcv" ||
                                                \Str::slug($result['component']['name']) == "mch" ||
                                                \Str::slug($result['component']['name']) == "mchc" ||
                                                \Str::slug($result['component']['name']) == "rdw-cv" ||
                                                \Str::slug($result['component']['name']) == "rdw-sd" ||
                                                \Str::slug($result['component']['name']) == "mpv" ||
                                                \Str::slug($result['component']['name']) == "pdw" ||
                                                \Str::slug($result['component']['name']) == "pct" ||
                                                \Str::slug($result['component']['name']) == "p-lcr" ||
                                                \Str::slug($result['component']['name']) == "wbcs-leukocytes" ||
                                                \Str::slug($result['component']['name']) == "lymphocytes" ||
                                                \Str::slug($result['component']['name']) == "monocytes" ||
                                                \Str::slug($result['component']['name']) == "eosinophils" ||
                                                \Str::slug($result['component']['name']) == "basophils" ||
                                                \Str::slug($result['component']['name']) == "neutrophil") &&
                                                $result['component']['title'] == 0
                                                
                                                )
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
                                                        <td class="tdtest @if ($result['status'] != 'Normal' && $result['status'] != null && isset($test['setting']['highlite']) && $test['setting']['highlite'] == true   ) tdtest_status @else tdtest_background @endif">
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
                                                        <td class="tdtest @if ($result['status'] != 'Normal' && $result['status'] != null && isset($test['setting']['highlite']) && $test['setting']['highlite'] == true ) tdtest_status @else tdtest_background @endif">
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
                                                    <td class="tdtest @if ($result['status'] != 'Normal' && $result['status'] != null && isset($test['setting']['highlite']) && $test['setting']['highlite'] == true  ) tdtest_status @else tdtest_background @endif">
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
                    @endforeach
                @endif

                @if (count($category['cultures']))
                    @foreach ($category['cultures'] as $culture)
                        @if ($count > 0)
                            <pagebreak>                
                        @endif
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
                        @if($culture->resident_antibiotics->count() || $culture->moderate_antibiotics->count() || $culture->high_antibiotics->count() )
                            <table class="tableculture">
                            <thead>
                                <tr>
                                    <th colspan="6"><b style="text-decoration: underline;">Antibiotic Senestivity Report</b></th>
                                </tr>


                            </thead>

                            <tbody>
                                <tr>
                                    <td @if(!setting('medical')['low_culture'] && !setting('medical')['resistant_culture'] ) width="50%" @else width="33%" @endif ><p style="text-decoration: underline;">High Senestive Antimicrobial</p></td>
                                    <td @if(!setting('medical')['low_culture'] && !setting('medical')['resistant_culture'] ) width="50%" @else width="33%" @endif><p style="text-decoration: underline;">Moderate Senestive Antimicrobial</p></td>
                                    @if(isset(setting('medical')['low_culture']) && setting('medical')['low_culture'] == true )   <td width="34%"><p style="text-decoration: underline;">Low Senestive Antimicrobial</p></td> @endif
                                    @if(isset(setting('medical')['resistant_culture']) && setting('medical')['resistant_culture'] == true ) <td width="34%"><p style="text-decoration: underline;">Resistant Antimicrobial</p></td> @endif
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align:top;">
                                    @foreach ($culture['high_antibiotics'] as $antibiotic)
                                    <ul style="padding: 2px;">
                                        @if (count($culture['high_antibiotics']) > 0)
                                            - {{ $antibiotic['antibiotic']['name'] }} 

                                            <!--<br>( {{ $antibiotic['antibiotic']['commercial_name'] }} )-->

                                        @endif
                                    </ul>
                                    @endforeach
                                    </td>

                                    <td align="left" style="vertical-align:top;">
                                    @foreach ($culture['moderate_antibiotics'] as $antibiotic)
                                    <ul style="padding: 2px;">
                                    @if (count($culture['moderate_antibiotics']) > 0)
                                    - {{ $antibiotic['antibiotic']['name'] }}
                                    <!--<br>( {{ $antibiotic['antibiotic']['commercial_name'] }} )-->
                                    @endif
                                    </ul>
                                    @endforeach
                                    </td>

                                    @if(isset(setting('medical')['low_culture']) && setting('medical')['low_culture'] == true )
                                        <td align="left" style="vertical-align:top;">
                                            @foreach ($culture['low_antibiotics'] as $antibiotic)
                                            <ul style="padding: 2px;">
                                            @if (count($culture['low_antibiotics']) > 0)
                                            -  {{ $antibiotic['antibiotic']['name'] }}
                                            <!--<br>( {{ $antibiotic['antibiotic']['commercial_name'] }} )-->
                                            @endif
                                            </ul>
                                            @endforeach
                                        </td>
                                    @endif

                                    @if(isset(setting('medical')['resistant_culture']) && setting('medical')['resistant_culture'] == true )

                                        <td align="left" style="vertical-align:top;">
                                        @foreach ($culture['resident_antibiotics'] as $antibiotic)
                                        <ul style="padding: 2px;">
                                        @if (count($culture['resident_antibiotics']) > 0)
                                        -  {{ $antibiotic['antibiotic']['name'] }}
                                        <!--<br>( {{ $antibiotic['antibiotic']['commercial_name'] }} )-->
                                        @endif
                                        </ul>
                                        @endforeach
                                        </td>
                                    @endif
                                </tr>
                            </tbody>
                            </table>
                        @endif

                        <!-- Comment -->
                        @if (isset($culture['comment']))
                            <br>

                                <table class="comment" width="100%">
                                    <tbody>
                                        <tr>
                                            <td width="12px" nowrap="nowrap"><b>Comment:</b></td>
                                            <td class="commentb">
                                                {!! str_replace(["<p><br></p>","\n"], '<br>', $culture['comment']) !!}
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
@else
    <div class="category_title">
        {{ __('You Must Pay ') }} {{ $group['due'] }}
    </div>
@endif

@endsection
