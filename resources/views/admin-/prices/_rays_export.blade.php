<table>
    <thead>
        <tr>
            <th align="center" width="30">{{__('Ray id')}}</th>
            <th align="center" width="30">{{__('Name')}}</th>
            <th align="center" width="30">{{__('Category')}}</th>
            <th align="center" width="20">{{__('Price')}}</th>
        </tr>
    </thead>
    <tbody>
    @foreach($rays as $ray)
        <tr>
            <td align="center">{{ $ray['id'] }}</td>
            <td align="center">{{ $ray['name'] }}</td>
            <td align="center">{{ $ray['category']['name'] }}</td>
            <td align="center">{{ $ray['price'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>