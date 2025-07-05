<div class="row">
    <div class="col-lg-6">
      <div class="form-group">
        <label class="form-label" for="duration">{{__('Duration Minutes')}}</label>
        <input type="number" class="form-control" placeholder="{{__('Duration Minutes')}}" name="duration" id="duration" @if(isset($violation)) value="{{$violation->duration}}" @endif required>
      </div>
    </div>

    <div class="col-lg-6">
        <div class="row">
          <div class="col-lg-4">
            <div class="form-group">
              <label class="form-label" for="duration">{{__('Violations Hours')}}</label>
              <input type="number" class="form-control" placeholder="{{__('Violations Hours')}}" name="hours" id="" @if(isset($violation)) value="{{(int)($violation->violations_mins/60)}}" @endif>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="form-group">
              <label class="form-label" for="duration">{{__('Violations Minutes')}}</label>
              <input type="number" class="form-control" placeholder="{{__('Violations Minutes')}}" name="mins" id="" @if(isset($violation)) value="{{($violation->violations_mins%60)}}" @endif>
            </div>
          </div>
        </div>

    </div>


</div>

