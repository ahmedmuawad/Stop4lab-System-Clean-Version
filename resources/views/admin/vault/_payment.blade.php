<ul class="p-1">
     @foreach($vault['payments'] as $payment)
          <li>
               @if($payment->vault_type == 0) {{ __('Receipt') }} @else {{ __('Export') }} @endif  : {{ $payment->payment_method->name  }} : {{ $payment->amount }}
          </li>
     @endforeach
</ul>