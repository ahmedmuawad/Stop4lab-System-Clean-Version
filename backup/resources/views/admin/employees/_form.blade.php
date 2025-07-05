<div class="row">
    <div class="col-lg-4">
        <div class="form-group">
            <label class="form-label" for="login-name">{{__('Name')}}</label>
            <select name="user_id" id="user_id" placeholder="{{__('Branches')}}" class="form-control select2" required>
                <option value="" disabled selected>{{__('Employee')}}</option>
                @foreach($users as $user)
                     <option @if(isset($employee)) @if($employee->user_id == $user['id']) selected @endif @endif  value="{{$user['id']}}">{{$user['name']}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="form-group">
            <label class="form-label" for="salary">{{__('Salary')}}</label>
            <input type="number" class="form-control" placeholder="{{__('Salary')}}" name="salary" id="salary" @if(isset($employee)) value="{{$employee->salary}}" @endif required>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="form-group">
            <label class="form-label" for="weekend">{{__('Weekends')}}</label>
            <select name="weekends[]" id="weekend" placeholder="{{__('Weekends')}}" class="form-control select2" multiple required>
                <option value="" disabled>{{__('Weekend')}}</option>
                <option @if(isset($employee)) @if(in_array("Friday",$employee->weekends) ) selected @endif @endif value="Friday">{{__('Friday')}}</option>
                <option @if(isset($employee)) @if(in_array("Saturday",$employee->weekends) ) selected @endif @endif value="Saturday">{{__('Saturday')}}</option>
                <option @if(isset($employee)) @if(in_array("Sunday",$employee->weekends) ) selected @endif @endif value="Sunday">{{__('Sunday')}}</option>
                <option @if(isset($employee)) @if(in_array("Monday",$employee->weekends) ) selected @endif @endif value="Monday">{{__('Monday')}}</option>
                <option @if(isset($employee)) @if(in_array("Tuesday",$employee->weekends) ) selected @endif @endif value="Tuesday">{{__('Tuesday')}}</option>
                <option @if(isset($employee)) @if(in_array("Wednesday",$employee->weekends) ) selected @endif @endif value="Wednesday">{{__('Wednesday')}}</option>
                <option @if(isset($employee)) @if(in_array("Thursday",$employee->weekends) ) selected @endif @endif value="Thursday">{{__('Thursday')}}</option>
            </select> 
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-4">
        <div class="form-group">
            <label class="form-label" for="job">{{__('Job')}}</label>
            <input type="text" class="form-control" placeholder="{{__('Job')}}" name="job" id="job" @if(isset($employee->user)) value="{{$employee->user->roles[0]->role->name}}" @endif  readonly>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="form-group">
            <label class="form-label" for="phone">{{__('Phone')}}</label>
            <input type="number" class="form-control" placeholder="{{__('Phone')}}" name="phone" id="phone" @if(isset($employee->user)) value="{{$employee->user->phone}}" @endif  readonly>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="form-group">
            <label class="form-label" for="address">{{__('Address')}}</label>
            <input type="text" class="form-control" placeholder="{{__('Address')}}" name="address" id="address" @if(isset($employee->user)) value="{{$employee->user->address}}" @endif  readonly>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="form-group">
            <label class="form-label" for="type">{{__('Type Work')}}</label>
            <select name="type" id="type" placeholder="{{__('Type Work')}}" class="form-control select2" required>
                <option value="" disabled selected>{{__('Type Work')}}</option>
                <option @if(isset($employee) && $employee->type == 0 ) selected  @endif value="0">{{__('Filexable')}}</option>
                <option @if(isset($employee) && $employee->type == 1 ) selected  @endif value="1">{{__('Fixed')}}</option>
             </select>
        </div>
    </div>
</div>
<div class="row" id='shift'>
    @if(isset($employee) && $employee->type == 0 )
        <div class="col-lg-12">
            <div class="form-group">
                <label class="form-label" for="works_mins">{{__('Working Hours')}}</label>
                <input type="number" class="form-control " placeholder="Working Hours" name="works_mins" id="works_mins" @if(isset($employee)) value="{{($employee['works_mins'] / 60)}}" @elseif(old('works_mins')) value="{{old('works_mins')}}" @endif>
            </div>
        </div>
    @elseif(isset($employee) && $employee->type == 1 )
        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-label" for="shift_start">{{__('Start Shift')}}</label>
                <input type="time" class="form-control " placeholder="Start Shift" name="shift_start" id="shift_start" @if(isset($employee)) value="{{$employee['shift_start']}}" @elseif(old('shift_start')) value="{{old('shift_start')}}" @endif>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-label" for="shift_end">{{__('End Shift')}}</label>
                <input type="time" class="form-control " placeholder="End Shift" name="shift_end" id="shift_end" @if(isset($employee)) value="{{$employee['shift_end']}}" @elseif(old('shift_end')) value="{{old('shift_end')}}" @endif>
            </div>
        </div>
    @endif
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="form-group">
            <label class="form-label" for="job_start">{{__('Date Job')}}</label>
            <input type="date" class="form-control " placeholder="{{__('Date Job')}}" name="job_start" id="job_start" required @if(isset($employee)) value="{{$employee['job_start']}}" @elseif(old('job_start')) value="{{old('job_start')}}" @endif>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group">
            <label class="form-label" for="age">{{__('Age')}}</label>
            <input type="number" class="form-control " placeholder="{{__('Age')}}" name="age" id="age" required @if(isset($employee)) value="{{$employee['age']}}" @elseif(old('age')) value="{{old('age')}}" @endif>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-2">
        <div class="form-group">
            <label class="form-label" for="vocations">{{__('Vocations')}}</label>
            <input type="number" class="form-control " placeholder="{{__('Vocations')}}" name="vocations" id="vocations" @if(isset($employee)) value="{{$employee->vocation}}" @elseif(old('vocations')) value="{{old('vocations')}}" @endif readonly>
        </div>
    </div>

    <div class="col-lg-2">
        <div class="form-group">
            <label class="form-label" for="violations">{{__('Violations')}}</label>
            <input type="number" class="form-control " placeholder="{{__('Violations')}}" name="violations" id="violations" @if(isset($employee)) value="{{$employee->violation}}" @elseif(old('violations')) value="{{old('violations')}}" @endif readonly>
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <label class="form-label" for="over_time">{{__('Over Time')}}</label>
            <input type="number" class="form-control " placeholder="{{__('Over Time')}}" name="over_time" id="over_time" @if(isset($employee)) value="{{$employee->attendance }}" @elseif(old('over_time')) value="{{old('over_time')}}" @endif readonly>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label class="form-label" for="over_time">{{__('Over Time')}}</label>
            <input type="number" class="form-control " placeholder="{{__('Over Time Status')}}" name="over_time" id="over_time" @if(isset($employee)) value="{{$employee->violation_status }}" @elseif(old('over_time')) value="{{old('over_time')}}" @endif>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="custom-control custom-switch custom-switch-dark">
            <p class="mb-50">{{__('Free Time')}}</p>
            <input type="checkbox" class="custom-control-input" name="violation_status"  id="customSwitch15" value="1" @if(isset($employee) && $employee->violation_status == '1') checked @endif >
            <label class="custom-control-label" for="customSwitch15">
                <span class="switch-icon-left"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg></span>
                <span class="switch-icon-right"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></span>
            </label>
        </div>
    </div>
</div>

