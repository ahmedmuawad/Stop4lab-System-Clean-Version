<table>
    <thead>
        <tr>
            <th align="center" width="30">{{__('Culture id')}}</th>
            <th align="center" width="30">{{__('Name')}}</th>
            <th align="center" width="20">{{__('Price')}}</th>
        </tr>
    </thead>
    <tbody>

    @foreach($cultures as $culture)
        <tr>
            <td align="center">{{ $culture['culture_id'] }}</td>
            <td align="center">{{ $culture['culture']['name'] }}</td>
            <td align="center">
                @if($culture->culture_price!=null)
                    {{$culture->culture_price->price}}
                @else
                    {{ $culture['price'] }}
                @endif
            </td>
        </tr>
    @endforeach

    </tbody>
</table>