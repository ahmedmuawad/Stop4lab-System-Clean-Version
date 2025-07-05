<!DOCTYPE html>
<html lang="en">

<head>


    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{__('Barcode')}} - #{{$group['id']}}</title>


    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }

        img {
            margin: 0;
        }

        @page {
            margin: 0;
            sheet-size: 38mm 25mm; /* imprtant to set paper size */

        }


        tr.border_bottom td {
            border-bottom: 1px solid black;
        }

    </style>

</head>

<body>
    @php
        $sample_type_arr = [];
        foreach ($group->all_tests as $value) {
            if(!in_array($value->test->sample_type,$sample_type_arr)){
                array_push($sample_type_arr,$value->test->sample_type);
            }
        }
        foreach ($group->all_cultures as $value) {
            if(!in_array($value->culture->sample_type,$sample_type_arr)){
                array_push($sample_type_arr,$value->culture->sample_type);
            }
        }
    @endphp

    @for ($i = 0; $i < $number; $i++) @if($i>0)
        <pagebreak>
            @endif
            <table>
                <tbody>
                    <tr class="border_bottom">

                        <td width="80%" align="left" class="padding_bottom">
                            <b>{{ $group['sample_collection_date'] }}</b>
                        </td>
                        <td width="20%" align="right">
                            <b>{{$group['id']}}</b>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center" width="100%">
                            <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($group['barcode'], $barcode_settings['type'])}}" alt="barcode" class="margin" width="100%" height"30%">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            {{ $group['patient']['name'] }} - {{ Str::limit($group['patient']['age'],5,'') }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                           <b> {{$sample_type_arr[$i] }}</b>
                        </td>
                    </tr>
                    <tr>

                        <td colspan="2" align="center" width="100%" >
                            @foreach ($group['all_tests'] as $test)
                                {{$test->test()->where('sample_type' , $sample_type_arr[$i])->first() ? $test->test()->where('sample_type' , $sample_type_arr[$i])->first()['name'] . ',' : '' }}
                            @endforeach
                            @foreach ($group['all_cultures'] as $test)
                                {{$test->culture()->where('sample_type' , $sample_type_arr[$i])->first() ? $test->culture()->where('sample_type' , $sample_type_arr[$i])->first()['name'] . ',' : '' }}
                            @endforeach
                        </td>

                    </tr>
            <!--[endif]-->
               </tbody>
            </table>
            @if($i>0)
        </pagebreak>
        @endif

        @endfor
</body>

</html>
