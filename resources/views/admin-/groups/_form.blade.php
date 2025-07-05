<!-- Patient Info -->

<div class="card card-primary">
    <div class="card-header">
        @can('create_patient')
            <button type="button" class="btn btn-primary btn-sm add_patient float-right" data-toggle="modal"
                data-target="#patient_modal">
                <i class="fa fa-exclamation-triangle"></i> {{ __('New Patient ?') }}
            </button>
        @endcan
        @can('edit_patient')
            <button type="button" class="btn btn-warning btn-sm mr-1 float-right" id="edit_patient" data-toggle="modal"
                data-target="#edit_patient_modal">
                <i class="fa fa-edit"></i> {{ __('Edit patient') }}
            </button>
        @endcan
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-2">
                <div class="card card-primary">
                    <div class="card-header">
                        <h5 class="text-center m-0 p-0">
                            {{ __('Avatar') }}
                        </h5>
                    </div>
                    <div class="card-body m-0 p-0">
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <a href="@if (isset($group) && !empty($group['patient']['avatar'])) {{ url('uploads/patient-avatar/' . $group['patient']['avatar']) }}@else{{ url('img/avatar.png') }} @endif"
                                    data-toggle="lightbox" data-title="Avatar">
                                    <img src="@if (isset($group) && !empty($group['patient']['avatar'])) {{ url('uploads/patient-avatar/' . $group['patient']['avatar']) }}@else{{ url('img/avatar.png') }} @endif"
                                        class="img-thumbnail" id="patient_avatar" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-danger btn-sm float-right" id="delete_patient_avatar"
                            style="width:100%"
                            patient_id="@if (isset($patient)) {{ $patient['id'] }} @endif">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-lg-10">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>{{ __('Code') }}</label>
                            <select id="code" name="patient_id" class="form-control" required>
                                @if (isset($group) && isset($group['patient']))
                                    <option value="{{ $group['patient']['id'] }}" selected>
                                        {{ $group['patient']['code'] }}</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>{{ __('Prefix') }}</label>
                            <input class="form-control" id="prefix"
                                @if (isset($group) && isset($group['patient'])) value=" {{ __($group['patient']['prefix']) ?? '' }} " @endif
                                readonly>

                            <!-- <select id="prefix" name="prefix" id="prefix" class="form-control" required>
                                @if (isset($group) && isset($group['patient']))
                                    <option value="{{ $group['patient']['prefix'] }}" selected>{{ $group['patient']['prefix'] }}</option>
                                @endif
                            </select> -->
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>{{ __('Name') }}</label>
                            <select id="name" name="patient_id" class="form-control" required>
                                @if (isset($group) && isset($group['patient']))
                                    <option value="{{ $group['patient']['id'] }}" selected>
                                        {{ $group['patient']['name'] }}</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>{{ __('Gender') }}</label>
                            <input class="form-control" id="gender"
                                @if (isset($group) && isset($group['patient'])) value="{{ $group['patient']['gender'] }}" @endif
                                readonly>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>{{ __('Date of birth') }}</label>
                            <input class="form-control" id="dob"
                                @if (isset($group) && isset($group['patient'])) value="{{ $group['patient']['dob'] }}" @endif
                                readonly>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>{{ __('Age') }}</label>
                            <input class="form-control" id="age"
                                @if (isset($group) && isset($group['patient'])) value="{{ $group['patient']['age'] }}" @endif
                                readonly>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>{{ __('Phone') }}</label>
                            <input class="form-control" id="phone"
                                @if (isset($group) && isset($group['patient'])) value="{{ $group['patient']['phone'] }}" @endif
                                readonly>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>{{ __('Phone') }} 2</label>
                            <input class="form-control" id="phone2"
                                @if (isset($group) && isset($group['patient'])) value="{{ $group['patient']['phone2'] }}" @endif
                                readonly>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>{{ __('Email') }}</label>
                            <input class="form-control" id="email"
                                @if (isset($group) && isset($group['patient'])) value="{{ $group['patient']['email'] }}" @endif
                                readonly>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>{{ __('Address') }}</label>
                            <input class="form-control" id="address"
                                @if (isset($group) && isset($group['patient'])) value="{{ $group['patient']['address'] }}" @endif
                                readonly>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>{{ __('Hours Fasting') }}</label>
                            <input class="form-control" id="hours_fasting"
                                @if (isset($group) && isset($group['patient'])) value="{{ $group['patient']['hours_fasting'] }}" @endif
                                readonly>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="d-block">{{ __('Contract') }}</label>

                            <input type="hidden" name="contract_id" id="contract_id"
                                @if (isset($group) && isset($group['contract']) && !$group->contract->trashed()) value="{{ $group['contract']['id'] }}" @endif
                                readonly>
                            <div class="row">
                                <select name="" id="contract_title" disabled
                                    data-url="{{ route('admin.update_patient_contract_id') }}" class="form-control"
                                    style="
                            width: 50%;">
                                    <option label=""></option>
                                    @foreach ($contracts as $contract)
                                        <option value="{{ $contract->id }}"
                                            @if (isset($group) && $group['contract_id'] == $contract->id) selected @endif>{{ $contract->title }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="button"
                                    class="btn btn-danger btn-xs float-right cancel_contract @if (!isset($group) || !isset($group['contract'])) disabled @endif"
                                    style="width: 35%;">
                                    {{ __('Cancel') }}
                                </button>
                            </div>


                        </div>
                    </div>

                    <div
                        class="col-lg-3 lab-to-lab d-none @if (isset($group) and $group->contract != null) @if ($group->contract->type == 'lab_to_lab') d-block @endif @endif">
                        <div class="form-group">
                            <label for="government_id">{{ __('Government') }}</label>
                            <select name="government_id" id="government_id" class="form-control" required>
                                <option></option>
                                @foreach ($governments as $government)
                                    <option
                                        @if (isset($group)) @if ($government->id == $group->government_id) selected @endif
                                        @endif
                                        value="{{ $government->id }}">{{ $government->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div
                        class="col-lg-3 lab-to-lab d-none @if (isset($group) and $group->contract != null) @if ($group->contract->type == 'lab_to_lab') d-block @endif @endif">
                        <div class="form-group">
                            <label for="region_id">{{ __('Region') }}</label>
                            <select name="region_id" id="region_id" class="form-control" required>
                                <option></option>
                                @if (isset($group) && $group['region_id'])
                                    <option value="{{ $group['region_id'] }}" selected>{{ $group->region->name }}
                                    </option>
                                @endif
                            </select>

                        </div>
                    </div>

                    <div
                        class="col-lg-3 lab-to-lab d-none @if (isset($group) and $group->contract != null) @if ($group->contract->type == 'lab_to_lab') d-block @endif @endif">
                        <div class="form-group">
                            <label for="user_id">{{ __('Lab') }}</label>
                            <select name="user_id" id="user_id" class="form-control select2" required>
                                @if (isset($group) && $group['user_id'])
                                    @if (isset($group->user))
                                        <option value="{{ $group['user_id'] }}" selected>{{ $group->user->lab_code }}
                                            - {{ $group->user->name }}</option>
                                    @endif
                                @endif
                            </select>
                        </div>
                    </div>

                    <div
                        class="col-lg-3 lab-to-lab d-none @if (isset($group) and $group->contract != null) @if ($group->contract->type == 'lab_to_lab') d-block @endif @endif">
                        <div class="form-group">
                            <label for="rep_id">{{ __('Representative') }}</label>
                            <select name="rep_id" id="rep_id" class="form-control">
                                <option></option>
                                @if (isset($group) && $group['rep_id'])
                                    <option value="{{ $group['rep_id'] }}" selected>
                                        {{ $group->representative->name }}</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div
                        class="col-lg-3 sub_contracts d-none @if (isset($group) and $group->contract != null) @if (count($group->contract->sub_contracts)) d-block @endif @endif">
                        <div class="form-group">
                            <label for="sub_contract_id">{{ __('Sub Contract') }}</label>
                            <select id="sub_contract_id" name="sub_contract_id" class="form-control">
                                @if (isset($group) && isset($group['sub_contract_id']))
                                    @foreach ($sub_contracts as $item)
                                        <option discount="{{ $item['discount_percentage'] }}"
                                            value="{{ $item['id'] }}"
                                            @if ($group->sub_contract_id == $item['id']) selected @endif>{{ $item->title }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>


                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>{{ __('Nationality') }}</label>
                            <input class="form-control" id="nationality"
                                @if (isset($group) && isset($group['patient'])) value=" {{ $group['patient']['country']['nationality'] ?? '' }} " @endif
                                readonly>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>{{ __('National ID') }}</label>
                            <input class="form-control" id="national_id"
                                @if (isset($group) && isset($group['patient'])) value="{{ $group['patient']['national_id'] }}" @endif
                                readonly>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>{{ __('Passport No.') }}</label>
                            <input class="form-control" id="passport_no"
                                @if (isset($group) && isset($group['patient'])) value="{{ $group['patient']['passport_no'] }}" @endif
                                readonly>
                        </div>
                    </div>





                    <div class="col-lg-3 d-none date_pms">
                        <div class="form-group">
                            <label>{{ __('Date PMS') }}</label>
                            <input class="form-control" id="date_pms"
                                @if (isset($group) && isset($group['patient'])) value="{{ $group['patient']['date_pms'] }}" @endif
                                readonly>
                        </div>
                    </div>


                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>{{ __('Doctor') }}</label>
                            @can('create_doctor')
                                <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal"
                                    data-target="#normal_doctor_modal"><i class="fa fa-exclamation-triangle"></i>
                                    {{ __('New Doctor ?') }}</button>
                            @endcan
                            <select class="form-control select2" name="normal_doctor_id" id="normal_doctor">

                                @php
                                    use App\Models\Role;
                                    use App\Models\User;
                                    use App\Models\Doctor;
                                    
                                    $doctors = Doctor::all();
                                    $role = Role::firstOrCreate(['name' => 'doctor']);
                                    $users = User::whereHas('roles', function ($q) use ($role) {
                                        $q->where('role_id', $role->id);
                                    })->get();
                                    
                                @endphp
                                <option></option>
                                @foreach ($doctors as $doctor)
                                    <option value="normaldoctor_{{ $doctor->id }}">{{ $doctor->name }}</option>
                                @endforeach
                                @foreach ($users as $user)
                                    <option value="doctor_{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                                @if (isset($group) && (isset($group['normalDoctor']) || isset($group['doctor'])))
                                    @if (isset($group['doctor']))
                                        <option value="doctor_{{ $group['doctor']['id'] }}" selected>
                                            {{ $group['doctor']['name'] }}</option>
                                    @else
                                        <option value="normaldoctor_{{ $group['normalDoctor']['id'] }}" selected>
                                            {{ $group['normalDoctor']['name'] }}</option>
                                    @endif

                                @endif
                            </select>
                        </div>
                    </div>




                    <div class="col-lg-3    ">
                        <div class="form-group">
                            <label>{{ __('Sample collection date') }}</label>
                            <input type="text" class="form-control flatpickr flatpickr-input"
                                name="sample_collection_date" id="sample_collection_date"
                                @if (isset($group)) value="{{ $group['sample_collection_date'] }}" @else value="{{ date('Y-m-d H:i') }}" @endif>

                        </div>
                    </div>
                    <div class="col-lg-3   ">
                        <div class="form-group">
                            <label>{{ __('Result R-date') }}</label>
                            <input type="text" class="form-control flatpickr flatpickr-input" name="resulte_date"
                                id="sample_collection_date"
                                @if (isset($group)) value="{{ $group['resulte_date'] }}" @endif>

                        </div>
                    </div>
                    <div class="col-lg-3   ">
                        <div class="form-group">
                            <label>{{ __('Invoice date') }}</label>

                            <input type="text" class="form-control flatpickr flatpickr-input" name="created_at"
                                id="created_at"
                                @if (isset($group)) value="{{ $group['created_at'] }}" @else value="{{ date('Y-m-d H:i') }}" @endif>
                        </div>
                    </div>

                   <!-- +++++++++++++++++++++++++++ Branches : My Tasks : الفرع +++++++++++++++++++++++++++ -->
                   {{-- Appear For "SuperAdmin" Only where "superAdmin role" is "auth()->guard('admin')->user()->roles[0]" --}}
                   <div class="col-lg-3 @if(auth()->guard('admin')->user()->roles[0]->role_id == 1)  @else d-none @endif"> 
                        <div class="form-group">
                            <label>Branches</label>
                            <select id="branches_id" name="branch_id" class="select2 form-control" required>
                                    <!-- if "edit form" Then "branchName=$group->branch->name" -->
                                    @if ( isset($group) )
                                        <option selected value="{{ $group->branch->id }}">{{ $group->branch->name }}</option> 
                                    <!-- Else "create form" Then "branchName=$branch->name"  -->
                                    @else 
                                        <option selected value="{{ session('branch_id') }}">{{ $branch->name }}</option> 
                                    @endif
                                </option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 d-flex align-items-center justify-content-center">
                        <div class="form-group pt-4">
                            <div class="input-group mb-3">
                                <div class="form-check">
                                    <input class="form-check-input @if (isset($group) && isset($group['patient'])) checked @endif"
                                        name="is_out" id="is_out" type="checkbox" value="">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        {{ __('استلام العينات خارجيا ؟') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-3 d-flex align-items-center justify-content-center">
                        <div class="form-group pt-4">
                            <div class="input-group mb-3">
                                <div class="form-check">

                                    <input class="form-check-input" @if (isset($group) && isset($group['including_portal_number']) && $group['including_portal_number'] == '1') checked @endif
                                        name="including_portal_number" id="including_portal_number" type="checkbox"
                                        value="">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        {{ __('showPortalNumber') }} ?
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    @can('allow_print_with_due')
                        <div class="col-lg-3 d-flex align-items-center justify-content-center">
                            <div class="form-group pt-4">
                                <div class="input-group mb-3">
                                    <div class="form-check">

                                        <input class="form-check-input" @if (isset($group) && isset($group['allow_print']) && $group['allow_print']) checked @endif
                                            name="allow_print" id="allow_print" type="checkbox" value="1">
                                        <label class="form-check-label" for="allow_print">
                                            {{ __('Show Reports If Not Paid') }} ?
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endcan

                    {{--                    <div class="col-lg-3"></div> --}}
                    {{-- Start Questions --}}
                    {{-- Fluid Patient --}}
                    <div class="modal-header col-lg-12 mb-3">
                        <h5 class="modal-title">{{ __('Diseases suffered by the patient') }}</h5>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="form-check">
                                    <input class="form-check-input"
                                        {{ isset($group['patient']) && $group['patient']['fluid_patient'] == 1 ? 'checked' : '' }}
                                        name="fluid_patient" id="fluid_patient" type="checkbox" value="1"
                                        id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        {{ __('Hemophilia') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Diabetic --}}
                    <div class="col-lg-2">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" name="diabetic" id="diabetic"
                                        {{ isset($group['patient']) && $group['patient']['diabetic'] == 1 ? 'checked' : '' }}
                                        type="checkbox" value="1" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        {{ __('Diabetic') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- gland --}}
                    <div class="col-lg-2">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" name="gland" id="gland"
                                        {{ isset($group['patient']) && $group['patient']['gland'] == 1 ? 'checked' : '' }}
                                        type="checkbox" value="1" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        {{ __('gland') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- tumors --}}
                    <div class="col-lg-2">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" name="tumors" id="tumors"
                                        {{ isset($group['patient']) && $group['patient']['tumors'] == 1 ? 'checked' : '' }}
                                        type="checkbox" value="1" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        {{ __('tumors') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- antibiotic --}}
                    <div class="col-lg-2">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" name="antibiotic" id="antibiotic"
                                        {{ isset($group['patient']) && $group['patient']['antibiotic'] == 1 ? 'checked' : '' }}
                                        type="checkbox" value="1" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        {{ __('antibiotic') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- iron --}}
                    <div class="col-lg-2">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" name="iron" id="iron"
                                        {{ isset($group['patient']) && $group['patient']['iron'] == 1 ? 'checked' : '' }}
                                        type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        {{ __('iron') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- cortisone --}}
                    <div class="col-lg-2">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" name="cortisone" id="cortisone"
                                        {{ isset($group['patient']) && $group['patient']['cortisone'] == 1 ? 'checked' : '' }}
                                        type="checkbox" value="1" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        {{ __('cortisone') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- pressure --}}
                    <div class="col-lg-2">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" name="pressure" id="pressure"
                                        {{ isset($group['patient']) && $group['patient']['pressure'] == 1 ? 'checked' : '' }}
                                        type="checkbox" value="1" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        {{ __('pressure') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Liver Patient --}}
                    <div class="col-lg-2">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" name="liver_patient" id="liver_patient"
                                        {{ isset($group['patient']) && $group['patient']['liver_patient'] == 1 ? 'checked' : '' }}
                                        type="checkbox" value="1" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        {{ __('Liver Patient') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="{{ __('Other') }}"
                                    @if (isset($group) && isset($group['patient']['answer_other'])) value="{{ $group['patient']['answer_other'] }}" @endif id="answer_other"
                                    style="height: 50px">{{ isset($group['patient']) && $group['patient']['answer_other'] ? $group['patient']['answer_other'] : '' }}</textarea>
                            </div>
                        </div>
                    </div>
                    {{-- End   Questions --}}
                    <div class="modal-header col-lg-12 mb-3">
                        <h5 class="modal-title">{{ __('Knowed Us By') }}</h5>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <select class="form-control select2" name="knowed_by" id="">
                                @foreach ($knows as $know)
                                    <option></option>
                                    <option @if (isset($group) && $group['knowed_by'] == $know->id) selected @endif
                                        value="{{ $know->id }}">{{ $know->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- <div class="col-lg-2">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" {{ isset($group['patient']) && $group['patient']['old_visit'] == 1 ? 'checked' : '' }} value="1"   id="old_visit"  type="checkbox"  id="old_visit">
                                    <label class="form-check-label" for="old_visit">
                                    {{ $know['name'] }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div> --}}


                    {{-- <div class="col-lg-2">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="form-check">
                                <input class="form-check-input"  {{ isset($group['patient']) && $group['patient']['frenid'] == 1 ? 'checked' : '' }} value="2"  type="checkbox"  id="frenid">
                                <label class="form-check-label" for="frenid">
                                {{__('Frenid')}}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-2">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="form-check">
                                <input class="form-check-input"  {{ isset($group['patient']) && $group['patient']['face'] == 1 ? 'checked' : '' }}  type="checkbox" value="3" id="face">
                                <label class="form-check-label" for="face">
                                {{__('Face Book')}}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-2">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="form-check">
                                <input class="form-check-input"   {{ isset($group['patient']) && $group['patient']['doctor_from'] == 1 ? 'checked' : '' }}  type="checkbox" value="" id="doctor_from">
                                <label class="form-check-label" for="doctor_from">
                                {{__('Doctor')}}
                                </label>
                            </div>
                        </div>
                    </div>
                </div> --}}


                    <div class="col-lg-4">
                        <div class="form-group">
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="{{ __('Other') }}"
                                    @if (isset($group) && isset($group['knowed_other'])) value="{{ $group['knowed_other'] }}" @endif id="knowed_other"
                                    name="knowed_other" style="height: 50px">{{ isset($group['patient']) && $group['knowed_other'] ? $group['knowed_other'] : '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /patient info-->
    {{-- {{ dd(\Route::currentRouteName()) }} --}}
    <!-- Tests -->

    <div class="row" id="images-review">
        {{-- {{$group->invoiceImage}} --}}
        @if (isset($group) && isset($group->invoiceImage))
            @foreach ($group->invoiceImage as $image)
                <div class="col-md-4">
                    <img src="{{ url('uploads/group/' . $image['img_name']) }}" alt="" class="w-100">
                    <form method="get" class="deleteImageForm"
                        action="{{ route('admin.delete-group-image', ['group_id' => $image['group_id'], 'image_name' => $image['img_name']]) }}"
                        class="d-inline" id="delete_form">
                        <a class="btn btn-danger"
                            href="{{ route('admin.delete-group-image', ['group_id' => $image['group_id'], 'image_name' => $image['img_name']]) }}">
                            {{ __('Delete') }}
                        </a>
                    </form>

                </div>
                </form>
            @endforeach
        @endif
    </div>

    <div class="row">

        @if (\Route::currentRouteName() == 'admin.ray_groups.create' || \Route::currentRouteName() == 'admin.ray_groups.edit')
            <div class="col-lg-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h5 class="card-title">
                            {{ __('Rays') }}
                        </h5>
                    </div>
                    <div class="card-header">
                        <select name="" id="select_ray" class="form-control"></select>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th width="40%">
                                        {{ __('Name') }}
                                    </th>
                                    <th>
                                        {{ __('Price') }}
                                    </th>
                                    <th width="10px">
                                    </th>
                                    <th width="10px">
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="selected_rays">
                                @if (isset($group) && $group['rays'])
                                    @foreach ($group['rays_with_canceled'] as $ray)
                                        <tr @if ($ray['is_canceled']) class="selected_ray color-red" @else class="selected_ray" @endif
                                            id="ray_{{ $ray['ray_id'] }}"
                                            default_price="{{ $ray['ray']['price'] }}">
                                            <td>
                                                {{ $ray['ray']['name'] }}
                                                <input type="hidden" class="rays_id"
                                                    name="rays[{{ $ray['ray_id'] }}][id]"
                                                    value="{{ $ray['ray_id'] }}">
                                            </td>
                                            <td>
                                                {{ $ray['ray']['category']['name'] }}
                                            </td>
                                            <td class="ray_price">
                                                {{ $ray['price'] }}
                                            </td>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-danger btn-sm delete_selected_row">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-danger btn-sm cancel_selected_row">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                            <input type="hidden" class="price"
                                                name="rays[{{ $ray['ray_id'] }}][price]"
                                                value="{{ $ray['price'] }}">
                                            <input type="hidden" class="is_canceled"
                                                name="rays[{{ $ray['ray_id'] }}][is_canceled]"
                                                value="{{ $ray['is_canceled'] }}">

                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h5 class="card-title">
                            {{ __('Packages') }}
                        </h5>
                    </div>
                    <div class="card-header">
                        <select name="" id="select_package" class="form-control"></select>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th
                                        style="width:20%;font-size: 12px;padding: 1px !important;padding: 10px;font-weight: 400;">
                                        {{ __('Name') }}
                                    </th>
                                    <th
                                        style="width:20%;font-size: 12px;padding: 1px !important;padding: 10px;font-weight: 400;">
                                        {{ __('Price') }}
                                    </th>
                                    <th
                                        style="width:20%;font-size: 12px;padding: 1px !important;padding: 10px;font-weight: 400;">
                                        {{ __('In/Out') }}
                                    </th>
                                    <th
                                        style="width:10%;font-size: 12px;padding: 1px !important;padding: 10px;font-weight: 400;">
                                        {{ __('Cost') }}
                                    </th>
                                    <th
                                        style="width:10%;font-size: 12px;padding: 1px !important;padding: 10px;font-weight: 400;">
                                        {{ __('delete') }}
                                    </th>
                                    <th
                                        style="width:10%;font-size: 12px;padding: 1px !important;padding: 10px;font-weight: 400;">
                                        {{ __('cancel') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="selected_packages">
                                @if (isset($group))
                                    @foreach ($group['packages_with_canceled'] as $package)
                                        <tr @if ($package['is_canceled']) class="selected_package color-red" @else class="selected_package" @endif
                                            id="package_{{ $package['package_id'] }}"
                                            default_price="{{ $package['package']['price'] }}">
                                            <td>
                                                {{ $package['package']['name'] }}
                                                <input type="hidden" class="packages_id"
                                                    name="packages[{{ $package['package_id'] }}][id]"
                                                    value="{{ $package['package_id'] }}">
                                            </td>
                                            <td class="package_price">
                                                {{ $package['price'] }}
                                            </td>
                                            <td>
                                                {{ $package['lab_to_lab_status'] }}
                                            </td>
                                            <td>
                                                {{ $package['lab_to_lab_cost'] }}
                                            </td>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-danger btn-sm delete_selected_row">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-danger btn-sm cancel_selected_row">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                            <input type="hidden" class="is_canceled"
                                                name="packages[{{ $package['package_id'] }}][is_canceled]"
                                                value="{{ $package['is_canceled'] }}">
                                            <input type="hidden" class="price"
                                                name="packages[{{ $package['package_id'] }}][price]"
                                                value="{{ $package['price'] }}">
                                            <input type="hidden" class="cost_lab_to_lab"
                                                name="packages[{{ $package['package_id'] }}][cost]"
                                                value="{{ $package['lab_to_lab_cost'] }}">

                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h5 class="card-title">
                            {{ __('Offers') }}
                        </h5>
                    </div>
                    <div class="card-header">
                        <select name="" id="select_offer" class="form-control"></select>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th
                                        style="width:20%;font-size: 12px;padding: 1px !important;padding: 10px;font-weight: 400;">
                                        {{ __('Name') }}
                                    </th>
                                    <th
                                        style="width:20%;font-size: 12px;padding: 1px !important;padding: 10px;font-weight: 400;">
                                        {{ __('shortcut') }}
                                    </th>
                                    <th
                                        style="width:20%;font-size: 12px;padding: 1px !important;padding: 10px;font-weight: 400;">
                                        {{ __('status') }}
                                    </th>
                                    <th
                                        style="width:10%;font-size: 12px;padding: 1px !important;padding: 10px;font-weight: 400;">
                                        {{ __('cost_before') }}
                                    </th>
                                    <th
                                        style="width:10%;font-size: 12px;padding: 1px !important;padding: 10px;font-weight: 400;">
                                        {{ __('cost_afetr') }}
                                    </th>
                                    <th
                                        style="width:10%;font-size: 12px;padding: 1px !important;padding: 10px;font-weight: 400;">
                                        {{ __('delete') }}
                                    </th>
                                    <th
                                        style="width:10%;font-size: 12px;padding: 1px !important;padding: 10px;font-weight: 400;">
                                        {{ __('cancel') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="selected_offers">
                                @if (isset($group))
                                    @foreach ($group['offers'] as $offer)
                                        <tr id="offer_{{ $offer['id'] }}"
                                            default_price="{{ $offer['cost_after'] }}">
                                            <td>
                                                {{ $offer['offer']['name'] }}
                                                <input type="hidden" class="offer_id"
                                                    name="offers[{{ $offer['id'] }}][id]"
                                                    value="{{ $offer['offer']['id'] }}">
                                                <input type="hidden" class="offer_id"
                                                    name="offers[{{ $offer['id'] }}][price]"
                                                    value="{{ $offer['offer']['cost_afetr'] }}">
                                                <input type="hidden" class="offer_id"
                                                    name="offers[{{ $offer['id'] }}][cost]"
                                                    value="{{ $offer['offer']['cost_before'] }}">

                                            </td>
                                            <td>
                                                {{ $offer['offer']['shortcut'] }}
                                            </td>
                                            <td>
                                                {{ $offer['offer']['status'] }}
                                            </td>
                                            <td class="offer_price">
                                                {{ $offer['offer']['cost_before'] }}
                                            </td>
                                            <td>
                                                {{ $offer['offer']['cost_afetr'] }}
                                            </td>

                                            <td>
                                                <button type="button"
                                                    class="btn btn-danger btn-sm cancel_selected_row">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-danger btn-sm delete_selected_row">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <div class="col-lg-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h5 class="card-title">
                            {{ __('Tests') }}
                        </h5>
                    </div>
                    <div class="card-header">
                        <select name="" id="select_test" class="form-control"></select>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered table-striped table-sm" style="padding: 5px;">
                            <thead>
                                <tr>
                                    <th
                                        style="width:20%;font-size: 12px;padding: 1px !important;padding: 10px;font-weight: 400; text-align:center;">
                                        {{ __('Name') }}
                                    </th>
                                    {{-- ======================== Task : test_sample ======================== --}}
                                    <th style="width:20%;font-size: 12px;padding: 1px !important;padding: 10px;font-weight: 400;text-align:center;">
                                        {{__('Sample')}}
                                    </th>
                                    <th
                                        style="width:20%;font-size: 12px;padding: 1px !important;padding: 10px;font-weight: 400;text-align:center;">
                                        {{ __('Price') }}
                                    </th>
                                    <th
                                        style="width:20%;font-size: 12px;padding: 1px !important;padding: 10px;font-weight: 400;text-align:center;">
                                        {{ __('In/Out') }}
                                    </th>
                                    <th
                                        style="width:10%;font-size: 12px;padding: 1px !important;padding: 10px;font-weight: 400;text-align:center;">
                                        {{ __('Cost') }}
                                    </th>
                                    <th
                                        style="width:10%;font-size: 12px;padding: 1px !important;padding: 10px;font-weight: 400;text-align:center;">
                                        {{ __('delete') }}
                                    </th>
                                    <th
                                        style="width:10%;font-size: 12px;padding: 1px !important;padding: 10px;font-weight: 400;text-align:center;">
                                        {{ __('cancel') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="selected_tests">
                                @if (isset($group))
                                    @php
                                        $contractGroup = $group->contract_id;
                                    @endphp
                                    @foreach ($group['tests_with_canceled'] as $test)
                                   
                                        <tr @if ($test['is_canceled']) class="selected_test color-red" @else class="selected_test" @endif
                                            @if (
                                                $contractGroup != null &&
                                                    $test->test->contract_prices()->where('contract_id', $contractGroup)->first() && $test->test->contract_prices()->where('contract_id', $contractGroup)->first()->is_refuse) style="background-color:#db9696 !important;" @endif
                                            id="test_{{ $test['test_id'] }}"
                                            default_price="{{ $test['test']['price'] }}">
                                            <td style="white-space: normal; text-align:center;">
                                                {{ $test['test']['name'] }}
                                                <input type="hidden" class="tests_id"
                                                    name="tests[{{ $test['test_id'] }}][id]"
                                                    value="{{ $test['test_id'] }}">
                                            </td>
                                            <td style="width:10%;text-align:center;">{{ ($test->test->sample)? $test->test->sample->name : null }}</td>
                                            <td style="text-align:center;" class="test_price">
                                                {{ $test['price'] }}
                                            </td>
                                            <td style="text-align:center;">
                                                <input type="text"
                                                    name="tests[{{ $test['test_id'] }}][lab_status]"
                                                    @if ($test['test']['lab_to_lab_status'] == 1) value="Out" @else value="In" @endif
                                                    style="width:70% !important"   
                                                />
                                            </td>
                                            <td style="width:10%;">
                                                {{ $test['lab_to_lab_cost'] }}
                                            </td>
                                            <td style="width:10%;">
                                                <button type="button" title="{{ __('Delete') }}"
                                                    class="btn btn-danger btn-sm delete_selected_row">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                            <td style="width:20%;">
                                                <button type="button" title="{{ __('Cancel') }}"
                                                    class="btn btn-warning btn-sm cancel_selected_row">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </td>
                                            <input type="hidden" class="price"
                                                name="tests[{{ $test['test_id'] }}][price]"
                                                value="{{ $test['price'] }}">
                                            <input type="hidden" class="cost_lab_to_lab"
                                                name="tests[{{ $test['test_id'] }}][cost]"
                                                value="{{ $test['lab_to_lab_cost'] }}">
                                            <input type="hidden" class="is_canceled"
                                                name="tests[{{ $test['test_id'] }}][is_canceled]"
                                                value="{{ $test['is_canceled'] }}">

                                        </tr>
                                    @endforeach
                                @elseif(isset($visitTests))
                                    @foreach ($visitTests as $test)
                                        <tr class="selected_test" id="test_{{ $test['test']['id'] }}"
                                            default_price="{{ $test['test']['price'] }}">
                                            <td style="width:20%;">
                                                {{ $test['test']['name'] }}
                                                <input type="hidden" class="tests_id"
                                                    name="tests[{{ $test['test']['id'] }}][id]"
                                                    value="{{ $test['test']['id'] }}">
                                            </td>
                                            <td style="width:10%;" class="test_price">
                                                {{ $test['test']['price'] }}
                                            </td>
                                            <td style="width:10%;">
                                                <input type="text"
                                                    name="tests[{{ $test['test']['id'] }}][lab_status]"
                                                    @if ($test['test']['lab_to_lab_status'] == 1) value="Out" @else value="In" @endif />
                                            </td>
                                            <td style="width:10%;">
                                                {{ $test['test']['lab_to_lab_cost'] }}
                                            </td>
                                            <td style="width:10%;">
                                                <button type="button" title="{{ __('Delete') }}"
                                                    class="btn btn-danger btn-sm delete_selected_row">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                            <td style="width:20%;">
                                                <button type="button" title="{{ __('Cancel') }}"
                                                    class="btn btn-warning btn-sm cancel_selected_row">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </td>
                                            <input type="hidden" class="price"
                                                name="tests[{{ $test['test']['id'] }}][price]"
                                                value="{{ $test['test']['price'] }}">
                                            <input type="hidden" class="cost_lab_to_lab"
                                                name="tests[{{ $test['test']['id'] }}][cost]"
                                                value="{{ $test['test']['lab_to_lab_cost'] }}">
                                            <input type="hidden" class="is_canceled"
                                                name="tests[{{ $test['test']['id'] }}][is_canceled]"
                                                value="{{ $test['test']['is_canceled'] }}">

                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h5 class="card-title">
                            {{ __('Cultures') }}
                        </h5>
                    </div>
                    <div class="card-header">
                        <select name="" id="select_culture" class="form-control"></select>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th
                                        style="width:20%;font-size: 12px;padding: 1px !important;padding: 10px;font-weight: 400;">
                                        {{ __('Name') }}
                                    </th>
                                    <th
                                        style="width:20%;font-size: 12px;padding: 1px !important;padding: 10px;font-weight: 400;">
                                        {{ __('Price') }}
                                    </th>
                                    <th
                                        style="width:20%;font-size: 12px;padding: 1px !important;padding: 10px;font-weight: 400;">
                                        {{ __('In/Out') }}
                                    </th>
                                    <th
                                        style="width:10%;font-size: 12px;padding: 1px !important;padding: 10px;font-weight: 400;">
                                        {{ __('Cost') }}
                                    </th>
                                    <th
                                        style="width:10%;font-size: 12px;padding: 1px !important;padding: 10px;font-weight: 400;">
                                        {{ __('delete') }}
                                    </th>
                                    <th
                                        style="width:10%;font-size: 12px;padding: 1px !important;padding: 10px;font-weight: 400;">
                                        {{ __('cancel') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="selected_cultures">
                                @if (isset($group))
                                    @foreach ($group['cultures_with_canceled'] as $culture)
                                        <tr @if ($culture['is_canceled']) class="selected_culture color-red" @else class="selected_culture" @endif
                                            @if (
                                                $contractGroup != null &&
                                                    $culture->culture->contract_prices()->where('contract_id', $contractGroup)->first() && $culture->culture->contract_prices()->where('contract_id', $contractGroup)->first()->is_refuse) style="background-color:#db9696 !important;" @endif
                                            id="culture_{{ $culture['culture_id'] }}"
                                            default_price="{{ $culture['culture']['price'] }}">
                                            <td>
                                                {{ $culture['culture']['name'] }}
                                                <input type="hidden" class="cultures_id"
                                                    name="cultures[{{ $culture['culture_id'] }}][id]"
                                                    value="{{ $culture['culture_id'] }}">
                                            </td>
                                            <td class="culture_price">
                                                {{ $culture['price'] }}
                                            </td>
                                            <td>
                                                {{ $culture['lab_to_lab_status'] }}
                                            </td>
                                            <td>
                                                {{ $culture['lab_to_lab_cost'] }}
                                            </td>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-danger btn-sm delete_selected_row">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-danger btn-sm cancel_selected_row">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                            <input type="hidden" class="price"
                                                name="cultures[{{ $culture['culture_id'] }}][price]"
                                                value="{{ $culture['price'] }}">
                                            <input type="hidden" class="is_canceled"
                                                name="cultures[{{ $culture['culture_id'] }}][is_canceled]"
                                                value="{{ $culture['is_canceled'] }}">
                                            <input type="hidden" class="cost_lab_to_lab"
                                                name="cultures[{{ $culture['culture_id'] }}][cost]"
                                                value="{{ $culture['lab_to_lab_cost'] }}">
                                        </tr>
                                    @endforeach
                                @elseif(isset($visitCultures))
                                    @foreach ($visitCultures as $culture)
                                        <tr class="selected_culture" id="culture_{{ $culture['culture']['id'] }}"
                                            default_price="{{ $culture['culture']['price'] }}">
                                            <td>
                                                {{ $culture['culture']['name'] }}
                                                <input type="hidden" class="cultures_id"
                                                    name="cultures[{{ $culture['culture']['id'] }}][id]"
                                                    value="{{ $culture['culture']['id'] }}">
                                            </td>
                                            <td class="culture_price">
                                                {{ $culture['culture']['price'] }}
                                            </td>
                                            <td>
                                                {{ $culture['culture']['lab_to_lab_status'] }}
                                            </td>
                                            <td>
                                                {{ $culture['culture']['lab_to_lab_cost'] }}
                                            </td>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-danger btn-sm delete_selected_row">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-danger btn-sm cancel_selected_row">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                            <input type="hidden" class="price"
                                                name="cultures[{{ $culture['culture']['id'] }}][price]"
                                                value="{{ $culture['culture']['price'] }}">
                                            <input type="hidden" class="is_canceled"
                                                name="cultures[{{ $culture['culture']['id'] }}][is_canceled]"
                                                value="{{ $culture['culture']['is_canceled'] }}">
                                            <input type="hidden" class="cost_lab_to_lab"
                                                name="cultures[{{ $culture['culture']['id'] }}][cost]"
                                                value="{{ $culture['culture']['lab_to_lab_cost'] }}">
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h5 class="card-title">
                            {{ __('Packages') }}
                        </h5>
                    </div>
                    <div class="card-header">
                        <select name="" id="select_package" class="form-control"></select>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th
                                        style="width:20%;font-size: 12px;padding: 1px !important;padding: 10px;font-weight: 400;">
                                        {{ __('Name') }}
                                    </th>
                                    <th
                                        style="width:20%;font-size: 12px;padding: 1px !important;padding: 10px;font-weight: 400;">
                                        {{ __('Price') }}
                                    </th>
                                    <th
                                        style="width:20%;font-size: 12px;padding: 1px !important;padding: 10px;font-weight: 400;">
                                        {{ __('In/Out') }}
                                    </th>
                                    <th
                                        style="width:10%;font-size: 12px;padding: 1px !important;padding: 10px;font-weight: 400;">
                                        {{ __('Cost') }}
                                    </th>
                                    <th
                                        style="width:10%;font-size: 12px;padding: 1px !important;padding: 10px;font-weight: 400;">
                                        {{ __('delete') }}
                                    </th>
                                    <th
                                        style="width:10%;font-size: 12px;padding: 1px !important;padding: 10px;font-weight: 400;">
                                        {{ __('cancel') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="selected_packages">
                                @if (isset($group))
                                    @foreach ($group['packages_with_canceled'] as $package)
                                        <tr @if ($package['is_canceled']) class="selected_package color-red" @else class="selected_package" @endif
                                            @if (
                                                $contractGroup != null &&
                                                    $package->package->contract_prices()->where('contract_id', $contractGroup)->first() && $package->package->contract_prices()->where('contract_id', $contractGroup)->first()->is_refuse) style="background-color:#db9696 !important;" @endif
                                            id="package_{{ $package['package_id'] }}"
                                            default_price="{{ $package['package']['price'] }}">
                                            <td>
                                                {{ $package['package']['name'] }}
                                                <input type="hidden" class="packages_id"
                                                    name="packages[{{ $package['package_id'] }}][id]"
                                                    value="{{ $package['package_id'] }}">
                                            </td>
                                            <td class="package_price">
                                                {{ $package['price'] }}
                                            </td>
                                            <td>
                                                {{ $package['lab_to_lab_status'] }}
                                            </td>
                                            <td>
                                                {{ $package['lab_to_lab_cost'] }}
                                            </td>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-danger btn-sm delete_selected_row">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-danger btn-sm cancel_selected_row">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                            <input type="hidden" class="is_canceled"
                                                name="packages[{{ $package['package_id'] }}][is_canceled]"
                                                value="{{ $package['is_canceled'] }}">
                                            <input type="hidden" class="price"
                                                name="packages[{{ $package['package_id'] }}][price]"
                                                value="{{ $package['price'] }}">
                                            <input type="hidden" class="cost_lab_to_lab"
                                                name="packages[{{ $package['package_id'] }}][cost]"
                                                value="{{ $package['lab_to_lab_cost'] }}">

                                        </tr>
                                    @endforeach
                                @elseif(isset($visitPackages))
                                    @foreach ($visitPackages as $package)
                                        <tr class="selected_package" id="package_{{ $package['package']['id'] }}"
                                            default_price="{{ $package['package']['price'] }}">
                                            <td>
                                                {{ $package['package']['name'] }}
                                                <input type="hidden" class="packages_id"
                                                    name="packages[{{ $package['package']['id'] }}][id]"
                                                    value="{{ $package['package']['id'] }}">
                                            </td>
                                            <td class="package_price">
                                                {{ $package['package']['price'] }}
                                            </td>
                                            <td>
                                                {{ $package['package']['lab_to_lab_status'] }}
                                            </td>
                                            <td>
                                                {{ $package['package']['lab_to_lab_cost'] }}
                                            </td>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-danger btn-sm delete_selected_row">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-danger btn-sm cancel_selected_row">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                            <input type="hidden" class="is_canceled"
                                                name="packages[{{ $package['package']['id'] }}][is_canceled]"
                                                value="{{ $package['package']['is_canceled'] }}">
                                            <input type="hidden" class="price"
                                                name="packages[{{ $package['package']['id'] }}][price]"
                                                value="{{ $package['package']['price'] }}">
                                            <input type="hidden" class="cost_lab_to_lab"
                                                name="packages[{{ $package['package']['id'] }}][cost]"
                                                value="{{ $package['package']['lab_to_lab_cost'] }}">

                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h5 class="card-title">
                            {{ __('Offers') }}
                        </h5>
                    </div>
                    <div class="card-header">
                        <select name="" id="select_offer" class="form-control"></select>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th
                                        style="width:20%;font-size: 12px;padding: 1px !important;padding: 10px;font-weight: 400;">
                                        {{ __('Name') }}
                                    </th>
                                    <th
                                        style="width:20%;font-size: 12px;padding: 1px !important;padding: 10px;font-weight: 400;">
                                        {{ __('shortcut') }}
                                    </th>
                                    <th
                                        style="width:20%;font-size: 12px;padding: 1px !important;padding: 10px;font-weight: 400;">
                                        {{ __('status') }}
                                    </th>
                                    <th
                                        style="width:10%;font-size: 12px;padding: 1px !important;padding: 10px;font-weight: 400;">
                                        {{ __('cost_before') }}
                                    </th>
                                    <th
                                        style="width:10%;font-size: 12px;padding: 1px !important;padding: 10px;font-weight: 400;">
                                        {{ __('cost_afetr') }}
                                    </th>
                                    <th
                                        style="width:10%;font-size: 12px;padding: 1px !important;padding: 10px;font-weight: 400;">
                                        {{ __('delete') }}
                                    </th>
                                    <th
                                        style="width:10%;font-size: 12px;padding: 1px !important;padding: 10px;font-weight: 400;">
                                        {{ __('cancel') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="selected_offers">
                                @if (isset($group))
                                    @foreach ($group['offers'] as $offer)
                                        <tr id="offer_{{ $offer['id'] }}"
                                            default_price="{{ $offer['cost_after'] }}">
                                            <td>
                                                {{ $offer['offer']['name'] }}
                                                <input type="hidden" class="offer_id"
                                                    name="offers[{{ $offer['id'] }}][id]"
                                                    value="{{ $offer['offer']['id'] }}">
                                                <input type="hidden" class="offer_id"
                                                    name="offers[{{ $offer['id'] }}][price]"
                                                    value="{{ $offer['offer']['cost_afetr'] }}">
                                                <input type="hidden" class="offer_id"
                                                    name="offers[{{ $offer['id'] }}][cost]"
                                                    value="{{ $offer['offer']['cost_before'] }}">

                                            </td>
                                            <td>
                                                {{ $offer['offer']['shortcut'] }}
                                            </td>
                                            <td>
                                                {{ $offer['offer']['status'] }}
                                            </td>
                                            <td class="offer_price">
                                                {{ $offer['offer']['cost_before'] }}
                                            </td>
                                            <td>
                                                {{ $offer['offer']['cost_afetr'] }}
                                            </td>

                                            <td>
                                                <button type="button"
                                                    class="btn btn-danger btn-sm cancel_selected_row">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-danger btn-sm delete_selected_row">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<div class="row">
    <div class="form-group col-11 mx-1">
        <label>
            {{ _('Notice') }}
        </label>
        <textarea name="notice" placeholder="{{ __('Notice') }}" class="form-control" rows="5">@if (isset($group) && $group->notice != null){{ $group->notice }}@endif</textarea>
    </div>
</div>

{{-- questions --}}
<div class="row">
    <div class="col-lg-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    {{ __('Questions') }}
                </h3>
            </div>
            <div class="card-body p-0" id="questions">
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table  table-stripped" id="questions_table">
                            <tbody>
                                <tr>
                                    <td>{{ __('Questions') }}</td>
                                    <td>{{ __('Answer') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row d-flex ">
    <div class="col-lg-6">
        <!-- Receipt -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    {{ __('Receipt') }}
                </h3>
            </div>
            <div class="card-body p-0" id="receipt">
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table  table-stripped" id="receipt_table">
                            <tbody>

                                <tr>
                                    <td width="100px">{{ __('Subtotal') }}</td>
                                    <td width="300px">
                                        <input type="number" id="subtotal" name="subtotal"
                                            @if (isset($group)) value="{{ $group['subtotal'] }}" @else value="0" @endif
                                            readonly class="form-control">
                                    </td>
                                    <td>
                                        {{ get_currency() }}
                                    </td>
                                </tr>
                                {{-- {{Auth::guard('admin')->user()->hasRole('add_discount')}} --}}

                                @if (Auth::guard('admin')->user()->hasRole('add_discount'))
                                    <tr>
                                        <td>{{ __('Discount') }}</td>
                                        <td>
                                            <input type="number" class="form-control" id="discount"
                                                name="discount"
                                                @if (isset($group)) @if (!Auth::guard('admin')->user()->hasRole('edit_discount'))
                                                    readonly @endif
                                            value="{{ $group['discount'] }}" @else value="0" @endif>
                                        </td>
                                        <td>

                                            %
                                        </td>
                                        <td>
                                            <input type="number" @if (!Auth::guard('admin')->user()->hasRole('edit_discount')) readonly @endif
                                                class="form-control" id="discount_value">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>{{ __('Total_Discount') }}</td>
                                        <td width="300px">
                                            <input type="number" name="discount_value" class="form-control"
                                                id="total_discount" readonly
                                                @if (isset($group)) value="{{ $group['discount_value'] }}" @else value="0" @endif>
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td>{{ __('Total') }}</td>
                                    <td>
                                        <input type="number" id="total" name="total" class="form-control"
                                            @if (isset($group)) value="{{ $group['total'] }}" @else value="0" @endif
                                            readonly>
                                    </td>
                                    <td>
                                        {{ get_currency() }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('Paid') }}</td>
                                    <td>
                                        <input type="number" id="paid" name="paid" min="0"
                                            class="form-control"
                                            @if (isset($group)) value="{{ $group['paid'] }}" @else value="0" @endif
                                            readonly required>
                                    </td>
                                    <td>
                                        {{ get_currency() }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('Due') }}</td>
                                    <td>
                                        <input type="number" id="due" name="due" class="form-control"
                                            @if (isset($group)) value="{{ $group['due'] }}" @else value="0" @endif
                                            readonly>
                                    </td>
                                    <td>
                                        {{ get_currency() }}
                                    </td>
                                </tr>
                                <tr class="d-none">
                                    <td>{{ __('Lab To Lab Cost') }}</td>
                                    <td>
                                        <input type="number" id="lab_cost" name="cost" class="form-control"
                                            @if (isset($group)) value="{{ $group['cost'] }}" @else value="0" @endif>
                                    </td>
                                    <td>
                                        {{ get_currency() }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('Delayed Money') }}</td>
                                    <td>
                                        <input type="number" id="delayed_money" name="delayed_money"
                                            class="form-control"
                                            @if (isset($group)) value="{{ $group['delayed_money'] }}" @else value="0" @endif>
                                    </td>
                                    <td>
                                        {{ get_currency() }}
                                    </td>
                                </tr>
                                <tr class="d-none">
                                    <td>{{ __('After Lab To Lab') }}</td>
                                    <td>
                                        <input type="number" id="after_lab" name="total_after_cost"
                                            class="form-control"
                                            @if (isset($group)) value="{{ $group['total_after_cost'] }}" @else value="0" @endif
                                            readonly>
                                    </td>
                                    <td>
                                        {{ get_currency() }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('Due For User') }} </td>
                                    <td>
                                        <input type="number" id="due_for_patient" name="due_for_patient"
                                            class="form-control"
                                            @if (isset($group)) value="{{ $group['due_for_patient'] }}" @else value="0" @endif
                                            readonly>
                                    </td>
                                    <td>
                                        {{ get_currency() }}
                                    </td>
                                </tr>
                                @if (isset(setting('account')['tax']) && setting('account')['tax'])
                                    <tr>
                                        <td>{{ __('Tax') }} %</td>
                                        <td>
                                            <input type="number" id="tax" class="form-control"
                                                value="{{ setting('account')['tax_persentage'] }}" readonly>
                                        </td>
                                        <td>
                                            %
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('Tax Value') }} %</td>
                                        <td>
                                            <input type="number" id="tax_value" name="tax" class="form-control"
                                                @if (isset($group)) value="{{ $group['tax'] }}" @else value="0" @endif
                                                readonly>
                                        </td>
                                        <td>
                                            {{ get_currency() }}
                                        </td>
                                    </tr>
                                @else
                                    <input type="hidden" id="tax" class="form-control" value="0">
                                    <input type="hidden" id="tax_value" name="tax" class="form-control"
                                        value="0">


                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- \Receipt -->
    </div>
    <div class="col-lg-6">
        <!-- Payments -->
        <div class="card card-primary">
            <div class="card-header">
                <h5 class="card-title">
                    {{ __('extraService') }}
                </h5>
            </div>
            <div class="card-header">
                <select name="" id="select_extra_Service" class="form-control"></select>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th
                                style="width:25%;font-size: 12px;padding: 1px !important;padding: 10px;font-weight: 400;">
                                {{ __('Name') }}
                            </th>
                            <th
                                style="width:25%;font-size: 12px;padding: 1px !important;padding: 10px;font-weight: 400;">
                                {{ __('Price') }}
                            </th>
                            <th
                                style="width:50%;font-size: 12px;padding: 1px !important;padding: 10px;font-weight: 400;">
                                {{ __('Description') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody id="selected_extraSerices">
                        @if (isset($extraServices))
                            @foreach ($extraServices as $service)
                                {{-- {{$service->extraService['id']}} --}}
                                <tr id="service_{{ $service->extraService['id'] }}"
                                    default_price="{{ $service->extraService['price'] }}">
                                    <td>
                                        {{ $service->extraService['name'] }}

                                        <input type="hidden" class="service_id"
                                            name="services[{{ $service->extraService['id'] }}][id]"
                                            value="{{ $service->extraService['id'] }}">
                                    </td>
                                    <td class="service_price">
                                        {{ $service->extraService['price'] }}
                                    </td>
                                    <td>
                                        {{ $service->extraService['descript'] }}
                                    </td>

                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm delete_selected_row">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                    {{-- <input type="hidden" class="is_canceled" name="services[{{$service->extraService['id']}}]"> --}}
                                    <input type="hidden" class="price"
                                        name="services[{{ $service->extraService['id'] }}][price]"
                                        value="{{ $service->extraService['price'] }}">
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card card-primary card-outline">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-12">
                        <h5 class="card-title">
                            {{ __('Payments') }}
                        </h5>
                        <button type="button" class="btn btn-primary d-inline float-right" id="add_payment">
                            <i class="fa fa-plus"></i> {{ __('Payment') }}
                        </button>
                    </div>
                </div>
                @can('create_payment_method')
                    <div class="row">
                        <div class="col-lg-12">
                            <button type="button" class="btn btn-warning d-inline" id="create_payment_method_button"
                                data-toggle="modal" data-target="#create_payment_method_modal">
                                <i class="fa fa-plus"></i> {{ __('Payment method') }}
                            </button>
                        </div>
                    </div>
                @endcan
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 table-responsive">
                        @php
                            $payments_count = 0;
                        @endphp
                        <table class="table table-striped table-bordered" id="payments_table">
                            <thead>
                                <th width="30%">{{ __('Date') }}</th>
                                <th width="30%">{{ __('Amount') }}</th>
                                <th>{{ __('Payment method') }}</th>
                                <th width="10px"></th>
                            </thead>
                            <tbody>
                                @if (isset($group))
                                    @foreach ($group['payments'] as $payment)
                                        @can ('edit_value')
                                            <tr>
                                                <td>
                                                    <input type="text"
                                                        class="form-control flatpickr flatpickr-input new_datepicker"
                                                        name="payments[{{ $payments_count }}][date]"
                                                        value="{{ $payment['date'] }}"
                                                        placeholder="{{ __('Date') }}" required>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control amount"
                                                        name="payments[{{ $payments_count }}][amount]"
                                                        value="{{ $payment['amount'] }}" id=""
                                                        @if (!Auth::guard('admin')->user()->hasRole('edit_value')) readonly @endif required>
                                                </td>
                                                <td>
                                                    <select name="payments[{{ $payments_count }}][payment_method_id]"
                                                        id="" class="form-control payment_method_id"
                                                        required>
                                                        <option value="" disabled selected>
                                                            {{ __('Select payment method') }}</option>
                                                        <option value="{{ $payment['payment_method_id'] }}"
                                                            @if ($payment['payment_method_id'] == $group->payments[$payments_count]->payment_method_id) selected @endif>
                                                            {{ $payment['payment_method']['name'] }}</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger delete_payment">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control"
                                                        name="payments[{{ $payments_count }}][date]"
                                                        value="{{ $payment['date'] }}"
                                                        placeholder="{{ __('Date') }}" required readonly>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control amount"
                                                        name="payments[{{ $payments_count }}][amount]"
                                                        value="{{ $payment['amount'] }}" id="" required
                                                        readonly>
                                                </td>
                                                <td>
                                                    <select name="payments[{{ $payments_count }}][payment_method_id]"
                                                        id="" class="form-control payment_method_id"
                                                        required>
                                                        <option value="" disabled selected>
                                                            {{ __('Select payment method') }}</option>
                                                        <option value="{{ $payment['payment_method_id'] }}"
                                                            @if ($payment['payment_method_id'] == $group->payments[$payments_count]->payment_method_id) selected @endif>
                                                            {{ $payment['payment_method']['name'] }}</option>
                                                    </select>
                                                </td>
                                                {{-- <td>
                                                <button type="button" class="btn btn-danger delete_payment">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </td> --}}
                                            </tr>
                                        @endcan
                                        @php
                                            $payments_count++;
                                        @endphp
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <input type="hidden" id="payments_count" value="{{ $payments_count }}">
                    </div>
                </div>
            </div>
        </div>
        <!--\Payments -->
        {{-- {{ dd(date('Y-m-d') . '/' .$group->payments[0]->date) }} --}}
        @if (isset($group) && $group['paid'] > 0 && $group['done'] == 0)
            <div class="btn btn-danger mb-2 retrieve_status">{{ __('Retrieve') }}</div>
            <div class="card card-primary card-outline" id="retrieve_pay">
                @if ($group['retrieve_amount'] > 0 && $group['retrieve_type'] != null && $group['retrieve_date'] != null)
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-12">
                                <h5 class="card-title">
                                    {{ __('Retrieved') }}
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 table-responsive">
                                @php
                                    $payments_count = 0;
                                @endphp
                                <table class="table table-striped table-bordered" id="">
                                    <thead>
                                        <th width="30%">{{ __('Date') }}</th>
                                        <th width="30%">{{ __('Amount') }}</th>
                                        <th>{{ __('Payment method') }}</th>
                                    </thead>
                                    <tbody>
                                        @if (isset($group))
                                            <tr>
                                                <td>
                                                    <input type="text"
                                                        class="form-control flatpickr flatpickr-input"
                                                        name="retrieve_date"
                                                        @if ($group['retrieve_date'] != null) value={{ $group['retrieve_date'] }} @endif
                                                        placeholder="{{ __('Date') }}" required>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control" id="retrieve_amount"
                                                        name="retrieve_amount" value="{{ $group->retrieve_amount }}"
                                                        required readonly>
                                                </td>
                                                <td>
                                                    <select name="retrieve_type" id="retrieve_type"
                                                        class="form-control" required>
                                                        <option value="" disabled selected>
                                                            {{ __('Select') }}
                                                        </option>
                                                        <option value="1"
                                                            @if ($group['retrieve_type'] == '1') selected @endif>
                                                            {{ __('Custody') }}</option>

                                                        @if ($group->payments[0]->date == date('Y-m-d'))
                                                            <option value="0"
                                                                @if ($group['retrieve_type'] == '0') selected @endif>
                                                                {{ __('Vault') }}</option>
                                                        @endif
                                                    </select>
                                                </td>
                                            </tr>


                                        @endif
                                    </tbody>
                                </table>
                                <input type="hidden" id="payments_count" value="{{ $payments_count }}">
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endif
        {{-- <div class="card card-primary card-outline" id="retrieve_pay">

        </div> --}}

    </div>


</div>


<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <button type="submit" class="btn btn-primary form-control">{{ __('Save') }}</button>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <a href="{{ route('admin.groups.index') }}"
            class="btn btn-danger form-control cancel_form">{{ __('Cancel') }}</a>
    </div>
</div>

<br>
