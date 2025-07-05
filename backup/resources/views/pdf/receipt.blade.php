@extends('layouts.pdf_3')
@section('title')
    {{ __('Receipt') }}-{{ $group['id'] }}-{{ date('Y-m-d') }}
@endsection
@section('content')
@if (isset($group['patient']))
<table width="100%">
    <tr>
         <td style="font-family: cairo;"><b>Invoice Num:</b></td>
         <td style="font-family: cairo;">{{ $group['id'] }}</td>
    </tr>
    <tr>
         <td style="font-family: cairo;"><b>Created At:</b></td>
         <td style="font-family: cairo;">{{ $group['sample_collection_date'] }}</td>
    </tr>

    <tr>
         <td style="font-family: cairo;"><b>Parient Name: </b></td>
        <td style="font-family: cairo;">@if (isset($group['patient']))
            {{ $group['patient']['name'] }}
        @endif</td></td>
    </tr>
</table>
<p class="text-center">@if (isset($group['patient']))
    <img src="https://chart.googleapis.com/chart?chs={{ $reports_settings['qrcode-dimension'] }}x{{ $reports_settings['qrcode-dimension'] }}&cht=qr&chl={{ url('patient/login/' . $group['patient']['code']) }}&choe=UTF-8"
        title="Link to Google.com" width="50%" />
    <br>
    <b>Patient Code </b>{{ __($group['patient']['code']) }}
    @endif
</p>
<hr>

<table width="100%">
    <tr>
         <td style="font-family: cairo;"><b>Test Name</b></td>
         <td style="font-family: cairo;"><b>Price</b></td>
    </tr>
    {{--  tests  --}}
    @foreach ($group['tests'] as $test)
    <tr>
        @if (isset($test['test']))
         <td style="font-family: cairo;">
            {{ $test['test']['name'] }}
       </td>
         <td style="font-family: cairo;">{{ formated_price($test['price']) }}</td>
        @endif
    </tr>
    @endforeach
     {{--  cultures  --}}
     @foreach ($group['cultures'] as $culture)
     <tr>
        @if (isset($culture['culture']))
          <td style="font-family: cairo;">
            {{ $culture['culture']['name'] }}
        </td>
          <td style="font-family: cairo;">{{ formated_price($culture['price']) }}</td>
         @endif
     </tr>
     @endforeach
        {{--  Rays  --}}
        @foreach ($group['rays'] as $ray)
     <tr>
        @if (isset($ray['ray']))
        <td style="font-family: cairo;">
            {{ $ray['ray']['name'] }}
        </td>
          <td style="font-family: cairo;">{{ formated_price($ray['price']) }}</td>
         @endif
     </tr>
     @endforeach
    //<tr><td colspan="2"><hr></td></tr>
    {{--  Packages  --}}
    @foreach ($group['packages'] as $package)
    <tr>
        <td style="font-family: cairo;"><b> @if (isset($package['package']))
            {{ $package['package']['name'] }}
        @endif</b></td>
         <td style="font-family: cairo;">{{ formated_price($package['price']) }}</td>
    </tr>
    <tr>
             <td style="font-family: cairo;">
                @foreach ($package['tests'] as $test)

                    <ul>{{ $test['test']['name'] }}</ul>

                @endforeach
                @foreach ($package['cultures'] as $culture)

                    <ul>{{ $culture['culture']['name'] }}</ul>

                @endforeach
            </td>
             <td style="font-family: cairo;">

            </td>
    </tr>
    @endforeach
</table>


<table width="100%">
    <tr>
         <td style="font-family: cairo;"><b>Subtotal</b></td>
         <td style="font-family: cairo;"><b>
             {{ formated_price($group['subtotal']) }}

             </b></td>
    </tr>
    <tr>
         <td style="font-family: cairo;"><b>Discount_Value</b></td>
         <td style="font-family: cairo;"><b>{{ formated_price($group['discount_value']) }}</b></td>
    </tr>
    <tr>
         <td style="font-family: cairo;"><b>Total</b></td>
         <td style="font-family: cairo;"><b>{{ formated_price($group['total']) }}</b></td>
    </tr>
</table>
<hr>
<table width="100%">
    <tr>
         <td style="font-family: cairo;"><b>Paid</b></td>
         <td style="font-family: cairo;"></td>
    </tr>
    <tr>
        <td style="font-family: cairo;">
            @foreach ($group['payments'] as $payment)
                {{ __('On') }}
                {{ $payment['date'] }}
                {{ __('By') }}
                {{ $payment['payment_method']['name'] }}
                <br>
            @endforeach
        </td>
        <td style="font-family: cairo;"><b>
            @if (count($group['payments']))
            {{ formated_price($payment['amount']) }}
             @else
             {{ formated_price(0) }}
             @endif
             </b></td>
    </tr>
    <tr>
         <td style="font-family: cairo;"><b>Total Paid</b></td>
         <td style="font-family: cairo;"><b>
            @if (count($group['payments']))
                {{ formated_price($group['paid']) }}
            @else
                {{ formated_price(0) }}
            @endif</b></td>
    </tr>
    <tr>
         <td style="font-family: cairo;"><b>Due</b></td>
         <td style="font-family: cairo;"><b>{{ formated_price($group['due']) }}</b></td>
    </tr>
</table>
<hr>
@endif
@endsection
