<div>
    <div class="row">
        <div @if (isset(setting('medical')['histogram_status'] ) && setting('medical')['histogram_status'] ) class="tleftcbc" @else class=" tleftcbc_noFig " @endif >
            <table width="100%">
                <thead class="test_head" style="color:{{ $test['setting']['test_head']['color']  }};text-align:{{ $test['setting']['test_head']['text-align']  }};font-size:{{ $test['setting']['test_head']['font-size']}};padding:{{ $test['setting']['test_head']['height']}}; }}">
                    <tr class="test_head">
                        <td style="color:{{ $test['setting']['test_head']['color']  }};text-align:{{ $test['setting']['test_head']['text-align']  }};font-size:{{ $test['setting']['test_head']['font-size']}};padding:{{ $test['setting']['test_head']['height']}};" class="theadtest" >Test </td>
                        <td style="color:{{ $test['setting']['test_head']['color']  }};text-align:{{ $test['setting']['test_head']['text-align']  }};font-size:{{ $test['setting']['test_head']['font-size']}};padding:{{ $test['setting']['test_head']['height']}};" class="theadtest" >Result</td>
                       @if(isset($test['setting']['show_unit']) && $test['setting']['show_unit'] == true ) <td style="color:{{ $test['setting']['test_head']['color']  }};text-align:{{ $test['setting']['test_head']['text-align']  }};font-size:{{ $test['setting']['test_head']['font-size']}};padding:{{ $test['setting']['test_head']['height']}};" class="theadtest" >Unit</td> @endif
                       @if(isset($test['setting']['show_status']) && $test['setting']['show_status'] == true ) <td style="color:{{ $test['setting']['test_head']['color']  }};text-align:{{ $test['setting']['test_head']['text-align']  }};font-size:{{ $test['setting']['test_head']['font-size']}};padding:{{ $test['setting']['test_head']['height']}};" class="theadtest" >Status</td> @endif
                       @if(isset($test['setting']['show_range']) && $test['setting']['show_range'] == true ) <td style="color:{{ $test['setting']['test_head']['color']  }};text-align:{{ $test['setting']['test_head']['text-align']  }};font-size:{{ $test['setting']['test_head']['font-size']}};padding:{{ $test['setting']['test_head']['height']}};" class="theadtest" >Normal Range</td> @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($test['results'] as $result)
                        @if (isset($result['component']))
                            @if (
                                \Str::slug($result['component']['name']) == "lymphocytes" ||
                                \Str::slug($result['component']['name']) == "monocytes" ||
                                \Str::slug($result['component']['name']) == "eosinophils" ||
                                \Str::slug($result['component']['name']) == "basophils" ||
                                \Str::slug($result['component']['name']) == "neutrophil" ||
                                \Str::slug($result['component']['name']) == "segment" ||
                                \Str::slug($result['component']['name']) == "band" ||
                                \Str::slug($result['component']['name']) == "lic" ||
                                \Str::slug($result['component']['name']) == "a-lic" ||
                                \Str::slug($result['component']['name']) == "aly" ||
                                \Str::slug($result['component']['name']) == "a-lymphocytes" ||
                                \Str::slug($result['component']['name']) == "a-monocytes" ||
                                \Str::slug($result['component']['name']) == "a-eosinophils" ||
                                \Str::slug($result['component']['name']) == "a-basophils" ||
                                \Str::slug($result['component']['name']) == "a-neutrophil" ||
                                \Str::slug($result['component']['name']) == "a-segment" ||
                                \Str::slug($result['component']['name']) == "a-band" ||
                                \Str::slug($result['component']['name']) == "wbcs-differential" ||
                                \Str::slug($result['component']['name']) == "relative-count" ||
                                \Str::slug($result['component']['name']) == "absolute-count" 
                                )
                            @else
                                <tr>
                                    <td style="color:{{ $test['setting']['test_name']['color']  }};text-align:{{ $test['setting']['test_name']['text-align']  }};font-size:{{ $test['setting']['test_name']['font-size']}};padding:{{ $test['setting']['test_name']['height']}};" class="tdtest test_name">
                                        @if($result['component']['title'])
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ $result['component']['name'] }}
                                        @elseif(
                                            \Str::slug($result['component']['name']) == "plateletplt" ||
                                            \Str::slug($result['component']['name']) == "platelet-count-plt" ||
                                            \Str::slug($result['component']['name']) == "hgbhemoglobin" ||
                                            \Str::slug($result['component']['name']) == "rbcs"||
                                            \Str::slug($result['component']['name']) == "wbcs-leukocytes" 
                                        )
                                            <b>{{ $result['component']['name'] }}</b>
                                        @else
                                            {{ $result['component']['name'] }}
                                        @endif
                                
                                    </td>
                                    <td
                                        
                                        @if ($result['status'] != 'Normal' && $result['status'] != null && isset($test['setting']['highlite']) && $test['setting']['highlite'] == true  ) 
                                            class="tdtest result  tdtest_status" 
                                        @else 
                                            style="color:{{ $test['setting']['result']['color']  }};text-align:{{ $test['setting']['result']['text-align']  }};font-size:{{ $test['setting']['result']['font-size']}};padding:{{ $test['setting']['result']['height']}};"
                                        @endif
                                        >
                                        {{ $result['result'] }}
                                        @if ($result['status'] == 'High' || $result['status'] == 'Critical high')
                                            <span>&#8593;</span>
                                        @elseif($result['status'] == 'Low' || $result['status'] == 'Critical low')
                                            <span>&#8595;</span>
                                        @endif
                                    </td>

                                    @if(isset($test['setting']['show_unit']) && $test['setting']['show_unit'] == true )
                                        <td style="color:{{ $test['setting']['unit']['color']  }};text-align:{{ $test['setting']['unit']['text-align']  }};font-size:{{ $test['setting']['unit']['font-size']}};padding:{{ $test['setting']['unit']['height']}};" class="tdtest unit">
                                            {{ $result['component']['unit'] }}
                                        </td>
                                    @endif
                                    
                                    @if(isset($test['setting']['show_status']) && $test['setting']['show_status'] == true ) 
                                        <td style="color:{{ $test['setting']['status']['color']  }};text-align:{{ $test['setting']['status']['text-align']  }};font-size:{{ $test['setting']['status']['font-size']}};padding:{{ $test['setting']['status']['height']}};" class="tdtest status" >
                                            {{ $result['status'] }} @if ($result['status'] == 'High' || $result['status'] == 'Critical high')
                                                <span>&#8593;</span>
                                            @elseif($result['status'] == 'Low' || $result['status'] == 'Critical low')
                                                <span>&#8595;</span>
                                            @endif
                                        </td>
                                    @endif
                                    
                                    @if(isset($test['setting']['show_range']) && $test['setting']['show_range'] == true )
                                        <td style="color:{{ $test['setting']['reference_range']['color']  }};text-align:{{ $test['setting']['reference_range']['text-align']  }};font-size:{{ $test['setting']['reference_range']['font-size']}};padding:{{ $test['setting']['reference_range']['height']}};" class="tdtest reference_range">
                                            {!! $result['comment'] !!}
                                        </td>
                                    @endif


                                </tr>
                            @endif
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>

        @if (isset(setting('medical')['histogram_status'] ) && setting('medical')['histogram_status'] )
            @if (isset(setting('medical')['histogram_conection'] ) && setting('medical')['histogram_conection'] == "device" )
                <x-fig-component :test="$test" />
            @else
                <x-histo-gram-component :test="$test" :group="$group" />
            @endif
        @endif
        
    </div>

    <div class="tleft">
        <table>
            <thead class="test_head">
                <tr>
                    <td class="relativeh" width="25%">Test</td>
                    <td class="relativeh" width="35%">Relative Count %</td>
                    <td class="relativeh" width="40%">Normal Range</td>
                </tr>
            </thead>
            @foreach ($test['results'] as $result)
                @if (isset($result['component']))
                    @if (
                            (\Str::slug($result['component']['name']) == "lymphocytes" ||
                            \Str::slug($result['component']['name']) == "monocytes" ||
                            \Str::slug($result['component']['name']) == "eosinophils" ||
                            \Str::slug($result['component']['name']) == "basophils" ||
                            \Str::slug($result['component']['name']) == "neutrophil" ||
                            \Str::slug($result['component']['name']) == "segment" ||
                            \Str::slug($result['component']['name']) == "lic" ||
                            \Str::slug($result['component']['name']) == "aly" ||
                            \Str::slug($result['component']['name']) == "band")
                            && $result['component']['title'] == 0
                        )
                        <tbody>
                            <tr>
                                <td class="tdtest">
                                    @if (\Str::slug($result['component']['name']) == "segment" || \Str::slug($result['component']['name']) == "band")
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        {{ $result['component']['name'] }}
                                    @else
                                        {{ $result['component']['name'] }}
                                    @endif
                                </td>
                                <td @if ($result['status'] != 'Normal' && $result['status'] != null && isset($test['setting']['highlite']) && $test['setting']['highlite'] == true) class="tdtest_status" @endif>
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
                        @if (
                            (\Str::slug($result['component']['name']) == "a-lymphocytes" ||
                            \Str::slug($result['component']['name']) == "a-monocytes" ||
                            \Str::slug($result['component']['name']) == "a-eosinophils" ||
                            \Str::slug($result['component']['name']) == "a-basophils" ||
                            \Str::slug($result['component']['name']) == "a-neutrophil" ||
                            \Str::slug($result['component']['name']) == "a-segment" ||
                            \Str::slug($result['component']['name']) == "a-lic" ||
                            \Str::slug($result['component']['name']) == "a-band")
                            && $result['component']['title'] == 0
                            )
                            <tr>

                                <td @if ($result['status'] != 'Normal' && $result['status'] != null && isset($test['setting']['highlite']) && $test['setting']['highlite'] == true) class="tdtest_status" @endif>
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
                    <td width="12px" nowrap="nowrap"><b>Comment:</b></td>
                    <td class="commentb">
                        {!! str_replace("<p><br></p>", '<br>', $test['comment']) !!}
                    </td>
                </tr>
            </tbody>
        </table>
    @endif
    <!-- /comment -->
    <!--/ end CBC Report ID 473-->
</div>