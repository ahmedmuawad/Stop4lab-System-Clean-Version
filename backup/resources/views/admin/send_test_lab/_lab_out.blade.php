<ul class="pl-3">
     @foreach($group['all_tests'] as $test)
         @if(($test->send_status == '1' || $test->send_status == '0') && isset($test['test']['lab_out']))
             <li>{{$test['test']['lab_out']['name']}}</li>
         @endif
     @endforeach
</ul>
