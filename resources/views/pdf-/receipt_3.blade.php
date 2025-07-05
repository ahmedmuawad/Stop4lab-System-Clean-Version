@extends('layouts.recieplLayout')
@section('title')
    {{ __('Receipt') }}-{{ $group['id'] }}-{{ date('Y-m-d') }}
@endsection
@section('content')
    <div class="header">
        <h1 align="center">{{ __('Receipt') }}</h1>
    </div>
    <div class="divBorder" style="padding:0;margin:0">
        <h3 align="center">{{ setting('info')['name'] }}</h3>
    </div>
    <br>
    <div class="border">
        <table style="direction: rtl !important;padding:0px !important;">
            <tbody style="padding:0px !important;">
                <tr style="padding:0px !important;">
                    <td width="25%">
                        {{ Carbon\Carbon::now() }}
                    </td>

                    <td width="25%">
                        {{ __('Date') }}
                    </td>
                    <td width="25%">
                        {{ $group['patient']['code'] }}
                    </td>
                    <td width="25%" align="right">
                        {{ __('code') }}
                    </td>
                </tr>

                <tr>
                    <td width="25%">
                        {{ $group['patient']['name'] }}
                    </td>

                    <td width="25%">
                        {{ __('name') }}
                    </td>

                    <td width="25%">
                        {{ $group->review_date }}
                    </td>

                    <td width="25%" align="right">
                        {{ __('Recivied_Date') }}
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <table class="testsTable" align="center" width="80%">
            <thead>
                <tr style="background-color:#ddd !important;border:1px solid #000 !important">
                    <th align="center">
                        {{ __('Test') }}
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($group['tests'] as $test)
                    <tr style="border:1px solid #000 !important">
                        <td align="center">{{ Str_replace(['(', ')'], '', $test->test->name) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        <div width="80%" style="padding-left:0px !important;">
            <table width="100%" class="calcuTable" style="float: right" {{-- style="padding-left: 10% !impotant;padding-right:10%!important;margin-left:10% !important;margin-right:10% !imporatnt" --}}>
                <tbody>
                    <tr>
                        <td width="20%">{{ __('Price') }}</td>
                        <td width="20%">{{ $group['total'] }}</td>
                    </tr>

                    <tr>
                        <td width="20%">{{ __('Paid') }}</td>
                        <td width="20%">{{ $group['paid'] }}</td>
                        <td width="15%"></td>
                        <td width="15%"></td>
                        <td width="30%">
                            {{ $group['paid'] }}
                            جنيها فقط لا غير
                        </td>
                    </tr>

                    <tr>
                        <td width="20%">{{ __('Discount') }}</td>
                        <td width="20%">{{ $group['discount_value'] }}</td>
                    </tr>

                    <tr>
                        <td width="20%">{{ __('Urget') }}</td>
                        <td width="20%">{{ $group['discount_value'] }}</td>
                        <td width="15%"></td>
                        <td width="15%"></td>

                        <td width="20%">
                            اسعار أساسية
                        </td>
                    </tr>
                    <tr>
                        <td width="40%">
                            <hr />
                        </td>
                    </tr>

                    <tr>
                        <td width="20%">{{ __('Due') }}</td>
                        <td width="20%">{{ $group['due'] }}</td>
                        <td width="15">

                        </td>
                        <td width="15">

                        </td>
                        <td width="20%">
                            <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($group['barcode'], 'C128') }}"
                                alt="barcode" width="40%" height="10mm">
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
    <br>
    <div class="address footer" style="margin-top:10px !important">
        @php
            $currentBranch = session('branch_id');
            $branch = App\Models\Branch::where('id', $currentBranch)->first();
        @endphp
        <div class="firstLine" style="font-size:24px !important;font-weight:bold" width="100%" align="center">
            <p>{{ $branch->address }}</p>
        </div>

        <div class="firstLine" style="font-size:24px !important;font-weight:bold" width="100%" align="center">
            <p>
                ت : {{ $branch->phone }}
                -
                واتس اب :
                {{ $branch->phone }}
            </p>
        </div>
        <div class="firstLine" style="font-size:24px !important;font-weight:bold;margin-right:10% !important" width="100%"
            align="center">
            <p>المعمل حاصل علي شهادة الآيزو 9001</p>
        </div>

        <div class="firstLine" style="font-size:24px !important;font-weight:bold;margin-right:20% !important" width="100%"
            align="center">
            <p>عفوا النتائج لا تبلغ تليفونيا</p>
        </div>
    </div>
@endsection