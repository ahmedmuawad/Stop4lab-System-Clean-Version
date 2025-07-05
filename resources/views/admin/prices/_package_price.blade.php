<input type="number" name="" id="package_{{$package['id']}}" 

@if($package->package_price!=null)
    value="{{$package->package_price->price}}"
@else
    value="{{$package['price']}}"
@endif


class="form-control package_price" package_id="{{$package['id']}}" @if (auth()->guard('admin')->user()->lab_id != null) readonly @endif>