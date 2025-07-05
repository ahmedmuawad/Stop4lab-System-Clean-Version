@php
    use App\Models\testExtraService;
    $extraService = testExtraService::where('groupId', $group['id'])
        ->with('extraService')
        ->get();
@endphp

@extends('layouts.pdf_3')
@section('title')
    {{ __('Receipt') }}-{{ $group['id'] }}-{{ date('Y-m-d') }}
@endsection
@section('content')
    @if (isset($group['patient']))
        <table width="100%" style="overflow: wrap">
            <tr>
                <td><b class="sty">{{ __('Invoice Num') }}:</b></td>
                <td><b class="sty">{{ $group['id'] }}</b></td>
            </tr>
            <tr>
                <td><b class="sty">{{ __('Created At') }}:</b></td>
                <td> <b class="sty">{{ $group['sample_collection_date'] }}</b></td>
            </tr>

            <tr>
                <td><b class="sty">{{ __('Parient Name') }}: </b></td>
                <td>
                    @if (isset($group['patient']))
                        <b class="sty">{{ $group['patient']['prefix'] }} / {{ $group['patient']['name'] }}</b>
                    @endif
                </td>
                </td>
            </tr>
        </table>
        <p class="text-center">
            @if (isset($group['patient']))
                @if (isset($reports_settings['qrcode_to_pdf']) && $reports_settings['qrcode_to_pdf'] == 'on')
                    <img src="https://chart.googleapis.com/chart?chs={{ $reports_settings['qrcode-dimension'] }}x{{ $reports_settings['qrcode-dimension'] }}&cht=qr&chl={{ $group['report_pdf'] }}&choe=UTF-8"
                        title="Link to Google.com" width="50%" />
                @else
                    <img src="https://chart.googleapis.com/chart?chs={{ $reports_settings['qrcode-dimension'] }}x{{ $reports_settings['qrcode-dimension'] }}&cht=qr&chl={{ url('patient/login/' . $group['patient']['code']) }}&choe=UTF-8"
                        title="Link to Google.com" width="50%" />
                @endif
                <br>
                <b style="font-family: cairo;">{{ __('Patient_Code') }} </b>{{ __($group['patient']['code']) }}
            @endif
        </p>
        <hr>

        <table width="100%" style="overflow: wrap">
            @foreach ($group['tests'] as $test)
                <tr>
                    @if (isset($test['test']))
                        @if (isset(setting('account')['show_test_name']) && setting('account')['show_test_name'])
                            <td>
                                <b class="sty">{{ $test['test']['name'] }}</b>
                            </td>
                        @endif
                        @if (isset(setting('account')['show_test_prices']) && setting('account')['show_test_prices'])
                            <td><b class="sty">{{ formated_price($test['price']) }}</b></td>
                        @endif
                    @endif
                </tr>
            @endforeach
            {{--  cultures  --}}
            @foreach ($group['cultures'] as $culture)
                <tr>
                    @if (isset($culture['culture']))
                        @if (isset(setting('account')['show_test_name']) && setting('account')['show_test_name'])
                            <td>
                                <b class="sty">{{ $culture['culture']['name'] }}</b>
                            </td>
                        @endif
                        @if (isset(setting('account')['show_test_prices']) && setting('account')['show_test_prices'])
                            <td>
                                <b class="sty">{{ formated_price($culture['price']) }}</b>
                            </td>
                        @endif
                    @endif
                </tr>
            @endforeach
            {{--  Rays  --}}
            @foreach ($group['rays'] as $ray)
                <tr>
                    @if (isset($ray['ray']))
                        <td>
                            <b class="sty">{{ $ray['ray']['name'] }}</b>
                        </td>
                        @if (isset(setting('account')['show_test_prices']) && setting('account')['show_test_prices'])
                            <td><b class="sty">{{ formated_price($ray['price']) }}</b></td>
                        @endif
                    @endif
                </tr>
            @endforeach

            @foreach ($group['packages'] as $package)
                <tr>
                    @if (isset(setting('account')['show_test_name']) && setting('account')['show_test_name'])
                        <td><b class="sty">
                                @if (isset($package['package']))
                                    {{ $package['package']['name'] }}
                                @endif
                            </b>
                        </td>
                    @endif

                    @if (isset(setting('account')['show_test_prices']) && setting('account')['show_test_prices'])
                        <td><b class="sty">{{ formated_price($package['price']) }}</b></td>
                    @endif
                </tr>
                <tr>
                    <td>
                        @if (isset(setting('account')['show_test_name']) && setting('account')['show_test_name'])
                            @foreach ($package['tests'] as $test)
                                <ul class="sty">{{ $test['test']['name'] }}</ul>
                            @endforeach
                            @foreach ($package['cultures'] as $culture)
                                <ul>{{ $culture['culture']['name'] }}</ul>
                            @endforeach
                        @endif
                    </td>
                    <td class="sty"style="font-family: cairo;">

                    </td>
                </tr>
            @endforeach
        </table>


        <table width="100%" style="overflow: wrap">
         
            @foreach ($extraService as $service)
                <tr>
                    @if (isset($service->extraService))
                        <td>
                            <b class="sty">{{ $service->extraService['name'] }}</b>
                        </td>
                        <td>
                            <b class="sty"> {{ $service->extraService['descript'] }}</b>
                        </td>
                        @if (isset(setting('account')['show_test_prices']) && setting('account')['show_test_prices'])
                            <td><b class="sty">{{ formated_price($service->extraService['price']) }}</b></td>
                        @endif
                    @endif
                </tr>
            @endforeach
            {{--  cultures  --}}
            @foreach ($group['cultures'] as $culture)
                <tr>
                    @if (isset($culture['culture']))
                        <td>
                            {{ $culture['culture']['name'] }}
                        </td>
                        @if (isset(setting('account')['show_test_prices']) && setting('account')['show_test_prices'])
                            <td>
                                <b class="sty">{{ formated_price($culture['price']) }}</b>

                            </td>
                        @endif
                    @endif
                </tr>
            @endforeach
            {{--  Rays  --}}
            @foreach ($group['rays'] as $ray)
                <tr>
                    @if (isset($ray['ray']))
                        <td>
                            <b class="sty"> {{ $ray['ray']['name'] }}</b>
                        </td>
                        @if (isset(setting('account')['show_test_prices']) && setting('account')['show_test_prices'])
                            <td>
                                <b class="sty">{{ formated_price($ray['price']) }}</b>
                            </td>
                        @endif
                    @endif
                </tr>
            @endforeach
            //<tr>
                <td class="sty"colspan="2">
                    <hr>
                </td>
            </tr>
            {{--  Packages  --}}
            @foreach ($group['packages'] as $package)
                <tr>
                    <td><b class="sty">
                            @if (isset($package['package']))
                                {{ $package['package']['name'] }}
                            @endif
                        </b>
                    </td>
                    @if (isset(setting('account')['show_test_prices']) && setting('account')['show_test_prices'])
                        <td><b class="sty">{{ formated_price($package['price']) }}</b></td>
                    @endif
                </tr>
                <tr>
                    <td>
                        @foreach ($package['tests'] as $test)
                            <ul>{{ $test['test']['name'] }}</ul>
                        @endforeach
                        @foreach ($package['cultures'] as $culture)
                            <ul>{{ $culture['culture']['name'] }}</ul>
                        @endforeach
                    </td>
                    <td class="sty"style="font-family: cairo;">

                    </td>
                </tr>
            @endforeach
        </table>

        <table width="100%" style="overflow: wrap">
            <tr>
                <td><b class="sty">{{ __('Subtotal') }}</b></td>
                <td><b class="sty">
                        {{ formated_price($group['subtotal']) }}

                    </b></td>
            </tr>
            @if (isset(setting('account')['show_discount_value']) && setting('account')['show_discount_value'])
                <tr>
                    <td><b class="sty">{{ __('Discount_Value') }}</b></td>
                    <td><b class="sty">{{ formated_price($group['discount_value']) }}</b></td>
                </tr>
            @endif
            <tr>
                <td><b class="sty">{{ __('Total') }}</b></td>
                <td><b class="sty">{{ formated_price($group['total']) }}</b></td>
            </tr>
        </table>
        <hr>
        <table width="100%" style="overflow: wrap">
            <tr>
                <td><b class="sty">{{ __('Paid') }}</b></td>
            </tr>
            <tr>
                @if (count($group['payments']) > 0)
                    <td>
                        @foreach ($group['payments'] as $payment)
                            <b class="sty">
                                {{ __('On') }}
                                {{ $payment['date'] }}
                                {{ __('By') }}
                                {{ $payment['payment_method']['name'] }}
                            </b>
                            <br>
                        @endforeach
                    </td>
                @endif
                <td><b class="sty">
                        @if (count($group['payments']))
                            {{ formated_price($payment['amount']) }}
                        @else
                            {{ formated_price(0) }}
                        @endif
                    </b></td>
            </tr>
            <tr>
                <td><b class="sty">{{ __('Total Paid') }}</b></td>
                <td class="sty"style="font-family: cairo;"><b class="sty">
                        @if (count($group['payments']))
                            {{ formated_price($group['paid']) }}
                        @else
                            {{ formated_price(0) }}
                        @endif
                    </b></td>
            </tr>
            <tr>
                <td><b class="sty">{{ __('Due') }}</b></td>
                <td><b class="sty">{{ formated_price($group['due']) }}</b></td>
            </tr>
        </table>
        <hr>
    @endif
@endsection
