@extends('layouts.pdf_3')
@section('title')
    {{ __('Receipt') }}-{{ $group['id'] }}-{{ date('Y-m-d') }}
@endsection
@section('content')
<table width="100%">
    <tr>
         <td style="font-family: cairo;"><b>Test Name</b></td>
         @if(isset(setting("account")['show_test_prices']) && setting("account")['show_test_prices'])
         <td style="font-family: cairo;"><b>Price</b></td>
         @endif
    </tr>
    {{--  tests  --}}
    @foreach ($group['tests'] as $test)
    <tr>
        @if (isset($test['test']))
         <td style="font-family: cairo;">
            {{ $test['test']['name'] }}
       </td>
       @if(isset(setting("account")['show_test_prices']) && setting("account")['show_test_prices'])
       
       <td style="font-family: cairo;">{{ formated_price($test['price']) }}</td>
       @endif
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
        @if(isset(setting("account")['show_test_prices']) && setting("account")['show_test_prices'])
        <td style="font-family: cairo;">{{ formated_price($culture['price']) }}</td>
        @endif
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
        @if(isset(setting("account")['show_test_prices']) && setting("account")['show_test_prices'])
        <td style="font-family: cairo;">{{ formated_price($ray['price']) }}</td>
        @endif 
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
        @if(isset(setting("account")['show_test_prices']) && setting("account")['show_test_prices'])
        <td style="font-family: cairo;">{{ formated_price($package['price']) }}</td>
        @endif
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
    @if(isset(setting("account")['show_discount_value'] ) && setting("account")['show_discount_value']  )

    <tr>
         <td style="font-family: cairo;"><b>Discount_Value</b></td>
         <td style="font-family: cairo;"><b>{{ formated_price($group['discount_value']) }}</b></td>
    </tr>
    @endif
    <tr>
         <td style="font-family: cairo;"><b>Total</b></td>
         <td style="font-family: cairo;"><b>{{ formated_price($group['total']) }}</b></td>
    </tr>
</table>
@endsection
