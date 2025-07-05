<table>
     <thead>
         <tr>
             <th align="center" width="30">{{__('Test id')}}</th>
             <th align="center" width="30">{{__('Name')}}</th>
             <th align="center" width="30">{{__('Category')}}</th>
             <th align="center" width="20">{{__('Price')}}</th>
               @foreach ($contracts as $contract)
                    <th>{{ $contract->title }}</th>
               @endforeach
         </tr>
     </thead>
     <tbody>
          @foreach ($testPrice as $key => $test)
               <tr>
                    <td>{{ $test->id }}</td>
                    <td>{{ $test->name }}</td>
                    <td>{{ $test->category->name }}</td>
                    <td>{{ $test->price }} </td>
                    {{-- {{ dd($contract->tests->toArray()) }} --}}
                    @foreach ($contracts as $contract)
                         <td>{{ $contract->tests[$key]->price}}</td>
                    @endforeach
               </tr>
          @endforeach
     </tbody>
 </table>