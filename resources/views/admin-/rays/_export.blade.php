<table>
     <thead>
         <tr>
             <th>id</th>
             <th>{{__('Category')}}</th>
             <th>{{__('Name')}}</th>
             <th>{{__('Shortcut')}}</th>
             <th>{{__('Price')}}</th>
         </tr>
     </thead>
     <tbody>
         @foreach ($rays as $ray)
             <tr>
                 <td>{{ $ray->id }}</td>
                 <td>{{ $ray->category->name }}</td>
                 <td>{{ $ray->name }}</td>
                 <td>{{ $ray->shortcut }}</td>
                 <td>{{ $ray->price }}</td>
             </tr>
         @endforeach
     </tbody>
 </table>