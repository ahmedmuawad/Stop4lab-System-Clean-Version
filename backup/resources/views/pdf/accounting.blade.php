@extends('layouts.pdf_2')
@section('title')
    {{ __('Accounting report') }}-{{ date('Y-m-d') }}
@endsection
@section('content')
    <style>
        .title {
            font-size: 20px;
            background-color: #dddddd;
            border: 1px solid black !important;
            margin-bottom: 10px;
            font-family: 'arial';
        }

        .table {
            margin-top: 20px;
            font-family: 'arial';
        }

        .accounting_header {
            border: 2px solid black;
            background-color: #F0F0F0;
            font-family: 'arial';
        }

        th {
            font-family: 'arial';
        }
    </style>

    @if(array_key_exists('payments', $data))
        <div class="accounting_header">
            <h3 align="center">
                <img src="data:image/png;base64,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"
                     width="15px" alt="">
                {{ __('Accounting Report') }}
                {{ __('Due Date') }} : {{ date('Y-m-d') }} <br>
                {{ __('From Date') }} {{ date('Y-m-d', strtotime($data['from'])) }} {{ __('To Date') }}
                {{ date('Y-m-d', strtotime($data['to'])) }} <br>
                {{ __('Branches') }} : <br>
                @foreach ($data['branches'] as $branche)
                    {{ $branche->name }}
                    <br>
                @endforeach  
            </h3>
        </div>
        <!-- Report Details -->
        <table class="table table-bordered">
            <thead>
            <tr class="title">
                <th colspan="11">
                    {{ __('Invoices') }}
                </th>
            </tr>
            <tr>
                <th>#</th>
                <th>{{ __('Date') }}</th>
                <th>{{ __('Patient Name') }}</th>
                <th>{{ __('Doctor') }}</th>
                <th>{{ __('Contract') }}</th>
                <th>{{ __('Tests') }}</th>
                <th>{{ __('Subtotal') }}</th>
                <th>{{ __('Discount') }}</th>
                <th>{{ __('Total') }}</th>
                <th>{{ __('Paid') }}</th>
                <th>{{ __('Due') }}</th>
            </tr>
            </thead>
            <tbody>
            @if (count($data['groups']) == 0)
                <tr>
                    <td colspan="11" align="center">
                        {{ __('No data available') }}
                    </td>
                </tr>
            @endif
            @foreach ($data['groups'] as $group)
                <tr>
                    <td align="center">
                        {{ $group['id'] }}
                    </td>
                    <td align="center">
                        {{ date('Y-m-d H:i', strtotime($group['created_at'])) }}
                    </td>
                    <td align="center">
                        @if (isset($group['patient']))
                            {{ $group['patient']['name'] }}
                        @endif
                    </td>
                    <td align="center">
                        @if (isset($group['doctor']))
                            {{ $group['doctor']['name'] }}
                        @endif
                        @if (isset($group['normalDoctor']))
                            {{ $group['normalDoctor']['name'] }}
                        @endif
                    </td>
                    <td align="center">
                        @if (isset($group['contract']))
                            {{ $group['contract']['title'] }}
                        @endif
                    </td>
                    <td>
                        <ul class="p-2">
                            @foreach ($group['tests'] as $test)
                                <li>{{ $test['test']['name'] }}</li>
                            @endforeach
                            @foreach ($group['cultures'] as $culture)
                                <li>{{ $culture['culture']['name'] }}</li>
                            @endforeach
                            @foreach($group['rays'] as $ray)
                                <li>{{$ray['ray']['name']}}</li>
                            @endforeach
                        </ul>
                        @foreach($group['packages'] as $package)
                            @if (isset($package['package']))
                              <b class="p-0 m-0">
                                {{$package['package']['name']}}
                              </b>
                              <ul class="pl-4 m-0">
                                @foreach($package['tests'] as $test)
                                  <li>{{$test['test']['name']}}</li>
                                @endforeach
                                @foreach($package['cultures'] as $culture)
                                  <li>{{$culture['culture']['name']}}</li>
                                @endforeach
                              </ul>
                            @endif
                        @endforeach
                    </td>
                    <td align="center">{{ formated_price($group['subtotal']) }}</td>
                    <td align="center">{{ formated_price($group['discount']) }}</td>
                    <td align="center">{{ formated_price($group['total']) }}</td>
                    <td align="center">{{ formated_price($group['paid']) }}</td>
                    <td align="center">{{ formated_price($group['due']) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <!-- \Report Details -->

        <!-- Payments Details -->
        <table class="table table-bordered" width="100%">
            <thead>
            <tr class="title">
                <th colspan="5">
                    {{ __('Payments') }}
                </th>
            </tr>
            <tr>
                <th width="2px" align="center">#</th>
                <th width="2px" align="center">#{{ __('Invoice') }}</th>
                <th>{{__('Patient')}}</th>
                <th>{{__('Doctor')}}</th>
                <th>{{__('Contract')}}</th>
                <th>{{__('Tests')}}</th>
                <th>{{ __('Date') }}</th>
                <th>{{ __('Amount') }}</th>
                <th>{{ __('Payment method') }}</th>
            </tr>
            </thead>
            <tbody>
            @if (count($data['payments']) == 0)
                <tr>
                    <td colspan="5" align="center">
                        {{ __('No data available') }}
                    </td>
                </tr>
            @endif
            @foreach ($data['payments'] as $payment)
                <tr>
                    <td width="2px" align="center">{{ $payment['id'] }}</td>
                    <td width="2px" align="center">{{ $payment['group_id'] }}</td>
                    <td align="center">
                        {{$payment['group']['patient']['name']}}
                    </td>
                    <td align="center">
                    @isset($payment['group']['doctor'])
                        {{$payment['group']['doctor']['name']}}
                    @endisset
                    @isset($payment['group']['normalDoctor'])
                        {{$payment['group']['normalDoctor']['name']}}
                    @endisset
                    
                    </td>
                    <td align="center">
                    @isset($payment['group']['contract'])
                        {{$payment['group']['contract']['title']}}
                    @endisset
                    </td>
                    <td align="center">
                    <ul>

                        @foreach($payment['group']['all_tests'] as $test)
                            <li>{{ $test->test->name }}</li>
                            
                        @endforeach
                    
                    </ul>
                    </td>
                    <td align="center">{{ $payment['date'] }}</td>
                    <td align="center">{{ formated_price($payment['amount']) }}</td>
                    <td align="center">
                        @if ($payment['payment_method'])
                            {{ $payment['payment_method']['name'] }}
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <!-- \Payments Details -->

        <!-- Expenses Details -->
        <table class="table table-bordered" width="100%">
            <thead>
            <tr class="title">
                <th colspan="5">
                    {{ __('Expenses') }}
                </th>
            </tr>
            <tr>
                <th width="2px">#</th>
                <th>{{ __('Category') }}</th>
                <th>{{ __('Date') }}</th>
                <th>{{ __('Amount') }}</th>
                <th>{{ __('Payment method') }}</th>
                <th>{{__('Created By')}}</th>
                <th>{{__('Notes')}}</th>
                <th>{{__('Branch')}}</th>
            </tr>
            </thead>
            <tbody>
            @if (count($data['expenses']) == 0)
                <tr>
                    <td colspan="5" align="center">
                        {{ __('No data available') }}
                    </td>
                </tr>
            @endif
            @foreach ($data['expenses'] as $expense)
                <tr>
                    <td align="center">{{ $expense['id'] }}</td>
                    <td align="center">
                        @if (isset($expense['category']))
                            {{ $expense['category']['name'] }}
                        @endif
                    </td>
                    <td align="center">{{ date('Y-m-d', strtotime($expense['date'])) }}</td>
                    <td align="center">{{ formated_price($expense['amount']) }}</td>
                    <td align="center">{{ $expense['payment_method']['name'] }}</td>
                    <td align="center">@if(isset($expense['doctor'])) {{ $expense['doctor']['name'] }} @endif</td>
                    <td align="center">{{ strip_tags($expense['notes'])}}</td>
                    <td align="center">{{ $expense['branch']['name'] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <!-- \Expenses Details -->

        <!-- Purchase Payments Details -->
        <table class="table table-bordered" width="100%">
            <thead>
            <tr class="title">
                <th colspan="5">
                    {{ __('Purchase payments') }}
                </th>
            </tr>
            <tr>
                <th width="2px" align="center">#</th>
                <th width="2px" align="center">#{{ __('Purchase') }}</th>
                <th>{{ __('Date') }}</th>
                <th>{{ __('Amount') }}</th>
                <th>{{ __('Payment method') }}</th>
            </tr>
            </thead>
            <tbody>
            @if (count($data['purchase_payments']) == 0)
                <tr>
                    <td colspan="5" align="center">
                        {{ __('No data available') }}
                    </td>
                </tr>
            @endif
            @foreach ($data['purchase_payments'] as $payment)
                <tr>
                    <td width="2px" align="center">{{ $payment['id'] }}</td>
                    <td width="2px" align="center">{{ $payment['purchase_id'] }}</td>
                    <td align="center">{{ $payment['date'] }}</td>
                    <td align="center">{{ formated_price($payment['amount']) }}</td>
                    <td align="center">{{ $payment['payment_method']['name'] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <!-- \Purchase Payments Details -->

        <!--  Report Summary  -->
        <table class="table table-bordered" width="100%">
            <thead>
            <tr class="title">
                <th colspan="2">
                    {{ __('Accounting Report Summary') }}
                </th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th width="100px" align="left">{{ __('Total') }}:</th>
                <td>{{ formated_price($data['total']) }}</td>
            </tr>
            <tr>
                <th width="100px" align="left">{{ __('Paid') }}:</th>
                <td>{{ formated_price($data['paid']) }}</td>
            </tr>
            <tr>
                <th width="100px" align="left">{{ __('Due') }}:</th>
                <td>{{ formated_price($data['due']) }}</td>
            </tr>
            <tr>
                <th width="100px" align="left">{{ __('Expenses') }}:</th>
                <td>{{ formated_price($data['total_expenses']) }}</td>
            </tr>
            <tr>
                <th width="100px" align="left">{{ __('Delayed Money') }}:</th>
                <td>{{ formated_price($data['delayed_money']) }}</td>
            </tr>
            <tr>
                <th width="100px" align="left">{{ __('Purchases') }}:</th>
                <td>{{ formated_price($data['total_purchases']) }}</td>
            </tr>
            <tr>
                <th width="100px" align="left">{{ __('Profit') }}:</th>
                <td>{{ formated_price($data['profit']) }}</td>
            </tr>
            <tr>
                <th width="100px" align="left">{{ __('Total After Custody') }}:</th>
                <td>{{ formated_price($data['custody']) }}</td>
            </tr>
            </tbody>
        </table>
        <!-- \ Report Summary-->

        {{-- branch summary --}}
            @foreach ($data['branchSummary'] as $branch)
            <table class="table table-bordered" width="100%">
                <thead>
                    <tr class="title">
                        <th colspan="2">
                            {{ __('Accounting Report Summary') }} - {{ $branch->name }}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th width="100px" align="left">{{ __('Total') }}:</th>
                        <td>{{ formated_price($branch->total) }}</td>
                    </tr>
                    <tr>
                        <th width="100px" align="left">{{ __('Paid') }}:</th>
                        <td>{{ formated_price($branch->paid) }}</td>
                    </tr>
                    <tr>
                        <th width="100px" align="left">{{ __('Due') }}:</th>
                        <td>{{ formated_price($branch->due) }}</td>
                    </tr>
                    <tr>
                        <th width="100px" align="left">{{ __('Total After Custody') }}:</th>
                        <td>{{ formated_price($branch->custody) }}</td>
                    </tr>
                    <tr>
                        <th width="100px" align="left">{{ __('Expenses') }}:</th>
                        <td>{{ formated_price($branch->expenses) }}</td>
                    </tr>
                </table>
            @endforeach
        {{-- branch summary --}}

        <!--  Balance  -->
        <table class="table table-bordered" width="100%">
            <thead>
            <tr class="title">
                <th colspan="4">
                    {{ __('Balance') }}
                </th>
            </tr>
            <tr>
                <th>
                    {{ __('Payment method') }}
                </th>
                <th>
                    {{ __('Income') }}
                </th>
                <th>
                    {{ __('Expense') }}
                </th>
                <th>
                    {{ __('Balance') }}
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach ($data['payment_methods'] as $payment_method)
                <tr>
                    <td>{{ $payment_method['name'] }}</td>
                    <td align="center">{{ formated_price($payment_method['income']) }}</td>
                    <td align="center">{{ formated_price($payment_method['expense']) }}</td>
                    <td align="center">{{ formated_price($payment_method['balance']) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <!-- \ Balanace -->

        <!-- Report Details groupsDelay -->
        <table class="table table-bordered" width="100%">
            <thead>
            <tr class="title">
                <th colspan="11">
                    {{ __('Delayed Money') }}
                </th>
            </tr>
            <tr>
                <th>#</th>
                <th>{{ __('Date') }}</th>
                <th>{{ __('Patient Name') }}</th>
                <th>{{ __('Doctor') }}</th>
                <th>{{ __('Contract') }}</th>
                <th>{{ __('Tests') }}</th>
                <th>{{ __('Subtotal') }}</th>
                <th>{{ __('Discount') }}</th>
                <th>{{ __('Total') }}</th>
                <th>{{ __('Paid') }}</th>
                <th>{{ __('Due') }}</th>
            </tr>
            </thead>
            <tbody>
            @if (count($data['groupsDelay']) == 0)
                <tr>
                    <td colspan="11" align="center">
                        {{ __('No data available') }}
                    </td>
                </tr>
            @endif
            @foreach ($data['groupsDelay'] as $group)
                <tr>
                    <td align="center">
                        {{ $group['id'] }}
                    </td>
                    <td align="center">
                        {{ date('Y-m-d H:i', strtotime($group['created_at'])) }}
                    </td>
                    <td align="center">
                        @if (isset($group['patient']))
                            {{ $group['patient']['name'] }}
                        @endif
                    </td>
                    <td align="center">
                        @if (isset($group['doctor']))
                            {{ $group['doctor']['name'] }}
                        @endif
                        @if (isset($group['normalDoctor']))
                            {{ $group['normalDoctor']['name'] }}
                        @endif
                    </td>
                    <td align="center">
                        @if (isset($group['contract']))
                            {{ $group['contract']['title'] }}
                        @endif
                    </td>
                    <td>
                        <ul class="p-2">
                            @foreach ($group['tests'] as $test)
                                <li>{{ $test['test']['name'] }}</li>
                            @endforeach
                            @foreach ($group['cultures'] as $culture)
                                <li>{{ $culture['culture']['name'] }}</li>
                            @endforeach
                            @foreach($group['rays'] as $ray)
                                <li>{{$ray['ray']['name']}}</li>
                            @endforeach
                        </ul>
                        @foreach($group['packages'] as $package)
                            @if (isset($package['package']))
                                <b class="p-0 m-0">
                                {{$package['package']['name']}}
                                </b>
                                <ul class="pl-4 m-0">
                                @foreach($package['tests'] as $test)
                                    <li>{{$test['test']['name']}}</li>
                                @endforeach
                                @foreach($package['cultures'] as $culture)
                                    <li>{{$culture['culture']['name']}}</li>
                                @endforeach
                                </ul>
                            @endif
                        @endforeach
                    </td>
                    <td align="center">{{ formated_price($group['subtotal']) }}</td>
                    <td align="center">{{ formated_price($group['discount']) }}</td>
                    <td align="center">{{ formated_price($group['total']) }}</td>
                    <td align="center">{{ formated_price($group['paid']) }}</td>
                    <td align="center">{{ formated_price($group['due']) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <!-- \Report Details -->

        <!-- Report Details groupsDue -->
        <table class="table table-bordered" width="100%">
            <thead>
            <tr class="title">
                <th colspan="11">
                    {{ __('Due') }}
                </th>
            </tr>
            <tr>
                <th>#</th>
                <th>{{ __('Date') }}</th>
                <th>{{ __('Patient Name') }}</th>
                <th>{{ __('Doctor') }}</th>
                <th>{{ __('Contract') }}</th>
                <th>{{ __('Tests') }}</th>
                <th>{{ __('Subtotal') }}</th>
                <th>{{ __('Discount') }}</th>
                <th>{{ __('Total') }}</th>
                <th>{{ __('Paid') }}</th>
                <th>{{ __('Due') }}</th>
            </tr>
            </thead>
            <tbody>
            @if (count($data['groupsDue']) == 0)
                <tr>
                    <td colspan="11" align="center">
                        {{ __('No data available') }}
                    </td>
                </tr>
            @endif
            @foreach ($data['groupsDue'] as $group)
                <tr>
                    <td align="center">
                        {{ $group['id'] }}
                    </td>
                    <td align="center">
                        {{ date('Y-m-d H:i', strtotime($group['created_at'])) }}
                    </td>
                    <td align="center">
                        @if (isset($group['patient']))
                            {{ $group['patient']['name'] }}
                        @endif
                    </td>
                    <td align="center">
                        @if (isset($group['doctor']))
                            {{ $group['doctor']['name'] }}
                        @endif
                        @if (isset($group['normalDoctor']))
                            {{ $group['normalDoctor']['name'] }}
                        @endif
                    </td>
                    <td align="center">
                        @if (isset($group['contract']))
                            {{ $group['contract']['title'] }}
                        @endif
                    </td>
                    <td>
                        <ul class="p-2">
                            @foreach ($group['tests'] as $test)
                                <li>{{ $test['test']['name'] }}</li>
                            @endforeach
                            @foreach ($group['cultures'] as $culture)
                                <li>{{ $culture['culture']['name'] }}</li>
                            @endforeach
                            @foreach($group['rays'] as $ray)
                                <li>{{$ray['ray']['name']}}</li>
                            @endforeach
                        </ul>
                        @foreach($group['packages'] as $package)
                            @if (isset($package['package']))
                                <b class="p-0 m-0">
                                {{$package['package']['name']}}
                                </b>
                                <ul class="pl-4 m-0">
                                @foreach($package['tests'] as $test)
                                    <li>{{$test['test']['name']}}</li>
                                @endforeach
                                @foreach($package['cultures'] as $culture)
                                    <li>{{$culture['culture']['name']}}</li>
                                @endforeach
                                </ul>
                            @endif
                        @endforeach
                    </td>
                    <td align="center">{{ formated_price($group['subtotal']) }}</td>
                    <td align="center">{{ formated_price($group['discount']) }}</td>
                    <td align="center">{{ formated_price($group['total']) }}</td>
                    <td align="center">{{ formated_price($group['paid']) }}</td>
                    <td align="center">{{ formated_price($group['due']) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <!-- \Report Details -->
    @else
        <div class="accounting_header">
            <h3 align="center">
                <img src="data:image/png;base64,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"
                     width="15px" alt="">
                {{ __('Accounting Report') }} - ({{ __('Delayed Money') }})
                {{ __('Due Date') }} : {{ date('Y-m-d') }} <br>
                {{ __('From Date') }} {{ date('Y-m-d', strtotime($data['from'])) }} {{ __('To Date') }}
                {{ date('Y-m-d', strtotime($data['to'])) }}
            </h3>
        </div>
        <!-- Report Details -->
        <table class="table table-bordered">
            <thead>
            <tr class="title">
                <th colspan="11">
                    {{ __('Total') . ': ' . $data['total'] }}
                </th>
            </tr>
            <tr>
                <td width="10px">#</td>
                <th>{{__('Date')}}</th>
                <th>{{__('Patient Name')}}</th>
                <th>{{__('Contract')}}</th>
                <th>{{__('Subtotal')}}</th>
                <th>{{__('Total')}}</th>
                <th>{{__('Delayed Money')}}</th>
            </tr>
            </thead>
            <tbody>
            @if (count($data['groups']) == 0)
                <tr>
                    <td colspan="11" align="center">
                        {{ __('No data available') }}
                    </td>
                </tr>
            @endif
            @foreach($data['groups'] as $group)
                <tr>
                    <td>
                        {{$group['id']}}
                    </td>
                    <td>
                        {{$group['created_at']}}
                    </td>
                    <td>
                        @if(isset($group['patient']))
                            {{$group['patient']['name']}}
                        @endif
                    </td>
                    <td>
                        @if(isset($group['contract']))
                            {{$group['contract']['title']}}
                        @endif
                    </td>
                    <td>{{formated_price($group['subtotal'])}}</td>
                    <td>{{formated_price($group['total'])}}</td>
                    <td>{{formated_price($group['delayed_money'])}}</td>

                </tr>
            @endforeach
            </tbody>
        </table>
        <!-- \Report Details -->

    @endif

@endsection
