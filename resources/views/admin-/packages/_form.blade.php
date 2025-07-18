@php
    if (session()->has('branch_id')) {
        $branch_rays = App\Models\Branch::find(session('branch_id'));
        if ($branch_rays != null) {
            $branch_rays = $branch_rays->ray_status;
        }
    } else {
        $branch_rays = 0;
    }
@endphp
<div class="row">
    <div class="col-lg-4">
        <div class="form-group">
            <label for="">{{__('Package name')}}</label>
            <input type="text" class="form-control" placeholder="{{__('Package name')}}" name="name" @if(isset($package)) value="{{$package['name']}}" @endif required>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group">
            <label for="">{{__('Shortcut')}}</label>
            <input type="text" class="form-control" placeholder="{{__('Shortcut')}}" name="shortcut" @if(isset($package)) value="{{$package['shortcut']}}" @endif>
        </div>
    </div>

    @if(!$branch_rays)
        <div class="col-lg-4">
            <div class="form-group">
                <label for="select_tests">{{__('Tests')}}</label>
                <select class="form-control" name="tests[]" id="select_tests" placeholder="{{__('Tests')}}" multiple>
                    @if(isset($package))
                        @foreach($package['tests'] as $test)
                            <option value="{{$test['testable_id']}}" selected>{{$test['test']['name']}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="select_cultures">{{__('Cultures')}}</label>
                <select class="form-control" name="cultures[]" id="select_cultures" placeholder="{{__('Cultures')}}" multiple>
                    @if(isset($package))
                        @foreach($package['cultures'] as $culture)
                            <option value="{{$culture['testable_id']}}" selected>{{$culture['culture']['name']}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
    @endif

    <div class="col-lg-4">
        <div class="form-group">
            <label for="select_rays">{{__('Rays')}}</label>
            <select class="form-control" name="rays[]" id="select_rays" placeholder="{{__('Rays')}}" multiple>
                @if(isset($package))
                    @foreach($package['rays'] as $ray)
                        
                        <option value="{{$ray['testable_id']}}" selected>{{$ray['ray']['name']}}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <label for="price">{{__('Price')}}</label>
            <div class="input-group form-group mb-3">
                <input type="number" class="form-control" name="price" min="0" id="price" 
                @if (isset($package))                   
                    @if(isset($package_price) && $package_price!=null) 
                        value="{{$package_price['price']}}"
                    @else 
                        value="{{$package->price}}"
                    @endif 
                @endif
                
                placeholder="{{__('Price')}}" required>
                <div class="input-group-append">
                    <span class="input-group-text">
                        {{get_currency()}}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="form-group">
             <label for="precautions">{{__('Precautions')}}</label>
             <textarea name="precautions" id="precautions" rows="3" class="form-control" placeholder="{{__('Precautions')}}">@if(isset($package)){{$package['precautions']}}@endif</textarea>
        </div>
    </div>
</div>

