@extends('layouts.app')

@section('title')
    {{ __('Edit medical report') }}
@endsection
@section('css')
    <link rel="stylesheet" href="{{ url('plugins/summernote/summernote-bs4.css') }}">
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.medical_reports.index') }}">{{ __('Medical reports') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Edit medical report') }}</li>
@endsection
@section('content')


    @can('view_medical_report')
        <div class="row">
            <div class="col-lg-12">

                <a href="{{ route('admin.medical_reports.show', $group['id']) }}" class="btn btn-danger float-right mb-3">
                    <i class="fa fa-file-pdf"></i> {{ __('Print Report') }}
                </a>

                @can('show_without_sgin_medical_report')
                    <a href="{{ route('admin.medical_reports.print_show_report', $group['id']) }}"
                        class="btn btn-warning  float-right mb-3">
                        <i class="fa fa-file-pdf"></i> {{ __('View Report') }}
                    </a>
                @endcan
                <button type="button" class="btn btn-info float-right mb-3 mr-1" data-toggle="modal"
                    data-target="#patient_modal">
                    <i class="fas fa-user-injured"></i> {{ $group['patient']['name'] }} -
                    {{ __($group['patient']['gender']) }}
                    - {{ $group['patient']['age'] }}
                </button>
                @can('edit_patient')
                    <a href="{{ route('admin.patients.edit', $group['patient']['id']) }}"
                        class="btn btn-warning  float-right mb-3">
                        <i class="fa fa-check"></i>
                        {{ __('Edit patient') }}
                    </a>
                @endcan
                @can('review_medical_report')
                    <a class="btn @if ($group['review_by'] == null) btn-danger  @else btn-success @endif float-right mb-3 mr-1"
                        href="{{ route('admin.medical_reports.review', $group['id']) }}">
                        <i class="fas fa-eye" aria-hidden="true"></i>
                        {{ __('Review Report') }}
                    </a>
                @endcan
                @can('sign_medical_report')
                    <a class="btn @if ($group['signed_by'] == null) btn-danger  @else btn-success @endif  float-right mb-3 mr-1"
                        href="{{ route('admin.medical_reports.sign', $group['id']) }}">
                        <i class="fas fa-signature" aria-hidden="true"></i>
                        {{ __('Sign Report') }}
                    </a>
                @endcan

                <a @if (isset($previous)) href="{{ route('admin.medical_reports.edit', $previous['id']) }}" @endif
                    class="btn btn-info @if (!isset($previous)) disabled @endif">
                    <i class="fa fa-backward mr-2"></i>
                    {{ __('Previous') }}
                </a>
                <a @if (isset($next)) href="{{ route('admin.medical_reports.edit', $next['id']) }}" @endif
                    class="btn btn-success @if (!isset($next)) disabled @endif">
                    {{ __('Next') }}
                    <i class="fa fa-forward ml-2"></i>
                </a>

            </div>
        </div>
    @endcan


    <form action="{{ route('admin.medical_reports.upload_report', $group['id']) }}" method="POST"
        enctype="multipart/form-data">
        <div id="toggleAccordion">
            <div class="card">
                <div class="card-header" id="...">

                    <section class="mb-0 mt-0">
                        <div role="menu" class="collapsed" data-toggle="collapse" data-target="#defaultAccordionOne"
                            aria-expanded="true" aria-controls="defaultAccordionOne">
                            {{ __('Upload report') }}
                        </div>
                    </section>
                </div>

                <div id="defaultAccordionOne" class="collapse" aria-labelledby="..." data-parent="#toggleAccordion">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <label>
                                    {{ __('You can upload a pdf file as the report') }}
                                </label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="report" accept="application/pdf"
                                                class="custom-file-input" id="report" required>
                                            <label class="custom-file-label" for="report">{{ __('Report') }}</label>
                                        </div>
                                        @if ($group['uploaded_report'])
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="">
                                                    <a href="{{ $group['report_pdf'] }}" target="_blank">
                                                        <i class="fa fa-file-pdf"></i>
                                                    </a>
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-check"></i>
                            {{ __('Upload') }}
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </form>

    <!-- tests -->
    @if (count($group['all_tests']))
        <div class="card">
            <div class="card-header" id="...">
                <section class="mb-0 mt-0">
                    <div role="menu" class="" data-toggle="collapse" data-target="#defaultAccordionTwo"
                        aria-expanded="false" aria-controls="defaultAccordionTwo">
                        {{ __('Tests') }}
                    </div>
                </section>
            </div>
            <div id="defaultAccordionTwo" class="collapse show" aria-labelledby="..." data-parent="#toggleAccordion">
                <div class="card-body">
                    <div class="card-body">
                        @if (count($group['all_tests']))
                            <div class="card card-primary card-tabs">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="taps">
                                        {{-- {{ dd($group['all_tests']->toArray()) }} --}}
                                        @foreach ($group['all_tests'] as $test)
                                            @if ($test['results']->isNotEmpty())    
                                                <li class="nav-item">
                                                    <a class="nav-link text-capitalize" href="#test_{{ $test['id'] }}"
                                                        data-toggle="tab">
                                                        {{ $test['test']['name'] }}
                                                        @if ($test['done'])
                                                            <i class="fa fa-check text-success"></i>
                                                        @endif
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div><!-- /.card-header -->
                                <div class="card-body p-0">
                                    <div class="tab-content">
                                        @foreach ($group['all_tests'] as $test)
                                            <div class="tab-pane" id="test_{{ $test['id'] }}">
                                                @if ($test->check_test == 1)
                                                    <form id="test_submit" class="test_submit_ajax"
                                                        action="{{ route('admin.medical_reports.ajax', $test['id']) }}"
                                                        data-action="{{ route('admin.medical_reports.ajax', $test['id']) }}"
                                                        method="POST">
                                                        <input type="hidden" class="form-control reference_range"
                                                            name="group_id" value="{{ $group['id'] }}">
                                                        <input type="hidden" class="form-control reference_range"
                                                            name="test_id" value="{{ $test['test_id'] }}">

                                                        @csrf
                                                        @if (in_array($test->test->id,setting('medical')['cbc']))
                                                            <x-cbc-component :test="$test" :group="$group" />
                                                        @else
                                                            <div class="table-responsive">
                                                                <table class="table table-striped table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th width="200px">{{ __('Name') }}</th>
                                                                            <th width="100px" class="text-center">
                                                                                {{ __('Unit') }}</th>
                                                                            <th width="400px" class="text-center">
                                                                                {{ __('Reference Range') }}</th>
                                                                            <th width="300px" class="text-center">
                                                                                {{ __('Result') }}</th>
                                                                            <th class="text-center" style="width:200px">
                                                                                {{ __('Status') }}</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($test['results'] as $key => $result)
                                                                            {{-- {{$result['id']}} --}}
                                                                            @if (isset($result['component']))
                                                                                @if ($result['component']['title'])
                                                                                    <tr>
                                                                                        <td colspan="5">
                                                                                            <b>{{ $result['component']['name'] }}
                                                                                                {{ $result['component']['id'] }}</b>
                                                                                        </td>
                                                                                    </tr>
                                                                                @else
                                                                                    <tr @if ($result->show == 0) style="background-color:#db9696 !important;" @endif >
                                                                                        <td>
                                                                                            <input type="checkbox" class="show" resulte_id="{{ $result['id'] }}"
                                                                                            name="result[{{ $result['id'] }}][show]" required value="1" @if ($result->show == 1) checked @endif />
                                                                                            {{ $result['component']['name'] }}
                                                                                            {{ $result['component']['id'] }}
                                                                                        </td>
                                                                                        <td class="text-center">
                                                                                            {{ $result['component']['unit'] }}
                                                                                        </td>
                                                                                        <td class="text-center">
                                                                                            @if (isset($result['component']) && count($result['component']['reference_ranges']))
                                                                                                <div class="card">
                                                                                                    <div class="card-header"
                                                                                                        id="...">
                                                                                                        <section
                                                                                                            class="mb-0 mt-0">
                                                                                                            <div role="menu"
                                                                                                                class="collapsed"
                                                                                                                data-toggle="collapse"
                                                                                                                data-target="#Reference_{{ $result['component']['id'] }}"
                                                                                                                aria-expanded="true"
                                                                                                                aria-controls="defaultAccordionOne">
                                                                                                                {{ __('Reference ranges') }}
                                                                                                                <button
                                                                                                                    type="button"
                                                                                                                    class="btn btn-tool delete-reference"
                                                                                                                    data-url="{{ route('admin.medical_report.save.reference.range') }}"
                                                                                                                    data-component="{{ $result['component']['id'] }}"
                                                                                                                    data-card-widget="remove"
                                                                                                                    data-group_id="{{ $group['id'] }}"
                                                                                                                    data-test_resulte_id="{{ $result['id'] }}"><i
                                                                                                                        class="fas fa-times"></i>
                                                                                                                </button>



                                                                                                                <input
                                                                                                                    type="hidden"
                                                                                                                    class="form-control reference_range"
                                                                                                                    name="component_id[]"
                                                                                                                    value="{{ $result['component']['id'] }}">
                                                                                                            </div>
                                                                                                        </section>
                                                                                                    </div>

                                                                                                    <div id="Reference_{{ $result['component']['id'] }}"
                                                                                                        class="collapse"
                                                                                                        aria-labelledby="..."
                                                                                                        data-parent="#Reference_{{ $result['component']['id'] }}">
                                                                                                        <div
                                                                                                            class="card-body">

                                                                                                            <table
                                                                                                                class="table table-striped table-bordered">
                                                                                                                <thead>
                                                                                                                    <tr>
                                                                                                                        <th>{{ __('Gender') }}
                                                                                                                        </th>
                                                                                                                        <th>{{ __('Age') }}
                                                                                                                        </th>
                                                                                                                        <th>{{ __('Critical low') }}
                                                                                                                        </th>
                                                                                                                        <th>{{ __('Normal') }}
                                                                                                                        </th>
                                                                                                                        <th>{{ __('Critical high') }}
                                                                                                                        </th>
                                                                                                                    </tr>
                                                                                                                </thead>
                                                                                                                @foreach ($result['component']['reference_ranges'] as $reference_range)
                                                                                                                    {{-- {{$reference_range}} --}}
                                                                                                                    <tr>
                                                                                                                        <td>
                                                                                                                            {{ __($reference_range['gender']) }}
                                                                                                                        </td>
                                                                                                                        <td>
                                                                                                                            {{ __($reference_range['age_from']) }}
                                                                                                                            :
                                                                                                                            {{ $reference_range['age_to'] }}
                                                                                                                            {{ __($reference_range['age_unit']) }}
                                                                                                                        </td>
                                                                                                                        <td>
                                                                                                                            {{ $reference_range['critical_low_from'] }}
                                                                                                                        </td>
                                                                                                                        <td>
                                                                                                                            {{ $reference_range['normal_from'] }}
                                                                                                                            :
                                                                                                                            {{ $reference_range['normal_to'] }}
                                                                                                                        </td>
                                                                                                                        <td>
                                                                                                                            {{ $reference_range['critical_high_from'] }}
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                    <tr>
                                                                                                                        <td
                                                                                                                            colspan="5">
                                                                                                                            {!! $reference_range['comment'] !!}
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                @endforeach
                                                                                                            </table>

                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            @endif
                                                                                            {{-- {{$result['comment']}} --}}
                                                                                            @php
                                                                                                $comment = null;
                                                                                                
                                                                                                if ($result['comment'] == null) {
                                                                                                    if (count($result['component']->reference_ranges)) {
                                                                                                        // echo count($result['component']->reference_ranges);
                                                                                                        foreach ($result['component']->reference_ranges as $ref_range) {
                                                                                                            // echo $ref_range;
                                                                                                
                                                                                                            if ($group->patient->unit == $ref_range->age_unit && ($ref_range->gender == $group->patient->gender || $ref_range->gender == 'both') && (int) $group->patient->age <= $ref_range->age_to && (int) $group->patient->age >= $ref_range->age_from) {
                                                                                                                if ($ref_range->comment == null) {
                                                                                                                    if ($ref_range->normal_from == null || $ref_range->normal_to == null) {
                                                                                                                        $comment = $result['component']->reference_range;
                                                                                                                    } else {
                                                                                                                        $comment = $ref_range->normal_from . ' &nbsp; : &nbsp; ' . $ref_range->normal_to;
                                                                                                                    }
                                                                                                                } else {
                                                                                                                    if ($ref_range->normal_from == null || $ref_range->normal_to == null) {
                                                                                                                        $comment = $ref_range->comment;
                                                                                                                    } else {
                                                                                                                        if ($ref_range->show_status == '1') {
                                                                                                                            $comment = $ref_range->comment;
                                                                                                                        } else {
                                                                                                                            $comment = $ref_range->normal_from . ' &nbsp; : &nbsp; ' . $ref_range->normal_to . '<br>' . $ref_range->comment;
                                                                                                                        }
                                                                                                                    }
                                                                                                                }
                                                                                                            }
                                                                                                        }
                                                                                                
                                                                                                        if ($comment == null) {
                                                                                                            $comment = $result['component']->reference_range;
                                                                                                        }
                                                                                                    } else {
                                                                                                        $comment = $result['component']->reference_range;
                                                                                                    }
                                                                                                } else {
                                                                                                    $comment = $result['comment'];
                                                                                                }
                                                                                                
                                                                                            @endphp


                                                                                            @if (isset($comment))
                                                                                                <div class="edit_newRef">
                                                                                                    {!! $comment !!}
                                                                                                </div>
                                                                                            @endif
                                                                                        </td>
                                                                                        <td>
                                                                                            @if ($result['component']['type'] == 'text')
                                                                                                <input type="hidden"
                                                                                                    id="isi_settings"
                                                                                                    value="{{ $medical_settings['isi'] }}">
                                                                                                <input type="hidden"
                                                                                                    name="result[{{ $result['id'] }}][comment]" 
                                                                                                    value="{{ $comment }}">
                                                                                                <input type="hidden"
                                                                                                    name="result[{{ $result['id'] }}][component]"
                                                                                                    value="{{ $result['component']['id'] }}">

                                                                                                <input type="text"
                                                                                                    name="result[{{ $result['id'] }}][result]" required
                                                                                                    class="{{ \Str::slug($result['component']['name']) }} test_result form-control "
                                                                                                    data-component="{{ $result['component']['id'] }}"
                                                                                                    data-url="{{ route('admin.medical_report.get-comment') }}"
                                                                                                    @if (\Str::slug($result['component']['name']) == 'control-time') value="{{ $medical_settings['pt_control_time'] }}" readonly 
                                                                                                
                                                                                                @else 
                                                                                                @if (!$result['result'] && $result['component']['default'] != null)
                                                                                                    value="{{ $result['component']['default'] }}"
                                                                                                
                                                                                                
                                                                                                
                                                                                                @else 
                                                                                                    value="{{ $result['result'] }}" @endif
                                                                                                    @endif

                                                                                                @if (!empty($result->reference_range())) normal_from="{{ $result->reference_range()->normal_from }}"
                                                                                                    normal_to="{{ $result->reference_range()->normal_to }}"
                                                                                                    critical_high_from="{{ $result->reference_range()->critical_high_from }}"
                                                                                                    critical_low_from="{{ $result->reference_range()->critical_low_from }}" @endif
                                                                                                >
                                                                                            @elseif($result['component']['type'] == 'multy')
                                                                                                <input type="hidden"
                                                                                                    name="result[{{ $result['id'] }}][comment]"
                                                                                                    value="{{ $comment }}">
                                                                                                <select
                                                                                                    class="form-control select_result option_basic " 
                                                                                                    @if($result['component']['name'] == "Crystals") id="crystals" @endif
                                                                                                    >
                                                                                                    @foreach ($result['component']['options'] as $option)
                                                                                                        <option
                                                                                                          
                                                                                                            @if ($option['name'] == $result['component']['default']) selected @endif
                                                                                                            @if ($option['name'] == $result['result']) selected @endif
                                                                                                            value="{{ $option['name'] }}">
                                                                                                            {{ $option['name'] }}
                                                                                                        </option>
                                                                                                    @endforeach


                                                                                                </select>
                                                                                                <select
                                                                                                    class="form-control select_result option_additional">

                                                                                                    @foreach ($result['component']['options_additional'] as $option)
                                                                                                        @if ($option['gender'] == 'both' || $option['gender'] == $group['patient']['gender'])
                                                                                                            <option
                                                                                                                @if ($option['name'] == $result['result']) selected @endif
                                                                                                                @if ($option['name'] == $result['component']['default']) selected @endif
                                                                                                                status="{{ $option['status'] }}"
                                                                                                                gender="{{ $option['gender'] }}"
                                                                                                                value="{{ $option['name'] }}">
                                                                                                                {{ $option['name'] }}
                                                                                                            </option>
                                                                                                        @endif
                                                                                                    @endforeach


                                                                                                </select>
                                                                                                <input type="button"
                                                                                                    class="form-control btn-success done-option"
                                                                                                    value="done" />

                                                                                                <textarea style="direction:ltr !important;" cols="50" rows="5"
                                                                                                    name="result[{{ $result['id'] }}][result]" required class="form-control  test_result resulte_option " data-component="{{ $result['component']['id'] }}"
                                                                                                    >@if ($result['result'] != null) {{ $result['result'] }}@elseif($result['component']['default'] != null){{ $result['component']['default'] }}@endif</textarea>
                                                                                            @else
                                                                                                <input type="hidden"
                                                                                                    name="result[{{ $result['id'] }}][comment]"
                                                                                                    value="{{ $comment }}">
                                                                                                <select
                                                                                                    name="result[{{ $result['id'] }}][result]" required
                                                                                                    class="form-control select_result test_result"
                                                                                                    @if($result['component']['name'] == "Reaction") id="reaction" @endif
                                                                                                    @if (!empty($result->reference_range())) normal_from="{{ $result->reference_range()->normal_from }}"
                                                                                        normal_to="{{ $result->reference_range()->normal_to }}"
                                                                                        critical_high_from="{{ $result->reference_range()->critical_high_from }}"
                                                                                        critical_low_from="{{ $result->reference_range()->critical_low_from }}" @endif>
                                                                                                    <option value=""
                                                                                                        value=""
                                                                                                        disabled selected>
                                                                                                        {{ __('Select result') }}
                                                                                                    </option>

                                                                                                    @foreach ($result['component']['options'] as $option)
                                                                                                        @if ($option['gender'] == 'both' || $option['gender'] == $group['patient']['gender'])
                                                                                                            <option
                                                                                                                value="{{ $option['name'] }}"
                                                                                                                status="{{ $option['status'] }}"
                                                                                                                gender="{{ $option['gender'] }}"

                                                                                                                @if ($option['name'] == $result['component']['default'] && $result['component']['default'] != '' )
                                                                                                                
                                                                                                                @php
                                                                                                                    $defulteStatus[$result['id']] = ["code" => $result['id'] , "data" => $option['status'] ];
                                                                                                                @endphp
                                                                                                                selected
                                                                                                                
                                                                                                                @endif
                                                                                                                @if ($option['name'] == $result['result'])
                                                                                                                
                                                                                                                selected

                                                                                                                @php
                                                                                                                    $defulteStatus[$result['id']] = ["code" => 0 , "data" => $option['status'] ];
                                                                                                                @endphp
                                                                                                                
                                                                                                                @endif>

                                                                                                                {{ $option['name'] }}

                                                                                                            </option>
                                                                                                        @endif
                                                                                                    @endforeach
                                                                                                    <!-- Deleted option -->

                                                                                                    @if (
                                                                                                        !$result['component']['options']->contains('name', $result['result']) &&
                                                                                                            !$result['component']['options']->contains('name', $result['component']['default']))
                                                                                                        <option
                                                                                                            value="{{ $result['result'] }}"
                                                                                                            selected>
                                                                                                            {{ $result['result'] }}
                                                                                                        </option>
                                                                                                    @endif

                                                                                                    <!-- \Deleted option -->
                                                                                                </select>
                                                                                            @endif
                                                                                        </td>
                                                                                        <td style="width:10px"
                                                                                            class="text-center">
                                                                                            <select
                                                                                                name="result[{{ $result['id'] }}][status]"
                                                                                                class="form-control status"
                                                                                                data-component="{{ $result['component']['id'] }}">
                                                                                                <option value=""
                                                                                                    value="" disabled
                                                                                                    selected>
                                                                                                    {{ __('Select status') }}
                                                                                                </option>
                                                                                                <option
                                                                                                    value="Critical high"
                                                                                                    @if ($result['status'] == 'Critical high') selected @endif>
                                                                                                    {{ __('Critical high') }}
                                                                                                </option>
                                                                                                <option value="High"
                                                                                                    @if ($result['status'] == 'High') selected @endif>
                                                                                                    {{ __('High') }}
                                                                                                </option>
                                                                                                <option value="Normal"
                                                                                                    @if ($result['status'] == 'Normal' || (isset($defulteStatus[$result['id']]) && $defulteStatus[$result['id']]["code"] == $result['id'] && $defulteStatus[$result['id']]["data"] == "Normal")) selected @endif>
                                                                                                    {{ __('Normal') }}
                                                                                                </option>
                                                                                                <option value="Low"
                                                                                                    @if ($result['status'] == 'Low') selected @endif>
                                                                                                    {{ __('Low') }}
                                                                                                </option>
                                                                                                <option
                                                                                                    value="Critical low"
                                                                                                    @if ($result['status'] == 'Critical low') selected @endif>
                                                                                                    {{ __('Critical low') }}
                                                                                                </option>
                                                                                                <option value="Abnormal"
                                                                                                    @if ($result['status'] == 'Abnormal' || (isset($defulteStatus[$result['id']]) && $defulteStatus[$result['id']]["code"] == $result['id'] && $defulteStatus[$result['id']]["data"] == "Abnormal")  ) selected @endif>
                                                                                                    {{ __('Abnormal') }}
                                                                                                </option>
                                                                                                <option value="Panic"
                                                                                                    @if ($result['status'] == 'Panic' || (isset($defulteStatus[$result['id']]) && $defulteStatus[$result['id']]["code"] == $result['id'] && $defulteStatus[$result['id']]["data"] == "Panic")) selected @endif>
                                                                                                    {{ __('Panic') }}
                                                                                                </option>
                                                                                                <!-- New status -->
                                                                                                @if (
                                                                                                    !empty($result['status']) &&
                                                                                                        !in_array($result['status'], ['High', 'Normal', 'Low', 'Critical high', 'Critical low', 'Abnormal', 'Panic']))
                                                                                                    <option
                                                                                                        value="{{ $result['status'] }}"
                                                                                                        selected>
                                                                                                        {{ $result['status'] }}
                                                                                                    </option>
                                                                                                @endif
                                                                                                <!-- \New status -->
                                                                                            </select>
                                                                                            @if ($result['component']['status'])
                                                                                            @endif
                                                                                        </td>

                                                                                    </tr>
                                                                                @endif
                                                                            @endif
                                                                        @endforeach
                                                                        <tr>
                                                                            <td colspan="5">
                                                                                <textarea name="comment" id="" cols="30" rows="3" placeholder="{{ __('Comment') }}"
                                                                                    class="form-control ray_comment comment">{{ $test['comment'] }}</textarea>
                                                                                <select
                                                                                    id="select_comment_test_{{ $test['id'] }}"
                                                                                    class="form-control select_comment">
                                                                                    <option value="" disabled
                                                                                        selected>
                                                                                        {{ __('Select comment') }}
                                                                                    </option>
                                                                                    @foreach ($test['test']['comments'] as $comment)
                                                                                        <option
                                                                                            value="{{ $comment['comment'] }}">
                                                                                            {{ $comment['comment'] }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>

                                                                                <button type="button"
                                                                                    class="btn btn-primary btn-block btn-add-comment"
                                                                                    data-id="{{ $test['test']['id'] }}"
                                                                                    data-url="{{ route('admin.medical_report.add_comment') }}"
                                                                                    data-test-id="{{ $test['id'] }}">{{ __('Add comment') }}
                                                                                </button>
                                                                            </td>
                                                                        </tr>


                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <td colspan="5">
                                                                                @if (in_array($test->test->id,setting('medical')['cbc']))
                                                                                    <button class="btn btn-primary"
                                                                                        id=""><i
                                                                                            class="fa fa-check"></i>
                                                                                        {{ __('Save') }}</button>
                                                                                    <div class="btn btn-dark float-right"
                                                                                        id="cbc_api"><i
                                                                                            class="fa fa-check"></i>
                                                                                        {{ __('CBC') }}</div>
                                                                                @else
                                                                                    <button class="btn btn-primary"><i
                                                                                            class="fa fa-check"></i>
                                                                                        {{ __('Save') }}</button>
                                                                                @endif
                                                                                @can('review_medical_report')
                                                                                    <a class="btn @if ($test['review_by'] == null) btn-danger  @else btn-success @endif float-right"
                                                                                        href="{{ route('admin.tests.review', $test->id) }}">
                                                                                        <i class="fas fa-eye"
                                                                                            aria-hidden="true"></i>
                                                                                        {{ __('Review Test') }}
                                                                                    </a>
                                                                                @endcan
                                                                                @can('sign_medical_report')
                                                                                    <a class="btn @if ($test['signed_by'] == null) btn-danger  @else btn-success @endif float-right"
                                                                                        href="{{ route('admin.tests.sign', $test->id) }}">
                                                                                        <i class="fas fa-eye"
                                                                                            aria-hidden="true"></i>
                                                                                        {{ __('Sign Test') }}
                                                                                    </a>
                                                                                @endcan
                                                                                <button type="button"
                                                                                    class="btn btn-danger mr-2 rounded bs-popover float-right"
                                                                                    data-container="body"
                                                                                    data-placement="bottom"
                                                                                    data-content="{{ $test->test->increased_in }}"
                                                                                    title="{{ $test->test->increased_in }}">
                                                                                    {{ __('Increased In') }}
                                                                                </button>
                                                                                <button type="button"
                                                                                    class="btn btn-secondary mr-2 rounded bs-popover float-right"
                                                                                    data-container="body"
                                                                                    data-placement="bottom"
                                                                                    data-content="{{ $test->test->decreased_in }}"
                                                                                    title="{{ $test->test->decreased_in }}">
                                                                                    {{ __('Decreased In') }}
                                                                                </button>
                                                                            </td>
                                                                        </tr>
                                                                    </tfoot>
                                                                </table>
                                                            </div>
                                                            @php
                                                                $groupTest = App\Models\GroupTest::where('group_id', $group->id)->first();
                                                            @endphp

                                                            @if ($groupTest['test_id'] == 11091)
                                                                <x-semen-images-component :group="$group" />


                                                                @if (setting('medical')['semen_layout'] == 'with_graph')
                                                                    <x-semen-images-component :group="$group" />


                                                                @endif




                                                            @endif
                                                        @endif
                                                    </form>
                                                @else
                                                    <div class="alert alert-warning">{{ __('Check Test First') }}</div>
                                                @endif
                                            </div>
                                        @endforeach
                                        <!-- /.tab-pane -->

                                    </div>
                                    <!-- /.tab-content -->
                                </div><!-- /.card-body -->
                            </div>
                        @else
                            <!-- check  tests selected -->
                            <h6 class="text-center">
                                {{ __('No data available') }}
                            </h6>
                            <!-- End check  tests selected -->
                        @endif

                    </div>

                </div>
            </div>
        </div>
    @endif
    <!-- End tests -->

    <!-- Cultures -->
    @php
        $antibiotic_count = 0;
    @endphp
    @if (count($group['all_cultures']))
        <div class="card">
            <div class="card-header" id="...">
                <section class="mb-0 mt-0">
                    <div role="menu" class="" data-toggle="collapse" data-target="#defaultAccordionTwo"
                        aria-expanded="false" aria-controls="defaultAccordionTwo">
                        {{ __('Cultures') }}
                    </div>
                </section>
            </div>
            <div id="defaultAccordionTwo" class="collapse show" aria-labelledby="..." data-parent="#toggleAccordion">
                <div class="card-body">
                    @if (count($group['all_cultures']))
                        <div class="card card-primary card-tabs">
                            <div class="card-header p-0 pt-1">
                                <ul class="nav nav-tabs" id="taps">
                                    @foreach ($group['all_cultures'] as $culture)
                                        <li class="nav-item">
                                            <a class="nav-link text-capitalize" href="#culture_{{ $culture['id'] }}"
                                                data-toggle="tab">
                                                @if ($culture['done'])
                                                    <i class="fa fa-check text-success"></i>
                                                @endif {{ $culture['culture']['name'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">
                                    @foreach ($group['all_cultures'] as $culture)
                                        <div class="tab-pane" id="culture_{{ $culture['id'] }}">
                                            <form method="POST"
                                                action="{{ route('admin.medical_reports.update_culture', $culture['id']) }}"
                                                class="culture_form">
                                                @csrf
                                                <div class="row">
                                                    @foreach ($culture['culture_options'] as $culture_option)
                                                        @if (isset($culture_option['culture_option']))
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label
                                                                        for="culture_option_{{ $culture_option['id'] }}">{{ $culture_option['culture_option']['value'] }}</label>
                                                                    <select class="form-control select2"
                                                                        name="culture_options[{{ $culture_option['id'] }}]"
                                                                        id="culture_option_{{ $culture_option['id'] }}">
                                                                        <option value="" selected>
                                                                            {{ __('none') }}
                                                                        </option>
                                                                        @foreach ($culture_option['culture_option']['childs'] as $option)
                                                                            <option value="{{ $option['value'] }}"
                                                                                @if ($option['value'] == $culture_option['value']) selected @endif)>
                                                                                {{ $option['value'] }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>

                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h5 class="card-title">
                                                            {{ __('Antibiotics') }}
                                                        </h5>
                                                    </div>
                                                    <div class="card-body p-0">
                                                        <div class="row">
                                                            <div class="col-lg-12 overflow-auto">
                                                                <div class="table-responsive">
                                                                    <table class="table table-striped table-bordered m-0">
                                                                        <thead>
                                                                            <tr>
                                                                                <th width="">{{ __('Antibiotic') }}
                                                                                </th>
                                                                                <th width="200px">
                                                                                    {{ __('Sensitivity') }}
                                                                                </th>
                                                                                <th width="20px">
                                                                                    <button type="button"
                                                                                        class="btn btn-primary btn-sm"
                                                                                        onclick="add_antibiotic('{{ $select_antibiotics }}',this)">
                                                                                        <i class="fa fa-plus"></i>
                                                                                    </button>
                                                                                </th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="antibiotics">
                                                                            @foreach ($culture['antibiotics'] as $antibiotic)
                                                                                @php
                                                                                    $antibiotic_count++;
                                                                                @endphp
                                                                                <tr>
                                                                                    <td>
                                                                                        <select
                                                                                            class="form-control antibiotic"
                                                                                            name="antibiotic[{{ $antibiotic_count }}][antibiotic]"
                                                                                            required>
                                                                                            <option value="" disabled
                                                                                                selected>
                                                                                                {{ __('Select Antibiotic') }}
                                                                                            </option>
                                                                                            @foreach ($select_antibiotics as $select_antibiotic)
                                                                                                <option
                                                                                                    value="{{ $select_antibiotic['id'] }}"
                                                                                                    @if ($select_antibiotic['id'] == $antibiotic['antibiotic_id']) selected @endif>
                                                                                                    {{ $select_antibiotic['id'] }}
                                                                                                    -
                                                                                                    {{ $select_antibiotic['name'] }}
                                                                                                    -
                                                                                                    {{ $select_antibiotic['shortcut'] }}
                                                                                                </option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </td>
                                                                                    <td>
                                                                                        <select class="form-control"
                                                                                            name="antibiotic[{{ $antibiotic_count }}][sensitivity]"
                                                                                            required>
                                                                                            <option value="" disabled
                                                                                                selected>
                                                                                                {{ __('Select Sensitivity') }}
                                                                                            </option>
                                                                                            <option value="High"
                                                                                                @if ($antibiotic['sensitivity'] == 'High') selected @endif>
                                                                                                High
                                                                                            </option>
                                                                                            <option value="Moderate"
                                                                                                @if ($antibiotic['sensitivity'] == 'Moderate') selected @endif>
                                                                                                Moderate
                                                                                            </option>
                                                                                            <option value="Resistant"
                                                                                                @if ($antibiotic['sensitivity'] == 'Resistant') selected @endif>
                                                                                                Resistant
                                                                                            </option>
                                                                                            @if (isset(setting('medical')['low_culture']) && setting('medical')['low_culture'] == true)
                                                                                                <option value="Low"
                                                                                                    @if ($antibiotic['sensitivity'] == 'Low') selected @endif>
                                                                                                    Low
                                                                                                </option>
                                                                                            @endif
                                                                                        </select>
                                                                                    </td>
                                                                                    <td>
                                                                                        <button type="button"
                                                                                            class="btn btn-danger btn-sm delete_row">
                                                                                            <i class="fa fa-trash"></i>
                                                                                        </button>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                        <tfoot>
                                                                            <tr>
                                                                                <td colspan="3">
                                                                                    <textarea class="form-control ray_comment comment" name="comment" id="" cols="30" rows="3"
                                                                                        placeholder="{{ __('Comment') }}">{{ $culture['comment'] }}</textarea>
                                                                                    <select
                                                                                        id="select_comment_culture_{{ $culture['id'] }}"
                                                                                        class="form-control select_comment">
                                                                                        <option value="" disabled
                                                                                            selected>
                                                                                            {{ __('Select comment') }}
                                                                                        </option>
                                                                                        @foreach ($culture['culture']['comments'] as $comment)
                                                                                            <option
                                                                                                value="{{ $comment['comment'] }}">
                                                                                                {{ $comment['comment'] }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </td>
                                                                            </tr>

                                                                        </tfoot>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer">
                                                        <td colspan="3">
                                                            <button class="btn btn-primary"><i class="fa fa-check"></i>
                                                                {{ __('Save') }}</button>
                                                        </td>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    @endforeach
                                    <!-- /.tab-pane -->
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Check Cultures Selected -->
                        <h6 class="text-center">
                            {{ __('No data available') }}
                        </h6>
                        <!-- End Check Cultures Selected -->
                    @endif
                </div>
            </div>
        </div>

    @endif
    <!-- antibiotic count -->
    <input type="hidden" id="antibiotic_count" value="{{ $antibiotic_count }}">
    <!-- End Cultures-->

    <input type="hidden" id="patient_id" value="{{ $group['patient_id'] }}">

    {{-- rays --}}
    @if (isset($group['rays']) && $group['rays']->isNotEmpty())
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ __('Rays') }}</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                            class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                            class="fas fa-times"></i></button>
                </div>
            </div>
            <div class="card-body">
                @if (count($group['rays']))
                    <div class="card card-primary card-tabs">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs" id="taps">
                                @foreach ($group['rays']->where(
            'based_by',
            auth()->guard('admin')->user()->id,
        ) as $ray)
                                    <li class="nav-item">
                                        <a class="nav-link text-capitalize" href="#ray_{{ $ray['id'] }}"
                                            data-toggle="tab">
                                            @if ($ray['checked'])
                                                <i class="fa fa-check text-success"></i>
                                            @endif {{ $ray['ray']['name'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                @foreach ($group['rays'] as $ray)
                                    <div class="tab-pane" id="ray_{{ $ray['id'] }}">
                                        {{-- <form method="POST" action="#" class="ray_form"> --}}
                                        <form method="POST"
                                            action="{{ route('admin.medical_reports.update_ray', $ray['id']) }}"
                                            class="ray_form">
                                            @csrf
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="comment">{{ __('Comment') }}</label>
                                                        <textarea name="comment" class="ray_comment comment" cols="30" rows="10" class="form-control"> @if (isset($ray->result))
<?= $ray->result->comment ?>
@endif  </textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">

                                                <td colspan="3">
                                                    <button class="btn btn-primary"><i class="fa fa-check"></i>
                                                        {{ __('Save') }}</button>
                                                </td>
                                            </div>
                                        </form>
                                    </div>
                                @endforeach
                                <!-- /.tab-pane -->
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Check Cultures Selected -->
                    <h6 class="text-center">
                        {{ __('No data available') }}
                    </h6>
                    <!-- End Check Cultures Selected -->
                @endif
            </div>

        </div>
    @endif
    {{-- end rays --}}

    @can('view_medical_report')
        <div class="row">
            <div class="col-lg-12">

                <a href="{{ route('admin.medical_reports.show', $group['id']) }}" class="btn btn-danger float-right mb-3">
                    <i class="fa fa-file-pdf"></i> {{ __('Print Report') }}
                </a>

                @can('show_without_sgin_medical_report')
                    <a href="{{ route('admin.medical_reports.print_show_report', $group['id']) }}"
                        class="btn btn-warning  float-right mb-3">
                        <i class="fa fa-file-pdf"></i> {{ __('View Report') }}
                    </a>
                @endcan

                <button type="button" class="btn btn-info float-right mb-3 mr-1" data-toggle="modal"
                    data-target="#patient_modal">
                    <i class="fas fa-user-injured"></i> {{ __('Patient info') }}
                </button>
                @can('edit_patient')
                    <a href="{{ route('admin.patients.edit', $group['patient']['id']) }}"
                        class="btn btn-warning  float-right mb-3">
                        <i class="fa fa-check"></i>
                        {{ __('Edit patient') }}
                    </a>
                @endcan
                @can('review_medical_report')
                    <a class="btn btn-success float-right mb-3 mr-1"
                        href="{{ route('admin.medical_reports.review', $group['id']) }}">
                        <i class="fas fa-eye" aria-hidden="true"></i>
                        {{ __('Review Report') }}
                    </a>
                @endcan
                @can('sign_medical_report')
                    <a class="btn btn-success float-right mb-3 mr-1"
                        href="{{ route('admin.medical_reports.sign', $group['id']) }}">
                        <i class="fas fa-signature" aria-hidden="true"></i>
                        {{ __('Sign Report') }}
                    </a>
                @endcan

                <a @if (isset($previous)) href="{{ route('admin.medical_reports.edit', $previous['id']) }}" @endif
                    class="btn btn-info @if (!isset($previous)) disabled @endif">
                    <i class="fa fa-backward mr-2"></i>
                    {{ __('Previous') }}
                </a>
                <a @if (isset($next)) href="{{ route('admin.medical_reports.edit', $next['id']) }}" @endif
                    class="btn btn-success @if (!isset($next)) disabled @endif">
                    {{ __('Next') }}
                    <i class="fa fa-forward ml-2"></i>
                </a>
            </div>
        </div>
    @endcan
    @include('admin.medical_reports._patient_modal')
@endsection

@section('scripts')
    <script>
        var low_culture = "{{ setting('medical')['low_culture'] }}";
        var resistant_culture = "{{ setting('medical')['resistant_culture'] }}";
    </script>

    <script src="{{ url('js/admin/medical_reports.js') }}"></script>
    <script src="{{ url('calculation.js') }}"></script>
@endsection
