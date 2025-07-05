<ul class="pl-3">
     @foreach($group['all_tests'] as $test)
          @if($test->send_status == '1' || $test->send_status == '0' )
               <input type="text" name="note[{{ $test['id'] }}]" value="{{ $test->notes }}" />
          @endif
     @endforeach
</ul>