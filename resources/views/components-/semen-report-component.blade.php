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
                    @foreach ($test['results'] as $result)
                        @if (isset($result['component']))
                            @if ($result['component']['id'] == 1494)
                                <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                    <td><b>{{ $result['component']['name'] }}</b></td>
                                    <td><b>{{ $result['result'] }}</b></td>
                                    <td><b> {!! $result['comment'] !!}</b></td>

                                </tr>
                            @elseif($result['component']['id'] == 1495)
                                <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                    <td><b>{{ $result['component']['name'] }}</b></td>
                                    <td><b>{{ $result['result'] }}</b></td>
                                    <td><b> {!! $result['comment'] !!}</b></td>

                                </tr>
                            @elseif($result['component']['id'] == 1497)
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
                            @elseif($result['component']['id'] == 127060)
                                <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                    <td><b>{{ $result['component']['name'] }}</b></td>
                                    <td><b>{{ $result['result'] }}</b></td>
                                    <td><b> {!! $result['comment'] !!}</b></td>

                                </tr>
                            @elseif($result['component']['id'] == 127061)
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
                    @foreach ($test['results'] as $result)
                        @if (isset($result['component']))
                            @if ($result['component']['id'] == 127062)
                                <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                    <td><b>{{ $result['component']['name'] }}</b></td>
                                    <td><b>{{ $result['result'] }}</b></td>
                                    <td><b>{!! $result['comment'] !!}</b></td>
                                </tr>
                            @elseif($result['component']['id'] == 127063)
                                <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                    <td><b>{{ $result['component']['name'] }}</b></td>
                                    <td><b>{{ $result['result'] }}</b></td>
                                    <td><b>{!! $result['comment'] !!}</b></td>

                                </tr>
                            @elseif($result['component']['id'] == 127064)
                                <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                    <td><b>{{ $result['component']['name'] }}</b></td>
                                    <td><b>{{ $result['result'] }}</b></td>
                                    <td><b>{!! $result['comment'] !!}</b></td>

                                </tr>
                            @elseif($result['component']['id'] == 127065)
                                <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                    <td><b>{{ $result['component']['name'] }}</b></td>
                                    <td><b>{{ $result['result'] }}</b></td>
                                    <td><b>{!! $result['comment'] !!}</b></td>

                                </tr>
                            @elseif($result['component']['id'] == 127066)
                                <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                    <td><b>{{ $result['component']['name'] }}</b></td>
                                    <td><b>{{ $result['result'] }}</b></td>
                                    <td><b>{!! $result['comment'] !!}</b></td>

                                </tr>
                            @elseif($result['component']['id'] == 127067)
                                <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                    <td><b>{{ $result['component']['name'] }}</b></td>
                                    <td><b>{{ $result['result'] }}</b></td>
                                    <td><b>{!! $result['comment'] !!}</b></td>

                                </tr>
                            @elseif($result['component']['id'] == 127068)
                                <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                    <td><b>{{ $result['component']['name'] }}</b></td>
                                    <td><b>{{ $result['result'] }}</b></td>
                                    <td><b>{!! $result['comment'] !!}</b></td>

                                </tr>
                            @elseif($result['component']['id'] == 127069)
                                <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                    <td><b>{{ $result['component']['name'] }}</b></td>
                                    <td><b>{{ $result['result'] }}</b></td>
                                    <td><b>{!! $result['comment'] !!}</b></td>

                                </tr>
                            @elseif($result['component']['id'] == 127070)
                                <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                    <td><b>{{ $result['component']['name'] }}</b></td>
                                    <td><b>{{ $result['result'] }}</b></td>
                                    <td><b>{!! $result['comment'] !!}</b></td>

                                </tr>
                            @elseif($result['component']['id'] == 127071)
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
                        @if (isset($result['component']))
                            @if ($result['component']['id'] == 1504)
                                <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                    <td colspan="2"><b>{{ $result['component']['name'] }}</b></td>
                                    <td colspan="1">
                                        <b>{{ $result['result'] }}</b>
                                    </td>
                                    <td>
                                        
                                        {{ str_replace(['<p>' , '</p>', '<b>' , '</b>' , '<br>'] , '',$result['comment']) }}
                                    </td>
                                </tr>
                            @elseif($result['component']['id'] == 127072)
                                <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                    <td colspan="2"><b>{{ $result['component']['name'] }}</b></td>
                                    <td colspan="1">
                                        <b>{{ $result['result'] }}</b>
                                    </td>
                                    <td>
                                       {{ str_replace(['<p>' , '</p>', '<b>' , '</b>' , '<br>'] , '',$result['comment']) }}
                                    </td>

                                </tr>
                            @elseif($result['component']['id'] == 127073)
                                <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                    <td colspan="2"><b>{{ $result['component']['name'] }}</b></td>
                                    <td colspan="1">
                                        <b>{{ $result['result'] }}</b>
                                    </td>
                                    <td>
                                        {{ str_replace(['<p>' , '</p>', '<b>' , '</b>' , '<br>'] , '',$result['comment']) }}
                                    </td>

                                </tr>
                            @elseif($result['component']['id'] == 127074)
                                <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                    <td colspan="2"><b>{{ $result['component']['name'] }}</b></td>
                                    <td colspan="1">
                                        <b>{{ $result['result'] }}</b>
                                    </td>
                                    <td>
                                         {{ str_replace(['<p>' , '</p>', '<b>' , '</b>' , '<br>'] , '',$result['comment']) }}
                                    </td>

                                </tr>
                            @elseif($result['component']['id'] == 127075)
                                <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                    <td colspan="2"><b>{{ $result['component']['name'] }}</b></td>
                                    <td>
                                         <b>{{ $result['result'] }}</b>
                                    </td>
                                    <td>
                                        {{ str_replace(['<p>' , '</p>', '<b>' , '</b>' , '<br>'] , '',$result['comment']) }}
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
    <div width="40%" style="float: right">
        <div style="margin-top: 0px" align="center">
            @if (isset($group->images[0]))
                <img src="{{ url('uploads/semen/' . $group->images[0]->image_name) }}"
                    style="height: 200px; width: 270px;" width="100%">
            @endif
        </div>
        <div style="margin-top: 50px" align="center">
            @php
                
                foreach ($test['results'] as $result) {
                    if (isset($result['component'])) {
                        if ($result['component']['id'] == 127064) {
                            $val1 = $result['result'];
                        }
                
                        if ($result['component']['id'] == 127076) {
                            $val2 = $result['result'];
                        }
                
                        if ($result['component']['id'] == 127077) {
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
    <br>
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
                        @if (isset($result['component']))
                            @if ($result['component']['id'] == 127064)
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
                                            @if ($result['component']['id'] == 127086)
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
                                                @if ($result['component']['id'] == 127082)
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
                                                @if ($result['component']['id'] == 127083)
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
                            @elseif($result['component']['id'] == 127076)
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
                                            @if ($result['component']['id'] == 127087)
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
                                                @if ($result['component']['id'] == 127084)
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
                            @elseif($result['component']['id'] == 127077)
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
                                            @if ($result['component']['id'] == 127088)
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
                                                @if ($result['component']['id'] == 127085)
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
                @php
                    foreach ($test['results'] as $result) {
                        if (isset($result['component'])) {
                            if ($result['component']['id'] == 127082) {
                                $val1 = $result['result'];
                            }
                    
                            if ($result['component']['id'] == 127083) {
                                $val2 = $result['result'];
                            }
                    
                            if ($result['component']['id'] == 127084) {
                                $val3 = $result['result'];
                            }
                    
                            if ($result['component']['id'] == 127085) {
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
                    @if (isset($result['component']))
                        @if ($result['component']['id'] == 127078)
                            <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                <td>
                                    {{-- Normal Form % --}}
                                    {{ $result['component']['name'] }} %
                                </td>
                                <td>
                                    <input type="text" value="{{ $result['result'] }}">
                                </td>
                                @foreach ($test['results'] as $result)
                                    @if (isset($result['component']))
                                        @if ($result['component']['id'] == 1522)
                                            <td>
                                                {{ $result['component']['name'] }}%
                                            </td>
                                            <td>
                                                <input type="text"
                                                    value="
                                        {{ $result['result'] . ' ' . $result['component']['unit'] }}">
                                            </td>
                                        @endif
                                    @endif
                                @endforeach

                            </tr>
                        @elseif($result['component']['id'] == 127079)
                            <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                <td>
                                    {{-- Normal Form % --}}
                                    {{ $result['component']['name'] }} %
                                </td>
                                <td>
                                    <input type="text" value="{{ $result['result'] }}">
                                </td>



                                @foreach ($test['results'] as $result)
                                    @if (isset($result['component']))
                                        @if ($result['component']['id'] == 127097)
                                            <td>
                                                {{ $result['component']['name'] }}%
                                            </td>
                                            <td>
                                                <input type="text"
                                                    value="
                                    {{ $result['result'] . ' ' . $result['component']['unit'] }}">
                                            </td>
                                        @endif
                                    @endif
                                @endforeach

                            </tr>
                        @elseif($result['component']['id'] == 127080)
                            <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                <td>
                                    {{-- Normal Form % --}}
                                    {{ $result['component']['name'] }} %
                                </td>
                                <td>
                                    <input type="text" value="{{ $result['result'] }}">
                                </td>



                                @foreach ($test['results'] as $result)
                                    @if (isset($result['component']))
                                        @if ($result['component']['id'] == 127098)
                                            <td>
                                                {{ $result['component']['name'] }} %
                                            </td>
                                            <td>
                                                <input type="text"
                                                    value="
                                {{ $result['result'] . ' ' . $result['component']['unit'] }}">
                                            </td>
                                        @endif
                                    @endif
                                @endforeach

                            </tr>
                        @elseif($result['component']['id'] == 127081)
                            <tr style="background-color: #b3adad ; color:#fff; padding:2px;margin:2px ">
                                <td>
                                    {{-- Normal Form % --}}
                                    {{ $result['component']['name'] }} %
                                </td>
                                <td>
                                    <input type="text" value="{{ $result['result'] }}">
                                </td>



                                @foreach ($test['results'] as $result)
                                    @if (isset($result['component']))
                                        @if ($result['component']['id'] == 127099)
                                            <td>
                                                {{ $result['component']['name'] }}
                                            </td>
                                            <td>
                                                <input type="text"
                                                    value="
                                {{ $result['result'] . ' ' . $result['component']['unit'] }}">
                                            </td>
                                        @endif
                                    @endif
                                @endforeach

                            </tr>
                        @endif
                    @endif
                @endforeach
            </tbody>
        </table>
        <div style="margin-top: -140px;float: right" width="40%">
            @php
                foreach ($test['results'] as $result) {
                    if (isset($result['component'])) {
                        if ($result['component']['id'] == 127078) {
                            $val1 = $result['result'];
                        }
                
                        if ($result['component']['id'] == 127079) {
                            $val2 = $result['result'];
                        }
                
                        if ($result['component']['id'] == 127080) {
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
