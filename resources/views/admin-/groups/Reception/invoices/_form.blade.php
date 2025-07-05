<!-- Patient Info -->
<div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1">
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column align-items-center text-center">

                        <a href="@if (isset($group) && !empty($group['patient']['avatar'])) {{ url('uploads/patient-avatar/' . $group['patient']['avatar']) }}@else{{ url('img/avatar.png') }} @endif"
                            data-toggle="lightbox" data-title="Avatar">
                            <img src="@if (isset($group) && !empty($group['patient']['avatar'])) {{ url('uploads/patient-avatar/' . $group['patient']['avatar']) }}@else{{ url('img/avatar.png') }} @endif"
                                class="rounded-circle p-1 bg-primary" width="110" id="patient_avatar" alt="">
                        </a>

                        <div class="mt-3">
                            <button class="btn btn-primary">{{ __('Upload Image') }}</button>
                        </div>
                    </div>
                    <hr class="my-4" />
                    <h4>{{ __('How did you hear about us?') }}</h4><br>
                    <select class="form-control select2" name="knowed_by" id="">
                        @foreach ($knows as $know)
                            <option></option>
                            <option @if (isset($group) && $group['knowed_by'] == $know->id) selected @endif value="{{ $know->id }}">
                                {{ $know->name }}</option>
                        @endforeach
                    </select>


                    <hr class="my-4" />
                    <div class="modal-header col-lg-12 mb-3">
                        <h5 class="modal-title">{{ __('Diseases suffered by the patient') }}</h5>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
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
                        <div class="col-lg-6">
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
                        <div class="col-lg-6">
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
                        <div class="col-lg-6">
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
                        <div class="col-lg-6">
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
                        <div class="col-lg-6">
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
                        <div class="col-lg-6">
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
                        <div class="col-lg-6">
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
                        <div class="col-lg-6">
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
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="{{ __('Other') }}"
                                    @if (isset($group) && isset($group['patient']['answer_other'])) value="{{ $group['patient']['answer_other'] }}" @endif id="answer_other"
                                    style="height: 50px">{{ isset($group['patient']) && $group['patient']['answer_other'] ? $group['patient']['answer_other'] : '' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <h6>Referral Doctor</h6>
                </div>
                <div class="row" style="padding: 10px;">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>{{ __('Type Doctor') }}</label>
                            <select class="form-control" name="doctor_type" id="type_doctor">
                                <option selected disabled label=""></option>
                                <option @if (isset($group) && isset($group['doctor'])) selected @endif value="0">
                                    {{ __('Doctor with commission') }}</option>
                                <option @if (isset($group) && isset($group['normalDoctor'])) selected @endif value="1">
                                    {{ __('Normal Doctor') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12 @if (isset($group) && isset($group['doctor'])) d-block @else d-none @endif doctor">
                        <div class="form-group">
                            <label>{{ __('Doctor') }}</label>
                            @can('create_doctor')
                                <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal"
                                    data-target="#doctor_modal"><i class="fa fa-exclamation-triangle"></i>
                                    {{ __('New Doctor ?') }}</button>
                            @endcan
                            <select class="form-control" name="doctor_id" id="doctor">
                                @if (isset($group) && isset($group['doctor']))
                                    <option value="{{ $group['doctor']['id'] }}" selected>
                                        {{ $group['doctor']['name'] }}</option>
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <br>

            </div>

        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="inputCode" class="form-label">{{ __('Code') }}</label>
                                    <select id="code" class="form-control" aria-hidden="true">
                                        <option value="" disabled>Patient Code</option>

                                    </select>
                                </div>

                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="prefix" class="form-label">Prefix</label>
                                    <select class="form-control prefix select2">

                                    </select>
                                    {{-- <input 
                                        @if (isset($group) && isset($group['patient'])) value=" {{ __($group['patient']['prefix']) ?? '' }} " @endif
                                        > --}}
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group" id="nameParent">
                                    <label for="inputLastName" class="form-label" style="color:red;">Patient Name
                                        *</label>
                                    <select id="name" class="single-select select2-hidden-accessible"
                                        aria-hidden="true">
                                        @if (isset($group) && isset($group['patient']))
                                            <option value="{{ $group['patient']['id'] }}" selected>
                                                {{ $group['patient']['code'] }}</option>
                                        @endif
                                    </select>

                                </div>
                                <div class="form-group" id="nameCreateParent">
                                    <label for="inputLastName" class="form-label" style="color:red;">Patient Name
                                        *</label>
                                    <input name="createName" type="text" class="form-control" id="createName"
                                        placeholder="Patient Name" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">

                                    <label for="inputFirstName" class="form-label"style="color:red;">Gender *</label>

                                    <input class="form-control" id="gender"
                                        @if (isset($group) && isset($group['patient'])) value="{{ $group['patient']['gender'] }}" @endif>
                                </div>
                            </div>
                            {{--  Appear only if pregnant or women only  --}}
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="form-label">Date of PMS </label>
                                    <input id="date_pms" type="text" class="form-control datepicker"
                                        placeholder="if female only" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">

                                    <label class="form-label" style="color:red;">Date of birth *</label>
                                    <input style="background-color: #fff !important" id="dob" type="text"
                                        class="form-control datepicker" />
                                </div>
                            </div>
                            {{-- <div class="col-sm-3">
                                <div class="form-group">

                                    <input type="number" class="form-control" id="inputLastName"
                                        placeholder="Days">
                                </div>
                            </div> --}}
                            {{-- <div class="col-sm-3">
                                <input type="number" class="form-control" id="inputLastName" placeholder="Weeks">

                            </div> --}}
                            {{-- <div class="col-sm-3">
                                <input type="number" class="form-control" id="inputLastName" placeholder="Months">

                            </div> --}}
                            {{-- <div class="col-sm-3">
                                <input type="number" class="form-control" id="inputLastName" placeholder="Years">

                            </div> --}}
                            <div class="col-4">
                                <label for="phone" class="form-label" style="color:red;">Whats App Number
                                    *</label>
                                <input style="direction: ltr" id="phone" type="phone" class="form-control"
                                    @if (isset($group) && isset($group['patient'])) value="{{ $group['patient']['phone'] }}" @endif>
                            </div>
                            <div class="col-4">
                                <label for="phone2" class="form-label">Phone Number</label>
                                <input id="phone2" type="phone" class="form-control"
                                    @if (isset($group) && isset($group['patient'])) value="{{ $group['patient']['phone2'] }}" @endif>
                            </div>
                            <div class="col-4">
                                <label for="inputEmailAddress" class="form-label">Email Address</label>
                                <input id="email" type="email" class="form-control"
                                    placeholder="example@user.com"
                                    @if (isset($group) && isset($group['patient'])) value="{{ $group['patient']['email'] }}" @endif>
                            </div>
                            <div class="col-4">
                                <label for="inputAddress" class="form-label">Address</label>
                                <input id="address" type="Address" class="form-control"
                                    placeholder="Enter Patient Address"
                                    @if (isset($group) && isset($group['patient'])) value="{{ $group['patient']['address'] }}" @endif>
                            </div>
                            <div class="col-4">
                                <label for="natiponalID" class="form-label">Natiponal ID</label>
                                <input type="natiponalID" class="form-control" placeholder="Enter Natiponal ID"
                                    id="national_id"
                                    @if (isset($group) && isset($group['patient'])) value="{{ $group['patient']['national_id'] }}" @endif>
                            </div>
                            <div class="col-4">
                                <label for="Nationality" class="form-label">Nationality</label>
                                <input class="form-control" id="nationality"
                                    @if (isset($group) && isset($group['patient'])) value=" {{ $group['patient']['country']['nationality'] ?? '' }} " @endif>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="d-block">{{ __('Contract') }}</label>

                                    <input type="hidden" name="contract_id" id="contract_id"
                                        @if (isset($group) && isset($group['contract']) && !$group->contract->trashed()) value="{{ $group['contract']['id'] }}" @endif
                                        readonly>
                                    <div class="row">
                                        <select name="" id="contract_title" disabled
                                            data-url="{{ route('admin.update_patient_contract_id') }}"
                                            class="form-control"
                                            style="
                                    width: 50%;">
                                            <option label=""></option>
                                            @foreach ($contracts as $contract)
                                                <option value="{{ $contract->id }}"
                                                    @if (isset($group) && $group['contract_id'] == $contract->id) selected @endif>
                                                    {{ $contract->title }}
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
                                class="col-lg-4 sub_contracts d-none @if (isset($group) and $group->contract != null) @if (count($group->contract->sub_contracts)) d-block @endif @endif">
                                <div class="form-group">
                                    <label for="sub_contract_id">{{ __('Sub Contract') }}</label>
                                    <select id="sub_contract_id" name="sub_contract_id" class="form-control">
                                        @if (isset($group) && isset($group['sub_contract_id']))
                                            @foreach ($sub_contracts as $item)
                                                <option discount="{{ $item['discount_percentage'] }}"
                                                    value="{{ $item['id'] }}"
                                                    @if ($group->sub_contract_id == $item['id']) selected @endif>
                                                    {{ $item->title }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            {{--  Appear only if lab to lab selected in contracts  --}}
                            <div
                                class="col-lg-4 lab-to-lab d-none @if (isset($group) and $group->contract != null) @if ($group->contract->type == 'lab_to_lab') d-block @endif @endif">
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
                                class="col-lg-4 lab-to-lab d-none @if (isset($group) and $group->contract != null) @if ($group->contract->type == 'lab_to_lab') d-block @endif @endif">
                                <div class="form-group">
                                    <label for="region_id">{{ __('Region') }}</label>
                                    <select name="region_id" id="region_id" class="form-control" required>
                                        <option></option>
                                        @if (isset($group) && $group['region_id'])
                                            <option value="{{ $group['region_id'] }}" selected>
                                                {{ $group->region->name }}
                                            </option>
                                        @endif
                                    </select>

                                </div>
                            </div>

                            <div
                                class="col-lg-4 lab-to-lab d-none @if (isset($group) and $group->contract != null) @if ($group->contract->type == 'lab_to_lab') d-block @endif @endif">
                                <div class="form-group">
                                    <label for="user_id">{{ __('Lab') }}</label>
                                    <select name="user_id" id="user_id" class="form-control select2" required>
                                        @if (isset($group) && $group['user_id'])
                                            @if (isset($group->user))
                                                <option value="{{ $group['user_id'] }}" selected>
                                                    {{ $group->user->lab_code }}
                                                    - {{ $group->user->name }}</option>
                                            @endif
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div
                                class="col-lg-4 lab-to-lab d-none @if (isset($group) and $group->contract != null) @if ($group->contract->type == 'lab_to_lab') d-block @endif @endif">
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


                            {{-- End Appear only if lab to lab selected in contracts  --}}
                        </div>
                        <div class="text-center">
                            <input type="button" class="btn btn-success" value="{{ __('Click To Save Patient') }}"
                                id="saveNewPatient">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h6>Attach files</h6>
                    <form>
                        <input type="file" class="form-control">
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<div id="step-2" class="tab-pane" style="height: auto;max-height: auto" role="tabpanel"
    aria-labelledby="step-2">
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="{{ url('assets/images/avatars/avatar-1.png') }}" alt="Admin"
                            class="rounded-circle p-1 bg-primary" width="110">
                        <br>
                        <h6 class="patientName">

                        </h6>
                        <h6 class="patientAgePlusGender" style="direction:ltr">

                        </h6>
                        <h6 class="contractName">

                        </h6>
                        <hr class="my-4" />
                        <div class="col-12" style="text-align:center;">
                            <h6>Receipt Calculator</h6>

                            <table class="table table-sm mb-0">
                                <tbody>
                                    <tr>
                                        <td>
                                            <b>Total</b>
                                        </td>
                                        <td id="tdTotal">

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>Contract</b>
                                        </td>
                                        <td>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>To Pay</b>
                                        </td>
                                        <td>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h6>Booking Details</h6>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="InsideLabOptions" id="InsideLab"
                            value="option1">
                        <label class="form-check-label" for="InsideLab">Inside
                            Lab</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="HomeVisitOptions" id="HomeVisit"
                            value="option2">
                        <label class="form-check-label" for="HomeVisit">Home
                            Visit</label>
                    </div>

                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h6>Date</h6>
                    <form class="row g-6">
                        <div class="col-sm-6">
                            <label class="form-label">Registeration Date *</label>
                            <input type="datetime-local" class="form-control">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Booking Date *</label>
                            <input type="datetime-local" class="form-control">
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <div class="col-8">
            <h6>Select Tests</h6>
            <select id="select_test" class="single-select select2-hidden-accessible" aria-hidden="true">

            </select>

            <div class="card-body">
                <table class="table table-bordered table-striped table-sm" style="padding: 5px;">
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
                    <tbody id="selected_tests">
                        @if (isset($group))
                            @foreach ($group['tests_with_canceled'] as $test)
                                <tr @if ($test['is_canceled']) class="selected_test color-red" @else class="selected_test" @endif
                                    id="test_{{ $test['test_id'] }}" default_price="{{ $test['test']['price'] }}">
                                    <td style="width:20%;">
                                        {{ $test['test']['name'] }}
                                        <input type="hidden" class="tests_id"
                                            name="tests[{{ $test['test_id'] }}][id]" value="{{ $test['test_id'] }}">
                                    </td>
                                    <td style="width:10%;" class="test_price">
                                        {{ $test['price'] }}
                                    </td>
                                    <td style="width:10%;">
                                        <input type="text" name="tests[{{ $test['test_id'] }}][lab_status]"
                                            @if ($test['test']['lab_to_lab_status'] == 1) value="Out" @else value="In" @endif />
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
                                    <td style="width:10%;" class="test_price">
                                        {{ $test['price'] }}
                                    </td>
                                    <td style="width:10%;">
                                        {{ $test['lab_to_lab_status'] }}
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
                                    <input type="hidden" class="price" name="tests[{{ $test['test_id'] }}][price]"
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
                                        <input type="text" name="tests[{{ $test['test']['id'] }}][lab_status]"
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

            <hr class="my-4" />

            <h6>Select Culture</h6>
            <select id="select_culture" class="single-select select2-hidden-accessible" aria-hidden="true">

            </select>

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
                                        <button type="button" class="btn btn-danger btn-sm delete_selected_row">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm cancel_selected_row">
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
                                        <button type="button" class="btn btn-danger btn-sm delete_selected_row">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm cancel_selected_row">
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

            <hr class="my-4" />

            <h6>Select Package</h6>
            <select id="select_package" class="single-select select2-hidden-accessible" aria-hidden="true">


            </select>

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
                                        <button type="button" class="btn btn-danger btn-sm delete_selected_row">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm cancel_selected_row">
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
                                        <button type="button" class="btn btn-danger btn-sm delete_selected_row">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm cancel_selected_row">
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

            <hr class="my-4" />
            <div class="col-12">
                <h6>Offers</h6>
                <select id="select_offer" class="single-select select2-hidden-accessible" aria-hidden="true">

                </select>

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
                                    <tr id="offer_{{ $offer['id'] }}" default_price="{{ $offer['cost_after'] }}">
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
                                            <button type="button" class="btn btn-danger btn-sm cancel_selected_row">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm delete_selected_row">
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
    </div>
</div>
<div id="step-3" class="tab-pane" style="height: auto" role="tabpanel" aria-labelledby="step-4">
    <h3>Services Info</h3>
    <h4>Tests</h4>
    <table class="table table-sm mb-0">
        <thead>
            <tr>
                <th scope="col" width="10%">{{ __('Name') }}</th>
                <th scope="col" width="30%">Info</th>
                <th scope="col" width="30%">Precautions</th>
                <th scope="col" width="20%">Questions</th>
                <th scope="col" width="10%">Answer</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><b>Urine Analasyis</b></td>
                <td>
                    <p>
                        Lorem Ipsum is simply dummy text of the printing and typesetting
                        industry. Lorem Ipsum has been the industrys standard dummy text
                        ever since the 1500s, when an unknown printer took a galley of
                        type and scrambled it to make a type specimen book
                    </p>
                </td>
                <td>
                    <p>
                        Lorem Ipsum is simply dummy text of the printing and typesetting
                        industry
                    </p>
                </td>
                <td>
                    <b>
                        Where does it come from?
                    </b>
                </td>
                <td>
                    <select class="single-select select2-hidden-accessible" aria-hidden="true">
                        <option value="">Yes </option>
                        <option value="">No</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><b>Complete Blood Picture</b></td>
                <td>
                    <p>
                        Lorem Ipsum is simply dummy text of the printing and typesetting
                        industry. Lorem Ipsum has been the industrys standard dummy text
                        ever since the 1500s, when an unknown printer took a galley of
                        type and scrambled it to make a type specimen book
                    </p>
                </td>
                <td>
                    <p>
                        Lorem Ipsum is simply dummy text of the printing and typesetting
                        industry
                    </p>
                </td>
                <td>
                    <b>
                        Where does it come from?
                    </b>
                </td>
                <td>
                    <select class="single-select select2-hidden-accessible" aria-hidden="true">
                        <option value="">Yes </option>
                        <option value="">No</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><b>Urine Examination</b></td>
                <td>
                    <p>
                        Lorem Ipsum is simply dummy text of the printing and typesetting
                        industry. Lorem Ipsum has been the industrys standard dummy text
                        ever since the 1500s, when an unknown printer took a galley of
                        type and scrambled it to make a type specimen book
                    </p>
                </td>
                <td>
                    <p>
                        Lorem Ipsum is simply dummy text of the printing and typesetting
                        industry
                    </p>
                </td>
                <td>
                    <b>
                        Where does it come from?
                    </b>
                </td>
                <td>
                    <select class="single-select select2-hidden-accessible" aria-hidden="true">
                        <option value="">Yes </option>
                        <option value="">No</option>
                    </select>
                </td>
            </tr>

        </tbody>

    </table>
    <tfoot>
        <div class="col">
            <button type="button" class="btn btn-outline-info px-5"><i
                    class='bx bx-cloud-download mr-1'></i>Print</button>
        </div>
    </tfoot>
</div>
<div id="step-4" class="tab-pane" role="tabpanel" aria-labelledby="step-3">
    <div class="invoice overflow-auto">
        <div style="min-width: 600px">
            <header>
                <div class="row">
                    <div class="col">
                        <a href="javascript:;">
                            <img src="assets/images/logo-icon.png" width="80" alt="" />
                        </a>
                    </div>
                    <div class="col company-details">
                        <h2 class="name">
                            <a target="_blank" href="javascript:;">
                                {{ setting('info')['name'] }}
                            </a>
                        </h2>
                        <div>

                            {{ setting('info')['address'] }}
                        </div>
                        <div>

                            {{ setting('info')['phone'] }}

                        </div>
                    </div>
                </div>
            </header>
            <main>
                <div class="row contacts">
                    <div class="col invoice-to">
                        <div class="text-gray-light">INVOICE TO:</div>
                        <h2 class="patientName">

                        </h2>
                        <div class="patintPhone"></div>
                        {{-- <div class="Phone">Male - 32 Years</div> --}}
                        <div class="patientAgePlusGender" style="direction:ltr">

                        </div>
                    </div>
                </div>
                <div class="col invoice-details">
                    <h1 class="invoice-id">INVOICE 3-2-1</h1>
                    <div class="date">Date of Invoice: 28/12/2022</div>
                    <div class="date">Report Date: 30/12/2022</div>
                </div>
        </div>
        <table class="table table-sm mb-0" style="width:100%;">
            <thead>
                <tr>

                    <th class="unit" width="30%">DESCRIPTION</th>
                    <th class="unit" width="20%">Action</th>
                    <th class="unit" width="20%">Report Date</th>
                    <th class="unit" width="20%">TOTAL</th>
                </tr>
            </thead>
            <tbody id="TestsCulture">
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="1"></td>
                    <td colspan="2">SUBTOTAL</td>

                    <td>
                        <input type="number" readonly class="form-control subtotal" value="">
                    </td>
                </tr>
                <tr>
                    <td colspan="1"></td>
                    <td colspan="2">TAX {{ setting('account')['tax_persentage'] }}%</td>

                    <td>
                        <input readonly type="number" class="form-control taxAmount" value="">
                    </td>
                </tr>
                <tr>
                    <td colspan="1"></td>
                    <td colspan="2">Sub Total</td>

                    <td class="">
                        <input type="number" readonly class="form-control subtotalWithTax" value="">
                    </td>
                </tr>
                <input type="hidden" id="tax" value="{{ setting('account')['tax_persentage'] }}">
                @if (Auth::guard('admin')->user()->hasRole('add_discount'))
                    <tr>
                        <td>{{ __('Discount') }}</td>
                        <td>
                            <input type="number" class="form-control" id="discount" name="discount"
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
                            <input type="number" name="discount_value" class="form-control" id="total_discount"
                                readonly
                                @if (isset($group)) value="{{ $group['discount_value'] }}" @else value="0" @endif>
                        </td>
                    </tr>
                @endif


                {{-- <div class="input-group mb-4"> <span class="input-group-text">%</span>
                            <input type="text" class="form-control"
                                aria-label="Dollar amount (with dot and two decimal places)" Value="10">
                        </div>
                    </td>
                    <td>
                        <div class="input-group mb-4"> <span class="input-group-text">L.E</span>
                            <input type="text" class="form-control"
                                aria-label="Dollar amount (with dot and two decimal places)" Value="25">
                        </div> --}}

                <tr>
                    <td colspan="1"></td>
                    <td colspan="2">Delayed Money <br>( Contract Name)</td>
                    <td></td>
                    <td>
                        <div class="input-group mb-4"> <span class="input-group-text">L.E</span>
                            <input type="text" class="form-control"
                                aria-label="Dollar amount (with dot and two decimal places)" Value="200 L.E">
                    </td>

                </tr>
                <tr>
                    <td colspan="1"></td>
                    <td colspan="2">Total to Pay</td>
                    <td></td>
                    <td>350.00 l.E</td>
                </tr>
            </tfoot>
        </table>
        <div class="thanks" style="text-align: center">Thank you!</div>

        <footer>Invoice was created on a Stop 4 Labs System By Lab Name.</footer>
    </div>
    <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
    <div></div>

</div>
<div id="step-5" class="tab-pane" role="tabpanel" aria-labelledby="step-4">
    <h3>Payment</h3>
    <table class="table table-sm mb-0">
        <thead>
            <tr>
                <th scope="col">Payment Date</th>
                <th scope="col">Value</th>
                <th scope="col">Payment Method</th>
                <th scope="col">Process No.</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <input type="datetime-local" class="form-control">
                </td>
                <td>
                    <input type="number" class="form-control" id="value" required>
                </td>
                <td>
                    <select class="single-select select2-hidden-accessible" aria-hidden="true">
                        <option value="">Visa </option>
                        <option value="">Cash</option>
                    </select>
                </td>
                <td>
                    <input type="number" class="form-control" id="processID" required>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="datetime-local" class="form-control">
                </td>
                <td>
                    <input type="number" class="form-control" id="value" required>
                </td>
                <td>
                    <select class="single-select select2-hidden-accessible" aria-hidden="true">
                        <option value="">Cash</option>
                        <option value="">Visa </option>
                    </select>
                </td>
                <td>
                    <input type="number" class="form-control" id="processID" required>
                </td>

            </tr>
        </tbody>
    </table>
    <table class="table table-sm mb-0">
        <thead>
            <tr>
                <th scope="col">Due</th>
                <th scope="col">Value</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <b>Due Value</b>
                </td>
                <td>
                    <input type="number" class="form-control" id="value" required>
            </tr>
        </tbody>
    </table>
    <div class="col">
        <button type="button" class="btn btn-outline-info px-5"><i class='bx bx-cloud-download mr-1'></i>Print
            Invoice</button>

        <button type="button" class="btn btn-outline-info px-5"><i class='bx bx-cloud-download mr-1'></i>Print
            Reciept</button>

        <button type="button" class="btn btn-outline-info px-5"><i class='bx bx-comment-detail mr-1'></i>Send
            Reciept WA</button>
    </div>
</div>
<div id="step-6" class="tab-pane" role="tabpanel" aria-labelledby="step-4">

    <h6 class="mb-0 text-uppercase">Sample Collection</h6>
    <hr />
    <form action="">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-3">

            <div class="card">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0"></p>
                    </div>
                    <div class="dropdown ms-auto">
                        <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown">
                            <i class='bx bx-dots-horizontal-rounded font-22'></i>
                        </div>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="javascript:;">Action</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="{{ url('imgs/sample_tube.png') }}" alt="..." class="card-img">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h6 class="card-title">EDTA</h6>
                            <p class="card-text">Test : CBC , Hemaology</p>
                            <p class="card-text">Department : Hemaology</p>
                            <p class="card-text"><small class="text-muted">10-01-2023
                                    at 04:23:52 PM</small>
                            </p>
                        </div>
                    </div>

                    <hr>
                    <div class="d-flex align-items-center gap-2" style=" padding-bottom: 10px;">
                        <a href="javascript:;" class="btn btn-warning px-5 rounded-0" style="width:100% ;">Collect
                            Sample</a>
                        </br>
                    </div>

                </div>
            </div>
            <div class="card">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0"></p>
                    </div>
                    <div class="dropdown ms-auto">
                        <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown">
                            <i class='bx bx-dots-horizontal-rounded font-22'></i>
                        </div>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="javascript:;">Action</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="{{ url('imgs/sample_tube.png') }}" alt="..." class="card-img">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h6 class="card-title">SERUM</h6>
                            <p class="card-text">Test : SGOT(AST)</p>
                            <p class="card-text">Department : Hemaology</p>
                            <p class="card-text"><small class="text-muted">10-01-2023
                                    at 04:23:52 PM</small>
                            </p>
                        </div>
                    </div>

                    <hr>
                    <div class="d-flex align-items-center gap-2" style=" padding-bottom: 10px;">
                        <a href="javascript:;" class="btn btn-warning px-5 rounded-0" style="width:100% ;">Collect
                            Sample</a>
                        </br>
                    </div>

                </div>
            </div>
            <div class="card">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0"></p>
                    </div>
                    <div class="dropdown ms-auto">
                        <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown">
                            <i class='bx bx-dots-horizontal-rounded font-22'></i>
                        </div>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="javascript:;">Action</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="{{ url('imgs/urine_sample.png') }}" alt="..." class="card-img">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h6 class="card-title">URINE</h6>
                            <p class="card-text">Test : Urine Analaysis</p>
                            <p class="card-text">Department : Hemaology</p>
                            <p class="card-text"><small class="text-muted">10-01-2023
                                    at 04:23:52 PM</small>
                            </p>
                        </div>
                    </div>

                    <hr>
                    <div class="d-flex align-items-center gap-2" style=" padding-bottom: 10px;">
                        <a href="javascript:;" class="btn btn-warning px-5 rounded-0" style="width:100% ;">Collect
                            Sample</a>
                        </br>
                    </div>

                </div>
            </div>
        </div>
    </form>
    <table class="table table-sm mb-0">
        <thead>
            <tr>
                <th scope="col"><input class="form-check-input" type="checkbox" id="inlineCheckbox1"
                        value="option1"></th>
                <th scope="col">Barcode</th>
                <th scope="col">Test Name</th>
                <th scope="col">Sample</th>
                <th scope="col">Result Date</th>
                <th scope="col">Department</th>
                <th scope="col">Sample Status</th>
                <th scope="col">Test Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row"><i class="lni lni-printer"></i></th>
                <td>323549842</td>
                <td>SGOT (AST)</td>
                <td>EDTA</td>
                <td>Hematology</td>
                <td>01/01/2023</td>
                <td>Registerd</td>
                <td>Pending</td>
                <td>
                    <div class="dropdown ms-auto">
                        <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown">
                            <i class='bx bx-dots-horizontal-rounded font-22'></i>
                        </div>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="javascript:;">Action</a>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
            <tr>
                <th scope="row"><i class="lni lni-printer"></i></th>
                <td>323549842</td>
                <td>SGOT (AST)</td>
                <td>Serum</td>
                <td>Hematology</td>
                <td>01/01/2023</td>
                <td>Registerd</td>
                <td>Pending</td>
                <td>
                    <div class="dropdown ms-auto">
                        <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown">
                            <i class='bx bx-dots-horizontal-rounded font-22'></i>
                        </div>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="javascript:;">Action</a>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
            <tr>
                <th scope="row"><i class="lni lni-printer"></i></th>
                <td>323549842</td>
                <td>Urine analysis</td>
                <td>Urine</td>
                <td>Hematology</td>
                <td>01/01/2023</td>
                <td>Registerd</td>
                <td>Pending</td>
                <td>
                    <div class="dropdown ms-auto">
                        <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown">
                            <i class='bx bx-dots-horizontal-rounded font-22'></i>
                        </div>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="javascript:;">Action</a>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <hr>
    <div class="d-flex align-items-center gap-2" style=" padding-bottom: 10px;">
        <a href="javascript:;" class="btn btn-secondary px-5 rounded-0">Print
            Barcode</a>
        <a href="javascript:;" class="btn btn-secondary px-5 rounded-0">Collect
            all</a>

        </br>
    </div>
</div>
<div id="step-7" class="tab-pane" role="tabpanel" aria-labelledby="step-4">

    <h6 class="mb-0 text-uppercase">Sample Handling</h6>
    <hr />
    <form action="">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-3">

            <div class="card">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0"></p>
                    </div>
                    <div class="dropdown ms-auto">
                        <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown">
                            <i class='bx bx-dots-horizontal-rounded font-22'></i>
                        </div>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="javascript:;">Print
                                    Barcode</a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:;">Sample
                                    Tracking</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="{{ url('imgs/sample_tube.png') }}" alt="..." class="card-img">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h6 class="card-title">EDTA</h6>
                            <p class="card-text">Colleted By : Ahmed Muawad</p>
                            <p class="card-text">Branch : Main Branch</p>
                            <p class="card-text"><small class="text-muted">10-01-2023
                                    at 04:23:52 PM</small>
                            </p>
                        </div>
                    </div>

                    <hr>
                    <div class="d-flex align-items-center gap-2" style=" padding-bottom: 10px;">
                        <a href="javascript:;" class="btn btn-warning px-5 rounded-0" style="width:100% ;">Send to
                            WORKARE</a>
                        </br>
                    </div>

                </div>
            </div>
            <div class="card">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0"></p>
                    </div>
                    <div class="dropdown ms-auto">
                        <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown">
                            <i class='bx bx-dots-horizontal-rounded font-22'></i>
                        </div>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="javascript:;">Print
                                    Barcode</a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:;">Sample
                                    Tracking</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="{{ url('imgs/sample_tube.png') }}" alt="..." class="card-img">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h6 class="card-title">SERUM</h6>
                            <p class="card-text">Colleted By : Ahmed Muawad</p>
                            <p class="card-text">Branch : Main Branch</p>
                            <p class="card-text"><small class="text-muted">10-01-2023
                                    at 04:23:52 PM</small>
                            </p>
                        </div>
                    </div>

                    <hr>
                    <div class="d-flex align-items-center gap-2" style=" padding-bottom: 10px;">
                        <a href="javascript:;" class="btn btn-warning px-5 rounded-0" style="width:100% ;">Send to
                            WORKARE</a>
                        </br>
                    </div>

                </div>
            </div>
            <div class="card">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0"></p>
                    </div>
                    <div class="dropdown ms-auto">
                        <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer"
                            data-bs-toggle="dropdown">
                            <i class='bx bx-dots-horizontal-rounded font-22'></i>
                        </div>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="javascript:;">Print
                                    Barcode</a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:;">Sample
                                    Tracking</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="{{ url('imgs/urine_sample.png') }}" alt="..." class="card-img">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h6 class="card-title">URINE</h6>
                            <p class="card-text">Colleted By : Ahmed Muawad</p>
                            <p class="card-text">Branch : Main Branch</p>
                            <p class="card-text"><small class="text-muted">10-01-2023
                                    at 04:23:52 PM</small>
                            </p>
                        </div>
                    </div>

                    <hr>
                    <div class="d-flex align-items-center gap-2" style=" padding-bottom: 10px;">
                        <a href="javascript:;" class="btn btn-warning px-5 rounded-0" style="width:100% ;">Send to
                            WORKARE</a>
                        </br>
                    </div>

                </div>
            </div>
        </div>
    </form>
    <table class="table table-sm mb-0">
        <thead>
            <tr>
                <th scope="col"><input class="form-check-input" type="checkbox" id="inlineCheckbox1"
                        value="option1"></th>
                <th scope="col">Barcode</th>
                <th scope="col">Test Name</th>
                <th scope="col">Sample</th>
                <th scope="col">Result Date</th>
                <th scope="col">Department</th>
                <th scope="col">Sample Status</th>
                <th scope="col">Test Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row"><input class="form-check-input" type="checkbox" id="inlineCheckbox1"
                        value="option1"></th>
                <td>323549842</td>
                <td>SGOT (AST)</td>
                <td>EDTA</td>
                <td>Hematology</td>
                <td>01/01/2023</td>
                <td>Collected</td>
                <td>Pending</td>
                <td>
                    <div class="dropdown ms-auto">
                        <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer"
                            data-bs-toggle="dropdown">
                            <i class='bx bx-dots-horizontal-rounded font-22'></i>
                        </div>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="javascript:;">Action</a>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
            <tr>
                <th scope="row"><input class="form-check-input" type="checkbox" id="inlineCheckbox1"
                        value="option1"></th>
                <td>323549842</td>
                <td>SGOT (AST)</td>
                <td>Serum</td>
                <td>Hematology</td>
                <td>01/01/2023</td>
                <td>Collected</td>
                <td>Pending</td>
                <td>
                    <div class="dropdown ms-auto">
                        <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer"
                            data-bs-toggle="dropdown">
                            <i class='bx bx-dots-horizontal-rounded font-22'></i>
                        </div>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="javascript:;">Action</a>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
            <tr>
                <th scope="row"><input class="form-check-input" type="checkbox" id="inlineCheckbox1"
                        value="option1"></th>
                <td>323549842</td>
                <td>Urine analysis</td>
                <td>Urine</td>
                <td>Hematology</td>
                <td>01/01/2023</td>
                <td>Collected</td>
                <td>Pending</td>
                <td>
                    <div class="dropdown ms-auto">
                        <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer"
                            data-bs-toggle="dropdown">
                            <i class='bx bx-dots-horizontal-rounded font-22'></i>
                        </div>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="javascript:;">Action</a>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <hr>
    <div class="d-flex align-items-center gap-2" style=" padding-bottom: 10px;">
        <a href="javascript:;" class="btn btn-secondary px-5 rounded-0">Print Working
            Paper</a>
        <a href="javascript:;" class="btn btn-secondary px-5 rounded-0">Send all to
            WORKARE
        </a>

        </br>
    </div>

</div>
