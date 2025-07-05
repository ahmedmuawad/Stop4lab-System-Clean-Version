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

    <x-layout-style-component :settings="$reports_settings" :group="$group" :header="$header" />

    <script src="https://www.google.com/jsapi"></script>


</head>

<body
    @if ($header && isset(setting('info')['Letterhead-bg']) && setting('info')['Letterhead-bg'] != null) style="min-height: 100% !important;
                background-image: url({{ public_path('img') }}/{{ setting('info')['Letterhead-bg'] }}) ;
                background-repeat: no-repeat;
                min-width:100% !important;
                background-position: center center;" @endif>

    <htmlpageheader name="page-header">

        @if ($reports_settings['show_header'] && isset($group['branch']) && $header)
            @if ($group['branch']['show_header_image'])
                <table width="100%" style="padding:0px;" style="border: 1px solid white;">
                    <tbody style="border: 1px solid white;">
                        <tr style="border: 1px solid white;">
                            <td align="center" style="padding:0px !important; border: 1px solid white;">
                                <img src="{{ public_path('uploads/branches/' . $group['branch']['header_image']) }}"
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
                                <img src="{{ public_path('img/reports_logo.png') }}" width="100px" />
                            </td>
                            <td width="70%"
                                align="{{ $reports_settings['report_header']['text-align'] }}"style="border: 1px solid white;">
                                <p class="branch_name">
                                    @if ($group['patient']['prefix'] != null)
                                        {{ __($group['patient']['prefix']) }} / {{ $group['patient']['name'] }}
                                    @else
                                        {{ $group['patient']['name'] }}
                                    @endif

                                </p>
                                <p class="branch_info">
                                    <img src="{{ public_path('img/report_phone.png') }}" width="16px" alt="">
                                    @if (isset($group['branch']))
                                        {{ $group['branch']['phone'] }}
                                    @endif
                                </p>
                                <p class="branch_info">
                                    <img src="{{ public_path('img/report_address.png') }}" width="16px" alt="">
                                    @if (isset($group['branch']))
                                        {{ $group['branch']['address'] }}
                                    @endif
                                </p>
                                <p class="branch_info">
                                    <img src="{{ public_path('img/report_email.png') }}" width="16px" alt="">
                                    {{ $info_settings['email'] }}
                                </p>
                                <p class="branch_info">
                                    <img src="{{ public_path('img/report_website.png') }}" width="16px" alt="">
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
            <table class="patient_title" style="width: 100%; @if (isset(setting('reports')['direction']) && setting('reports')['direction']) direction:rtl; @endif">

                <tr>
                    <td width="15%" style="background-color:#EBECF0;">Name:</td>
                    <td style="width:40%;">
                        @if ($group['patient']['prefix'] != null)
                            {{ __($group['patient']['prefix']) }} / {{ $group['patient']['name'] }}
                        @else
                            {{ $group['patient']['name'] }}
                        @endif
                    </td>
                    <td style="background-color:#EBECF0;">Barcode:</td>
                    <td width="20%"><img
                            src="data:image/png;base64,{{ DNS1D::getBarcodePNG($group['barcode'], $barcode_settings['type'][session('branch_id')]) }}"
                            alt="barcode"></td>
                    @if (isset($group['patient']) && $group['patient']['avatar'] && $reports_settings['show_avatar'])
                        <td rowspan="4"><img
                                src="@if (!empty($group['patient']['avatar'])) {{ url('uploads/patient-avatar/' . $group['patient']['avatar']) }} @else {{ url('img/avatar.png') }} @endif"
                                max-width="90px" max-height="90px"></td>
                    @endif
                    @php
                                $show_qr = isset($group->user->show_qr) && $group->user->show_qr == 0  ? false : true  ;
                                $show_contract_name = isset($group->user->show_contract_name) && $group->user->show_contract_name == 0  ? false : true  ;
                                $show_sample_collect = isset($group->user->show_sample_collect) && $group->user->show_sample_collect == 0  ? false : true  ;
                            @endphp
                            @if (isset($group['patient']) && $show_qr && $reports_settings['show_qrcode'])
                                <td rowspan="4">
                                        @if (isset($reports_settings['qrcode_to_pdf']) && $reports_settings['qrcode_to_pdf'] == 'on')
                                                <img src="/qr/?data={{ $group['report_pdf'] }}&size=3" title="Link to Google.com" />
                                            @else
                                            <img src="/qr/?size=3&data={{ url('patient/login/' . $group['patient']['code']) }}"title="Link to Google.com" />
                                        @endif
                                                                            
                                  <br>
                                    {{ $group['id'] }}
                                </td>
                            @endif
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
                                    @endif
                                </td>

                            </tr>
                        </table>
                    </td>
                    <td style="background-color:#EBECF0;">Patient ID:</td>
                    <td width="25%">
                        @if (isset($group['patient']))
                            {{ __($group['patient']['code']) }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="background-color:#EBECF0;">Reffered by:
                    </td>
                    <td width="25%">
                        @if (isset($group['doctor']))
                            {{ $group['doctor']['name'] }}
                        @endif
                        @if (isset($group['normalDoctor']))
                            {{ $group['normalDoctor']['name'] }}
                        @endif
                        @if (!isset($group['normalDoctor']) && !isset($group['doctor']) && $group['contract_id'] == null)
                            @if ($group['patient']['gender'] == 'male')
                                Himself
                            @else
                                Herself
                            @endif
                        @endif
                        @if ($group['user_id'] != null && $show_contract_name)
                            - {{ $group['user']['name'] }}
                        @else
                            @if ($group['contract_id'] != null && $show_contract_name)
                                - {{ $group['contract']['title'] }}
                            @endif
                        @endif



                    </td>
                    @if (isset($reports_settings['show_d_collection']) && $reports_settings['show_d_collection'])
                        <td style="background-color:#EBECF0;">D.Collection:</td>
                        <td width="25%">{{ date('Y-m-d g:i A', strtotime($group['sample_collection_date'])) }}</td>
                    @endif
                </tr>
                <tr>
                    <td style="background-color:#EBECF0;">D.Reporting:</td>
                    <td>{{ $group['resulte_date'] == null ? receivedDate($group['id']) : $group['resulte_date'] }}
                    </td>
                    @if (isset($reports_settings['show_branch']) && $reports_settings['show_branch'])
                        <td width="15%" style="background-color:#EBECF0;">Branch:</td>
                        <td style="width:25%;">
                            {{ $group['branch']['name'] }}
                        </td>
                    @endif

                </tr>
                @if ($show_sample_collect && isset($reports_settings['show_s_collection']) && $reports_settings['show_s_collection'])
                    <tr>
                        <td style="background-color:#EBECF0;">S.Collection:</td>
                        <td>{{ isset($group)&&$group['is_out']==1 ? 'Outside Lab' : 'InSide Lab' }}
                        </td>
                        <td style="background-color:#EBECF0;">Report Code:</td>
                        <td>{{ $group['id'] }}
                        </td>
                    </tr>
                @endif
                @if (isset($group['patient']) && $group['patient']['passport_no'])
                    <tr>
                        <td style="background-color:#EBECF0;">Passport:</td>
                        <td width="25%">{{ $group['patient']['passport_no'] }}</td>
                    </tr>
                @endif


            </table>
        @endif
    </htmlpageheader>


    @yield('content')


    {{--  --}}
    <htmlpagefooter name="page-footer" class="page-footer">
        @if ($reports_settings['show_signature'] || $reports_settings['show_qrcode'])

            @if (isset($group['signed_by']) && $header && setting('reports')['show_sign_with_header'])
                <div class="signature">
                    @if (isset(setting('reports')['sign_with_header']) && setting('reports')['sign_with_header'] == '1')
                        <table width="100%" style="border: 0px solid white !important;">
                            <tr style="border: 0px solid white !important;">
                                <td style="border: 0px solid white !important;" width="5%"></td>
                                <td style="border: 0px solid white !important;" width="40%"> 
                                    
                                    Reviewed By :
                                    @if ($group->signed_by_user->sgin_name != null)
                                        {{ $group->signed_by_user->sgin_name }}
                                    @else
                                        {{ $group->signed_by_user->name }}
                                    @endif
                                  
                                
                                </td>
                                <td style="border: 0px solid white !important;" width="10%"></td>
                                <td style="border: 0px solid white !important;" width="40%"> Signed By :
                                   

                                    @if ($group->signed_by_user->sgin_name != null)
                                        {{ $group->signed_by_user->sgin_name }}
                                    @else
                                        {{ $group->signed_by_user->name }}
                                    @endif

                                </td>
                                <td style="border: 0px solid white !important;" width="5%"></td>
                            </tr>
                            <tr style="border: 0px solid white !important;">
                                <td style="border: 0px solid white !important;" width="5%"></td>
                                <td style="border: 0px solid white !important;" width="40%">
                                    {{ $group->review_by_user->sgin_name }}</td>
                                <td style="border: 0px solid white !important;" width="10%"></td>
                                <td style="border: 0px solid white !important;" width="40%">
                                    {{ $group->signed_by_user->sgin_name }}</td>
                                <td style="border: 0px solid white !important;" width="5%"></td>
                            </tr>
                            <tr style="border: 0px solid white !important;">
                                <td style="border: 0px solid white !important;" width="5%"></td>
                                <td style="border: 0px solid white !important;" width="40%">
                                    {{ date('Y-m-d g:i A', strtotime($group->review_date)) }}</td>
                                <td style="border: 0px solid white !important;" width="10%"></td>
                                <td style="border: 0px solid white !important;" width="40%">
                                    {{ date('Y-m-d g:i A', strtotime($group->signed_date)) }}</td>
                                <td style="border: 0px solid white !important;" width="5%"></td>
                            </tr>
                        </table>
                    @elseif(isset(setting('reports')['sign_with_header']) && setting('reports')['sign_with_header'] == '2')
                        <img src="{{ public_path('uploads/signature/' . $group['signed_by_user']['signature']) }}"
                            alt="" height="120">
                            <p style="color:black; text-align: center; text-decoration:bold;"> Report
                            at {{ $group->review_date }} &nbsp;Sign By

                            @if ($group->signed_by_user->sgin_name != null)
                                {{ $group->signed_by_user->sgin_name }}
                            @else
                                {{ $group->signed_by_user->name }}
                            @endif
                            at {{ $group->signed_date }}
                        </p>
                    @elseif(isset(setting('reports')['sign_with_header']) && setting('reports')['sign_with_header'] == '3')
                        <p style="color:black; text-align: center; text-decoration:bold;"> Report
                            at {{ $group->review_date }} &nbsp;Sign By

                            @if ($group->signed_by_user->sgin_name != null)
                                {{ $group->signed_by_user->sgin_name }}
                            @else
                                {{ $group->signed_by_user->name }}
                            @endif
                            at {{ $group->signed_date }}
                        </p>
                    @elseif(setting('reports')['sign_with_header'] == '4')
                        <div class="signature4">
                            Doctor's Signature :
                        </div>

                    @endif
                </div>
            @elseif(isset($group['signed_by']) && $header == false && setting('reports')['show_sign_without_header'])
                <div class="signature-without-header">
                    @if (isset(setting('reports')['sign_without_header']) && setting('reports')['sign_without_header'] == '1')
                        <table width="100%" style="border: 0px solid white !important;">
                            <tr style="border: 0px solid white !important;">
                                <td style="border: 0px solid white !important;" width="5%"></td>
                                <td style="border: 0px solid white !important;" width="40%"> Reviewed By :
                                    {{ $group->review_by_user->name }}</td>
                                <td style="border: 0px solid white !important;" width="10%"></td>
                                <td style="border: 0px solid white !important;" width="40%"> Signed By :
                                    {{ $group->signed_by_user->name }} </td>
                                <td style="border: 0px solid white !important;" width="5%"></td>
                            </tr>
                            <tr style="border: 0px solid white !important;">
                                <td style="border: 0px solid white !important;" width="5%"></td>
                                <td style="border: 0px solid white !important;" width="40%">
                                    {{ $group->review_by_user->roles[0]->role->name }}</td>
                                <td style="border: 0px solid white !important;" width="10%"></td>
                                <td style="border: 0px solid white !important;" width="40%">
                                    {{ $group->signed_by_user->roles[0]->role->name }}</td>
                                <td style="border: 0px solid white !important;" width="5%"></td>
                            </tr>
                            <tr style="border: 0px solid white !important;">
                                <td style="border: 0px solid white !important;" width="5%"></td>
                                <td style="border: 0px solid white !important;" width="40%">
                                    {{ date('Y-m-d g:i A', strtotime($group->review_date)) }}</td>
                                <td style="border: 0px solid white !important;" width="10%"></td>
                                <td style="border: 0px solid white !important;" width="40%">
                                    {{ date('Y-m-d g:i A', strtotime($group->signed_date)) }}</td>
                                <td style="border: 0px solid white !important;" width="5%"></td>
                            </tr>
                        </table>
                    @elseif(isset(setting('reports')['sign_without_header']) && setting('reports')['sign_without_header'] == '2')
                        <img src="{{ public_path('uploads/signature/' . $group['signed_by_user']['signature']) }}"
                            alt="" height="120">
                    @elseif(isset(setting('reports')['sign_without_header']) && setting('reports')['sign_without_header'] == '3')
                        <p style="color:black; text-align: center; text-decoration:bold;"> Report
                            at {{ $group->review_date }} &nbsp;Sign By

                            @if ($group->signed_by_user->sgin_name != null)
                                {{ $group->signed_by_user->sgin_name }}
                            @else
                                {{ $group->signed_by_user->name }}
                            @endif
                            at {{ $group->signed_date }}
                        </p>
                    @elseif(setting('reports')['sign_without_header'] == '4')
                        <div class="signature4">
                            Doctor's Signature :
                        </div>
                    @endif
                </div>
            @endif


        @endif
        @if ($reports_settings['show_footer'] && $header)

            @if ($group['branch']['show_footer_image'])
                <img src="{{ public_path('uploads/branches/' . $group['branch']['footer_image']) }}" alt=""
                    max-height="300">
            @else
                <table width="100%" border="0">
                    <tbody border="0">
                        <tr border="0">
                            <td class="footer" border="0">
                                {!! str_replace(["\r\n", "\n\r", "\r", "\n"], '<br>', $group['branch']['report_footer']) !!}
                            </td>
                        </tr>
                    </tbody>
                </table>
            @endif

        @endif
    </htmlpagefooter>

</body>

</html>
