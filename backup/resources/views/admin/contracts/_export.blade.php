<table>
     <thead>
         <tr class="title">
             <th colspan="6" align="center">
                 {{ $name }} - {{ get_system_date() }}
             </th>
         </tr>
         <tr>
             <th>{{ __('ID') }}</th>
             <th>{{ __('Name') }}</th>
             <th>{{ __('Sample Type') }}</th>
             <th>{{ __('Time') }}</th>
             <th>{{ __('Precautions') }}</th>
             <th>{{ __('Price') }}</th>
         </tr>
     </thead>
     <tbody>
         @foreach ($contract['tests'] as $test)
             @if (isset($test['priceable']))
                 <tr>
                     <td>
                         {{ $test['priceable']['id'] }}
                     </td>
                     <td>
                         {{ $test['priceable']['name'] }}
                     </td>
                     <td>
                         {{ $test['priceable']['sample_type'] }}
                     </td>
                     <td>
                         {{ $test['priceable']['num_day_receive'] }} Days -
                         {{ $test['priceable']['num_hour_receive'] }} Hours
                     </td>
                     <td>
                         {{ $test['priceable']['precautions'] }}
                     </td>
                     <td>
                         {{ $test['price'] }}
                     </td>
                 </tr>
             @endif
         @endforeach
     </tbody>
 </table>
 