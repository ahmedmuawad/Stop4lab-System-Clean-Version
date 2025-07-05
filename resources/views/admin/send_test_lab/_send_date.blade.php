<ul class="pl-3">
    @foreach($group['all_tests'] as $test)
        @if($test->send_status == '1' || $test->send_status == '0' ) 
            <li>{{ $test->send_date != null?  date('Y-m-d g:i A', strtotime($test->send_date)): '' }}</li>
        @endif
    @endforeach
</ul>