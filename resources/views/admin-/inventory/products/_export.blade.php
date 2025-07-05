<table>
    <thead>
        <tr>
            <th>{{__('Name')}}</th>
            <th>{{__('SKU')}}</th>
            <th>النوع</th>
            <th>{{__('Initial')}}</th>
            {{-- <th>{{__('Purchases')}}</th>
            <th>{{__('In')}}</th>
            <th>{{__('Out')}}</th>
            <th>{{__('Consumption')}}</th> --}}
            <th>{{__('Stock')}}</th>
            <th>{{__('Branch')}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $product)
            @foreach ($product->branches as $branch)
                <tr>
                    <td>
                        {{$product['name']}}
                    </td>
                    <td>
                        {{$product['sku']}}
                    </td>
                    <td>
                        {{$product['type']}}
                    </td>
                    <td>
                        {{$branch['initial_quantity']}}
                    </td>

                    <td>
                        {{$branch['alert_quantity']}}
                    </td>
                    <td>
                        {{$branch['branch']['name']}}
                    </td>
                </tr>
                
            @endforeach  
        @endforeach
    </tbody>
</table>