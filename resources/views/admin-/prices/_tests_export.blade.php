<table>
    <thead>
        <tr>
            <th align="center" width="30">{{__('Test id')}}</th>
            <th align="center" width="30">{{__('Name')}}</th>
            <th align="center" width="30">{{__('Category Name')}}</th>
            <th align="center" width="30">{{__('Lab to Lab Status')}}</th>
            <th align="center" width="30">{{__('Lab to Lab Cost')}}</th>
            <th align="center" width="30">{{__('Lab to Lab')}}</th>
            <th align="center" width="20">{{__('Price')}}</th>
        </tr>
    </thead>
    <tbody>
    @foreach($tests as $test)
        <tr>
            <td align="center">{{ $test['id'] }}</td>
            <td align="center">{{ $test['name'] }}</td>
            <td align="center">{{ $test['category']['name'] }}</td>
            <td align="center">@if($test['lab_to_lab_status'] == '0') In @else Out @endif</td>
            <td align="center">{{ $test['lab_to_lab_cost'] }}</td>
            <td align="center">@if(isset($test['lab_out'])) {{ $test['lab_out']['name'] }} @endif</td>
            <td align="center">
                @if($test->test_price!=null)
                    {{$test->test_price->price}}
                @else
                    {{ $test['price'] }}
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>