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

        .barcode {
            height: {{ $barcode_settings['width'][session('branch_id')] }}mm !important;

        }

        div {
            margin: 0px !important;
            padding: 0px !important;
            padding-left:2px !important;
            padding-right:2px !important;
        }


        tr.border_bottom td {
            border-bottom: 1px solid black;
        }
    </style>

</head>

<body>
    @php
        $index = 0; 
    @endphp 
    @foreach ($sample_type_arr as $sample_type)
        @php $index++ @endphp 
        @for ($i = 0; $i < $sample_type['number']; $i++)
            @if ($i > 0)
                <pagebreak>
            @endif
            <div>
                <div width="100%" style="font-size: 10px;font-weight:bold" align="right">
                    <b>{{ $group['patient']['name'] }}</b>
                </div>
                <div align="center" width="100%" style="margin:0 !important;padding:0px !important;height: auto;min-height: 2px">
                    <span 
                    style="font-weight: bold;font-size:{{setting('barcode')['font_size'][session('branch_id')]}}px;margin-bottom:0px;margin:0"> 

                    @foreach ($group['all_tests'] as $test)
                                                {{$test->test()->whereHas('sample', function ($q) use ($sample_type) {
                                        return $q->where('parent_id', $sample_type['id']);
                                    })->first()
                                    ? Str::limit($test->test()->whereHas('sample', function ($q) use ($sample_type) {
                                                return $q->where('parent_id', $sample_type['id']);
                                            })->first()['shortcut'] , 5 , '').',':null 
                                    ,
                                 }}

                    @endforeach
                </span>
                <span
                            style="font-weight: bold;font-size:{{setting('barcode')['font_size'][session('branch_id')]}}px;margin-bottom:0px;margin-top:0px;">
                    @foreach ($group['all_cultures'] as $test)
                        {{ 
                                $test->culture()->whereHas('sample', function ($q) use ($sample_type) {
                                        return $q->where('parent_id', $sample_type['id']);
                                    })->first()
                                    ? Str::limit($test->culture()->whereHas('sample', function ($q) use ($sample_type) {
                                                return $q->where('parent_id', $sample_type['id']);
                                            })->first()['shortcut'] , 5 , '').',':null ,
                            }}
                    @endforeach
                </span>
                    @foreach ($group['rays'] as $test)
                            <span style="font-weight: bold;font-size:{{setting('barcode')['font_size'][session('branch_id')]}}px;margin-bottom:0;margin-top:0">
                                {{ 
                                    Str::limit($test->ray->name , 5 , '')}}
                            
                            </span>
                        
                    @endforeach
                </div>

                <div style="font-size:6px;font-weight:bold" width="100%">
                    <b style="margin-top:0px">
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
                </div>

                <div align="center">
                    <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($group['barcode'], $barcode_settings['type'][session('branch_id')]) }}"
                        alt="barcode" width="100%" height="7mm">
                </div>

                <div width="100%">

                    <p style="font-size: {{setting('barcode')['font_size'][session('branch_id')]}}px;float: left;" align="left" width="50%">
                        {{ $group['id'] }}
                    </p>

                    <p style="font-size: {{setting('barcode')['font_size'][session('branch_id')]}}px;float: right;margin-top:0" align="right" width="50%">
                        {{ $sample_type['name'] }}
                    </p>

                </div>
                <div style="clear: both"></div>
            </div>

            @if ($i > 0)
                </pagebreak>
            @endif
            @if($index!=count($sample_type_arr))
            <div style="page-break-before:always"></div> 

            @endif
        @endfor

        @if ($loop->iteration > 1)
            </pagebreak>
        @endif
    @endforeach
</body>
</html>