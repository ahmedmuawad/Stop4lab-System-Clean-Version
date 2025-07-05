<div class="">

    <style>

@page {
            header: page-header;
            footer: page-footer;

            @if($header)

                    sheet-size: A4; /* imprtant to set paper size */
                    min-height: 100% !important;
                   
                    background-repeat: no-repeat;
                    background-position: center center;
                    
                  margin-left: {{ $reports_settings['header-margin-left'] }}mm;
                margin-right: {{ $reports_settings['header-margin-right'] }}mm;

                margin-top: {{ $reports_settings['header-margin-top'] }}mm;
                margin-header: {{ $reports_settings['content-header-margin-top'] }}mm;

                margin-bottom: {{ $reports_settings['header-margin-bottom'] }}mm;
                margin-footer: {{ $reports_settings['content-header-margin-bottom'] }}mm;
            @else
                
                margin-left: {{ $reports_settings['margin-left'] }}mm;
                margin-right: {{ $reports_settings['margin-right'] }}mm;

                margin-top: {{ $reports_settings['margin-top'] }}mm;
                margin-header: {{ $reports_settings['content-margin-top'] }}mm;

                margin-bottom: {{ $reports_settings['margin-bottom'] }}mm;
                margin-footer: {{ $reports_settings['content-margin-bottom'] }}mm;

            @endif


            @if ( $header && $group['branch']['show_watermark_image'])background: url("{{ url('img/Letterhead-bg.jpg') }}") no-repeat;
            background-position: center;
            @endif
        }

        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            font-family:{{$reports_settings['patient_title']['font-family']}}!important;
            height: 20px;
        }
        td{
        padding: 2px;
        }
        .withoutBorder{
            border:unset;
        }
        *{
            font-family: cairo;
        }
    .pinfo {
        border-collapse: collapse;
        border-radius: 10px;
        height: 30px;
        width: 100%;
    }
        .title{
            background-color: #ddd;
        }
        .branch_name{
            color:{{$reports_settings['branch_name']['color']}}!important;
            font-size:{{$reports_settings['branch_name']['font-size']}}!important;
        }
        .branch_info{
            color:{{$reports_settings['branch_info']['color']}}!important;
            font-size:{{$reports_settings['branch_info']['font-size']}}!important;
        }
        .title{
            color:{{$reports_settings['patient_title']['color']}}!important;
            font-size:{{$reports_settings['patient_title']['font-size']}}!important;
            font-family:{{$reports_settings['patient_title']['font-family']}}!important;
            text-align: right!important;
        }
        .data{
            color:{{$reports_settings['patient_data']['color']}}!important;
            font-size:{{$reports_settings['patient_data']['font-size']}}!important;
            font-family:{{$reports_settings['patient_data']['font-family']}}!important;
        }
        .header{
            border:{{$reports_settings['report_header']['border-width']}} solid {{$reports_settings['report_header']['border-color']}} !important;
            background-color:{{$reports_settings['report_header']['background-color']}} !important;
            text-align:{{$reports_settings['report_header']['text-align']}} !important;
        }
        .footer{
            background-color:{{$reports_settings['report_footer']['background-color']}};
            color:{{$reports_settings['report_footer']['color']}}!important;
            font-size:{{$reports_settings['report_footer']['font-size']}}!important;
            font-family:{{$reports_settings['report_footer']['font-family']}}!important;
            text-align:{{$reports_settings['report_footer']['text-align']}}!important;
        }
        .signature{
            align-content: right;
            padding-bottom: 0px !important;
            text-align: right;
            float: right;
            color:{{$reports_settings['signature']['color']}}!important;
            font-size:{{$reports_settings['signature']['font-size']}}!important;
            font-family:{{$reports_settings['signature']['font-family']}}!important;
        }
        .signature-without-header{
            align-content: right;
            padding-bottom: {{ $reports_settings['margin-bottom'] }}mm !important;
            text-align: right;
            float: right;
            color:{{$reports_settings['signature']['color']}}!important;
            font-size:{{$reports_settings['signature']['font-size']}}!important;
            font-family:{{$reports_settings['signature']['font-family']}}!important;
        }
        .signature4{
            align-content: right;
            padding-bottom: {{ $reports_settings['margin-bottom'] - 10 }}mm !important;
            margin-right: 70px !important;
            text-align: right;
            float: right;
            color:{{$reports_settings['signature']['color']}}!important;
            font-size:{{$reports_settings['signature']['font-size']}}!important;
            font-family:{{$reports_settings['signature']['font-family']}}!important;
        }

    </style>
</div>