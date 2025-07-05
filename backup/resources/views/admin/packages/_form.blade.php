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
    <div class="col-lg-2">
        <div class="form-group">
            <label for="price">{{__('Price')}}</label>
            <div class="input-group form-group mb-3">
                <input type="number" class="form-control" name="price" min="0" id="price" @if(isset($package)) value="{{$package['price']}}" @endif placeholder="{{__('Price')}}" required>
                <div class="input-group-append">
                    <span class="input-group-text">
                        {{get_currency()}}
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
             <label for="num_day_receive">{{__('Lab To Lab Status')}}</label>
             <div class="input-group form-group mb-3">
                 <select name="lab_to_lab_status" class="form-control" id="lab_status">
                     <option value="0" @if(isset($package)) @if($package['lab_to_lab_status'] == 0) selected  @endif @endif>{{ __('IN') }}</option>
                     <option value="1" @if(isset($package)) @if($package['lab_to_lab_status'] == 1) selected  @endif @endif>{{ __('Out') }}</option>
                 </select>
             </div>
        </div>
     </div>

     <div class="col-lg-3 lab_cost @if (isset($package)) @if ($package['lab_to_lab_status'] == 0) d-none @else d-block  @endif  @else d-none @endif">
        <div class="form-group">
            <label for="lab_to_lab_cost">{{__('Lab To Lab Cost')}}</label>
            <div class="input-group form-group mb-3">
                <input type="number" class="form-control" id="lab_to_lab_cost" name="lab_to_lab_cost" @if(isset($package))value="{{$package['lab_to_lab_cost']}}" @endif  required>
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

