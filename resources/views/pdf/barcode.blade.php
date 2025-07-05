<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Barcode') }} - #{{ $group['id'] }}</title>


    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
        }

        img {
            margin: 0;
        }

        @page {
            margin: 0;
            padding: 0;
            sheet-size: {{ $barcode_settings['width'][session('branch_id')] }}mm {{ $barcode_settings['height'][session('branch_id')] }}mm;
            /* sheet-size: 38mm 25mm; imprtant to set paper size */

        }



        tr.border_bottom td {
            border-bottom: 1px solid black;
        }
    </style>

</head>

<body>

    {{-- <pagebreak> --}}

    <table>
        <tbody>
            <tr width="100%">
                <td colspan="2" width="100%"
                    style="font-size: 10px;display: flex;justify-content: end;
                        flex-wrap: nowrap;"
                    align="right">
                    <span><b>{{ $group['patient']['name'] }}</b></span>

                </td>
            </tr>
            <div style="clear: both"></div>
            <tr>

                <td colspan="2" style="font-size:6px;" width="100%">
                    <b>
                        {{ ucfirst(Str::Limit($group['patient']['gender'], 1, '')) }}
                        -
                        {{ $group['patient']['age'] }}
                        -
                        @php
                            
                            $date = Carbon\Carbon::parse($group['sample_collection_date']);
                            $date = $date->format('h:i:s a Y-m-d');
                        @endphp
                        {{ $date }}

                    </b>
                    {{-- {{ ucfirst($group['patient']['age']) }} --}}
                    {{-- <b>{{ $group['patient']['name'] }}</b> --}}
                </td>

                {{-- <td  align="left" style="float: right;">
                            <b>{{ $group['patient']['name'] }}</b>
                        </td> --}}
            </tr>
            <br>
            <tr>
                <td colspan="2" align="center">
                    {{-- <img src="data:image/png;base64,{{DNS1D::getBarcodePNG('456342342343', 'C39+',3,33,array(1,1,1), true)}} . '" alt="barcode"   height="1"/> --}}
                    <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($group['barcode'], $barcode_settings['type'][session('branch_id')]) }}"
                        alt="barcode" width="100%" height="7mm">
                </td>
            </tr>
            <br>

            <tr>
                <td colspan="2" align="left" style="font-size:18px;margin-left:10px;margin-top: 20px"
                    width="100%">
                    @php
                        $date = Carbon\Carbon::parse($group['sample_collection_date']);
                        $date = $date->format('d-M-Y h:i:s A');
                    @endphp
                    <b style="font-size: 8px">
                        {{ $date }}
                    </b>
                </td>
            </tr>
            <!--[endif]-->
        </tbody>
    </table>

    {{-- @if ($loop->iteration > 1) --}}
    {{-- </pagebreak> --}}
    {{-- @endif --}}
    {{-- @endforeach --}}
</body>

</html>
