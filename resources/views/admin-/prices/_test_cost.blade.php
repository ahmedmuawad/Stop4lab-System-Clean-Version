@if (auth()->guard('admin')->user()->lab_id != null) 
<input type="number" name="" id="test_cost_{{$test['id']}}" 
    class="form-control test_cost" test_id="{{$test['id']}}" 
    @if (auth()->guard('admin')->user()->lab_id != null) readonly @endif>
@else
    <input type="number" name="" id="test_cost_{{$test['id']}}" 
        @if (isset($test->test_price))
            value="{{$test->test_price['cost']}}"
        @else
            value="0"
        @endif
 class="form-control test_cost" test_id="{{$test['id']}}">
@endif
