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
        @if(session('rtl'))
            .pdf-header{
                direction:ltr;
            }
        @endif
        @media print {
            @page {
                margin: 15px 15px; /* imprtant to logo margin */
                sheet-size: 80mm 350mm; /* imprtant to set paper size */
                font-family: cairo;
            }
            html {
                direction: ltr;
                font-family: cairo;
            }
            html,body{margin:15;padding:0}
            #printContainer {
                width: 250px;
                margin: 0;
                padding: 10px;
                font-family: cairo;
                text-align: justify;
            }

           .text-center{text-align: center;}

        }
    </style>

</head>
<body onload="window.print();">
    <h1 id="logo" class="text-center"><img src='{{ url('img/logo.png') }}' alt='Logo' style="width: 75px; height: 75px margin-top:0;"></h1>

    <div id='printContainer'>
        <h2 id="slogan" style="margin-top:0; font-family: cairo;" class="text-center">{{ $info['name'] }}</h2>



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


</body>

</html>
