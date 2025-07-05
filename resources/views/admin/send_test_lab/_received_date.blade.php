<ul class="pl-3">
    @foreach($group['all_tests'] as $test)
        @if($test->send_status == '1' || $test->send_status == '0' ) 
            <li>{{ $test->send_date != null? calcReceivedDate($test->send_date,$test->test->num_day_receive,$test->test->num_hour_receive): '' }}</li>
        @endif
    @endforeach
</ul>