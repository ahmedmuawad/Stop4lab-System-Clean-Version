<div class="cont">
    <div class="">
        <table class="" style="border: unset" width="100%">
            <tr style="border: unset" width="100%">
                <td style="border: unset" width="33%">
                    Print_Date:
                    {{ Carbon\Carbon::now() }}
                </td>

                <td style="border: unset" width="33%" align="center">
                    <b>Job Order</b>
                </td>

                <td style="border: unset" width="33%" align="right">
                    <b>{{ setting('info')['name'] }}</b>
                </td>
            </tr>
        </table>

        <div class="tableWithBorder">
            <table style="border:unset;padding:15px" width="100%">
                <tr style="border: unset" width="100%">
                    <td style="border: unset" width="50%">

                        <b>User Name:</b>
                        {{ auth()->guard('admin')->user()->name }}
                    </td>
                    <td style="border: unset" width="50%" align="right">
                        <b>Date:</b>
                        <b>{{ Carbon\Carbon::now() }}</b>
                    </td>
                </tr>
            </table>
        </div>
        <div class="parientTable" width="100%" style="padding:10px">
            <div>
                <p style="float: left;margin-top:0" class="workData" align="left" width="50%">
                    Personal Data :
                </p>
                <p style="float: right;margin-top:-8px" align="right" width="50%">
                    {{ $group->patient->code }}
                </p>
            </div>

            <table style="border:unset;" width="50%">
                <tr style="border: unset">
                    <td style="border:unset" width="30%" align="left">
                        <b>Patient:</b>
                    </td>
                    <td style="border:unset" width="30%" align="center">
                        {{ $group->patient->code }}
                    </td>

                    <td style="border:unset" width="30%" align="right">
                        {{ $group->patient->name }}
                    </td>
                </tr>
            </table>

            {{-- {{dd($group)}} --}}
            <div style="clear:both"></div>
            <table style="float: left;border:unset" width="60%">
                <tr style="border:unset" width="100%">
                    <td width="10%" style="border:unset">
                        <b>Age:</b>
                    </td>

                    <td width="30%" style="border:unset">
                        @php $array = explode(" ",$group->patient->age); @endphp
                        {{-- {{dd($array)}} --}}
                        <input type="number" @if ($array[1] == 'Years') value="{{ $array[0] }}" @endif
                            style="width:30px;margin-left:10px;margin-right:10px">
                        -
                        <input type="number" @if ($array[1] == 'Months') value="{{ $array[0] }}" @endif
                            style="width:30px;margin-left:10px;margin-right:10px">

                        -
                        <input type="number" @if ($array[1] == 'Days') value="{{ $array[0] }}" @endif
                            style="width:30px;margin-left:10px;margin-right:10px">

                    </td>

                    <td width="10%" style="border:unset">
                        <b>Telephone:</b>
                    </td>

                    <td width="30%" style="border:unset">
                        {{ $group->patient->phone }}
                    </td>
                </tr>
                <tr style="border:unset">
                    <td width="10%" style="border:unset">
                        <b> Gender:</b>
                    </td>
                    <td width="40%" style="border:unset">
                        {{ $group->patient->gender }}
                    </td>

                    <td width="10%" style="border:unset">
                        <b>Mobile:</b>
                    </td>
                    <td width="40%" colspan="3" style="border:unset">
                        {{ $group->patient->phone2 }}
                    </td>
                </tr>
                <tr style="border:unset">
                    <td width="5%" style="border:unset">
                        <b>Address:</b>
                    </td>
                    <td width="95%" colspan="3" style="border:unset">
                        {{ $group->patient->address }}
                    </td>
                </tr>
                <tr style="border:unset">
                    <td width="10%" style="border:unsets">
                        <b>Doctor:</b>
                    </td>

                    <td width="40%" style="border:unsets">
                        @if (isset($group['doctor']))
                            Dr. {{ $group['doctor']['name'] }}
                        @elseif(isset($group['normalDoctor']))
                            Dr. {{ $group['normalDoctor']['name'] }}
                        @endif

                    </td>

                    <td width="10%" style="border:unsets">
                        <b>Rec Date</b>
                    </td>

                    <td width="40%" style="border:unsets">
                        {{ $group->retrieve_date }}
                    </td>

                </tr>
            </table>
            {{-- </div> --}}
            <div width="40%"
                style="margin-top:-120px;float: right;padding:20px;border:2px solid #000;border-radius: 20px"
                width="30%" align="right">
                <table style="border: unset">
                    <tr style="border: unset">
                        <td style="border: unset" width="40%">
                            <b>Total Cost:</b>
                        </td>
                        <td style="border: unset" width="40%">
                            <input type="number" value="{{ $group->total }}" width="40px">
                        </td>
                    </tr>

                    <tr style="border: unset">
                        <td style="border: unset" width="40%">
                            <b>Payed:</b>
                        </td>
                        <td style="border: unset" width="40%">
                            <input type="number" value="{{ $group->paid }}" width="40px">
                        </td>
                    </tr>

                    <tr style="border: unset">
                        <td style="border: unset" width="40%">
                            <b>Discount:</b>
                        </td>
                        <td style="border: unset" width="40%">
                            <input type="number" value="{{ $group->discount_value }}" width="40px">
                        </td>
                    </tr>
                    {{-- <hr> --}}
                    <tr style="border: unset">
                        <td style="border: unset" width="40%">
                            <b>Remains:</b>
                        </td>
                        <td style="border: unset" width="40%">
                            <input type="number"
                                value="{{ $group->total - ($group->paid + $group->discount_value) }}" width="40px">
                        </td>
                    </tr>
                </table>
            </div>

        </div>
        <div class="tableWithBorder">
            <p class="workData">Work Data:</p>
            <table style="border:unset;float: right;margin-left:50px;margin-top:0px;">
                <tr style="border:unset">
                    <td style="border: unset" width="20%">
                        <b>company:</b>
                    </td>

                    <td style="border: unset" width="20%">
                        @if (isset($group['contract']))
                            {{ $group['contract']['title'] }}
                        @endif
                    </td>
                </tr>

                <tr style="border:unset">
                    <td style="border: unset" width="20%">
                        <b>Patient Class:</b>
                    </td>
                    <td style="border: unset" width="20%">
                        @if (isset($group['sub_contract']))
                            {{ $group['sub_contract']['title'] }}
                        @endif
                    </td>

                    <td style="border: unset" width="20%">
                        <b>Patient Type:</b>
                    </td>

                    <td style="border: unset" width="20%">

                    </td>
                </tr>
            </table>
        </div>
        <div style="clear: both"></div>
        <div width="100%">
            <p class="workData">Tests</p>
            <table width="100%" class="testsTable" style="margin-left:50px;margin-top:0px;">
                <thead>
                    <tr>
                        <th align="center" width="10%">
                           Unit 
                        </th>
                        <th align="center" width="10%">
                            Test
                        </th>

                        <th align="center" width="35%">
                            Test Name
                        </th>

                        <th align="center" width="15%">
                            Staus
                        </th>

                        <th align="center" width="15%">
                            Test Date
                        </th>

                        <th align="center" width="15%">
                            Rec Date
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($group['all_tests'] as $test)
                        {{-- {{dd($test)}} --}}
                        <tr>
                            <td align="center" width="10%">
                                {{ $test->test->unit }}
                            </td>
                            <td align="center" width="10%">
                                {{ $test['test']['id'] }}
                            </td>

                            <td align="center" width="35%">
                                {{ $test['test']['name'] }}
                            </td>


                            <td align="center" width="15%">
                                {{-- {{ __('Staus') }} --}}

                                @if ($test->done)
                                    {{ __('Completed') }}
                                @else
                                    @if ($test->check_test)
                                        {{ __('collected') }}
                                    @else
                                        {{ __('booked') }}
                                    @endif
                                @endif
                            </td>

                            <td align="center" width="15%">
                                {{ $group->check_test_date }}
                            </td>

                            <td align="center" width="15%">
                                {{ $group->retrieve_date }}
                            </td>
                        </tr>
                    @endforeach
                    @foreach ($group['cultures'] as $key => $culture)
                        <tr>
                            <td class="workingpapertd">{{ $culture['culture']['unit'] }}</td>
                            <td class="workingpapertd">{{ $culture['culture']['id'] }}</td>
                            <td class="workingpapertd"> {{ $culture['culture']['name'] }}</td>
                            <td align="center" width="15%">
                                {{-- {{ __('Staus') }} --}}

                                @if ($culture->done)
                                Completed
                                @else
                                    @if ($culture->check_test)
                                    collected
                                    @else
                                    booked
                                    @endif
                                @endif
                            </td>
                            <td align="center" width="15%">
                                {{ $group->check_test_date }}
                            </td>

                            <td align="center" width="15%">
                                {{ $group->retrieve_date }}
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @php
            $sample_type_arr = [];
            $temp = [];
            foreach ($group->all_tests as $value) {
                if (isset($value->test->sample->parent->id)) {
                    if (!in_array($value->test->sample->parent->id, $temp)) {
                        // dd($value->test->sample->parent);
                        $sample_type_arr[] = ['name' => $value->test->sample->parent->name, 'id' => $value->test->sample->parent->id];
                        array_push($temp, $value->test->sample->parent->id);
                    }
                }
            }
            foreach ($group->all_cultures as $value) {
                if (isset($value->culture->sample->parent->id)) {
                    if (!in_array($value->culture->sample->parent->id, $sample_type_arr)) {
                        $sample_type_arr[] = ['name' => $value->culture->sample->parent->name, 'id' => $value->culture->sample->parent->id];
                        array_push($temp, $value->culture->sample->parent->id);
                    }
                }
            }
        @endphp
        {{-- {{dd($sample_type_arr)}} --}}
        <div style="clear: both"></div>
        <div width="100%">
            <p class="workData">Samples</p>
            <table width="80%" align="center" class="testsTable" style="margin-left:50px;margin-top:20px;">

                <tbody>
                    @foreach ($sample_type_arr as $sample)
                        {{-- {{dd($test)}} --}}
                        <tr>
                            <td align="center" width="10%">
                                {{ $sample['id'] }}
                            </td>
                            <td align="center" width="30%">
                                {{ $sample['name'] }}

                            </td>

                            <td align="center" width="30%">

                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

        <div style="clear: both"></div>
        <div width="100%">
            <p class="workData">Qusetions</p>
            @isset($group->questions)
                <div class="row">
                    <div class="col-lg-12">
                        <table class="demTable" style="margin-left:50px;margin-top:20px;">
                            <tbody>
                                <tr>
                                    <td style="" align="center">{{ __('Questions') }}</td>
                                    <td align="center">{{ __('Answer') }}</td>
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
        </div>
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
    </div>
</div>
