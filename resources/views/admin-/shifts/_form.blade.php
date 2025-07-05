<div class="row">
    <div class="col-lg-4">
        <div class="form-group">
            <label class="form-label" for="login-name">{{ __('Name') }}</label>
            <input type="text" name="name" class="form-control" @if(isset($shift)) value="{{$shift->name}}" @endif placeholder="{{ __('Shift Name') }}">
        </div>
    </div>

    {{-- {{$employee}} --}}

    <div class="col-lg-4">
        <div class="form-group">
            <label class="form-label" for="starting_at">{{ __('Starting at') }}</label>
            <input type="time" class="form-control" placeholder="{{ __('Starting at') }}" name="starting_at"
                id="starting_at" @if (isset($shift)) value="{{explode(' ',$shift->start_at)[1]}}" @endif required>
        </div>
    </div>

    
    <div class="col-lg-4">
        <div class="form-group">
            <label class="form-label" for="ending_at">{{ __('Ending_at') }}</label>
            <input type="time" class="form-control" placeholder="{{ __('Ending_at') }}" name="ending_at"
                id="ending_at"
                @if (isset($shift)) value="{{explode(' ',$shift->end_at)[1]}}" @endif required>
        </div>
    </div>


{{-- {{$employees}} --}}

@php
if(isset($shift)){    
    $shift->employees = $shift->Usershift;
    $shift->employees = array_column($shift->employees->toArray() , 'employees');
    $ids = array_column($shift->employees , 'id');
}
@endphp 
{{-- {{dd($shift->employees)}} --}}

    <div class="col-lg-4">
        <div class="form-group">
            <label class="form-label" for="Employees">{{ __('Employees') }}</label>
            <select name="employees[]" id="Employee" placeholder="{{ __('Employees') }}" class="form-control select2"
                multiple>
                <option value="" disabled>{{__('Employee') }}</option>

                @foreach ($employees as $employee)
                    <option @if (isset($shift)) @if (in_array($employee->id , $ids)) selected @endif
                        @endif value="{{ $employee->id }}">
                        {{ $employee->user->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<hr>
