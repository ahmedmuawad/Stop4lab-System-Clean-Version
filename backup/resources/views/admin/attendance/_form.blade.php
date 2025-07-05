<div class="row">
  <div class="col-lg-6">
    <div class="form-group">
      <label class="form-label" for="age">{{__('Employee')}}</label>
      <select name="employee_id" id="" placeholder="{{__('Branches')}}" class="form-control select2" required>
        <option value="" selected disabled>{{__('Employee')}}</option>
        @foreach($employees as $employee)
             <option @if(isset($attendance)) @if($attendance->employee_id == $employee['user_id']) selected @endif @endif  value="{{$employee->id}}">{{$employee->user['name']}}</option>
        @endforeach
      </select>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="form-group">
      <label class="form-label" for="age">{{__('Attendance')}}</label>
        <select name="attendance_type" id="" placeholder="{{__('Attendance')}}" class="form-control select2" required>
          <option value="" selected disabled>{{__('Attendance')}}</option>
          <option value="0">{{__('Check In')}}</option>
          <option value="1">{{__('Check Out')}}</option>
       </select>
    </div>
  </div>
</div>

