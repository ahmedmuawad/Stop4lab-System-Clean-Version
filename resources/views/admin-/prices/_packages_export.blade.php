<table>
    <thead>
        <tr>
            <th align="center" width="30">{{__('Package id')}}</th>
            <th align="center" width="30">{{__('Name')}}</th>
            <th align="center" width="20">{{__('Price')}}</th>
        </tr>
    </thead>
    <tbody>

    @foreach($packages as $package)
        <tr>
            <td align="center">{{ $package['package_id'] }}</td>
            
            <td align="center">
                @if($package->package!=null)
                {{ $package->package['name'] }}</td>
                @else
                    
                @endif
            <td align="center">
                @if($package->package_price!=null)
                    {{$package->package_price->price}}
                @else
                    {{ $package['price'] }}
                @endif
            </td>
        </tr>
    @endforeach

    </tbody>
</table>