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
            <label for="">{{__('Offer name')}}</label>
            <input type="text" class="form-control" placeholder="{{__('Offer name')}}" name="name" @if(isset($offer)) value="{{$offer['name']}}" @endif required>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group">
            <label for="">{{__('Shortcut')}}</label>
            <input type="text" class="form-control" placeholder="{{__('Shortcut')}}" name="shortcut" @if(isset($offer)) value="{{$offer['shortcut']}}" @endif required>
        </div>
    </div>

    @if(!$branch_rays)
    <div class="col-lg-4">
        <div class="form-group">
            <label for="select_tests">{{__('Tests')}}</label>
            <select class="form-control" name="tests[]" id="select_tests" placeholder="{{__('Tests')}}" multiple>
                @if(isset($offer))
                    @foreach($offer['tests'] as $test)
                        <option value="{{$test['test']['id']}}" selected>{{$test['test']['name']}}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group">
            <label for="select_cultures">{{__('Cultures')}}</label>
            <select class="form-control" name="cultures[]" id="select_cultures" placeholder="{{__('Cultures')}}" multiple>
                @if(isset($offer))
                {{$offer['culturies']}}
                    @foreach($offer['culturies'] as $culture)
                    
                        <option value="{{$culture['culature']['id']}}" selected>{{$culture['culature']['name']}}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    @endif

    <div class="col-lg-4">
        <div class="form-group">
            <label for="select_packages">{{__('Packagies')}}</label>
            <select class="form-control" name="packagies[]" id="select_packages" placeholder="{{__('Packagies')}}" multiple>
                @if(isset($offer))
                    @foreach($offer['packages'] as $package)
                        <option value="{{$package['package']['id']}}" selected>{{$package['package']['name']}}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>


    <div class="col-lg-4">
        <div class="form-group">
            <label for="select_rays">{{__('rays')}}</label>
            <select class="form-control" name="rays[]" id="select_rays" placeholder="{{__('Rays')}}" multiple>
                @if(isset($offer))
                    @foreach($offer['rays'] as $ray)
                        <option value="{{$ray['ray']['id']}}" selected>{{$ray['ray']['name']}}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <label for="price">{{__('cost_afetr')}}</label>
            <div class="input-group form-group mb-3">
                <input type="number" class="form-control" name="cost_afetr" min="0" id="cost_afetr" 
                @if (isset($offer))                   
                    value="{{$offer->cost_afetr}}"
                @endif 
                
                placeholder="{{__('cost_afetr')}}" required>
                <div class="input-group-append">
                    <span class="input-group-text">
                        {{get_currency()}}
                    </span>
                </div>
            </div>
        </div>
    </div>
    @if (isset($offer))
    <div class="col-lg-2">
        <div class="form-group">
            <label for="price">{{__('cost_before')}}</label>
            <div class="input-group form-group mb-3">
                <input type="number" class="form-control" name="cost_before" min="0" id="cost_before" 
                @if (isset($offer))                   
                    value="{{$offer->cost_before}}"
                    disabled
                @endif 
                required
                placeholder="{{__('cost_before')}}">
                <div class="input-group-append">
                    <span class="input-group-text">
                        {{get_currency()}}
                    </span>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="col-lg-2" style="    display: flex;
    justify-content: center;
    align-items: center;">
            <div class="form-group">
        <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input" id="customSwitches" name="status" 
        @if(isset($offer))
        @if($offer->status=='active') checked @endif
        @endif
        >
        <label class="custom-control-label" for="customSwitches">Active Or Not</label>

    </div>
    </div>
</div>
</div>
