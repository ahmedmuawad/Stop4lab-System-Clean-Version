@foreach ($group['all_tests'] as $test)
    <div class="text-center">
        <input type="checkbox" class="is_receive" data-status="test" test_id="{{ $test['id'] }}"
            name="is_receive[{{ $test['id'] }}]" value="1" @if ($test->is_receive == 1) checked @endif /> <br>
    </div>
@endforeach

@foreach ($group['all_cultures'] as $test)
    <div class="text-center">

        <input type="checkbox" class="is_receive" data-status="culture" test_id="{{ $test['id'] }}"
            name="is_receive[{{ $test['id'] }}]" value="1" @if ($test->is_receive == 1) checked @endif />
        <br>
    </div>
@endforeach
