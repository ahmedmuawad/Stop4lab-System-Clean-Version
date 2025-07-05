<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{__('Barcode')}} - #{{$group['id']}}</title>


    <style>
    body { font-family: DejaVu Sans, sans-serif; }
        img{
            margin-bottom: 10px;
        }

        @page {
            margin-left: 5px;
            margin-right: 5px;
            margin-top: 5px;
            margin-bottom: 5px;
        }
    </style>

</head>
<body>
    @for ($i = 0; $i < $number; $i++)
    @if($i>0)
    <pagebreak>
    @endif
    <table width="100%" style="width:100%;text-algin:center">
        <tr>
            <td align="center">

                <b>{{ $group['sample_collection_date'] }}
                </b>

            </span>

        </td>
        </tr>
        <tr>
            <td align="center">
                <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($group['barcode'], $barcode_settings['type'])}}" alt="barcode" class="margin" width="100%"/>
                <b>
                    {{$group['barcode']}}
                </b>
            </td>
        </tr>

    </table>
    @if($i>0)
    </pagebreak>
    @endif
    @endfor
</body>
</html>
