@if (auth()->guard('admin')->user()->lab_id != null) 
<input type="number" name="" id="test_{{$test['id']}}" 
   
@if($test->test_price!=null)
        value="{{$test->test_price['price']}}"
    @else
        value="{{$test->price}}"
    @endif
    class="form-control test_price" test_id="{{$test['id']}}"  readonly >
@else
    <input type="number" name="" id="test_{{$test['id']}}" 
    
    @if($test->test_price!=null)
        value="{{$test->test_price['price']}}"
    @else
        value="{{$test->price}}"
    @endif
 class="form-control test_price" test_id="{{$test['id']}}">
@endif