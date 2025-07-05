<table>
    <thead>
        <tr>
            <th align="center" width="30"><b>id</b></th>
            <th align="center" width="30"><b> Name</b></th>
        </tr>
    </thead>
    <tbody>
    @foreach($knows as $know)
        <tr>
            <td align="center">{{ $know['id'] }}</td>
            <td align="center">{{ $know['name'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>