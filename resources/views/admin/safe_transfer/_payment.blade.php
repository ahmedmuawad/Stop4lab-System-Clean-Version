<ul class="p-1">
     @php
          $is_cach = 0;
     @endphp
     @foreach($safe['payments'] as $payment)
          <li>
               @if ($payment->payment_method_id == setting('account')['payment'] && $is_cach == 0)
                    {{ $payment->payment_method->name  }} : {{ $payment->amount-$custody }} 
                    @php
                         $is_cach = 1;
                    @endphp
               @else
                    {{ $payment->payment_method->name  }} : {{ $payment->amount }} 
               @endif  
          </li>
     @endforeach
</ul>