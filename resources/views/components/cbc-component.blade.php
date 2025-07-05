<div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th width="200px">{{ __('Name') }}</th>
                    <th width="100px" class="text-center">
                        {{ __('Unit') }}</th>
                    <th width="400px" class="text-center">
                        {{ __('Reference Range') }}</th>
                    <th width="200px" class="text-center">
                        {{ __('Result') }}</th>
                    <th class="text-center" style="width:200px">
                        {{ __('Status') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($test['results'] as $key => $result)
                    @if (
                        \Str::slug($result['component']['name']) == "lymphocytes" ||
                        \Str::slug($result['component']['name']) == "monocytes" ||
                        \Str::slug($result['component']['name']) == "eosinophils" ||
                        \Str::slug($result['component']['name']) == "basophils" ||
                        \Str::slug($result['component']['name']) == "neutrophil" ||
                        \Str::slug($result['component']['name']) == "segment" ||
                        \Str::slug($result['component']['name']) == "band" ||
                        \Str::slug($result['component']['name']) == "a-lymphocytes" ||
                        \Str::slug($result['component']['name']) == "a-monocytes" ||
                        \Str::slug($result['component']['name']) == "a-eosinophils" ||
                        \Str::slug($result['component']['name']) == "a-basophils" ||
                        \Str::slug($result['component']['name']) == "a-neutrophil" ||
                        \Str::slug($result['component']['name']) == "a-segment" ||
                        \Str::slug($result['component']['name']) == "a-band" ||
                        \Str::slug($result['component']['name']) == "wbcs-differential" ||
                        \Str::slug($result['component']['name']) == "relative-count" ||
                        \Str::slug($result['component']['name']) == "absolute-count" ||
                        \Str::slug($result['component']['name']) == "aly" ||
                        \Str::slug($result['component']['name']) == "lic" ||
                        \Str::slug($result['component']['name']) == "a-lic" 
                        
                        )
                    @else
                    <tr @if ($result->show == 0) style="background-color:#db9696 !important;" @endif >
                            <td>
                                {{-- enabale in report --}}

                                <input type="checkbox" class="show" resulte_id="{{ $result['id'] }}"
                                                                                            name="result[{{ $result['id'] }}][show]" value="1" @if ($result->show == 1) checked @endif />
                                @if (
                                    \Str::slug($result['component']['name']) == "plateletplt" ||
                                    \Str::slug($result['component']['name']) == "platelet-count-plt" ||
                                    \Str::slug($result['component']['name']) == "neutrophil" ||
                                    \Str::slug($result['component']['name']) == "neutrophil")
                                    <b>{{ $result['component']['name'] }}</b>
                                    @elseif (\Str::slug($result['component']['name']) == "pct" ||
                                        \Str::slug($result['component']['name']) == "mpv" ||
                                        \Str::slug($result['component']['name']) == "pdw" ||
                                        \Str::slug($result['component']['name']) == "p-lcr" ||
                                        \Str::slug($result['component']['name']) == "p-lcc" ||
                                        \Str::slug($result['component']['name']) == "band"
                                        )
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    {{ $result['component']['name'] }}
                                @else
                                    {{ $result['component']['name'] }}
                                @endif
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
                                            <div class="card-body">

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

                                @php
                                // dd($group['patient']['age2']Days );
                                    $comment = null;
                                    if ($result['comment'] == null) {
                                        if (count($result['component']->reference_ranges)) {
                                            foreach ($result['component']->reference_ranges->sortBy("age_to_days") as $ref_range) {
                                                if ($group->patient->unit == $ref_range->age_unit && ($ref_range->gender == $group->patient->gender || $ref_range->gender == 'both') && ((int) $group['patient']['age2'] <= $ref_range->age_to) && ((int) $group['patient']['age2'] >= $ref_range->age_from) ) {
                                                    if($ref_range->comment == null){
                                                        if($ref_range->normal_from == null || $ref_range->normal_to == null ){
                                                            $comment = $result['component']->reference_range;

                                                        }else {
                                                            $comment = $ref_range->normal_from . ' &nbsp; : &nbsp; ' . $ref_range->normal_to ;

                                                        }

                                                    }else{

                                                        if($ref_range->normal_from == null || $ref_range->normal_to == null ){
                                                            $comment = $ref_range->comment;

                                                        }else {
                                                            if($ref_range->show_status == '1'){
                                                                $comment = $ref_range->comment ;
                                                            }else{
                                                                $comment = $ref_range->normal_from . ' &nbsp; : &nbsp; ' . $ref_range->normal_to . '<br>' . $ref_range->comment ;
                                                            }

                                                        }
                                                    }
                                                    break;
                                                }
                                            }

                                            if($comment == null){
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
                                    <div class="edit_newRef"
                                        >
                                        {!! $comment !!}
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if ($result['component']['type'] == 'text')
                                    
                                    <input type="hidden"
                                        name="result[{{ $result['id'] }}][component]"
                                        value="{{ $result['component']['id'] }}">
                                    <input type="hidden"
                                        name="result[{{ $result['id'] }}][comment]"
                                        value="{{ $comment }}">
                                    <input type="text"

                                        name="result[{{ $result['id'] }}][result]"
                                        class="{{ \Str::slug($result['component']['name'].'-cbc') }} test_result testx_result form-control "
                                        {{-- class="{{ $result['component']['id'] == 1257 ? 'WBCs' : '' }} {{ $result['component']['id'] == 1261 ? 'Lymphocytes' : '' }} {{ $result['component']['id'] == 1262 ? 'Monocytes' : '' }} {{ $result['component']['id'] == 1263 ? 'Eosinophils' : '' }} {{ $result['component']['id'] == 1264 ? 'Basophils' : '' }} {{ $result['component']['id'] == 1266 ? 'Neutrophil' : '' }} {{ $result['component']['id'] == 1267 ? 'Segment' : '' }} {{ $result['component']['id'] == 1268 ? 'Band' : '' }} form-control  {{ $result['component']['id'] == 1419 ? 'a_Lymphocytes' : '' }} {{ $result['component']['id'] == 1420 ? 'a_Monocytes' : '' }} {{ $result['component']['id'] == 1421 ? 'a_Eosinophils' : '' }} {{ $result['component']['id'] == 1422 ? 'a_Basophils' : '' }} {{ $result['component']['id'] == 1424 ? 'a_Neutrophil' : '' }} {{ $result['component']['id'] == 1425 ? 'a_Segment' : '' }} {{ $result['component']['id'] == 1426 ? 'a_Band' : '' }} test_result {{ $result['component']['id'] == 1249 ? 'rpcs' : '' }} {{ $result['component']['id'] == 1253 ? 'mchc' : '' }} {{ $result['component']['id'] == 1251 ? 'mcv' : '' }} {{ $result['component']['id'] == 1248 ? 'Hemoglobin' : '' }} {{ $result['component']['id'] == 1252 ? 'mch' : '' }} {{ $result['component']['id'] == 1250 ? 'hct' : '' }} {{ $result['component']['id'] == 1483 ? 'cho' : '' }} {{ $result['component']['id'] == 1484 ? 'Triglycerides' : '' }} {{ $result['component']['id'] == 1485 ? 'hdl' : '' }} {{ $result['component']['id'] == 1486 ? 'ldl' : '' }} {{ $result['component']['id'] == 1487 ? 'Risk1' : '' }} {{ $result['component']['id'] == 1488 ? 'Risk2' : '' }} {{ $result['component']['id'] == 532 ? 'pt' : '' }} {{ $result['component']['id'] == 1479 ? 'Concentration' : '' }} {{ $result['component']['id'] == 3031 ? 'PT_Time' : '' }} {{ $result['component']['id'] == 3032 ? 'Control_Time' : '' }} {{ $result['component']['id'] == 3033 ? 'Activity' : '' }} {{ $result['component']['id'] == 3034 ? 'INR' : '' }}" --}}
                                        
                                        data-component="{{ $result['component']['id'] }}"
                                        data-url="{{ route('admin.medical_report.get-comment') }}"
                                        
                                        @if(!$result['result'])
                                            value="{{$result['component']['default']}}"
                                        @else
                                            value="{{ $result['result'] }}"
                                        @endif

                                        @if (!empty($result->reference_range())) normal_from="{{ $result->reference_range()->normal_from }}"
                                        
                               normal_to="{{ $result->reference_range()->normal_to }}"
                               critical_high_from="{{ $result->reference_range()->critical_high_from }}"
                               critical_low_from="{{ $result->reference_range()->critical_low_from }}" @endif>


                                @if (isset($result->reference_range()->normal_from ))
                                        
                                    <input type="hidden"
                                    name="result[{{ $result['id'] }}][normal_from]"
                                    value="{{ $result->reference_range()->normal_from }}"
                                    >
                                @endif

                                @if (isset($result->reference_range()->normal_to))
                                    
                                    <input type="hidden"
                                    name="result[{{ $result['id'] }}][normal_to]"
                                    value="{{ $result->reference_range()->normal_to }}"
                                    >
                                @endif

                                @if (isset($result->reference_range()->critical_high_from))
                                    
                                    <input type="hidden"
                                    name="result[{{ $result['id'] }}][critical_high_from]"
                                    value="{{ $result->reference_range()->critical_high_from }}"
                                    >
                                @endif
                                @if (isset($result->reference_range()->critical_low_from ))
                                    
                                    <input type="hidden"
                                    name="result[{{ $result['id'] }}][critical_low_from]"
                                    value="{{ $result->reference_range()->critical_low_from }}"
                                    >
                                @endif
                                @else
                                    <input type="hidden"
                                        name="result[{{ $result['id'] }}][comment]"
                                        value="{{ $comment }}">
                                    <select
                                        name="result[{{ $result['id'] }}][result]"
                                        class="form-control select_result test_result"
                                        @if (!empty($result->reference_range())) normal_from="{{ $result->reference_range()->normal_from }}"
                                normal_to="{{ $result->reference_range()->normal_to }}"
                                critical_high_from="{{ $result->reference_range()->critical_high_from }}"
                                critical_low_from="{{ $result->reference_range()->critical_low_from }}" @endif>
                                        <option value=""
                                            value="" disabled
                                            selected>
                                            {{ __('Select result') }}
                                        </option>
                                        @foreach ($result['component']['options'] as $option)
                                            <option
                                                value="{{ $option['name'] }}"
                                                @if ($option['name'] == $result['result']) selected @endif
                                                @if ($option['name'] == $result['component']['default'] && $result['result']==null) selected @endif
                                                >
                                                {{ $option['name'] }}
                                            </option>
                                        @endforeach
                                        <!-- Deleted option -->
                                        @if (!$result['component']['options']->contains('name', $result['result'])
                                        &&
                                             !$result['component']['options']->contains('name', $result['component']['default'])
                                        )
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
                                    <option value="Critical high"
                                        @if ($result['status'] == 'Critical high') selected @endif>
                                        {{ __('Critical high') }}
                                    </option>
                                    <option value="High"
                                        @if ($result['status'] == 'High') selected @endif>
                                        {{ __('High') }}
                                    </option>
                                    <option value="Normal"
                                        @if ($result['status'] == 'Normal') selected @endif>
                                        {{ __('Normal') }}
                                    </option>
                                    <option value="Low"
                                        @if ($result['status'] == 'Low') selected @endif>
                                        {{ __('Low') }}
                                    </option>
                                    <option value="Critical low"
                                        @if ($result['status'] == 'Critical low') selected @endif>
                                        {{ __('Critical low') }}
                                    </option>
                                    <!-- New status -->
                                    @if (!empty($result['status']) &&
                                        !in_array($result['status'], ['High', 'Normal', 'Low', 'Critical high', 'Critical low']))
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
                @endforeach

        </table>
    </div>
    <div class="card-header">
        <input type="hidden" id="the_rest_val" value=""
            readonly>
        <h5 class="card-title">
            {{ __('Remaining') }} : <span id="the_rest"></span>
            %
        </h5>
    </div>
    <div class="tleft" style="float: left; width:50%">
        <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th width="20%">{{ __('Name') }}</th>
                    <th width="10%" class="text-center">
                        {{ __('Unit') }}</th>
                    <th width="40%" class="text-center">
                        {{ __('Reference Range') }}</th>
                    <th width="30%" class="text-center">
                        {{ __('Result') }}</th>
                    {{--  <th width="25%"class="text-center">
                        {{ __('Status') }}</th>  --}}
                </tr>
            </thead>

            @foreach ($test['results'] as $key => $result)
                @if (
                    (
                    \Str::slug($result['component']['name']) == "lymphocytes" ||
                    \Str::slug($result['component']['name']) == "monocytes" ||
                    \Str::slug($result['component']['name']) == "eosinophils" ||
                    \Str::slug($result['component']['name']) == "basophils" ||
                    \Str::slug($result['component']['name']) == "neutrophil" ||
                    \Str::slug($result['component']['name']) == "segment" ||
                    \Str::slug($result['component']['name']) == "lic" ||
                    \Str::slug($result['component']['name']) == "aly" ||
                    \Str::slug($result['component']['name']) == "band")
                    && $result['component']['title'] == 0
                    )
                    <tbody>
                        <tr @if ($result->show == 0) style="background-color:#db9696 !important;" @endif >
                            <td>
                                {{-- enabale in report --}}

                                <input type="checkbox" class="show" resulte_id="{{ $result['id'] }}"
                                    name="result[{{ $result['id'] }}][show]" value="1" @if ($result->show == 1) checked @endif />
                                {{ $result['component']['name'] }}
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
                                                    class="collapsed_{{ $result['component']['id'] }}"
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
                                            <div class="card-body">

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

                                @php
                                $comment = null;
                                if ($result['comment'] == null) {
                                    if (count($result['component']->reference_ranges)) {

                                        foreach ($result['component']->reference_ranges->sortBy("age_to_days") as $ref_range) {

                                            if ($group->patient->unit == $ref_range->age_unit && ($ref_range->gender == $group->patient->gender || $ref_range->gender == 'both') && ((int) $group['patient']['age2'] <= $ref_range->age_to) && ((int) $group['patient']['age2'] >= $ref_range->age_from) ) {
                                                if($ref_range->comment == null){
                                                    if($ref_range->normal_from == null || $ref_range->normal_to == null ){
                                                        $comment = $result['component']->reference_range;

                                                    }else {
                                                        $comment = $ref_range->normal_from . '&nbsp;&nbsp;:&nbsp;&nbsp;' . $ref_range->normal_to ;

                                                    }

                                                }else{

                                                    if($ref_range->normal_from == null || $ref_range->normal_to == null ){
                                                        $comment =  $ref_range->comment;

                                                    }else {

                                                        if($ref_range->show_status == '1'){
                                                            $comment = $ref_range->comment ;
                                                        }else{
                                                            $comment = $ref_range->normal_from . ' &nbsp; : &nbsp; ' . $ref_range->normal_to . '<br>' . $ref_range->comment ;
                                                        }

                                                    }
                                                }
                                            }
                                        }

                                        if($comment == null){
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
                                    <div class="edit_newRef"
                                        >
                                        {!! $comment !!}
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if ($result['component']['type'] == 'text')
                                    
                                    <input type="hidden"
                                        name="result[{{ $result['id'] }}][comment]"
                                        value="{{ $comment }}">
                                    <input type="hidden"
                                        name="result[{{ $result['id'] }}][component]"
                                        value="{{ $result['component']['id'] }}">
                                    <input type="text"

                                        name="result[{{ $result['id'] }}][result]"
                                        class="{{ \Str::slug($result['component']['name'].'-cbc') }} test_result form-control "
                                        value="{{ $result['result'] }}"
                                        data-component="{{ $result['component']['id'] }}"
                                        data-url="{{ route('admin.medical_report.get-comment') }}"
                                        @if (!empty($result->reference_range())) normal_from="{{ $result->reference_range()->normal_from }}"
                                        
                                                normal_to="{{ $result->reference_range()->normal_to }}"
                                                critical_high_from="{{ $result->reference_range()->critical_high_from }}"
                                                critical_low_from="{{ $result->reference_range()->critical_low_from }}" @endif>

                                        @if (isset($result->reference_range()->normal_from ))
                                
                                            <input type="hidden"
                                            name="result[{{ $result['id'] }}][normal_from]"
                                            value="{{ $result->reference_range()->normal_from }}"
                                            >
                                        @endif

                                        @if (isset($result->reference_range()->normal_to))
                                            
                                            <input type="hidden"
                                            name="result[{{ $result['id'] }}][normal_to]"
                                            value="{{ $result->reference_range()->normal_to }}"
                                            >
                                        @endif

                                        @if (isset($result->reference_range()->critical_high_from))
                                            
                                            <input type="hidden"
                                            name="result[{{ $result['id'] }}][critical_high_from]"
                                            value="{{ $result->reference_range()->critical_high_from }}"
                                            >
                                        @endif
                                        @if (isset($result->reference_range()->critical_low_from ))
                                            
                                            <input type="hidden"
                                            name="result[{{ $result['id'] }}][critical_low_from]"
                                            value="{{ $result->reference_range()->critical_low_from }}"
                                            >
                                        @endif

                                        
                                @else
                                    <input type="hidden"
                                        name="result[{{ $result['id'] }}][comment]"
                                        value="{{ $comment }}">
                                    <select
                                        name="result[{{ $result['id'] }}][result]"
                                        class="form-control select_result test_result"
                                        @if (!empty($result->reference_range())) normal_from="{{ $result->reference_range()->normal_from }}"
                                                    normal_to="{{ $result->reference_range()->normal_to }}"
                                                    critical_high_from="{{ $result->reference_range()->critical_high_from }}"
                                                    critical_low_from="{{ $result->reference_range()->critical_low_from }}" @endif>
                                        <option value=""
                                            value="" disabled
                                            selected>
                                            {{ __('Select result') }}
                                        </option>
                                        @foreach ($result['component']['options'] as $option)
                                            <option
                                                value="{{ $option['name'] }}"
                                                @if ($option['name'] == $result['result']) selected @endif>
                                                {{ $option['name'] }}
                                            </option>
                                        @endforeach
                                        <!-- Deleted option -->
                                        @if (!$result['component']['options']->contains('name', $result['result']))
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
                        </tr>
                @endif
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
    <div class="tleft" style="float: right; width:50%">
        <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th width="20%">{{ __('Name') }}</th>
                    <th width="10%" class="text-center">
                        {{ __('Unit') }}</th>
                    <th width="40%" class="text-center">
                        {{ __('Reference Range') }}</th>
                    <th width="30%" class="text-center">
                        {{ __('Result') }}</th>

            </thead>

            @foreach ($test['results'] as $key => $result)


                @if (
                    (\Str::slug($result['component']['name']) == "a-lymphocytes" ||
                    \Str::slug($result['component']['name']) == "a-monocytes" ||
                    \Str::slug($result['component']['name']) == "a-eosinophils" ||
                    \Str::slug($result['component']['name']) == "a-basophils" ||
                    \Str::slug($result['component']['name']) == "a-neutrophil" ||
                    \Str::slug($result['component']['name']) == "a-segment" ||
                    \Str::slug($result['component']['name']) == "a-lic" ||
                    \Str::slug($result['component']['name']) == "a-band")
                    && $result['component']['title'] == 0
                    
                    )
                    <tbody>
                        <tr @if ($result->show == 0) style="background-color:#db9696 !important;" @endif >

                            <td>
                                {{-- enabale in report --}}
                                <input type="checkbox" class="show" resulte_id="{{ $result['id'] }}"
                                    name="result[{{ $result['id'] }}][show]" value="1" @if ($result->show == 1) checked @endif />
                                {{ $result['component']['name'] }}
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
                                                    class="collapsed_{{ $result['component']['id'] }}"
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
                                            <div class="card-body">

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

                                @php
                                    $comment = null;
                                    if ($result['comment'] == null) {
                                        if (count($result['component']->reference_ranges)) {

                                            foreach ($result['component']->reference_ranges->sortBy("age_to_days") as $ref_range) {

                                                if ($group->patient->unit == $ref_range->age_unit && ($ref_range->gender == $group->patient->gender || $ref_range->gender == 'both') && ((int) $group['patient']['age2'] <= $ref_range->age_to) && ((int) $group['patient']['age2'] >= $ref_range->age_from) ) {
                                                    if($ref_range->comment == null){
                                                        if($ref_range->normal_from == null || $ref_range->normal_to == null ){
                                                            $comment = $result['component']->reference_range;

                                                        }else {
                                                            $comment = $ref_range->normal_from . ' &nbsp; : &nbsp; ' . $ref_range->normal_to ;

                                                        }

                                                    }else{

                                                        if($ref_range->normal_from == null || $ref_range->normal_to == null ){
                                                            $comment = $ref_range->comment;

                                                        }else {
                                                            if($ref_range->show_status == '1'){
                                                                $comment = $ref_range->comment ;
                                                            }else{
                                                                $comment = $ref_range->normal_from . ' &nbsp; : &nbsp; ' . $ref_range->normal_to . '<br>' . $ref_range->comment ;
                                                            }

                                                        }
                                                    }
                                                }
                                            }

                                            if($comment == null){
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
                                    <div class="edit_newRef"
                                        >
                                        {!! $comment !!}
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if ($result['component']['type'] == 'text')
                                    
                                    <input type="hidden"
                                        name="result[{{ $result['id'] }}][component]"
                                        value="{{ $result['component']['id'] }}">
                                    <input type="hidden"
                                        name="result[{{ $result['id'] }}][comment]"
                                        value="{{ $comment }}">
                                    <input type="text"

                                        name="result[{{ $result['id'] }}][result]"
                                        class="{{ \Str::slug($result['component']['name'].'-cbc') }} test_result form-control "
                                        value="{{ $result['result'] }}"
                                        data-component="{{ $result['component']['id'] }}"
                                        data-url="{{ route('admin.medical_report.get-comment') }}"
                                        @if (!empty($result->reference_range())) normal_from="{{ $result->reference_range()->normal_from }}"
                                        
                                normal_to="{{ $result->reference_range()->normal_to }}"
                                critical_high_from="{{ $result->reference_range()->critical_high_from }}"
                                critical_low_from="{{ $result->reference_range()->critical_low_from }}" @endif>

                                @if (isset($result->reference_range()->normal_from ))
                                        
                                <input type="hidden"
                                name="result[{{ $result['id'] }}][normal_from]"
                                value="{{ $result->reference_range()->normal_from }}"
                                >
                            @endif

                            @if (isset($result->reference_range()->normal_to))
                                
                                <input type="hidden"
                                name="result[{{ $result['id'] }}][normal_to]"
                                value="{{ $result->reference_range()->normal_to }}"
                                >
                            @endif

                            @if (isset($result->reference_range()->critical_high_from))
                                
                                <input type="hidden"
                                name="result[{{ $result['id'] }}][critical_high_from]"
                                value="{{ $result->reference_range()->critical_high_from }}"
                                >
                            @endif
                            @if (isset($result->reference_range()->critical_low_from ))
                                
                                <input type="hidden"
                                name="result[{{ $result['id'] }}][critical_low_from]"
                                value="{{ $result->reference_range()->critical_low_from }}"
                                >
                            @endif
                                @else
                                    <input type="hidden"
                                        name="result[{{ $result['id'] }}][comment]"
                                        value="{{ $comment }}">
                                    <select
                                        name="result[{{ $result['id'] }}][result]"
                                        class="form-control select_result test_result"
                                        @if (!empty($result->reference_range())) normal_from="{{ $result->reference_range()->normal_from }}"
                                    normal_to="{{ $result->reference_range()->normal_to }}"
                                    critical_high_from="{{ $result->reference_range()->critical_high_from }}"
                                    critical_low_from="{{ $result->reference_range()->critical_low_from }}" @endif>
                                        <option value=""
                                            value="" disabled
                                            selected>
                                            {{ __('Select result') }}
                                        </option>
                                        @foreach ($result['component']['options'] as $option)
                                            <option
                                                value="{{ $option['name'] }}"
                                                @if ($option['name'] == $result['result']) selected @endif>
                                                {{ $option['name'] }}
                                            </option>
                                        @endforeach
                                        <!-- Deleted option -->
                                        @if (!$result['component']['options']->contains('name', $result['result']))
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
                        </tr>
                @endif
            @endforeach
            </tbody>


        </table>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <tbody>
                <tr>
                    <td colspan="5">

                        <textarea name="comment" cols="30" rows="3" placeholder="{{ __('Comment') }}"
                            class="form-control comment ray_comment">{{ $test['comment'] }}</textarea>
                            <select id="select_comment_test_{{$test['id']}}" class="form-control select_comment">
                                <option value="" disabled selected>{{__('Select comment')}}</option>
                                @foreach($test['test']['comments'] as $comment)
                                    <option value="{{$comment['comment']}}">{{$comment['comment']}}</option>
                                @endforeach
                            </select>
                        <button type="button"
                            class="btn btn-primary btn-block btn-add-comment"
                            data-id="{{ $test['test']['id'] }}"
                            data-url="{{ route('admin.medical_report.add_comment') }}"
                            data-test-id="{{ $test['id'] }}">{{ __('Add comment') }}</button>
                        
                        
                    </td>
                </tr>
                
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5">
                        
                            <button class="btn btn-primary"
                                id=""><i
                                    class="fa fa-check"></i>
                                {{ __('Save') }}</button>
                            <div class="btn btn-dark float-right"
                                id="cbc_api"><i
                                    class="fa fa-check"></i>
                                {{ __('CBC') }}</div>
                        

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
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>