<div class="row">
    <div class="col-lg-4">
       <div class="form-group">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1">
                    <i  class="fas fa-map-marked-alt nav-icon"></i>
              </span>
            </div>
            <select name="branche_id" class="form-control">
                @foreach ($branches as $branche)
                    <option value="{{ $branche->id }}">{{ $branche->name }}</option>
                @endforeach
            </select>        
        </div>
       </div>
    </div>

    

    <div class="col-lg-4">
        <div class="form-group">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1">
                    <i class="fas fa-phone-alt"></i>
                  </span>
                </div>
                <select name="custody_type" class="form-control">
                    <option value="1">{{ __('presonal') }}</option>
                    <option value="2">{{ __('From Lab') }}</option>
                </select>   
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="form-group">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1">
                    <i class="fas fa-map-marker-alt"></i>
                  </span>
                </div>
                <input type="number" class="form-control" placeholder="{{__('Custody')}}" name="custody" id="custody" @if(isset($branch)) value="{{$branch->address}}" @endif required>
            </div>
        </div>
    </div>


</div>

