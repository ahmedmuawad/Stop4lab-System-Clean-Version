<!DOCTYPE html>
<html>
@php
    $currentLang = App::getLocale();
    if (setting('invoices')['direction'] == 'rtl') {
        App::setLocale('ar');
    } else {
        App::setLocale('en');
    }
@endphp

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
        .sty{
            font-size:@php echo setting('invoices')['font_size'].'px!important' @endphp;
            font-family:@php echo setting('invoices')['font-family'].'!important' @endphp;
        }
        @if (session('rtl'))
            .pdf-header {
                direction: rtl !important;
            }

        @endif
        @media print {
            @page {
                margin: 15px 15px;
                /* imprtant to logo margin */
                sheet-size: 300px 250mm;
                /* imprtant to set paper size */
                font-family: cairo;
            }

            html {
                direction: rtl !important;
                font-family: cairo;
            }

            html,
            body {
                margin: 15;
                direction: rtl !important;
                padding: 0
            }

            #printContainer {
                width: 250px;
                margin: 0;
                padding: 10px;
                font-family: cairo;
                text-align: justify;
            }

            .text-center {
                text-align: center;
            }
        }
        
    </style>
</head>

<body onload="window.print();"
    @if (isset(setting('invoices')['direction'])) 
    style="direction:{{ setting('invoices')['direction'] }} @endif">
    
    <div id="logo" class="text-center">
        <img src='https://nbdlab.stop4labs.com/img/logo-new.png' alt='Logo' style="width: 150px; height: 150px;margin-top:0">
    </div>

    <div id='printContainer'>
        <h2 id="slogan" style="margin-top:0; font-family: cairo;" class="text-center">{{ $info['name'] }}</h2>

        @if ($group['including_portal_number'] == 1 && isset(setting('info')['portalID']))
            <p class="text-center" style="font-family: cairo;margin-top:0;margin-bottom: 0px">
                {{ __('PortalID') }}: {{ setting('info')['portalID'] }}
            </p>
        @endif
    </div>

    @yield('content')
    <footer>
        <table width="100%">
            <tr>
                <td style="font-family: cairo;">{{ $group['branch']['address'] }}</td>
                <td style="font-family: cairo;">{{ $group['branch']['phone'] }}</td>
            </tr>
        </table>
    </footer>
    @if (isset(setting('info')['portalID']))
        <br><br><br>
    @endif
</body>
@php
    App::setLocale($currentLang);
@endphp

</html>