@extends('layouts.pdf')

@section('title')
    {{ __('Receipt') }}-{{ $group['id'] }}-{{ date('Y-m-d') }}
@endsection
@php    
    use App\Models\testExtraService;
    $extraService = testExtraService::where('groupId' , $group['id'])->with('extraService')->get();
@endphp

@section('content')
<br>
<br><br><br><br><br>
    <div class="invoice" style="padding-top:150px;">
        <table class="table table-bordered" width="100%">
            <thead>
                <tr>
                    @if(isset(setting("account")['show_test_name']) && setting("account")['show_test_name'])<th colspan="3" width="60%">{{ __('Test Name') }}</th> @endif
                    @if(isset(setting("account")['show_test_prices']) && setting("account")['show_test_prices']) <th width="15%">{{ __('Price') }}</th> @endif
                    @if(isset(setting("account")['show_test_date']) && setting("account")['show_test_date'])<th width="25%">موعد التسليم</th> @endif
                </tr>
            </thead>
            <tbody>

                @foreach ($group['tests'] as $test)
                    <tr>
                        @if(isset(setting("account")['show_test_name']) && setting("account")['show_test_name'])
                            <td colspan="3" class="print_title test_name">
                                @if (isset($test['test']))
                                    {{ $test['test']['name'] }}
                                @endif
                            </td>
                        @endif
                        @if(isset(setting("account")['show_test_prices']) && setting("account")['show_test_prices'])
                            <td>{{ formated_price($test['price']) }}</td>
                        @endif

                         @if(isset(setting("account")['show_test_date']) && setting("account")['show_test_date'])<td>{{ $group['resulte_date'] == null ? calcReceivedDate($group['created_at'] ,$test->test->num_day_receive,$test->test->num_hour_receive) : $group['resulte_date'] }}</td>@endif
                    </tr>
                @endforeach

                @foreach ($group['cultures'] as $culture)
                    <tr>
                        @if(isset(setting("account")['show_test_name']) && setting("account")['show_test_name'])

                            <td colspan="3" class="print_title test_name">
                                @if (isset($culture['culture']))
                                    {{ $culture['culture']['name'] }}
                                @endif
                            </td>
                        @endif
                        @if(isset(setting("account")['show_test_prices']) && setting("account")['show_test_prices'] ) <td>{{ formated_price($culture['price']) }}</td> @endif
                        @if(isset(setting("account")['show_test_date']) && setting("account")['show_test_date'])<td>{{ $group['resulte_date'] == null ? calcReceivedDate($group['created_at'] ,$culture->culture->num_day_receive,$culture->culture->num_hour_receive) : $group['resulte_date']}}</td>@endif

                    </tr>
                @endforeach

                @foreach ($group['packages'] as $package)
                    <tr>
                        @if(isset(setting("account")['show_test_name']) && setting("account")['show_test_name'])
                            <td colspan="3" class="print_title test_name">

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
                        @endif
                        @if(isset(setting("account")['show_test_prices']) && setting("account")['show_test_prices'])<td>{{ formated_price($package['price']) }}</td>@endif
                        <td></td>
                    </tr>
                @endforeach

                @foreach ($group['rays'] as $ray)
                    <tr>
                        <td colspan="3" class="print_title ray_name">
                            @if (isset($ray['ray']))
                                {{ $ray['ray']['name'] }}
                            @endif
                        </td>
                        @if(isset(setting("account")['show_test_prices']))<td>{{ formated_price($ray['price']) }}</td>@endif
                    </tr>
                @endforeach


                <tr class="receipt_title border-top" width="100%">
                    <td width="" class="no-right-border"></td>
                    <td class="total">
                        <b>{{ __('Subtotal') }}</b>
                    </td>
                    <td class="total">{{ formated_price($group['subtotal']) }}</td>
                </tr>

                @if(isset(setting("account")['show_discount_persentage'] ) && setting("account")['show_discount_persentage'])
                <tr class="receipt_title">
                    <td width="" class="no-right-border"></td>

                    <td class="total">
                        <b>
                            {{ __('Discount') }}
                        </b>
                    </td>
                    <td class="total">{{ $group['discount'] . ' %' }}</td>
                </tr>
                @endif
                @if(isset(setting("account")['show_discount_value'] ) && setting("account")['show_discount_value']  )
                <tr class="receipt_title">
                    <td width="" class="no-right-border"></td>

                    <td class="total">
                        <b>
                            {{ __('Discount') }}
                        </b>
                    </td>
                    <td class="total">{{ formated_price($group['discount_value']) }}</td>
                </tr>
                @endif

                <tr class="receipt_title">
                    <td width="" class="no-right-border"></td>
                    <td class="total">
                        <b>{{ __('Total') }}</b>
                    </td>
                    <td class="total">{{ formated_price($group['total']) }}</td>
                </tr>

                <tr class="receipt_title">
                    <td width="" class="no-right-border"></td>
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
                    <td width="" class="no-right-border"></td>
                    <td class="total">
                        <b>{{ __('Due') }}</b>
                    </td>
                    <td class="total">{{ formated_price($group['due']) }}</td>
                </tr>

            </tbody>
        </table>
    @if($extraService->isNotEmpty())
        <table width="100%">
            <tr>
                 <td style="font-family: cairo;"><b>Service Name</b></td>
                 <td style="">Description</td>
                 <td style="font-family: cairo;"><b>Price</b></td>
            </tr>
            {{--  tests  --}}
            @foreach ($extraService as $service)
            <tr>
                @if (isset($service->extraService))
                 <td style="font-family: cairo;">
                    {{ $service->extraService['name'] }}
               </td>
               <td style="font-family: cairo;">
                {{ $service->extraService['descript'] }}
           </td>
                 <td style="font-family: cairo;">{{ formated_price($service->extraService['price']) }}</td>
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
    @endif
    </div>
@endsection
