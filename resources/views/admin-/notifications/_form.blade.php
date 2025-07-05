<div class="row">



    <div class="col-lg-12">

    <!-- select send notification -->
    <label for="user_ids">{{ __('Users') }}</label>
    <div class="form-group">
        <select name="type" id="type" class="form-control select2">
            <option value="" disabled selected>{{ __('Choose Users') }}</option>
            <option value="all_users">{{ __('All User') }}</option>
            <option value="all_patients">{{ __('All Patient') }}</option>
            <option value="users" data-content='
            <div class=" col-md-12">
                <label for="user_ids">{{ __('Choose Users') }}</label>
                <div class="form-group">
                    <select name="user_ids[]" id="user_ids" class="form-control select2"  multiple>
                        @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

            </div>'>{{ __('Select Users') }}</option>

            <option value="patients" data-content='
            <div class=" col-md-12">
                <label for="patient_ids">{{ __('Choose Patient') }}</label>
                <div class="form-group">
                    <select name="patient_ids[]" id="patient_ids" class="form-control select2"  multiple>
                        
                    </select>
                </div>

            </div>'>{{ __('Select Patients') }}</option>
            <option value="current_branch">{{ __('Current Branch') }}</option>

        </select>
        @if ($errors->has('type')) <span class="error" role="alert">
            <strong>{{ $errors->first('type') }}</strong>
        </span>
        @endif
        @if ($errors->has('user_ids')) <span class="error" role="alert">
            <strong>{{ $errors->first('user_ids') }}</strong>
        </span>
        @endif
    </div>


    <div class="col-lg-12 row" id="append-content"></div>

    </div>

    <div class="col-lg-12">

        <div class="row">


            <div class="col-lg-12">
                <div class="form-group">
                    <label for="">{{__('Content')}}</label>

                    <textarea class="form-control" placeholder="{{__('Content')}}" name="content" id="content"></textarea>

                </div>
            </div>

        </div>

    </div>

    <div class="col-lg-12">

        <div class="card card-primary">
            <div class="card-header">
                <h5 class="text-center m-0 p-0">
                    {{__('Image')}}
                </h5>
            </div>
            <div class="card-footer m-0 p-0 pt-3">
                <div class="col-lg-12">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="avatar" class="custom-file-input" id="avatar">
                                <label class="custom-file-label">{{__('Choose Image')}}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body m-0 p-0">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <a href="@if(!empty($notification['image'])){{url('uploads/notifications-avatar/'.$notification['image'])}}@else{{url('img/avatar.png')}}@endif" data-toggle="lightbox" data-title="Avatar">
                            <img src="@if(!empty($notification['image'])){{url('uploads/notifications-avatar/'.$notification['image'])}}@else{{url('img/avatar.png')}}@endif" class="img-thumbnail" id="patient_avatar" alt="">
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
