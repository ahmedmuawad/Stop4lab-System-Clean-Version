<div class="row">
    @foreach ($branches as $branche)
        <div class="btn btn-success">
            {{ $branche->name }} <br>
            {{ __('Cach') }} = {{ $branche->get_safe }} <br>
            {{ __('Other (Visa)') }}  {{ get_safe_other($branche->id,null)}} <br>
            {{ __('Total trans') }} = {{  (get_safe_other($branche->id,null) - get_safe_other($branche->id,null) * 0.02) + $branche->get_safe   }}

        </div>
    @endforeach
</div>
<div class="row">
    <div class="btn btn-primary">
        {{ __('Main Safe') }} = {{ get_main_safe() }}<br>
        {{ __('Other (Visa)') }} = {{ get_main_safe_other() }}
    </div>
</div>
<div class="row">
    <div class="btn btn-primary">
        {{ __('Bank') }} = {{ number_format(get_bank()) }}<br>
        {{ __('Other (Visa)') }} = {{ get_bank_other() }}
    </div>
</div>
<div class="row">
    <div class="col-lg-3">
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

    

    <div class="col-lg-3">
        <div class="form-group">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1">
                    <i class="fas fa-phone-alt"></i>
                  </span>
                </div>
                <select name="custody_type" class="form-control">
                    <option value="1">{{ __('Bank') }}</option>
                    <option value="2">{{ __('From Lab') }}</option>
                    <option value="3">{{ __('Main Safe') }}</option>
                    <option value="4">{{ __('branch safe') }}</option>
                </select>   
            </div>
        </div>
    </div>

    <div class="col-lg-3">
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
    <div class="col-lg-3">
        <div class="form-group">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1">
                    <i class="fas fa-map-marker-alt"></i>
                  </span>
                </div>
                <input type="date" class="form-control" placeholder="{{__('date')}}" name="created_at" @if(isset($branch)) value="{{$branch->created_at}}" @endif required>
            </div>
        </div>
    </div>


</div>

