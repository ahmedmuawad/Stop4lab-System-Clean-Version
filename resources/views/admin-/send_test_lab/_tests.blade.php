<ul class="pl-3">
@foreach($group['all_tests'] as $test)
    @if($test->send_status == '1' || $test->send_status == '0' )
        <li class="@if($test['done']) text-success @endif">{{$test['test']['name']}}</li>
    @endif
@endforeach
</ul>