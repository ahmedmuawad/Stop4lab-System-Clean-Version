<div class="row">
    <div class="col-lg-12">
        <div class="input-group form-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="fa fa-user"></i>
                </span>
            </div>
            <input type="text" class="form-control" placeholder="{{ __('Name') }}" name="name"
                @if (isset($user)) value="{{ $user['name'] }}" @endif required>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="input-group form-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
                </span>
            </div>
            <input type="email" class="form-control" placeholder="{{ __('Email Address') }}" name="email"
                @if (isset($user)) value="{{ $user['email'] }}" @endif required>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="input-group form-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="fa fa-key" aria-hidden="true"></i>
                </span>
            </div>
            <input type="password" class="form-control" placeholder="{{ __('Password') }}" name="password"
                @if (!isset($user)) required @endif>
        </div>
    </div>
</div>
{{mt_rand(1, 100)}}
@if (!isset($user) || (isset($user) && $user['id'] != 1))

    {{--  <div class="row">
        <div class="col-lg-12">
            <div class="input-group form-group mb-3">
                <div class="input-group-prepend">
              <span class="input-group-text">
                <i class="fas fa-globe"></i>
              </span>
                </div>
                <select name="government_id" id="government_id" class="form-control select2">
                    <option value="">{{__('Governments')}}</option>
                    @foreach ($governments as $government)
                        <option @if (isset($user)) @if ($government->id == $user->government_id) selected @endif @endif value="{{$government['id']}}">{{$government['name']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="input-group form-group mb-3">
                <div class="input-group-prepend">
              <span class="input-group-text">
                <i class="fas fa-globe"></i>
              </span>
                </div>
                <select name="region_id" id="region_id" class="form-control select2">
                    @if (isset($user) && $user['region_id'] != null)
                        <option value="{{$user['region_id']}}" selected>{{$user->region->name}}</option>
                    @endif
                </select>
            </div>
        </div>
    </div>  --}}

    <div class="row">
        <div class="col-lg-12">
            <div class="input-group form-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-user-tie"></i>
                    </span>
                </div>
                <select name="roles[]" id="roles_assign" placeholder="{{ __('Roles') }}" class="form-control select2"
                    multiple required>
                    <option value="" disabled>{{ __('Roles') }}</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="input-group form-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-map-marked-alt"></i>
                    </span>
                </div>
                <select name="branches[]" id="branches_assign" placeholder="{{ __('Branches') }}"
                    class="form-control select2" multiple required>
                    <option value="" disabled>{{ __('Branches') }}</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch['id'] }}">{{ $branch['name'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>


@endif
<div class="row">
    <div class="form-group col-12">
        <label>
            Sgin Name
        </label>
        <input type="text" name="sgin_name" class="form-control"
            @if (isset($user)) value="{{ $user->sgin_name }}" @endif>
    </div>
</div>


<div class="row">
    <div class="form-group col-12">
        <label>
            Random Inculding
        </label>
        <input type="checkbox" name="random_including" class="form-control"
            @if (isset($user)) @if ($user->randamaize == 1)
                checked @endif
            @endif
        >
    </div>
</div>
