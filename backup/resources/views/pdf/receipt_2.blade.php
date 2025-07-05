@extends('layouts.pdf_2')
@section('title')
    {{ __('Receipt') }}-{{ $group['id'] }}-{{ date('Y-m-d') }}
@endsection
@section('content')
    <div class="invoice">

        <table class="table table-bordered" width="100%">
            <thead>
                <tr>
                    <th colspan="2" width="85%">{{ __('Test Name') }}</th>
                    <th width="15%">{{ __('Price') }}</th>
                </tr>
            </thead>
            <tbody>

                @php
                    $num_date = '';
                    $created_at_report = '';
                    // get num_date from relationship tests
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
                @endphp

                <div class="test_title" align="center"> {{ $diff->format('Y-m-d') }} : <b>تاريخ الاستلام</b>
                </div>

                @foreach ($group['tests'] as $test)
                    <tr>
                        <td colspan="2" class="print_title test_name">
                            @if (isset($test['test']))
                                {{ $test['test']['name'] }}
                            @endif
                        </td>
                        <td>{{ formated_price($test['price']) }}</td>
                    </tr>
                @endforeach

                @foreach ($group['cultures'] as $culture)
                    <tr>
                        <td colspan="2" class="print_title test_name">
                            @if (isset($culture['culture']))
                                {{ $culture['culture']['name'] }}
                            @endif
                        </td>
                        <td>{{ formated_price($culture['price']) }}</td>
                    </tr>
                @endforeach

                @foreach ($group['packages'] as $package)
                    <tr>
                        <td colspan="2" class="print_title test_name">
                            @if (isset($package['package']))
                                {{ $package['package']['name'] }}
                            @endif
                            <ul>
                                @foreach ($package['tests'] as $test)
                                    <li>
                                        {{ $test['test']['name'] }}
                                    </li>
                                @endforeach
                                @foreach ($package['cultures'] as $culture)
                                    <li>
                                        {{ $culture['culture']['name'] }}
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ formated_price($package['price']) }}</td>
                    </tr>
                @endforeach

                @foreach ($group['rays'] as $ray)
                    <tr>
                        <td colspan="2" class="print_title ray_name">
                            @if (isset($ray['ray']))
                                {{ $ray['ray']['name'] }}
                            @endif
                        </td>
                        <td>{{ formated_price($ray['price']) }}</td>
                    </tr>
                @endforeach
                <tr class="receipt_title border-top">
                    <td width="50%" class="no-right-border"></td>
                    <td class="total">
                        <b>{{ __('Subtotal') }}</b>
                    </td>
                    <td class="total">{{ formated_price($group['subtotal']) }}</td>
                </tr>

                <tr class="receipt_title">
                    <td width="50%" class="no-right-border"></td>
                    <td class="total">
                        <b>
                            {{ __('Discount') }}
                        </b>
                    </td>
                    <td class="total">{{ $group['discount'] . ' %' }}</td>
                </tr>

                <tr class="receipt_title">
                    <td width="50%" class="no-right-border"></td>
                    <td class="total">
                        <b>{{ __('Total') }}</b>
                    </td>
                    <td class="total">{{ formated_price($group['total']) }}</td>
                </tr>

                <tr class="receipt_title">
                    <td width="50%" class="no-right-border"></td>
                    <td class="total">
                        <b>
                            {{ __('Paid') }}
                        </b>
                        <br>
                        @foreach ($group['payments'] as $payment)
                            {{ formated_price($payment['amount']) }}
                            <b>{{ __('On') }}</b>
                            {{ $payment['date'] }}
                            <b>{{ __('By') }}</b>
                            {{ $payment['payment_method']['name'] }}
                            <br>
                        @endforeach
                    </td>
                    <td class="total">
                        @if (count($group['payments']))
                            {{ formated_price($group['paid']) }}
                        @else
                            {{ formated_price(0) }}
                        @endif
                    </td>
                </tr>

                <tr class="receipt_title">
                    <td width="50%" class="no-right-border"></td>
                    <td class="total">
                        <b>{{ __('Due') }}</b>
                    </td>
                    <td class="total">{{ formated_price($group['due']) }}</td>
                </tr>

            </tbody>
        </table>
    </div>
@endsection
