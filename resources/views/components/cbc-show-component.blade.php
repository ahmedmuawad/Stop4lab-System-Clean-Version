<div>
    <table width="100%">
        <thead>
            <tr>
                <td class="theadcbc">Test</td>
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
                    @if (
                        \Str::slug($result['component']['name']) == "lymphocytes" ||
                        \Str::slug($result['component']['name']) == "monocytes" ||
                        \Str::slug($result['component']['name']) == "eosinophils" ||
                        \Str::slug($result['component']['name']) == "basophils" ||
                        \Str::slug($result['component']['name']) == "neutrophil" ||
                        \Str::slug($result['component']['name']) == "segment" ||
                        \Str::slug($result['component']['name']) == "band" ||
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

                                {!! $result['comment'] !!}
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
                                <td>{{ $result['component']['name'] }}
                                </td>
                                <td>{{ $result['result'] }}
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

                                <td>{{ $result['result'] }}</td>
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
</div>
