<div class="row">

    <div class="media mb-2">
        <a href="@if (!empty($patient['avatar'])) {{ url('uploads/patient-avatar/' . $patient['avatar']) }}@else{{ url('img/avatar.png') }} @endif"
            data-toggle="lightbox" data-title="Avatar" alt="users avatar"
            class="user-avatar users-avatar-shadow rounded mr-2 my-25 cursor-pointer" height="90" width="90">
            <img src="@if (!empty($patient['avatar'])) {{ url('uploads/patient-avatar/' . $patient['avatar']) }}@else{{ url('img/avatar.png') }} @endif"
                alt="users avatar" class="user-avatar users-avatar-shadow rounded mr-2 my-25 cursor-pointer"
                height="90" width="90" id="patient_avatar" alt="">
        </a>
        <div class="media-body mt-50">
            <h4>{{ __('Avatar') }}</h4>
            <div class="col-12 d-flex mt-1 px-0">
                <label class="btn btn-primary mr-75 mb-0 waves-effect waves-float waves-light" for="change-picture">
                    <span class="d-none d-sm-block">{{ __('Choose avatar') }}</span>
                    <input class="form-control" type="file" id="change-picture" name="avatar" hidden=""
                        accept="image/png, image/jpeg, image/jpg">
                    <span class="d-block d-sm-none">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-edit mr-0">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                        </svg>
                    </span>
                </label>

                <button class="btn btn-outline-secondary d-none d-sm-block waves-effect" id="delete_avatar"
                    patient_id="@if (isset($patient)) {{ $patient['id'] }} @endif">Remove</button>
                <button class="btn btn-outline-secondary d-block d-sm-none waves-effect">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-trash-2 mr-0">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        <line x1="10" y1="11" x2="10" y2="17"></line>
                        <line x1="14" y1="11" x2="14" y2="17"></line>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div class="col-lg-12">

        <div class="row">

            <div class="col-md-4">
                <div class="form-group" id="basic-addon1">
                    <label for="username">{{ __('Patient Name') }}</label>
                    <input type="text" class="form-control" placeholder="{{ __('Patient Name') }}" name="name"
                        id="name"
                        @if (isset($patient)) value="{{ $patient->name }}" @elseif(old('name')) value="{{ old('name') }}" @endif
                        required>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group" id="basic-addon1">
                    <label for="status">{{ __('Select nationality') }}</label>
                    <select class="form-control" name="country_id" id="country_id">
                        <option value="" disabled selected>{{ __('Select nationality') }}</option>
                        @if (isset($patient) && isset($patient['country']))
                            <option value="{{ $patient['country_id'] }}" selected>
                                {{ $patient['country']['nationality'] }}</option>
                        @endif
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group" id="basic-addon1">
                    <label for="username">{{ __('National ID') }}</label>
                    <input type="text" class="form-control" placeholder="{{ __('National ID') }}"
                        name="national_id" id="national_id"
                        @if (isset($patient)) value="{{ $patient->national_id }}" @elseif(old('national_id')) value="{{ old('national_id') }}" @endif>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group" id="basic-addon1">
                    <label for="username">{{ __('Passport no') }}</label>
                    <input type="text" class="form-control" placeholder="{{ __('Passport no') }}"
                        name="passport_no" id="passport_no"
                        @if (isset($patient)) value="{{ $patient->passport_no }}" @elseif(old('passport_no')) value="{{ old('passport_no') }}" @endif>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group" id="basic-addon1">
                    <label for="username">{{ __('Email Address') }}</label>
                    <input type="email" class="form-control" placeholder="{{ __('Email Address') }}"
                        name="email" id="email"
                        @if (isset($patient)) value="{{ $patient->email }}" @elseif(old('email')) value="{{ old('email') }}" @endif>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group" id="basic-addon1">
                    <label for="username">{{ __('Phone number') }}</label>
                    <input type="text" class="form-control" placeholder="{{ __('Phone number') }}"
                        name="phone" id="phone"
                        @if (isset($patient)) value="{{ $patient->phone }}" @elseif(old('phone')) value="{{ old('phone') }}" @endif>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group" id="basic-addon1">
                    <label for="username">{{ __('Phone number') }} 2</label>
                    <input type="text" class="form-control" placeholder="{{ __('Phone number') }} 2"
                        name="phone2" id="phone2"
                        @if (isset($patient)) value="{{ $patient->phone2 }}" @elseif(old('phone2')) value="{{ old('phone2') }}" @endif>
                </div>
            </div>

            <div class="@if(isset($patient) && $patient['gender'] == 'male') col-md-4 @else col-md-2  @endif  gender">
                <div class="form-group" id="basic-addon1">
                    <label for="status">{{ __('Gender') }}</label>
                    <select class="form-control" name="gender" placeholder="{{ __('Gender') }}" id="gender"
                        required>
                        <option value="" disabled selected>{{ __('Select Gender') }}</option>
                        <option value="male"
                            @if (isset($patient) && $patient['gender'] == 'male') selected @elseif(old('gender') == 'male') selected @endif>
                            {{ __('Male') }}</option>
                        <option value="female"
                            @if (isset($patient) && $patient['gender'] == 'female') selected @elseif(old('gender') == 'female') selected @endif>
                            {{ __('Female') }}</option>
                        <option value="pregnant"
                            @if (isset($patient) && $patient['gender'] == 'pregnant') selected @elseif(old('gender') == 'pregnant') selected @endif>
                            {{ __('Pregnant') }}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2 @if(isset($patient) && $patient['gender'] == 'male') d-none  @endif date_pms">
                <div class="form-group" id="basic-addon1">
                    <label for="username">{{ __('date PMS') }}</label>
                    <input type="text" class="form-control datepicker" placeholder="{{ __('Date of birth') }}"
                        name="date_pms" id="date_pms" 
                        @if (isset($patient)) value="{{ $patient['date_pms'] }}" @elseif(old('date_pms')) value="{{ old('date_pms') }}" @endif>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group" id="basic-addon1">
                    <label for="fp-default">{{ __('Date of birth') }}</label>
                    <input type="text" class="form-control datepicker" placeholder="{{ __('Date of birth') }}"
                        name="dob" id="dob" required
                        @if (isset($patient)) value="{{ $patient['dob'] }}" @elseif(old('dob')) value="{{ old('dob') }}" @endif>
                </div>
            </div>

            <div class="col-lg-4">
                <label for="DOB">{{ __('Date of birth') }}</label>
                <div class="row">
                    <div class="col-lg-6 col-sm-6 col-xs-6 col-md-6 pr-0">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fas fa-baby"></i>
                                </span>
                            </div>
                            <input type="number" class="form-control" name="age" id="age"
                                placeholder="{{ __('Age') }}"
                                @if (!isset($patient) && old('age')) value="{{ old('age') }}" @endif required>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-xs-6 col-md-6 pl-0">
                        <div class="input-group mb-3">
                            <select class="form-control" name="age_unit" id="age_unit" required>
                                <option value="" disabled selected>{{ __('Select age unit') }}</option>
                                <option value="years" @if (!isset($patient) && old('age_unit') == 'years') selected @endif>
                                    {{ __('Years') }}</option>
                                <option value="months" @if (!isset($patient) && old('age_unit') == 'months') selected @endif>
                                    {{ __('Months') }}</option>
                                <option value="days" @if (!isset($patient) && old('age_unit') == 'days') selected @endif>
                                    {{ __('Days') }}</option>
                            </select>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-lg-4">
                <label for="Address">{{ __('Address') }}</label>
                <div class="form-group">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fas fa-map-marker-alt"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" placeholder="{{ __('Address') }}"
                                name="address" id="address"
                                @if (isset($patient)) value="{{ $patient->address }}" @elseif(old('address')) value="{{ old('address') }}" @endif>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <label for="Address">{{ __('Select contract') }}</label>
                <div class="form-group">
                    <select name="contract_id" id="contract_id" class="form-control">
                        <option value="" selected disabled>{{ __('Select contract') }}</option>
                        @if (isset($patient) && isset($patient['contract']))
                            <option value="{{ $patient['contract_id'] }}" selected>
                                {{ $patient['contract']['title'] }}</option>
                        @elseif(old('contract_id'))
                            @php
                                $contract = \App\Models\Contract::find(old('contract_id'));
                            @endphp
                            <option value="{{ old('contract_id') }}" selected>{{ $contract['title'] }}</option>
                        @endif
                    </select>

                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="username">{{ __('Hours Fasting') }} </label>
                    <input type="number" class="form-control" placeholder="{{ __('Hours Fasting') }}"
                        name="hours_fasting" id="hours_fasting"
                        @if (isset($patient)) value="{{ $patient->hours_fasting }}" @elseif(old('hours_fasting')) value="{{ old('hours_fasting') }}" @endif>
                </div>
            </div>
            {{-- <div class="col-lg-3"></div> --}}
            {{-- Start Questions --}}
            {{-- Fluid Patient --}}
            <div class="col-lg-1">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="form-check">
                            <input class="custom-control custom-radio check_ask" name="fluid_patient"
                                value="{{ isset($patient) && $patient->fluid_patient ? 1 : 0 }}" id="fluid_patient"
                                {{ isset($patient) && $patient->fluid_patient == 1 ? 'checked' : '' }}
                                type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                {{ __('Hemophilia') }}
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Diabetic --}}
            <div class="col-lg-1">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="form-check">
                            <input class="custom-control custom-radio check_ask" name="diabetic" id="diabetic"
                                value="{{ isset($patient) && $patient->diabetic ? 1 : 0 }}"
                                {{ isset($patient) && $patient->diabetic == 1 ? 'checked' : '' }} type="checkbox"
                                value="" id="flexCheckDefault1">
                            <label class="form-check-label" for="flexCheckDefault1">
                                {{ __('Diabetic') }}
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Liver Patient --}}
            <div class="col-lg-1">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="form-check">
                            <input class="custom-control custom-radio check_ask" name="liver_patient" id="liver_patient"
                                value="{{ isset($patient) && $patient->liver_patient ? 1 : 0 }}"
                                {{ isset($patient) && $patient->liver_patient == 1 ? 'checked' : '' }}
                                type="checkbox" id="flexCheckDefault2">
                            <label class="form-check-label" for="flexCheckDefault2">
                                {{ __('Liver Patient') }}
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pregnant --}}
            {{-- <div class="col-lg-1">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="form-check">
                            <input class="custom-control custom-radio check_ask" name="pregnant" id="pregnant"
                                value="{{ isset($patient) && $patient->pregnant ? 1 : 0 }}"
                                {{ isset($patient) && $patient->pregnant == 1 ? 'checked' : '' }} type="checkbox"
                                value="" id="flexCheckDefault3">
                            <label class="form-check-label" for="flexCheckDefault3">
                                {{ __('Pregnant') }}
                            </label>
                        </div>
                    </div>
                </div>
            </div> --}}
            {{-- gland --}}
            <div class="col-lg-1">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="form-check">
                            <input class="custom-control custom-radio check_ask" name="gland" id="gland"
                                value="{{ isset($patient) && $patient->gland ? 1 : 0 }}"
                                {{ isset($patient) && $patient->gland == 1 ? 'checked' : '' }} type="checkbox"
                                value="" id="flexCheckDefault3">
                            <label class="form-check-label" for="flexCheckDefault3">
                                {{ __('gland') }}
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            {{-- tumors --}}
            <div class="col-lg-1">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="form-check">
                            <input class="custom-control custom-radio check_ask" name="tumors" id="tumors"
                                value="{{ isset($patient) && $patient->tumors ? 1 : 0 }}"
                                {{ isset($patient) && $patient->tumors == 1 ? 'checked' : '' }} type="checkbox"
                                value="" id="flexCheckDefault3">
                            <label class="form-check-label" for="flexCheckDefault3">
                                {{ __('tumors') }}
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            {{-- antibiotic --}}
            <div class="col-lg-1">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="form-check">
                            <input class="custom-control custom-radio check_ask" name="antibiotic" id="antibiotic"
                                value="{{ isset($patient) && $patient->antibiotic ? 1 : 0 }}"
                                {{ isset($patient) && $patient->antibiotic == 1 ? 'checked' : '' }} type="checkbox"
                                value="" id="flexCheckDefault3">
                            <label class="form-check-label" for="flexCheckDefault3">
                                {{ __('antibiotic') }}
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            {{-- iron --}}
            <div class="col-lg-1">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="form-check">
                            <input class="custom-control custom-radio check_ask" name="iron" id="iron"
                                value="{{ isset($patient) && $patient->iron ? 1 : 0 }}"
                                {{ isset($patient) && $patient->iron == 1 ? 'checked' : '' }} type="checkbox"
                                value="" id="flexCheckDefault3">
                            <label class="form-check-label" for="flexCheckDefault3">
                                {{ __('iron') }}
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            {{-- cortisone --}}
            <div class="col-lg-1">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="form-check">
                            <input class="custom-control custom-radio check_ask" name="cortisone" id="cortisone"
                                value="{{ isset($patient) && $patient->cortisone ? 1 : 0 }}"
                                {{ isset($patient) && $patient->cortisone == 1 ? 'checked' : '' }} type="checkbox"
                                value="" id="flexCheckDefault3">
                            <label class="form-check-label" for="flexCheckDefault3">
                                {{ __('cortisone') }}
                            </label>
                        </div>
                    </div>
                </div>
            </div>


            {{-- Other --}}
            <div class="col-lg-4">
                <div class="form-group">
                    <div class="form-floating">
                        <textarea class="form-control" name="answer_other" placeholder="{{ __('Other') }}" id="floatingTextarea2"
                            style="height: 50px">{{ isset($patient) && $patient->answer_other ? $patient->answer_other : '' }}</textarea>
                    </div>
                </div>
            </div>
            {{-- End   Questions --}}
        </div>

    </div>

</div>
