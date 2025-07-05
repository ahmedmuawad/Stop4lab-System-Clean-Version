<div>
    <div width="60%" style="float:left">
        <div class="dis" style="margin-top: -10px">
            <table width="100%">
                <thead>
                    <tr>
                        <th colspan="3" align="center"
                            style="background-color: blue ; color:#fff ; font-size:20px;font-weight: bold">
                            Physical Exmination
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Sample Volume == 11094    -->
                    <!-- Collection == 11092 -->
                    <!-- Liquefaction time == 11096 -->
                    <!-- Color == 11097 -->
                    <!-- Reaction == 11098 -->
                    @foreach ($test['results'] as $result)
                        @if (isset($result['component']) && $result['result'] != null)
                        
                        @if ($result['component']['id'] == 11094)
                                <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                    <td><b>{{ $result['component']['name'] }}</b></td>
                                    <td><b>{{ $result['result'] }}</b></td>
                                    <td><b> {!! $result['comment'] !!}</b></td>

                                </tr>
                       
                            @elseif($result['component']['id'] == 11092)
                                <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                    <td><b>{{ $result['component']['name'] }}</b></td>
                                    <td><b>{{ $result['result'] }}</b></td>
                                    <td><b> {!! $result['comment'] !!}</b></td>

                                </tr>
                     
                            @elseif($result['component']['id'] == 11096)
                                <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                    <td><b>{{ $result['component']['name'] }}</b></td>
                                    <td><b>{{ $result['result'] }}</b></td>
                                    <td><b> {!! $result['comment'] !!}</b></td>

                                </tr>
                            @elseif($result['component']['id'] == 1499)
                                <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                    <td><b>{{ $result['component']['name'] }}</b></td>
                                    <td><b>{{ $result['result'] }}</b></td>
                                    <td><b>{!! $result['comment'] !!}</b></td>

                                </tr>
                        
                            @elseif($result['component']['id'] == 11097)
                                <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                    <td><b>{{ $result['component']['name'] }}</b></td>
                                    <td><b>{{ $result['result'] }}</b></td>
                                    <td><b> {!! $result['comment'] !!}</b></td>

                                </tr>
                        
                            @elseif($result['component']['id'] == 11098)
                                <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                    <td><b>{{ $result['component']['name'] }}</b></td>
                                    <td><b>{{ $result['result'] }}</b></td>
                                    <td><b> {!! $result['comment'] !!}</b></td>

                                </tr>
                            @endif
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        <br />
        <div class="dis" style="margin-top: -10px">
            <table width="100%">
                <thead>
                    <tr>
                        <th colspan="3" align="center"
                            style="background-color: blue ; color:#fff ; font-size:20px;font-weight: bold">
                            Summerized Data
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <!-- SPERM CONC == 11105 -->
                    <!-- Total Sperm Count == 11106 -->  
                    <!-- Progressive Moltility-PR == 11107 -->
                    <!-- Toatal NR and NPR % == 11108 -->
                    <!-- Normal Morphology Form == 11109 -->
                    <!-- Functional Sperm == 11110 -->
                    <!-- Functional Sperm CONC-FSC == 11136 -->
                    <!-- Teratozoospermic index-TZI == 11112 -->
                    <!-- Sperm deformity index-SDI == 11113 -->
                    <!-- Vitality == 1115 -->
                    @foreach ($test['results'] as $result)
                        @if (isset($result['component']) && $result['result'] != null)
                        
                            @if ($result['component']['id'] == 11105)
                                <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                    <td><b>{{ $result['component']['name'] }}</b></td>
                                    <td><b>{{ $result['result'] }}</b></td>
                                    <td><b>{!! $result['comment'] !!}</b></td>
                                </tr>
                              
                            @elseif($result['component']['id'] == 11106)
                                <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                    <td><b>{{ $result['component']['name'] }}</b></td>
                                    <td><b>{{ $result['result'] }}</b></td>
                                    <td><b>{!! $result['comment'] !!}</b></td>

                                </tr>
                        
                            @elseif($result['component']['id'] == 11107)
                                <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                    <td><b>{{ $result['component']['name'] }}</b></td>
                                    <td><b>{{ $result['result'] }}</b></td>
                                    <td><b>{!! $result['comment'] !!}</b></td>

                                </tr>
                        
                            @elseif($result['component']['id'] == 11108)
                                <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                    <td><b>{{ $result['component']['name'] }}</b></td>
                                    <td><b>{{ $result['result'] }}</b></td>
                                    <td><b>{!! $result['comment'] !!}</b></td>

                                </tr>
                        
                            @elseif($result['component']['id'] == 11109)
                                <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                    <td><b>{{ $result['component']['name'] }}</b></td>
                                    <td><b>{{ $result['result'] }}</b></td>
                                    <td><b>{!! $result['comment'] !!}</b></td>

                                </tr>
                        
                            @elseif($result['component']['id'] == 11110)
                                <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                    <td><b>{{ $result['component']['name'] }}</b></td>
                                    <td><b>{{ $result['result'] }}</b></td>
                                    <td><b>{!! $result['comment'] !!}</b></td>

                                </tr>
                        
                            @elseif($result['component']['id'] == 11136)
                                <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                    <td><b>{{ $result['component']['name'] }}</b></td>
                                    <td><b>{{ $result['result'] }}</b></td>
                                    <td><b>{!! $result['comment'] !!}</b></td>

                                </tr>
                        
                            @elseif($result['component']['id'] == 11112)
                                <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                    <td><b>{{ $result['component']['name'] }}</b></td>
                                    <td><b>{{ $result['result'] }}</b></td>
                                    <td><b>{!! $result['comment'] !!}</b></td>

                                </tr>
                        
                            @elseif($result['component']['id'] == 11113)
                                <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                    <td><b>{{ $result['component']['name'] }}</b></td>
                                    <td><b>{{ $result['result'] }}</b></td>
                                    <td><b>{!! $result['comment'] !!}</b></td>

                                </tr>
                        
                            @elseif($result['component']['id'] == 1115)
                                <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                    <td><b>{{ $result['component']['name'] }}</b></td>
                                    <td><b>{{ $result['result'] }}</b></td>
                                    <td><b>{!! $result['comment'] !!}</b></td>
                                </tr>
                            @endif
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        <br />
        <div class="dis" style="margin-top: -10px">
            <table width="100%">
                <thead>
                    <tr>
                        <th colspan="4" align="center"
                            style="background-color: blue ; color:#fff ; font-size:20px;font-weight: bold">
                            Other Cells And abnorminality
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($test['results'] as $result)
                        @if (isset($result['component']) && $result['result'] != null)
                        <!-- RBCs -->
                            @if ($result['component']['id'] == 11100)
                                <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                    <td colspan="2"><b>{{ $result['component']['name'] }}</b></td>
                                    <td colspan="1">
                                        <b>{{ $result['result'] }}</b>
                                    </td>
                                    <td>
                                        <input class="" value="{{ $result['result'] }}" type="text">
                                    </td>
                                </tr>
                            <!-- SPERMATOGlELINC CELL -->
                            @elseif($result['component']['id'] == 11103)
                                <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                    <td colspan="2"><b>{{ $result['component']['name'] }}</b></td>
                                    <td colspan="1">
                                        <b>{{ $result['result'] }}</b>
                                    </td>
                                    <td>
                                        <input class="" value="{{ $result['result'] }}" type="text">
                                    </td>

                                </tr>
                            <!-- WBC Cell -->
                            @elseif($result['component']['id'] == 11101)
                                <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                    <td colspan="2"><b>{{ $result['component']['name'] }}</b></td>
                                    <td colspan="1">
                                        <b>{{ $result['result'] }}</b>
                                    </td>
                                    <td>
                                        <input class="" value="{{ $result['result'] }}" type="text">
                                    </td>

                                </tr>
                            <!-- Epithelial Cell -->
                            @elseif($result['component']['id'] == 11102)
                                <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                    <td colspan="2"><b>{{ $result['component']['name'] }}</b></td>
                                    <td colspan="1">
                                        <b>{{ $result['result'] }}</b>
                                    </td>
                                    <td>
                                        <input class="" value="{{ $result['result'] }}" type="text">
                                    </td>

                                </tr>
                            <!-- Aggulationtion -->
                            @elseif($result['component']['id'] == 11104)
                                <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                    <td colspan="2"><b>{{ $result['component']['name'] }}</b></td>
                                    <td colspan="2">
                                        <b>{{ $result['result'] }}</b>
                                    </td>

                                </tr>
                            @endif
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        <br />
    </div>
    
    <div width="38%" style="float: right">
        <div style="margin-top: 0px" align="center">
            @if (isset($group->images[0]))
                <img src="{{ url('uploads/semen/' . $group->images[0]->image_name) }}"
                    style="height: 200px; width: 270px;" width="100%">
            @endif
        </div>
        <div style="margin-top: 50px" align="center">
        <!-- Progressive Moltility-PR == 11107 -->
        <!-- Non Progressive Motility == 11119 -->
         <!-- Immotile == 11120 -->
            @php

                foreach ($test['results'] as $result) {
                    if (isset($result['component'])) {
                        
                        if ($result['component']['id'] == 11107) {
                            $val1 = $result['result'];
                        }
                        
                        if ($result['component']['id'] == 11119) {
                            $val2 = $result['result'];
                        }
                       
                        if ($result['component']['id'] == 11120) {
                            $val3 = $result['result'];
                        }
                    }
                }
                $chart2 = new QuickChart([
                    'width' => 500,
                    'height' => 400,
                ]);

                // $obj = array('type' => "pie", array('labels' => )  )
                if (isset($val1) && isset($val2) && isset($val3)) {
                    $chart2->setConfig("{
                    type: 'pie',
                    data: {
                        labels: [ 'RP' , 'NRP' , 'Immotbile' ],
                        datasets: [{
                        label: 'Foo',
                        data: [ $val1 , $val2 , $val3 ]
                        }]
                    }
                    }");
                }
            @endphp
            @if (isset($val1) && isset($val2) && isset($val3))
                <img src="{{ $chart2->getUrl() }}" width="100%">
            @endif
        </div>
    </div>
    <div style="clear:both"></div>
    <br><br><br>
    <div width="100%">
        <div class="dis">
            <table width="60%" style="float: left">
                <thead>
                    <tr>
                        <th colspan="4" align="center"
                            style="background-color: blue ; color:#fff ; font-size:20px;font-weight: bold">
                            Motility Analysis
                        </th>
                    </tr>
                    <tr>
                        <th>
                            <input type="text" value="Moltiy Grade">
                        </th>

                        <th>
                            <input type="text" value="Precent">
                        </th>

                        <th>
                            <input type="text" value="Total Count">
                        </th>

                        <th>
                            <input type="text" value="Class %">
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($test['results'] as $result)
                        @if (isset($result['component']) && $result['result'] != null)
                        <!-- Progressive Moltility-PR -->
                            @if ($result['component']['id'] == 11107)
                                <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px">
                                    <td width="40%"><b>{{ $result['component']['name'] }}</b></td>
                                    <td width="15%">
                                        <span style="border:1px solid #000;">
                                            {{ $result['result'] }}
                                        </span>
                                        &nbsp;
                                        <span style="border:1px solid #000;">
                                            %
                                        </span>
                                    </td>
                                    @foreach ($test['results'] as $result)
                                        @if (isset($result['component']))
                                        <!-- total_Progressive -->
                                            @if ($result['component']['id'] == 11121)
                                                <td width="15%">
                                                    <span style="border:1px solid #000;">
                                                        {{ $result['result'] }}
                                                    </span>
                                                    &nbsp;
                                                    <span style="border:1px solid #000;">
                                                        {{ $result['component']['unit'] }}
                                                    </span>

                                                </td>
                                            @endif
                                        @endif
                                    @endforeach
                                    <td width="30%">
                                        @foreach ($test['results'] as $result)
                                            @if (isset($result['component']))
                                            <!-- Class A -->
                                                @if ($result['component']['id'] == 11124)
                                                    {{-- <td width="15%"> --}}
                                                    <div>

                                                        <span style="border:1px solid #000;">
                                                            {{ $result['component']['name'] }}
                                                        </span>
                                                        &nbsp;
                                                        <span style="border:1px solid #000;">
                                                            {{ $result['result'] }}
                                                        </span>
                                                        &nbsp;
                                                        <span style="border:1px solid #000;">

                                                            {{ $result['component']['unit'] }}
                                                        </span>
                                                    </div>
                                                @endif
                                            @endif
                                        @endforeach

                                        @foreach ($test['results'] as $result)
                                            @if (isset($result['component']))
                                            <!-- Class B -->
                                                @if ($result['component']['id'] == 11125)
                                                    {{-- <td width="15%"> --}}
                                                    <div style="margin-top: 3px">
                                                        <span style="border:1px solid #000;">
                                                            {{ $result['component']['name'] }}
                                                        </span>
                                                        &nbsp;
                                                        <span style="border:1px solid #000;">
                                                            {{ $result['result'] }}
                                                        </span>
                                                        &nbsp;
                                                        <span style="border:1px solid #000;">

                                                            {{ $result['component']['unit'] }}
                                                        </span>
                                                    </div>
                                                @endif
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                                <!-- Non Progressive Motility -->
                            @elseif($result['component']['id'] == 11119)
                                <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                    <td width="40%"><b>{{ $result['component']['name'] }}</b></td>
                                    <td width="15%">
                                        <span style="border:1px solid #000;">
                                            {{ $result['result'] }}
                                        </span>
                                        &nbsp;
                                        <span style="border:1px solid #000;">
                                            %
                                        </span>
                                    </td>
                                    @foreach ($test['results'] as $result)
                                        @if (isset($result['component']))
                                        <!-- total_Non Progressive Motility -->
                                            @if ($result['component']['id'] == 11122)
                                                <td width="15%">
                                                    <span style="border:1px solid #000;">
                                                        {{ $result['result'] }}
                                                    </span>
                                                    &nbsp;
                                                    <span style="border:1px solid #000;">
                                                        {{ $result['component']['unit'] }}
                                                    </span>

                                                </td>
                                            @endif
                                        @endif
                                    @endforeach
                                    <td width="30%">
                                        @foreach ($test['results'] as $result)
                                            @if (isset($result['component']))
                                            <!-- Class c -->
                                                @if ($result['component']['id'] == 11126)
                                                    {{-- <td width="15%"> --}}
                                                    <span style="border:1px solid #000;">
                                                        {{ $result['component']['name'] }}
                                                    </span>
                                                    &nbsp;
                                                    <span style="border:1px solid #000;">
                                                        {{ $result['result'] }}
                                                    </span>
                                                    &nbsp;
                                                    <span style="border:1px solid #000;">

                                                        {{ $result['component']['unit'] }}
                                                    </span>
                                                @endif
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                                
                            @elseif($result['component']['id'] == 11120)
                            <!-- Immotile -->
                                <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                    <td width="40%"><b>{{ $result['component']['name'] }}</b></td>
                                    <td width="15%">
                                        <span style="border:1px solid #000;">
                                            {{ $result['result'] }}
                                        </span>
                                        &nbsp;
                                        <span style="border:1px solid #000;">
                                            %
                                        </span>
                                    </td>
                                    @foreach ($test['results'] as $result)
                            <!-- total_Immotile -->
                                        @if (isset($result['component']))
                                            @if ($result['component']['id'] == 11123)
                                                <td width="15%">
                                                    <span style="border:1px solid #000;">
                                                        {{ $result['result'] }}
                                                    </span>
                                                    &nbsp;
                                                    <span style="border:1px solid #000;">
                                                        {{ $result['component']['unit'] }}
                                                    </span>

                                                </td>
                                            @endif
                                        @endif
                                    @endforeach
                                    <td colspan="1" width="30%">
                                        @foreach ($test['results'] as $result)
                                            @if (isset($result['component']))
                        <!-- Class D -->
                                                @if ($result['component']['id'] == 11127)
                                                    {{-- <td width="15%"> --}}
                                                    <span style="border:1px solid #000;">
                                                        {{ $result['component']['name'] }}
                                                    </span>
                                                    &nbsp;
                                                    <span style="border:1px solid #000;">
                                                        {{ $result['result'] }}
                                                    </span>
                                                    &nbsp;
                                                    <span style="border:1px solid #000;">

                                                        {{ $result['component']['unit'] }}
                                                    </span>
                                                @endif
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                            @elseif($result['component']['id'] == 3056)
                            @endif
                        @endif
                    @endforeach
                </tbody>
            </table>
            <div width="40%" style="margin-top: -150px;float: right;">
            <!-- Class A == 11124 -->
            <!-- Class B == 11125 -->
            <!-- Class C == 11126 -->
            <!-- Class D == 11127 -->
                @php
                    foreach ($test['results'] as $result) {
                        
                        if (isset($result['component']) && $result['result'] != null) {
                            if ($result['component']['id'] == 11124) {
                                $val1 = $result['result'];
                            }
                        
                            if ($result['component']['id'] == 11125) {
                                $val2 = $result['result'];
                            }
                        
                            if ($result['component']['id'] == 11126) {
                                $val3 = $result['result'];
                            }
                        
                            if ($result['component']['id'] == 11127) {
                                $val4 = $result['result'];
                            }
                        }
                    }
                    if (isset($val1) && isset($val2) && isset($val3) && isset($val4)) {
                        $chart2 = new QuickChart([
                            'width' => 300,
                            'height' => 200,
                        ]);

                        // $obj = array('type' => "pie", array('labels' => )  )

                        $chart2->setConfig("{
                type: 'bar',
                data: {
                    labels: [ 'Class A' , 'Class B' , 'Class C' , 'Class D'],
                    datasets: [{
                    label: [ 'Class A' , 'Class B' , 'Class C' , 'Class D'],
                    data: [ $val1 , $val2 , $val3 , $val4 ]
                    }]
                }
                }");
                    }
                @endphp
                @if (isset($val1) && isset($val2) && isset($val3) && isset($val4))
                    <img src="{{ $chart2->getUrl() }}" style="margin-left:70px" width="80%" align="right">
                @endif
            </div>

        </div>
        <div style="clear:both"></div>
    </div>
</div>
<div style="border:5px solid #ddd;padding:10px">
    <div class="dis">
        <table width="60%" style="float: left">
            <thead>
                <tr>
                    <th colspan="4" align="center"
                        style="background-color: blue ; color:#fff ; font-size:20px;font-weight: bold">
                        Morphology Analysis
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($test['results'] as $result)
                    @if (isset($result['component']) && $result['result'] != null)
                    <!-- Normal Forms == 11129 -->
                        @if ($result['component']['id'] == 11129)
                            <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                <td>
                                    {{-- Normal Form % --}}
                                    {{ $result['component']['name'] }} %
                                </td>
                                <td>
                                    <input type="text" value="{{ $result['result'] }}">
                                </td>

                                <td>
                                    %
                                </td>
                                @foreach ($test['results'] as $result)
                                    @if (isset($result['component']))
                                        @if ($result['component']['id'] == 11129)
                                            <td>
                                                @if ($result['component']['id'] == 11138)
                                                    <input type="text"
                                                        value="
                                        {{ $result['result'] . ' ' . $result['component']['unit'] }}">
                                                @endif
                                        @endif
                                        </td>
                                    @endif
                                @endforeach

                            </tr>
                            <!-- Abnormal Neck == 11131 -->
                            <!-- Abnormal Tail == 11132 -->
                            <!-- Normal Forms == 11129 -->
                            <!-- Abnormal Head == 11130 -->
                        @elseif($result['component']['id'] == 11130)
                            <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                <td>
                                    {{-- Normal Form % --}}
                                    {{ $result['component']['name'] }} %
                                </td>
                                <td>
                                    <input type="text" value="{{ $result['result'] }}">
                                </td>

                                <td>
                                    %
                                </td>

                                @foreach ($test['results'] as $result)
                                @if (isset($result['component']))
                                    @if ($result['component']['id'] == 11129)
                                        <td>
                                            @if ($result['component']['id'] == 11138)
                                                <input type="text"
                                                    value="
                                    {{ $result['result'] . ' ' . $result['component']['unit'] }}">
                                            @endif
                                    @endif
                                    </td>
                                @endif
                            @endforeach
                            </tr>
                            
                        @elseif($result['component']['id'] == 11131)
                            <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                <td>
                                    {{-- Normal Form % --}}
                                    {{ $result['component']['name'] }} %
                                </td>
                                <td>
                                    <input type="text" value="{{ $result['result'] }}">
                                </td>

                                <td>
                                    %
                                </td>

                                <td>
                                    <input type="text"
                                        value="{{ $result['result'] . ' ' . $result['component']['unit'] }}">
                                </td>
                            </tr>
                        @elseif($result['component']['id'] == 11129)
                            <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                <td>
                                    {{-- Normal Form % --}}
                                    {{ $result['component']['name'] }} %
                                </td>
                                <td>
                                    <input type="text" value="{{ $result['result'] }}">
                                </td>

                                <td>
                                    %
                                </td>

                                <td>
                                    <input type="text"
                                        value="{{ $result['result'] . ' ' . $result['component']['unit'] }}">
                                </td>
                            </tr>
                            
                        @elseif($result['component']['id'] == 11132)
                            <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                <td>
                                    {{-- Normal Form % --}}
                                    {{ $result['component']['name'] }} %
                                </td>
                                <td>
                                    <input type="text" value="{{ $result['result'] }}">
                                </td>

                                <td>
                                    %
                                </td>

                                <td>
                                    <input type="text"
                                        value="{{ $result['result'] . ' ' . $result['component']['unit'] }}">
                                </td>
                            </tr>
                        @endif
                    @endif
                @endforeach
            </tbody>
        </table>
        <div style="margin-top: -120px;float: right;margin-bottom: 25px" width="40%">
        <!-- Normal Forms == 11129 -->
        <!-- Abnormal Head == 11130 -->
        <!-- Abnormal Neck == 11131 -->
        <!-- Abnormal Tail  == 127081 -->
            @php
                foreach ($test['results'] as $result) {
                    if (isset($result['component']) && $result['result'] != null) {
                        
                        if ($result['component']['id'] == 11129) {
                            $val1 = $result['result'];
                        }
                        
                        if ($result['component']['id'] == 11130) {
                            $val2 = $result['result'];
                        }
                        
                        if ($result['component']['id'] == 11131) {
                            $val3 = $result['result'];
                        }
                        
                        if ($result['component']['id'] == 127081) {
                            $val4 = $result['result'];
                        }
                    }
                }
                if (isset($val1) && isset($val2) && isset($val3) && isset($val4)) {
                    $chart2 = new QuickChart([
                        'width' => 300,
                        'height' => 200,
                    ]);
                    $chart2->setConfig("{
            type: 'bar',
            data: {
                labels: ['Normal','Head' , 'Neck' , 'Tail'],
                datasets: [{
                label: ['Normal','Head' , 'Neck' , 'Tail'],
                data: [$val1, $val2 , $val3 , $val4]
                }]
            }
            }");
                }
            @endphp
            @if (isset($val1) && isset($val2) && isset($val3) && isset($val4))
                <img src="{{ $chart2->getUrl() }}" style="margin-left:70px" width="80%" align="right">
            @endif
        </div>
    </div>
    <div class="" width="100%">
        <img src="{{ url('uploads/semen/Static-top.jpg') }}" width="100%" alt="">
    </div>
    <div style="margin-top: 10px">
        <div class="" width="20%" style="float: left;margin-left: 10px">
            <img src="{{ url('uploads/semen/static-left.jpg') }}" width="100%" style="height: 200px"
                alt="">
        </div>
        <div class="" width="38%" style="float:left;margin-left: 10px">
            @if (isset($group->images[1]))
                <img src="{{ url('uploads/semen/' . $group->images[1]->image_name) }}" style="height: 180px"
                    width="100%">
            @endif
        </div>

        <div class="" width="38%" style="float: right;margin-left: 10px">
            @if (isset($group->images[2]))
                <img src="{{ url('uploads/semen/' . $group->images[2]->image_name) }}" style="height: 180px"
                    width="100%">
            @endif
        </div>
    </div>
</div>
</div>
<!-- Comment -->

@if (isset($test['comment']))
    <br>
    <table class="comment" width="100%">
        <tbody>
            <tr>
                <td width="12px" nowrap="nowrap"><b>Comment:</b></td>
                <td class="comment">
                    {!! str_replace("\n", '<br />', $test['comment']) !!}
                </td>
            </tr>
        </tbody>
    </table>
@endif
</div>
