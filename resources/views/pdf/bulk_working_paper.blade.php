<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

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
                font-family: sans-serif;
                 !important;
                border-collapse: collapse;
                border: 1pt solid gray;

            }

            .tr .th {
                border: 1pt solid black;

            }

            .total {
                font-family: sans-serif;
                 !important;
            }

            .due_date {
                font-family: sans-serif;
                 !important;
            }

            .test_name {
                color: {{ $reports_settings['test_name']['color'] }} !important;
                font-size: {{ $reports_settings['test_name']['font-size'] }} !important;
                font-family: sans-serif;
                 !important;
            }

            .text-center {
                text-align: center;
            }

            .head {
                background-color: #d3d3d3;
            }
        </style>
    </head>

    @php
        $count = 0;
    @endphp
    @foreach ($groups as $group)
        @if ($count > 0)
        @endif
        <div class="invoice">
            @if (isset($group['patient']))
                <table width="100%">
                    <thead class="head">
                        <tr class="head">
                            <td>Barcode</td>
                            <td>Patient Name</td>
                            <td>Gender</td>
                            <td>Age</td>
                            <td>Date</td>
                            <td>Rferred By</td>
                            <td>Ok</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $group['barcode'] }}</td>
                            <td>
                                @if (isset($group['patient']))
                                    {{ $group['patient']['name'] }}
                                @endif
                            </td>
                            <td>
                                @if (isset($group['patient']))
                                    {{ __($group['patient']['gender']) }}
                                @endif
                            </td>
                            <td>
                                @if (isset($group['patient']))
                                    {{ $group['patient']['age'] }}
                                @endif
                            </td>
                            <td> {{ $group['sample_collection_date'] }}</td>
                            <td>
                                @if($group['user_id'] == null)
                                    @if(isset($group['doctor']))
                                    Dr. {{ $group['doctor']['name'] }}
                                    @elseif(isset($group['normalDoctor']))
                                    Dr.  {{ $group['normalDoctor']['name'] }}
                                    @endif

                                    @if ($group['contract_id'] != null)
                                    {{ $group['contract']['title'] }}
                                    @endif
                                @else
                                    {{ $group['user']['name'] }}
                                @endif
                            </td>
                            </td>
                            <td>

                        </tr>
                    </tbody>
                </table>
                <br>
                @if ($group->all_tests->isNotEmpty() || $group->cultures->isNotEmpty())
                    <table width="100%">
                        <tbody>
                            @foreach ($group['all_tests'] as $key => $test)
                                <tr>
                                    <td class="workingpapertd">{{ $test['test']['name'] }}</td>
                                    <td class="workingpapertd">{{ $test->check_test ? 'yes' : 'no' }}</td>
                                </tr>
                            @endforeach
                            @foreach ($group['cultures'] as $key => $culture)
                                <tr>
                                    <td class="workingpapertd"> {{ $culture['culture']['name'] }}</td>
                                    <td class="workingpapertd"> {{ $culture->check_test ? 'yes' : 'no' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <br>
                    <hr style="height:2px;border-width:1;color:rgb(0, 0, 0);background-color:gray">
                    <br>
                @endif
            @endif
        </div>
        @if ($count > 0)
        @endif
        @php
            $count++;
        @endphp
    @endforeach

@endsection
