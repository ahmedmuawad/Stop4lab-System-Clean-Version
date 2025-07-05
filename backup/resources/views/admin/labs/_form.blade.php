<input type="hidden" name="item" value=" @if(isset($lab)){{ $lab->id }} @endif" id="">
<div class="row">
    <div class="col-lg-12">
        <div class="form-group @if($errors->has('name')) error-validation @endif">
            <label for="name">{{__('Name')}}</label>
            <input type="text" class="form-control" name="name" placeholder="{{__('Name')}}" id="name"
                @if(isset($lab)) value="{{$lab->name}}" @endif required>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="form-group @if($errors->has('email')) error-validation @endif">
            <label for="email">{{__('Email')}}</label>
            <input type="email" class="form-control" name="email" placeholder="{{__('Email')}}" id="email"
                @if(isset($lab)) value="{{$lab->email}}" @endif required>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="form-group @if($errors->has('password')) error-validation @endif">
            <label for="password">{{__('Password')}}</label>
            <input type="password" class="form-control" name="password" placeholder="{{__('Password')}}" id="password">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="form-group @if($errors->has('government_id')) error-validation @endif">
            <label for="government_id">{{__('Choose Government')}}</label>
            <select name="government_id" id="government_id" class="form-control">
                <option value="">{{__('Choose Government')}}</option>
                @foreach($governments as $government)
                    <option value="{{ $government->id }}" {{ ( isset($lab) && $government->id == $lab->government_id) ? 'selected' : '' }}>{{ $government->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="form-group @if($errors->has('region_id')) error-validation @endif">
            <label for="region_id">{{__('Choose Region')}}</label>
            <select name="region_id" id="region_id" class="form-control">
                <option value="">{{__('Choose Region')}}</option>
                @if(isset($lab) && $lab->region_id != null)
                <option value="{{ $lab->region_id }}" selected>{{ $lab->region->name }}</option>
                @endif
            </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="form-group @if($errors->has('lab_id')) error-validation @endif">
            <label for="email">{{__('Choose Contract')}}</label>
            <select name="lab_id" id="lab_id" class="form-control">
                <option value="">{{__('Choose Contract')}}</option>
                @foreach($contracts as $contract)
                    <option value="{{ $contract->id }}" {{ (isset($lab) && $contract->id == $lab->lab_id) ? 'selected' : '' }}>{{ $contract->title }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>





