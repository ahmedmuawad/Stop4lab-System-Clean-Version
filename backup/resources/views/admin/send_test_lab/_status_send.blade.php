<ul class="pl-3">
     @foreach($group['all_tests'] as $test)
        @if($test->send_status == '1' || $test->send_status == '0' )
            <input type="checkbox" name="checkbox[{{ $test['id'] }}]" value="1" @if($test->send_status == 1) checked @endif /> <br>
        @endif
     @endforeach
</ul>