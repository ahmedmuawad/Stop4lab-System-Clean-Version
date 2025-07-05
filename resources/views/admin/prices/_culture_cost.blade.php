<input class="form-control" id="culture_cost_{{$culture['id']}}" 
name="cultures[cost][{{ $culture['id'] }}]"
@if($culture->culture_price!=null)
    value="{{$culture->culture_price['cost']}}"
@else
    value="444"
@endif
class="form-control culture_cost" culture_id="{{$culture['id']}}" 

@if (auth()->guard('admin')->user()->lab_id != null) readonly @endif>