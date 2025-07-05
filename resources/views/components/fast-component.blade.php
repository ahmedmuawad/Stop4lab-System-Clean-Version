<div>
    {{-- <div width="60%" style="float:left">
        <div class="dis">
            <div class="heading">
                <h2 align="left" style="font-size:20px;font-weight: bold;text-decoration: underline;margin-top: 0">
                    GLUCOSE TOLERANCE CURVE
                </h2>
            </div>
            <div class="" style="float: left;" width="60%;">
                @foreach ($test['results'] as $result)
                    @if ($result['component']['name'] == 'Fasting B. Glucose')
                        <div class="" style="margin-left: 20px;margin-top: 0" width="100%">
                            <div style="float: left">
                                <span align="left">
                                    <b> {{ $result['component']['name'] }}</b>
                                </span>
                                <span class="" align="center">
                                    :
                                </span>

                                <span align="right" style="margin-top:0px" width="15%">
                                    {{ $result['result'] }}
                                    &nbsp;
                                    &nbsp;
                                    &nbsp;
                                    {{ $result['component']['unit'] }}
                                    &nbsp;
                                    &nbsp;
                                    &nbsp;
                                    {{ $result['status'] }}

                                </span>
                            </div>

                            <div style="float: right">
                            </div>
                        </div>
                    @endif
                @endforeach
                <div style="clear: both"></div>
                @foreach ($test['results'] as $result)
                    @if ($result['component']['name'] == '60 min')
                        <div class="" style="margin-left: 20px;margin-top: 0" width="100%">
                            <div style="float: left">
                                <span align="left">
                                    <b> {{ $result['component']['name'] }}</b>
                                </span>
                                <span class="" align="center">
                                    :
                                </span>

                                <span align="right" style="margin-top:0px" width="15%">
                                    {{ $result['result'] }}
                                    &nbsp;
                                    &nbsp;
                                    &nbsp;
                                    {{ $result['component']['unit'] }}
                                    &nbsp;
                                    &nbsp;
                                    &nbsp;
                                    {{ $result['status'] }}

                                </span>
                            </div>

                            <div style="float: right">


                            </div>
                        </div>
                    @endif
                @endforeach

                <div style="clear: both"></div>
                @foreach ($test['results'] as $result)
                    @if ($result['component']['name'] == '120 min')
                        <div class="" style="margin-left: 20px;margin-top: 0" width="100%">
                            <div style="float: left">
                                <span align="left">
                                    <b> {{ $result['component']['name'] }}</b>
                                </span>
                                <span class="" align="center">
                                    :
                                </span>

                                <span align="right" style="margin-top:0px" width="15%">
                                    {{ $result['result'] }}
                                    &nbsp;
                                    &nbsp;
                                    &nbsp;
                                    {{ $result['component']['unit'] }}
                                    &nbsp;
                                    &nbsp;
                                    &nbsp;
                                    {{ $result['status'] }}

                                </span>
                            </div>

                            <div style="float: right">

                      
                            </div>
                        </div>
                    @endif
                @endforeach
                <div style="clear: both"></div>
                @foreach ($test['results'] as $result)
                    @if ($result['component']['name'] == '180 min')
                        <div class="" style="margin-left: 20px;margin-top: 0" width="100%">
                            <div style="float: left">
                                <span align="left" width="70%">
                                    <b> {{ $result['component']['name'] }}</b>
                                </span>
                                <span class="" align="center">
                                    :
                                </span>

                                <span align="right" style="margin-top:0px" width="15%">
                                    {{ $result['result'] }}
                                    &nbsp;
                                    &nbsp;
                                    &nbsp;
                                    {{ $result['component']['unit'] }}
                                    &nbsp;
                                    &nbsp;
                                    &nbsp;
                                    {{ $result['status'] }}

                                </span>
                            </div>

                            <div style="float: right">

                            </div>
                        </div>
                    @endif
                @endforeach
            </div>


        </div>
    </div> --}}
    {{-- <div width="40%" style="float: right">

        <h2 align="left" style="font-size:20px;font-weight: bold;text-decoration: underline;margin-top:0">
            Reference Range :
        </h2>
        <div class="" style="float: left;" width="50%;">
            @foreach ($test['results'] as $result)
                @if ($result['component']['name'] == 'Fasting B. Glucose')
                    <div class="" style="float: left;margin-left: 40px" width="40%" align="left">
                        <b>
                            {{ str_replace(['<p>', '</p>', '<br>'], '', $result['component']['reference_range']) }}</b>
                    </div>
                @endif
            @endforeach
            <div style="clear: both"></div>
            @foreach ($test['results'] as $result)
                @if ($result['component']['name'] == '60 min')
                    <div class="" style="float: left;margin-left: 40px" width="40%" align="left">
                        <b>
                            {{ str_replace(['<p>', '</p>', '<br>'], '', $result['component']['reference_range']) }}</b>

                    </div>
                @endif
            @endforeach

            <div style="clear: both"></div>
            @foreach ($test['results'] as $result)
                @if ($result['component']['name'] == '120 min')
                    <div class="" style="float: left;margin-left: 40px" width="40%" align="left">
                        <b>
                            {{ str_replace(['<p>', '</p>', '<br>'], '', $result['component']['reference_range']) }}</b>

                    </div>
                @endif
            @endforeach
            <div style="clear: both"></div>
            @foreach ($test['results'] as $result)
                @if ($result['component']['name'] == '180 min')
                    <div class="" style="float: left;margin-left: 40px" width="40%" align="left">
                        <b>
                            {{ str_replace(['<p>', '</p>', '<br>'], '', $result['component']['reference_range']) }}</b>

                    </div>
                @endif
            @endforeach
        </div>

        <div style="margin-top: 0px" align="center">
            @if (isset($group->images[0]))
                <img src="{{ url('uploads/semen/' . $group->images[0]->image_name) }}"
                    style="height: 200px; width: 270px;" width="100%">
            @endif
        </div> --}}
        <div style="margin-top: 50px" align="center">
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
                $fal = false;
                if (isset($val1) && isset($val2) && isset($val3)) {
                    $chart2->setConfig("{
            type: 'line',
            
            data: {
                labels: ['January', 'February', 'March', 'April'],
                datasets: [{
                data: [$val1 ,$val2 , $val3 , $val4],
                borderColor: 'rgb(255, 99, 132)',
                fill:'0'
                }]
            }
            }");
                }
            @endphp
            @if (isset($val1) && isset($val2) && isset($val3))
                <img src="{{ $chart2->getUrl() }}" width="100%">
            @endif
        </div>


    {{-- </div>
</div>
<div style="clear:both"></div>
</div> --}}
