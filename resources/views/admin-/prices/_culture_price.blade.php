<input class="form-control" id="culture_{{$culture['id']}}" 
name="cultures[price][{{ $culture['id'] }}]"
@if($culture->culture_price!=null)
    value="{{$culture->culture_price->price}}"
    {{-- class="{{$culture['price']}}" --}}
@else
    value="{{$culture['price']}}"
@endif
class="form-control culture_price" culture_id="{{$culture['id']}}" 

@if (auth()->guard('admin')->user()->lab_id != null) readonly @endif>