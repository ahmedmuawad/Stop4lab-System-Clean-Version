<div class="modal fade" id="patient_modal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('Create Patient') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ route('ajax.create_patient') }}" method="POST" id="create_patient">
                @csrf
                <div class="text-danger" id="patient_modal_error"></div>
                <div class="modal-body" id="create_patient_inputs">
                    <div class="row">
                        <div class="col-lg-4">
                            {{-- <div class="form-group"> --}}

                            @php
                                use App\Models\Prefix;
                                $prefix = Prefix::all();
                                
                            @endphp
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </div>

                                    <select id="prefix" name="prefix" class="form-control" width="90%">
                                        <option label=""></option>
                                        @foreach ($prefix as $item)
                                            <option data-gender="{{ $item->gender }}" value="{{ $item->name }}">
                                                {{ __($item->name) }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            {{-- </div> --}}
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="fa fa-user"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="{{ __('Patient Name') }}"
                                        name="name" id="create_name" required>
                                    <span class="required"
                                        style="
                                        font-size: 21px;
  color: red;
  position: relative;
  left: 18px;
  top: 10px;">*</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">
                                                <i class="fas fa-mars"></i>
                                            </span>
                                        </div>
                                        <select class="form-control" name="gender" placeholder="{{ __('Gender') }}"
                                            id="create_gender" required>
                                            <option value="" disabled selected>{{ __('Select Gender') }}</option>
                                            <option value="male">{{ __('Male') }}</option>
                                            <option value="female">{{ __('Female') }}</option>
                                            <option value="pregnant">{{ __('Pregnant') }}</option>
                                        </select>
                                        <span class="required"
                                            style="
                                        font-size: 21px;
  color: red;
  position: relative;
  left: 18px;
  top: 10px;">*</span>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">
                                                <i class="fas fa-baby"></i>
                                            </span>
                                        </div>
                                        <input type="date" class="form-control "
                                            placeholder="{{ __('Date of birth') }}" name="dob" id="create_dob"
                                            required>
                                        <span class="required"
                                            style="
                                        font-size: 21px;
  color: red;
  position: relative;
  left: 18px;
  top: 10px;">*</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="row">
                                <div class="col-lg-6 col-sm-6 col-xs-6 col-md-6 pr-0">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">
                                                <i class="fas fa-baby"></i>
                                            </span>
                                        </div>
                                        <input type="number" class="form-control" name="age" id="create_age"
                                            placeholder="{{ __('Age') }}" required>
                                        <span class="required"
                                            style="
                                                    font-size: 21px;
                                                    color: red;
                                                    position: relative;
                                                    left: 18px;
                                                    top: 10px;">*</span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-xs-6 col-md-6 pl-0">
                                    <div class="input-group mb-3">
                                        <select class="form-control" name="age_unit" id="create_age_unit" required>
                                            <option value="" disabled selected>{{ __('Select age unit') }}
                                            </option>
                                            <option value="years">{{ __('Years') }}</option>
                                            <option value="months">{{ __('Months') }}</option>
                                            <option value="days">{{ __('Days') }}</option>
                                        </select>
                                        <span class="required"
                                            style="
                                            font-size: 21px;
                                            color: red;
                                            position: relative;
                                            left: 18px;
                                            top: 10px;">*
                                        </span>

                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-4">
                            <div class="row">
                                <div class="col-lg-6 col-sm-6 col-xs-6 col-md-6 pr-0">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">
                                                <i class="fas fa-baby"></i>
                                            </span>
                                        </div>
                                        <input type="number" class="form-control" name="age" id="create_age2"
                                            placeholder="{{ __('Age') }}" required>
                                        <span class="required"
                                            style="
                                                    font-size: 21px;
                                                    color: red;
                                                    position: relative;
                                                    left: 18px;
                                                    top: 10px;">*</span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-xs-6 col-md-6 pl-0">
                                    <div class="input-group mb-3">
                                        <select class="form-control" name="age_unit" id="create_age_unit2" required>
                                            <option value="" disabled selected>{{ __('Select age unit') }}
                                            </option>

                                        </select>
                                        <span class="required"
                                            style="
                                            font-size: 21px;
                                            color: red;
                                            position: relative;
                                            left: 18px;
                                            top: 10px;">*
                                        </span>

                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="fab fa-whatsapp" aria-hidden="true" class="text-success"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control"
                                        placeholder="{{ __('Phone number') }}" name="phone" id="create_phone">
                                    <span class="required"
                                        style="
                                        font-size: 21px;
  color: red;
  position: relative;
  left: 18px;
  top: 10px;">*</span>
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
                                    <input type="text" class="form-control"
                                        placeholder="{{ __('Phone number') }} 2" name="phone2" id="create_phone2">
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                    </div>
                                    <input type="email" class="form-control"
                                        placeholder="{{ __('Email Address') }}" name="email" id="create_email">
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-4">
                            <div class="form-group">
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">
                                                <i class="fas fa-map-marker-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="{{ __('Address') }}"
                                            name="address" id="create_address">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="fa fa-user"></i>
                                        </span>
                                    </div>
                                    <input type="number" class="form-control"
                                        placeholder="{{ __('Hours of Fasting') }}" name="hours_fasting"
                                        id="edit_hours_fasting">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="fas fa-file-contract"></i>
                                        </span>
                                    </div>
                                    <select name="contract_id" id="patient_contract_id"
                                        data-url="{{ route('admin.update_patient_contract_id') }}"
                                        class="form-control">
                                        <option value="" selected disabled>{{ __('Select contract') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-4">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="create_avatar">
                                        <input type="hidden" id="create_patient_avatar_hidden" name="avatar">
                                        <label class="custom-file-label">{{ __('Choose avatar') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>






                        <div class="col-lg-4">
                            {{-- <div class="form-group"> --}}
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="fas fa-globe"></i>
                                        </span>
                                    </div>
                                    <select class="form-control" name="country_id" id="create_country_id"
                                        @if (setting('portal') != null) required @endif>
                                        <option value="" disabled selected>{{ __('Select nationality') }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            {{-- </div> --}}
                        </div>
                        @if (setting('portal') != null)
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="gov">
                                                <i class="fas fa-globe"></i>
                                            </span>
                                        </div>
                                        <input required type="text" name="gov" class="form-control"
                                            placeholder="{{ __('Select Gov') }}">
                                        @if (setting('portal') != null)
                                            <span class="required"
                                                style="
                                        font-size: 21px;
                                        color: red;
                                        position: relative;
                                        left: 18px;
                                        top: 10px;">*</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="city">
                                                <i class="fas fa-globe"></i>
                                            </span>
                                        </div>
                                        <input @if (setting('portal') != null) required @endif type="text"
                                            name="city" class="form-control"
                                            placeholder="{{ __('Select city') }}">
                                        @if (setting('portal') != null)
                                            <span class="required"
                                                style="
                                        font-size: 21px;
                                        color: red;
                                        position: relative;
                                        left: 18px;
                                        top: 10px;">*</span>
                                        @endif
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-4">
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="street">
                                                <i class="fas fa-globe"></i>
                                            </span>
                                        </div>
                                        <input @if (setting('portal') != null) required @endif type="text"
                                            name="street" class="form-control"
                                            placeholder="{{ __('Select street') }}">
                                        @if (setting('portal') != null)
                                            <span class="required"
                                                style="
                                        font-size: 21px;
                                        color: red;
                                        position: relative;
                                        left: 18px;
                                        top: 10px;">*</span>
                                        @endif
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-4">
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="building">
                                                <i class="fas fa-globe"></i>
                                            </span>
                                        </div>
                                        <input @if (setting('portal') != null) required @endif type="text"
                                            name="building" class="form-control"
                                            placeholder="{{ __('Select building') }}">
                                        @if (setting('portal') != null)
                                            <span class="required"
                                                style="
                                        font-size: 21px;
                                        color: red;
                                        position: relative;
                                        left: 18px;
                                        top: 10px;">*</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">
                                                <i class="fa fa-id-card"></i>
                                            </span>
                                        </div>
                                        <input @if (setting('portal') != null) required @endif type="text"
                                            class="form-control" placeholder="{{ __('National ID') }}"
                                            name="national_id" id="create_national_id">
                                        @if (setting('portal') != null)
                                            <span class="required"
                                                style="
                                        font-size: 21px;
                                        color: red;
                                        position: relative;
                                        left: 18px;
                                        top: 10px;">*</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="col-lg-4">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="fa fa-passport"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="{{ __('Passport no') }}"
                                        name="passport_no" id="create_passport_no">
                                </div>
                            </div>
                        </div>





                        <div class="col-lg-4  d-none create_date_pms">
                            <div class="form-group">
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">
                                                <i class="fas fa-mars"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control datepicker"
                                            placeholder="{{ __('Date of PMS') }}" name="date_pms"
                                            id="create_date_pms">
                                    </div>
                                </div>
                            </div>

                        </div>








                        {{-- Start Questions --}}
                        {{-- Fluid Patient --}}
                        <div class="col-lg-2">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" name="fluid_patient" id="fluid_patient"
                                            type="checkbox" id="flexCheckDefault">
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
                                            type="checkbox" id="flexCheckDefault1">
                                        <label class="form-check-label" for="flexCheckDefault1">
                                            {{ __('Diabetic') }}
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
                                            type="checkbox" id="flexCheckDefault2">
                                        <label class="form-check-label" for="flexCheckDefault2">
                                            {{ __('Liver Patient') }}
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
                                        <input class="form-check-input check_ask" name="gland" type="checkbox"
                                            value="" id="flexCheckDefault3">
                                        <label class="form-check-label" for="flexCheckDefault3">
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
                                        <input class="form-check-input check_ask" name="tumors" type="checkbox"
                                            value="" id="flexCheckDefault4">
                                        <label class="form-check-label" for="flexCheckDefault4">
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
                                        <input class="form-check-input check_ask" name="antibiotic" type="checkbox"
                                            value="" id="flexCheckDefault5">
                                        <label class="form-check-label" for="flexCheckDefault5">
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
                                        <input class="form-check-input check_ask" name="iron" type="checkbox"
                                            value="" id="flexCheckDefault6">
                                        <label class="form-check-label" for="flexCheckDefault6">
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
                                        <input class="form-check-input check_ask" name="cortisone" type="checkbox"
                                            value="" id="flexCheckDefault7">
                                        <label class="form-check-label" for="flexCheckDefault7">
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
                                        <input class="form-check-input check_ask" name="pressure" type="checkbox"
                                            value="" id="pressure">
                                        <label class="form-check-label" for="pressure">
                                            {{ __('pressure') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Pregnant --}}
                        {{-- <div class="col-lg-2">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input"  name="pregnant" id="pregnant" type="checkbox"
                                             id="flexCheckDefault3">
                                        <label class="form-check-label" for="flexCheckDefault3">
                                            {{ __('Pregnant') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        {{-- Other --}}
                        <div class="col-lg-4">
                            <div class="form-group">
                                <div class="form-floating">
                                    <textarea class="form-control" name="answer_other" placeholder="{{ __('Other') }}" id="floatingTextarea"
                                        style="height: 50px"></textarea>
                                </div>
                            </div>
                        </div>
                        {{-- End   Questions --}}
                    </div>

                    {{-- <div class="col-lg-2">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" name="old_visit" id="create_old_visit" type="checkbox"
                                            >
                                    <label class="form-check-label" for="create_old_visit">
                                        {{ __('Old Visit') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" name="frenid" id="create_frenid" type="checkbox"
                                            >
                                    <label class="form-check-label" for="create_frenid">
                                        {{ __('Frenid') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" name="face" id="create_face" type="checkbox"
                                    >
                                    <label class="form-check-label" for="create_face">
                                        {{ __('Face Book') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="form-check">
                                    <input class="form-check-input check_ask" name="doctor_from" type="checkbox" value="1" id="create_doctor_from">
                                    <label class="form-check-label" for="create_doctor_from">
                                    {{__('Doctor')}}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <div class="form-floating">
                                <textarea class="form-control" name="knowed_other" placeholder="{{ __('Other') }}" id="create_knowed_other"
                                    style="height: 50px"></textarea>
                            </div>
                        </div>
                    </div> --}}
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
</div>
