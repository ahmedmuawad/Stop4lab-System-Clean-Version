<div class="row">
    <div class="col-lg-6">
        <div class="input-group form-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">
                <i class="fas fa-user-tie"></i>
              </span>
            </div>
            <input type="number" class="form-control" placeholder="{{__('Duration Month')}}" name="duration" id="" @if(isset($vocation)) value="{{$vocation->duration}}" @endif required>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="input-group form-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
              </span>
            </div>
            <input type="number" class="form-control" placeholder="{{__('Vocations days')}}" name="vocations_days" id="" @if(isset($vocation)) value="{{$vocation->vocations_days}}" @endif required>
        </div>
    </div>


</div>

