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
            font-family: DejaVu Sans, sans-serif;
            
        }

        img {
            margin: 0;
            text-align: center;
            padding-left: 10mm;
            width:80%;
            height: 10mm;
            
        }

        @page {
            margin: 0;
            sheet-size: {{ $barcode_settings['width'][session('branch_id')] }}mm {{ $barcode_settings['height'][session('branch_id')] }}mm;
            /* sheet-size: 38mm 25mm; imprtant to set paper size */

        }


        tr.border_bottom td {
            border-bottom: 1px solid black;
        }
    </style>

</head>

<body>
    @foreach ($group['rays'] as $i => $ray)
        {{-- @for ($i = 0 ; $i<$group['rays']->count();$i++)             --}}
            @if ($i > 0)
                <pagebreak>
            @endif
            <table width="100%">
                <tbody>
                    <tr class="">

                        <td>
                            <b>Name</b>
                        </td>
                        <td>
                            {{ $group['patient']['name'] }}
                        </td>
                    </tr>
                    <tr class="">

                        <td>
                            <b>Date</b>
                        </td>
                        <td>
                            {{ $group['created_at'] }}
                        </td>
                    </tr>
                    <tr class="">

                        <td>
                            <b>Type</b>
                        </td>
                        <td>
                            {{ $ray->ray->name }}
                        </td>
                    </tr>
                    <tr>

                        <td>
                            <b>ID</b>
                        </td>
                        <td>
                            {{ $group['patient']['code'] }}
                        </td>
                        <td>
                            <b>P.W</b>
                        </td>
                        <td>
                            {{ $group['barcode'] }}
                        </td>
                    </tr>
                    <!--[endif]-->
                </tbody>
            </table>

            <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG( $group['barcode'] , $barcode_settings['type'][session('branch_id')]) }}"
                                alt="barcode" class="margin">

            @if ($i > 0)
                </pagebreak>
            @endif
        {{-- @endfor --}}

    @endforeach
</body>

</html>
