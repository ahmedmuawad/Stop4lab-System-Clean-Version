<table>
     <thead>
         <tr>
             <th align="center">{{__('Package id')}}</th>
             <th align="center" width="30">{{__('Name')}}</th>
             <th align="center" width="20">{{__('Price')}}</th>
               @foreach ($contracts as $contract)
                    <th>{{ $contract->title }}</th>
               @endforeach
         </tr>
     </thead>
     <tbody>
          @foreach ($packages as $key => $package)
               <tr>
                    <td>{{ $package->id }}</td>
                    <td>{{ $package->name }}</td>
                    <td>{{ $package->price }} </td>

                    @foreach ($contracts as $contract)
                         <td>{{ $contract->packages[$key]->price}}</td>
                    @endforeach
               </tr>
          @endforeach
     </tbody>
 </table>