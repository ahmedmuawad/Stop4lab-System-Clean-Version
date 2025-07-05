<ul class="pl-3">
     @foreach($group['all_tests'] as $test)
          @if($test->send_status == '1' || $test->send_status == '0' )
             <li>{{$test['test']['lab_to_lab_cost']}}</li>
         @endif
     @endforeach
</ul>