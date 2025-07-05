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
        @if ($type == 3 || $type == 4 || $type == 5 || $type == 6 || $type == 7)
            @page {
                margin-top: 10px;
                margin-right: 10px;
                margin-left: 10px;
                margin-bottom:10px;
                sheet-size: A4;
            }
        @else
            @page {
                header: page-header;
                footer: page-footer;
                margin-left: 10px;
                margin-right: 10px;
                margin-top: 20px;
                /* margin-header: 135px; */
                /* margin-bottom: 80px; */
                /* margin-footer: 0px; */
                sheet-size: A4;
            }
        @endif
        body,
        html {
            margin: 0;
            padding: 0;font-family: 'cairo' !important;
            direction:rtl !important; 
        }

        h1 {
            font-family: 'cairo' !important;
            text-decoration: underline;
        }

        .divBorder {
            text-decoration: underline;
            width: 100%;
            font-weight: bold;
            border: 1px solid #000;
            border-radius: 10px;

        }
        /* td , tr{
            border: unset !important;
        } */
        .testsTable ,.testsTable tr{
            border:1px solid #000 !important;
            border-radius: 5px;
        }
        .testsTable td  , .testsTable th{
            border-bottom:1px solid #000 !important;
        }
        .testsTable thead{
            background-color: #ddd !important;
        }
        td{
            font-family: cairo;
            font-size:18px;
            font-weight: bold;
        }
        .calcuTable{
            padding-right: 7% !important;
            margin-right: 7% !important;
        }
        .footer{
            margin-top:30px !important;
            width:100% !important; 
            padding-top:20px !important;
            border:1px solid #000 !important;
            width:100% !important;
            border-radius: 5px !important;


        }
        .border{
            border:1px solid #000 !important;
            padding-top:4px !important;
            padding-bottom:4px !important;
            border-radius: 5px !important;
        }
        .firstLine{
            font-size:26px !important;
            font-weight: bold !important;
        }
        .firstLine p{
            text-align: center !important;
            margin-top:0px !important;
            margin-bottom:0px !important;
            font-size:23px !important;

        }
    </style>
</head>

<body dir="rtl" style="direction: rtl !important">
    @yield('content')
</body>

</html>
