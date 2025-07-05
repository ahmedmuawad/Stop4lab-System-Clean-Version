<table>
    <thead>
        <tr>
            <th align="center" width="30"><b>id</b></th>
            <th align="center" width="30"><b>Category Name</b></th>
            <th align="center" width="30"><b>Parent Category Name</b></th>
        </tr>
    </thead>
    <tbody>
    @foreach($categories as $category)
        <tr>
            <td align="center">{{ $category['id'] }}</td>
            <td align="center">{{ $category['name'] }}</td>
            <td align="center">{{ ($category['parent'])? $category['parent']['name'] : '' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>