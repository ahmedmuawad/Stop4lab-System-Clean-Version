<table>
     <thead>
         <tr>
             <th align="center">{{__('Culture id')}}</th>
             <th align="center" width="30">{{__('Name')}}</th>
             <th align="center" width="20">{{__('Price')}}</th>
               @foreach ($contracts as $contract)
                    <th>{{ $contract->title }}</th>
               @endforeach
         </tr>
     </thead>
     <tbody>
          @foreach ($cultures as $key => $culture)
               <tr>
                    <td>{{ $culture->id }}</td>
                    <td>{{ $culture->name }}</td>
                    <td>{{ $culture->price }} </td>

                    @foreach ($contracts as $contract)
                         <td>{{ $contract->cultures[$key]->price}}</td>
                    @endforeach
               </tr>
          @endforeach
     </tbody>
 </table>