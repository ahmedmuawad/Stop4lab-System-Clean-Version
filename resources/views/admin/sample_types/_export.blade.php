<table>
    <thead>
        <tr>
            <th align="center" width="30">{{__('Sample id')}}</th>
            <th align="center" width="30">{{__('Sub Name')}}</th>
            <th align="center" width="30">{{__('Main Name')}}</th>
        </tr>
    </thead>
    <tbody>
    @foreach($samples as $sample)
        <tr>
            <td align="center">{{ $sample['id'] }}</td>
            <td align="center">{{ $sample['name'] }}</td>
            <td align="center">{{ $sample['parent']['name'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>