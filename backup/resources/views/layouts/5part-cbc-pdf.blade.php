<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>
        @yield('title')
    </title>
  <style>

        @if($type==3||$type==4||$type==5||$type==6||$type==7)
        @page {
                margin-top: 0px;
                margin-right: {{$reports_settings['margin-right']}}px;
                margin-left: {{$reports_settings['margin-left']}}px;
                margin-bottom: {{$reports_settings['margin-bottom']}}px;
            }

    @else @page {
            header: page-header;
            footer: page-footer;

            margin-left: {{ $reports_settings['margin-left'] }}px;
            margin-right: {{ $reports_settings['margin-right'] }}px;

            margin-top: 250px;
            margin-header: 0px;

            margin-bottom: 0px;
            margin-footer: 0px;

            @if ($group['branch']['show_watermark_image'])background: url("{{ url('uploads/branches/' . $group['branch']['watermark_image']) }}") no-repeat;
            background-position: center;
            @endif
        }
        @endif

        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            font-family:{{$reports_settings['patient_title']['font-family']}}!important;
        }
        td{
        padding: 2px;
        }
       .pinfo {
        border-collapse: collapse;
        font-family: {{ $reports_settings['test_head']['font-family'] }} !important;
        border-radius: 10px;
        width: 100%;
       }
        .title{
            background-color: #ddd;
            font-family: {{ $reports_settings['test_head']['font-family'] }} !important;
        }
        .branch_name{
            color:{{$reports_settings['branch_name']['color']}}!important;
            font-size:{{$reports_settings['branch_name']['font-size']}}!important;
            font-family: {{ $reports_settings['test_head']['font-family'] }} !important;
        }
        .branch_info{
            color:{{$reports_settings['branch_info']['color']}}!important;
            font-size:{{$reports_settings['branch_info']['font-size']}}!important;
            font-family: {{ $reports_settings['test_head']['font-family'] }} !important;
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
            border:{{$reports_settings['report_header']['border-width']}} solid {{$reports_settings['report_header']['border-color']}};
            background-color:{{$reports_settings['report_header']['background-color']}};
            text-align:{{$reports_settings['report_header']['text-align']}}!important;
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
            text-align: right;
            float: right;
            color:{{$reports_settings['signature']['color']}}!important;
            font-size:{{$reports_settings['signature']['font-size']}}!important;
            font-family:{{$reports_settings['signature']['font-family']}}!important;
        }

    </style>

</head>

<body>

    @if ($type !== 3 && $type !== 4 && $type !== 5 && $type !== 6 && $type !== 7)
        <htmlpageheader name="page-header">

            @if ($reports_settings['show_header'] && isset($group['branch']))
                @if ($group['branch']['show_header_image'])
                    <table width="100%" style="padding:0px;" style="border: 1px solid white;">
                        <tbody style="border: 1px solid white;">
                            <tr style="border: 1px solid white;">
                                <td align="center" style="padding:0px"style="border: 1px solid white;">
                                    <img src="{{ url('uploads/branches/' . $group['branch']['header_image']) }}"
                                        alt="" max-height="300" min-height="300">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                @else
                    <table width="100%" class="pdf-header header" style="border: 1px solid white;">
                        <tbody>
                            <tr>
                                <td width="15%" align="right" style="border: 1px solid white;">
                                    <img src="{{ url('img/reports_logo.png') }}" width="100px" />
                                </td>
                                <td width="70%" align="{{ $reports_settings['report_header']['text-align'] }}" style="border: 1px solid white;">
                                    <p class="branch_name">
                                        {{ $group['branch']['name'] }}
                                    </p>
                                    <p class="branch_info">
                                        <img src="{{ url('img/report_phone.png') }}" width="16px" alt="">
                                        @if (isset($group['branch']))
                                            {{ $group['branch']['phone'] }}
                                        @endif
                                    </p>
                                    <p class="branch_info">
                                        <img src="{{ url('img/report_address.png') }}" width="16px" alt="">
                                        @if (isset($group['branch']))
                                            {{ $group['branch']['address'] }}
                                        @endif
                                    </p>
                                    <p class="branch_info">
                                        <img src="{{ url('img/report_email.png') }}" width="16px" alt="">
                                        {{ $info_settings['email'] }}
                                    </p>
                                    <p class="branch_info">
                                        <img src="{{ url('img/report_website.png') }}" width="16px" alt="">
                                        {{ $info_settings['website'] }}
                                    </p>
                                </td>
                                <td align="right" width="15%" style="border: 1px solid white;">
                                    @if (isset($group['patient']) && $reports_settings['show_avatar'])
                                        <img src="@if (!empty($group['patient']['avatar'])) {{ url('uploads/patient-avatar/' . $group['patient']['avatar']) }} @else {{ url('img/avatar.png') }} @endif"
                                            max-width="100px" max-height="100px">
                                    @endif
                                </td>
                            </tr>

                        </tbody>
                    </table>
                @endif
            @endif



            @if (isset($group['patient']))
            <table style="width: 100%;">

              <tr>
                 <td width="15%" style="background-color:#EBECF0;">Name:</td>
                  <td style="width:25%;">
                  @if (isset($group['patient']))
                     {{ $group['patient']['name'] }}
                 @endif</td>
                 <td style="background-color:#EBECF0;">Barcode:</td>
                 <td width="25%"><img src="data:image/png;base64,{{DNS1D::getBarcodePNG($group['barcode'], $barcode_settings['type'])}}" alt="barcode" class="margin"></td>
                 @if (isset($group['patient']) && $group['patient']['avatar'] && $reports_settings['show_avatar'])
                 <td rowspan="4"><img src="@if (!empty($group['patient']['avatar'])) {{ url('uploads/patient-avatar/' . $group['patient']['avatar']) }} @else {{ url('img/avatar.png') }} @endif"
                     max-width="90px" max-height="90px"></td>
                 @endif
                 <td rowspan="4" style="text-align:center;"> @if (isset($group['patient']))
                     <img src="https://chart.googleapis.com/chart?chs={{ $reports_settings['qrcode-dimension'] }}x{{ $reports_settings['qrcode-dimension'] }}&cht=qr&chl={{ url('patient/login/' . $group['patient']['code']) }}&choe=UTF-8"
                         title="Link to Google.com" />
                 @endif</td>


              </tr>
              <tr>
                 <td style="background-color:#EBECF0;">P.Info:</td>
                 <td width="25%">
             <table class="pinfo">
             <tr>
               <td width="50%">
               @if (isset($group['patient']))
                     {{ __($group['patient']['gender']) }}
               @endif
               </td>
               <td width="50%">
               @if (isset($group['patient']))
                     {{ $group['patient']['age'] }}
               @endif</td>

             </tr>
             </table>
             </td>
                 <td style="background-color:#EBECF0;">Contract:</td>
                 <td width="25%">
                 @if(isset($group['contract']))
                         {{ $group['contract']['title'] }}
                 @endif
                 </td>
              </tr>
                <tr>
                 <td style="background-color:#EBECF0;">Reffered by:</td>
                 <td width="25%">
                    @if (isset($group['doctor']))
                                    {{ $group['doctor']['name'] }}
                                @endif
                                @if (isset($group['normalDoctor']))
                                    {{ $group['normalDoctor']['name'] }}
                                @endif
                 </td>
                 <td style="background-color:#EBECF0;">D.Collection:</td>
                 <td width="25%">{{ $group['sample_collection_date'] }}</td>
              </tr>
                @php
                    $num_date = '';
                    $diff = '';
                    $created_at_report = '';
                    // get num_date from relationship tests
                    $tests = $group->tests()->whereHas('test', function ($query) {
                        $query->where('num_day_receive', '!=', 0);
                    })->get();
                    if(count($tests)) {
                        foreach ($group['tests'] as $test) {
                            $num_date = $test->test->orderby('num_day_receive', 'desc')->first();
                            $created_at_report = $test;
                        }

                        // get created_at and add day use carbon
                        $created_at = $created_at_report ? $created_at_report->created_at : '';
                        if ($created_at) {
                            $created_at = \Carbon\Carbon::parse($created_at);
                            $diff = $created_at->addDays($num_date->num_day_receive);
                        }
                    } else {
                        foreach ($group['tests'] as $test) {
                            $num_date = $test->test->orderby('num_hour_receive', 'desc')->first();
                            $created_at_report = $test;
                        }

                        // get created_at and add day use carbon
                        $created_at = $created_at_report ? $created_at_report->created_at : '';
                        if ($created_at) {
                            $created_at = \Carbon\Carbon::parse($created_at);
                            $diff = $created_at->addHours($num_date->num_hour_receive);
                        }
                    }

                @endphp
              <tr>
                 <td style="background-color:#EBECF0;">D.Reporting:</td>
                 <td width="25%"> {{ now() }}</td>

                 @if (isset($group['patient']) && $group['patient']['passport_no'])
                 <td style="background-color:#EBECF0;">Passport:</td>
                 <td width="25%">{{ $group['patient']['passport_no'] }}</td>
                 @endif
              </tr>
              <tr>
                  <td width="15%" style="background-color:#EBECF0;">Branch:</td>
                  <td style="width:25%;">
                      {{ $group['branch']['name'] }}
                  </td>
                  <td width="15%" style="background-color:#EBECF0;">{{ __('Sample Collected') }}:</td>
                  <td style="width:25%;">
                      @if($group['is_out'])

                          <bdi>{{ __('Outside') }}</bdi> {{ $info['name'] }}
                      @else
                        <bdi>{{ __('Inside') }}</bdi> {{ $info['name'] }}
                      @endif
                  </td>
                <td width="15%" style="background-color:#EBECF0;">{{ __('Patient ID:') }}</td>
                  <td style="width:25%; text-align:center;">
                      @if (isset($group['patient']))
                     {{ __($group['patient']['code']) }}
                  @endif
                  </td>
              </tr>

           </table>
          @endif
                  </htmlpageheader>
              @endif
    <br>
              @yield('content')




              <htmlpagefooter name="page-footer" class="page-footer">
                @if ($type == 1)
                    @if ($reports_settings['show_signature'] || $reports_settings['show_qrcode'])
        <div class="signature">
                                        @if ($reports_settings['show_signature'])
                                            <p class="signature">

                                            </p>
                                        @endif

                                        @if ($reports_settings['show_signature'])
                                            @if (!empty($group['signed_by']))
                                                <p>
                                                    <img src="{{ url('uploads/signature/' . $group['signed_by_user']['signature']) }}"
                                                        alt="" height="150">
                                                </p>
                                            @endif
                                        @endif
        </div>
                    @endif
                @endif
    </htmlpagefooter>


    </body>

    </html>
