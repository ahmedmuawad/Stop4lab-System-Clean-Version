<div class="row">
    <div class="col-lg-3">
        <div class="form-group">
            <label for="">{{ __('Category') }}</label>
            <select name="category_id" class="form-control" id="category" required>
                @if (isset($test) && $test['category'])
                    <option value="{{ $test['category_id'] }}" selected>{{ $test['category']['name'] }}</option>
                @endif
            </select>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="name">{{ __('Name') }}</label>
            <input type="text" class="form-control" name="name" id="name"
                @if (isset($test)) value="{{ $test->name }}" @endif required>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="shortcut">{{ __('Shortcut') }}</label>
            <input type="text" class="form-control" name="shortcut" id="shortcut"
                @if (isset($test)) value="{{ $test->shortcut }}" @endif required>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="sample_type">{{ __('Sample Type') }}</label>
            <input type="text" class="form-control" name="sample_type" id="sample_type"
                @if (isset($test)) value="{{ $test->sample_type }}" @endif>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="sample_type_id">{{ __('Select Sample Type') }}</label>
            <select name="sample_type_id" class="form-control select2" id="sample_type_id">
                <option label=""></option>
                @if ($samplesTypes)
                    @foreach ($samplesTypes as $sample)
                        <option value="{{ $sample->id }}" @if (isset($test) && $sample->id == $test->sample_type_id) selected @endif>
                            {{ $sample->name }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    @if (auth()->guard('admin')->user()->lab_id == null)
        <div class="col-lg-3">
            <div class="form-group">
                <label for="price">{{ __('Price') }}</label>
                <div class="input-group form-group mb-3">
                    <input type="number" class="form-control" name="price" min="0" id="price"
                        @if (isset($test)) @if (isset($test_Price) && $test_Price != null) value="{{ $test_Price->price }}" 
                            @else 
                                value="{{ $test->price }}" @endif
                        @endif

                    required>
                    <div class="input-group-append">
                        <span class="input-group-text">
                            {{ get_currency() }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="form-group">
                <label for="num_day_receive">{{ __('Num Day Receive') }}</label>
                <div class="input-group form-group mb-3">
                    <input type="number" class="form-control" name="num_day_receive" min="0" step="1"
                        id="num_day_receive" value="{{ isset($test) ? $test->num_day_receive : 0 }}" required>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label for="num_hour_receive">{{ __('Num Hour Receive') }}</label>
                <div class="input-group form-group mb-3">
                    <input type="number" class="form-control" name="num_hour_receive" min="0" step="1"
                        id="num_hour_receive" value="{{ isset($test) ? $test->num_hour_receive : 1 }}" required>
                </div>
            </div>
        </div>
        {{-- <div class="col-lg-3">
       <div class="form-group">
            <label for="num_hour_receive">{{__('Min')}}</label>
            <div class="input-group form-group mb-3">
                <input type="number" class="form-control" name="min" value="{{isset($test) ? $test->min : 0 }}" required>
            </div>
       </div>
    </div>
    <div class="col-lg-3">
       <div class="form-group">
            <label for="num_hour_receive">{{__('Max')}}</label>
            <div class="input-group form-group mb-3">
                <input type="number" class="form-control" name="max" value="{{isset($test) ? $test->max : 1000 }}" required>
            </div>
       </div>
    </div> --}}
        <div class="col-lg-3">
            <div class="form-group">
                <label for="num_day_receive">{{ __('Lab To Lab Status') }}</label>
                <div class="input-group form-group mb-3">
                    <select name="lab_to_lab_status" class="form-control" id="lab_status">
                        <option value="0"
                            @if (isset($test)) @if ($test['lab_to_lab_status'] == 0) selected @endif
                            @endif>{{ __('IN') }}</option>
                        <option value="1"
                            @if (isset($test)) @if ($test['lab_to_lab_status'] == 1) selected @endif
                            @endif>{{ __('Out') }}</option>
                    </select>
                </div>
            </div>
        </div>

        <div
            class="col-lg-3 lab_cost @if (isset($test)) @if ($test['lab_to_lab_status'] == 0) d-none @else d-block @endif
@else
d-none  @endif">
            <div class="form-group">
                <label for="lab_to_lab_cost">{{ __('Lab To Lab Cost') }}</label>
                <div class="input-group form-group mb-3">
                    <input type="number" class="form-control" id="lab_to_lab_cost" name="lab_to_lab_cost"
                        @if (isset($test)) value="{{ $test['lab_to_lab_cost'] }}" @endif required>
                </div>
            </div>
        </div>
        <div
            class="col-lg-3 lab_out @if (isset($test)) @if ($test['lab_to_lab_status'] == 0) d-none @else d-block @endif
@else
d-none  @endif">
            <div class="form-group">
                <label for="lab_to_lab_cost">{{ __('Out Lab') }}</label>
                <div class="input-group form-group mb-3">
                    <select name="lab_out_id" class="form-control select2">
                        <option selected disabled>{{ __('Select Lab') }}</option>
                        @if (isset($labs_out))
                            @foreach ($labs_out as $lab)
                                <option @if (isset($test) && $test->lab_out_id == $lab->id) selected @endif
                                    value="{{ $lab->id }}">
                                    {{ $lab->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>
    @endif
    <div class="col-lg-12">
        <div class="form-group">
            <label for="precautions">{{ __('Precautions') }}</label>
            <textarea name="precautions" id="precautions" rows="3" class="form-control"
                placeholder="{{ __('Precautions') }}">
@if (isset($test)){{ $test['precautions'] }}@endif
</textarea>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="form-group">
            <label for="details">{{ __('Details') }}</label>
            <textarea name="details" id="details" rows="3" class="form-control" placeholder="{{ __('details') }}">
@if (isset($test)){{ $test['details'] }}@endif
</textarea>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            <label for="Decreased">{{ __('Decreased In') }}</label>
            <textarea name="decreased_in" id="Decreased" rows="3" class="form-control"
                placeholder="{{ __('Decreased In') }}">
@if (isset($test)){{ $test['decreased_in'] }}@endif
</textarea>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            <label for="Increased">{{ __('Increased In') }}</label>
            <textarea name="increased_in" id="Increased" rows="3" class="form-control"
                placeholder="{{ __('Increased In') }}">
@if (isset($test)){{ $test['increased_in'] }}@endif
</textarea>
        </div>
    </div>

    {{-- <div class="col-12">
        <div id="accordion">

            <div class="card card-info">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                    class="btn btn-primary mb-2 collapsed" aria-expanded="false">
                    <i class="fas fa-dollar-sign"></i> {{ __('Contract Price') }}
                </a>
                <div id="collapseOne" class="row pl-2 panel-collapse in collapse">
                    @foreach ($contracts as $key => $contract)
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="contract_id">{{ $contract->title }}</label>
                                <input type="hidden" class="form-control" name="contract_id[]" multiple
                                    id="contract_id" value="{{ $contract->id }}" required>

                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="price_contract">{{ __('Price') }}</label>
                                <div class="input-group form-group mb-3">
                                    <input type="number" class="form-control" name="price_contract[]" multiple
                                        min="1" step="1" id="price_contract"
                                        value="{{ isset($test) ? $test->contract_prices[$key]['price'] : 1 }}"
                                        required>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div> --}}


</div>
<br>
<div class="row">
    <div class="col-lg-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">{{ __('Test Components') }}</h3>
                <ul class="list-style-none">
                    <li class="d-inline float-right">
                        <button type="button" class="btn btn-primary btn-sm add_component">
                            <i class="fa fa-plus"></i>
                            {{ __('Component') }}
                        </button>
                    </li>
                    <li class="d-inline float-right mr-1">
                        <button type="button" class="btn btn-primary btn-sm  add_title">
                            <i class="fa fa-plus"></i>
                            {{ __('Title') }}
                        </button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 table-responsive">
                        <table class="table table-striped table-bordered components">
                            <thead>
                                <th width="2%"></th>
                                <th class="text-center name">{{ __('Name') }}</th>
                                <th class="text-center unit">{{ __('Unit') }}</th>
                                <th class="text-center result">{{ __('Result') }}</th>
                                <th class="text-center reference_ranges">{{ __('Reference Range') }}</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                {{--  <th class="text-center separated">{{__('Separated')}}</th>
                                <th class="text-center status">{{__('Status')}}</th>
                                <th class="text-center " width="20px">{{__('Min')}}</th>
                                <th class="text-center " width="20px">{{__('Max')}}</th>
                                <th width="10px"></th>  --}}
                            </thead>
                            <tbody class="items">
                                @php
                                    $count = 0;
                                    $count_reference_ranges = 0;
                                    $count_comments = 0;
                                    $question_count = 0;
                                @endphp
                                @if (isset($test))
                                    @foreach ($test['components'] as $component)
                                        @php
                                            $count++;
                                        @endphp
                                        <tr num="{{ $count }}" test_id="{{ $component['id'] }}">
                                            <td  style="vertical-align: top;">
                                                <input type="number" name="component[{{ $count }}][sort]"
                                                    value="{{ ($component['sort'] == 0) ? $loop->iteration : $component['sort']}}" style="width: 50px !important">
                                            </td>
                                            @if ($component['title'])
                                                <td colspan="6">
                                                    <div class="form-group">
                                                        <input type="hidden"
                                                            name="component[{{ $count }}][title]"
                                                            value="true">
                                                        <input type="hidden"
                                                            name="component[{{ $count }}][id]"
                                                            value="{{ $component['id'] }}">
                                                        {{ $component['id'] }}
                                                        <input type="text" class="form-control"
                                                            name="component[{{ $count }}][name]"
                                                            placeholder="{{ __('Name') }}"
                                                            value="{{ $component['name'] }}" required>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger delete_row">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                            @else
                                                <td style="vertical-align: top !important;">
                                                    <div class="form-group">
                                                        <input type="hidden"
                                                            name="component[{{ $count }}][id]"
                                                            value="{{ $component['id'] }}">
                                                        {{ $component['id'] }}
                                                        <input type="text" class="form-control"
                                                            name="component[{{ $count }}][name]"
                                                            placeholder="{{ __('Name') }}"
                                                            value="{{ $component['name'] }}" required
                                                            style="width: 120px !important">
                                                    </div>
                                                </td>
                                                <td style="vertical-align: top !important;">
                                                    <div class="form-group">
                                                        <input type="text" style="width: 60px !important" class="form-control"
                                                            name="component[{{ $count }}][unit]"
                                                            placeholder="{{ __('Unit') }}"
                                                            value="{{ $component['unit'] }}">
                                                    </div>
                                                </td>
                                                <td style="vertical-align: top !important;">
                                                    <ul class="p-0 list-style-none">
                                                        <li>
                                                            <input class="select_type" value="text" type="radio"
                                                                name="component[{{ $count }}][type]"
                                                                id="text_{{ $count }}"
                                                                @if ($component['type'] == 'text') checked @endif
                                                                required> <label
                                                                for="text_{{ $count }}">{{ __('Text') }}</label>
                                                        </li>
                                                        <li>
                                                            <input class="select_type" value="select" type="radio"
                                                                name="component[{{ $count }}][type]"
                                                                id="select_{{ $count }}"
                                                                @if ($component['type'] == 'select') checked @endif
                                                                required> <label
                                                                for="select_{{ $count }}">{{ __('Select') }}</label>
                                                        </li>
                                                        <li>
                                                            <input class="select_type" value="multy" type="radio"
                                                                name="component[{{ $count }}][type]"
                                                                id="select_{{ $count }}"
                                                                @if ($component['type'] == 'multy') checked @endif
                                                                required> <label
                                                                for="select_{{ $count }}">{{ __('Multiple') }}</label>
                                                        </li>
                                                    </ul>
                                                    <div class="options">
                                                        @if ($component['type'] == 'select')
                                                            <table width="600">
                                                                <thead>
                                                                    <tr>
                                                                        <th>{{ __('Option') }}</th>
                                                                        <th>{{ __('Gender') }}</th>
                                                                        <th>{{ __('Stauts') }}</th>
                                                                        <th width="10px" class="text-center">
                                                                            <button type="button"
                                                                                class="btn btn-primary btn-sm add_option">
                                                                                <i class="fa fa-plus"></i>
                                                                            </button>
                                                                        </th>
                                                                    </tr>
                                                                    </head>
                                                                <tbody>
                                                                    @foreach ($component['options'] as $option)
                                                                        <tr option_id="{{ $option['id'] }}">
                                                                            <td>
                                                                                <input type="text"
                                                                                    name="component[{{ $count }}][old_options][{{ $option['id'] }}][name]"
                                                                                    value="{{ $option['name'] }}"
                                                                                    class="form-control" required>
                                                                            </td>
                                                                            <td>
                                                                                <select class="form-control"
                                                                                    name="component[{{ $count }}][old_options][{{ $option['id'] }}][gender]"
                                                                                    required>
                                                                                    <option value="both"
                                                                                        @if ($option['gender'] == 'both') selected @endif>
                                                                                        {{ __('Both') }}</option>
                                                                                    <option value="male"
                                                                                        @if ($option['gender'] == 'male') selected @endif>
                                                                                        {{ __('Male') }}</option>
                                                                                    <option value="female"
                                                                                        @if ($option['gender'] == 'female') selected @endif>
                                                                                        {{ __('Female') }}</option>
                                                                                    <option value="pregnant"
                                                                                        @if ($option['gender'] == 'pregnant') selected @endif>
                                                                                        {{ __('Pregnant') }}</option>
                                                                                </select>
                                                                            </td>
                                                                            <td>
                                                                                <select class="form-control"
                                                                                    name="component[{{ $count }}][old_options][{{ $option['id'] }}][status]"
                                                                                    id="">
                                                                                    <option></option>
                                                                                    <option
                                                                                        @if ($option['status'] == 'Abnormal') selected @endif
                                                                                        value="Abnormal">Abnormal
                                                                                    </option>
                                                                                    <option
                                                                                        @if ($option['status'] == 'Normal') selected @endif
                                                                                        value="Normal">Normal</option>
                                                                                    <option
                                                                                        @if ($option['status'] == 'Panic') selected @endif
                                                                                        value="Panic">Panic</option>
                                                                                </select>

                                                                            </td>
                                                                            <td>
                                                                                <button type="button"
                                                                                    class="btn btn-danger btn-sm text-center delete_option">
                                                                                    <i class="fa fa-trash"></i>
                                                                                </button>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        @elseif($component['type'] == 'multy')
                                                            <table width="600">
                                                                <thead>
                                                                    <tr>
                                                                        <th>{{ __('Option') }}</th>
                                                                        <th width="10px" class="text-center">
                                                                            <button type="button"
                                                                                class="btn btn-primary btn-sm add_one_option">
                                                                                <i class="fa fa-plus"></i>
                                                                            </button>
                                                                        </th>
                                                                    </tr>
                                                                    </head>
                                                                <tbody>
                                                                    @foreach ($component['options'] as $option)
                                                                        <tr option_id="{{ $option['id'] }}">
                                                                            <td>
                                                                                <input type="text"
                                                                                    name="component[{{ $count }}][old_options][{{ $option['id'] }}][name]"
                                                                                    value="{{ $option['name'] }}"
                                                                                    class="form-control" required>
                                                                                <input type="hidden"
                                                                                    name="component[{{ $count }}][old_options][{{ $option['id'] }}][status]"
                                                                                    class="form-control">
                                                                                <input type="hidden"
                                                                                    name="component[{{ $count }}][old_options][{{ $option['id'] }}][gender]"
                                                                                    class="form-control">
                                                                            </td>
                                                                            <td>
                                                                                <button type="button"
                                                                                    class="btn btn-danger btn-sm text-center delete_option">
                                                                                    <i class="fa fa-trash"></i>
                                                                                </button>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                            <table width="100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>{{ __('Option') }} 2 </th>
                                                                        <th>{{ __('Gender') }}</th>
                                                                        <th>{{ __('Status') }} </th>
                                                                        <th width="10px" class="text-center">
                                                                            <button type="button"
                                                                                class="btn btn-primary btn-sm add_option2">
                                                                                <i class="fa fa-plus"></i>
                                                                            </button>
                                                                        </th>
                                                                    </tr>
                                                                    </head>
                                                                <tbody>
                                                                    @if (isset($component['options_additional']))
                                                                        @foreach ($component['options_additional'] as $option)
                                                                            <tr option_id="{{ $option['id'] }}">
                                                                                <td>
                                                                                    <input type="text"
                                                                                        name="component[{{ $count }}][old_options_additional][{{ $option['id'] }}][name]"
                                                                                        value="{{ $option['name'] }}"
                                                                                        class="form-control" required>
                                                                                </td>
                                                                                <td>
                                                                                    <select class="form-control"
                                                                                        name="component[{{ $count }}][old_options_additional][{{ $option['id'] }}][gender]"
                                                                                        required>
                                                                                        <option value="both"
                                                                                            @if ($option['gender'] == 'both') selected @endif>
                                                                                            {{ __('Both') }}
                                                                                        </option>
                                                                                        <option value="male"
                                                                                            @if ($option['gender'] == 'male') selected @endif>
                                                                                            {{ __('Male') }}
                                                                                        </option>
                                                                                        <option value="female"
                                                                                            @if ($option['gender'] == 'female') selected @endif>
                                                                                            {{ __('Female') }}
                                                                                        </option>
                                                                                        <option value="pregnant"
                                                                                            @if ($option['gender'] == 'pregnant') selected @endif>
                                                                                            {{ __('Pregnant') }}
                                                                                        </option>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <select class="form-control"
                                                                                        name="component[{{ $count }}][old_options_additional][{{ $option['id'] }}][status]"
                                                                                        id="">
                                                                                        <option></option>
                                                                                        <option
                                                                                            @if ($option['status'] == 'Abnormal') selected @endif
                                                                                            value="Abnormal">Abnormal
                                                                                        </option>
                                                                                        <option
                                                                                            @if ($option['status'] == 'Normal') selected @endif
                                                                                            value="Normal">Normal
                                                                                        </option>
                                                                                        <option
                                                                                            @if ($option['status'] == 'Panic') selected @endif
                                                                                            value="Panic">Panic
                                                                                        </option>
                                                                                    </select>

                                                                                </td>
                                                                                <td>
                                                                                    <button type="button"
                                                                                        class="btn btn-danger btn-sm text-center delete_option">
                                                                                        <i class="fa fa-trash"></i>
                                                                                    </button>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td colspan="7">
                                                    <table class="table table-bordered reference_range">
                                                        <thead>
                                                            <tr>
                                                                <th class="gender text-center" style="width: 18%">
                                                                    {{ __('Gender') }}</th>
                                                                <th class="age_unit text-center" style="width: 18%">
                                                                    {{ __('Age unit') }}</th>
                                                                <th class="age_from text-center" style="width: 13%">
                                                                    {{ __('Age') }}</th>
                                                                <th class="age text-center">{{ __('C-low') }}</th>
                                                                <th class="age text-center">{{ __('Normal') }}</th>
                                                                <th class="age text-center">{{ __('C-high') }}</th>
                                                                <th width="10px">
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-primary add_range">
                                                                        <i class="fa fa-plus"></i>
                                                                    </button>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            {{-- {{$component->reference_ranges }} --}}
                                                            @foreach ($component->reference_ranges as $reference_range)
                                                                {{-- {{$component[{{ $count }}][reference_ranges][{{ $reference_range->id }}]}} --}}
                                                                @php $count_reference_ranges++ @endphp
                                                                <tr>
                                                                    <td class="text-center">
                                                                        <select class="form-control"
                                                                            name="component[{{ $count }}][reference_ranges][{{ $reference_range->id }}][gender]"
                                                                            required>
                                                                            <option value="both"
                                                                                @if ($reference_range['gender'] == 'both') selected @endif>
                                                                                {{ __('Both') }}</option>
                                                                            <option value="male"
                                                                                @if ($reference_range['gender'] == 'male') selected @endif>
                                                                                {{ __('Male') }}</option>
                                                                            <option value="female"
                                                                                @if ($reference_range['gender'] == 'female') selected @endif>
                                                                                {{ __('Female') }}</option>
                                                                            <option value="pregnant"
                                                                                @if ($reference_range['gender'] == 'pregnant') selected @endif>
                                                                                {{ __('Pregnant') }}</option>
                                                                        </select>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <select class="form-control"
                                                                            name="component[{{ $count }}][reference_ranges][{{ $reference_range->id }}][age_unit]"
                                                                            required>
                                                                            <option value="day"
                                                                                @if ($reference_range['age_unit'] == 'day') selected @endif>
                                                                                {{ __('Days') }}</option>
                                                                            <option value="month"
                                                                                @if ($reference_range['age_unit'] == 'month') selected @endif>
                                                                                {{ __('Months') }}</option>
                                                                            <option value="year"
                                                                                @if ($reference_range['age_unit'] == 'year') selected @endif>
                                                                                {{ __('Years') }}</option>
                                                                        </select>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="number"
                                                                            name="component[{{ $count }}][reference_ranges][{{ $reference_range->id }}][age_from]"
                                                                            class="form-control"
                                                                            value="{{ $reference_range['age_from'] }}"
                                                                            required>:
                                                                        <input type="number"
                                                                            name="component[{{ $count }}][reference_ranges][{{ $reference_range->id }}][age_to]"
                                                                            class="form-control"
                                                                            value="{{ $reference_range['age_to'] }}"
                                                                            required>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text"
                                                                            name="component[{{ $count }}][reference_ranges][{{ $reference_range->id }}][critical_low_from]"
                                                                            class="form-control"
                                                                            value="{{ $reference_range['critical_low_from'] }}">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text"
                                                                            name="component[{{ $count }}][reference_ranges][{{ $reference_range->id }}][normal_from]"
                                                                            class="form-control"
                                                                            value="{{ $reference_range['normal_from'] }}">:
                                                                        <input type="text"
                                                                            name="component[{{ $count }}][reference_ranges][{{ $reference_range->id }}][normal_to]"
                                                                            class="form-control"
                                                                            value="{{ $reference_range['normal_to'] }}">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text"
                                                                            name="component[{{ $count }}][reference_ranges][{{ $reference_range->id }}][critical_high_from]"
                                                                            class="form-control"
                                                                            value="{{ $reference_range['critical_high_from'] }}">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <button type="button"
                                                                            class="btn btn-sm btn-danger delete_range">
                                                                            <i class="fa fa-times"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="6">
                                                                        <textarea name="component[{{ $count }}][reference_ranges][{{ $reference_range->id }}][comment]"
                                                                            style="width: 100%" rows="2">{{ $reference_range->comment }}</textarea>
                                                                    </td>
                                                                    <td colspan="2">
                                                                        <label
                                                                            for="">{{ __('Show') }}</label>
                                                                        <input
                                                                            name="component[{{ $count }}][reference_ranges][{{ $reference_range->id }}][show_status]"
                                                                            type="checkbox" value="1"
                                                                            @if ($reference_range->show_status == '1') checked @endif />
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                    <div class="form-group">
                                                        <textarea class="form-control" name="component[{{ $count }}][reference_range]"
                                                            placeholder="{{ __('Reference Range') }}">
                                                            {{-- @if (!empty($component->reference_ranges[0]))
                                                                {!!$component->reference_range !!}
                                                            
                                                            @endif --}}

                                                            {!! $component->reference_range !!}

                                                            </textarea>
                                                    </div>
                                                </td>


                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" placeholder="{{__('defult value')}}" name="component[{{ $count }}][default]" 
                                                    
                                                    value="{{$component->default}}"
                                                    style="width:170px !important">
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <label>Separated </label><input class="check_separated"
                                                    num="{{ $count }}" type="checkbox"
                                                    name="component[{{ $count }}][separated]"
                                                    @if ($component['separated']) checked @endif>
                                                <div class="component_price">
                                                    @if ($component['separated'])
                                                        <div class="card card-primary card-outline">
                                                            <div class="card-header">
                                                                <h5 class="card-title">
                                                                    {{ __('Price') }}
                                                                </h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="input-group form-group mb-3">
                                                                    <input type="number" class="form-control"
                                                                        name="component[{{ $count }}][price]"
                                                                        value="{{ $component['price'] }}"
                                                                        min="0" class="price" required>
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text">
                                                                            {{ get_currency() }}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <label>Status </label> <input type="checkbox"
                                                    name="component[{{ $count }}][status]"
                                                    @if ($component['status']) checked @endif>
                                            </td>
                                            <td class="text-center">
                                                <input type="number" name="component[{{ $count }}][min]"
                                                    value="{{ isset($component) ? $component->min : 0 }}" required>
                                            </td>
                                            <td class="text-center">
                                                <input type="number" name="component[{{ $count }}][max]"
                                                    value="{{ isset($component) ? $component->max : 1000 }}"
                                                    required>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger delete_row_component">
                                                    <i class="fa fa-trash"> {{ __('Delete Component') }}</i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endif
                                    </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <ul class="list-style-none">
                    <li class="d-inline float-right">
                        <button type="button" class="btn btn-primary btn-sm add_component">
                            <i class="fa fa-plus"></i>
                            {{ __('Component') }}
                        </button>
                    </li>
                    <li class="d-inline float-right mr-1">
                        <button type="button" class="btn btn-primary btn-sm  add_title">
                            <i class="fa fa-plus"></i>
                            {{ __('Title') }}
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card card-primary">
            <div class="card-header">
                <h5 class="card-title">
                    {{ __('Result comments') }}
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 table-responsive">
                        <table class="table table-striped table-bordered" id="comments_table">
                            <thead>
                                <tr>
                                    <th>{{ __('Comment') }}</th>
                                    <th width="10px">
                                        <button type="button" class="btn btn-primary float-right add_comment">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($test))
                                    @foreach ($test['comments'] as $comment)
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <textarea class="ray_comment" name="comments[{{ $count_comments }}]" class="form-control" id=""
                                                        cols="30" rows="3" required>{{ $comment['comment'] }}</textarea>
                                                </div>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm delete_comment">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @php
                                            $count_comments++;
                                        @endphp
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>{{ __('Comment') }}</th>
                                    <th width="10px">
                                        <button type="button" class="btn btn-primary float-right add_comment">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" name="" id="count" value="{{ $count }}">
<input type="hidden" name="" id="count_reference_ranges" value="{{ $count_reference_ranges }}">
<input type="hidden" name="" id="count_comments" value="{{ $count_comments }}">
<input type="hidden" name="" id="question_count" value="{{ $question_count }}">


@php
    $consumption_count = 0;
@endphp
<div class="row">
    <div class="col-lg-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h5 class="card-title">
                    {{ __('Consumptions') }}
                </h5>
                <button type="button" class="btn btn-primary float-right add_consumption">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>{{ __('Product') }}</th>
                            <th width="100px">{{ __('Quantity') }}</th>
                            <th width="10px"></th>
                        </tr>
                    </thead>
                    <tbody class="test_consumptions">
                        @if (isset($test))
                            @foreach ($test['consumptions'] as $consumption)
                                @php
                                    $consumption_count++;
                                @endphp
                                <tr class="consumption_row">
                                    <td>
                                        <div class="form-group">
                                            <select class="form-control product_id"
                                                id="consumption_product_{{ $consumption_count }}"
                                                name="consumptions[{{ $consumption_count }}][product_id]" required>
                                                <option value="{{ $consumption['product_id'] }}" selected>
                                                    {{ $consumption['product'] ? $consumption['product']['name'] : '' }}
                                                </option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="number" class="form-control"
                                                name="consumptions[{{ $consumption_count }}][quantity]"
                                                placeholder="{{ __('Quantity') }}"
                                                value="{{ $consumption['quantity'] }}" required>
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger delete_consumption">
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

<input type="hidden" id="consumption_count" value="{{ $consumption_count }}">



@php
    $question_count = 0;
@endphp
<div class="row">
    <div class="col-lg-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h5 class="card-title">
                    {{ __('Questions') }}
                </h5>
                <button type="button" class="btn btn-primary float-right add_question">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 table-responsive">
                        <table class="table table-striped table-bordered" id="questions_table">
                            <thead>
                                <tr>
                                    <th>{{ __('question') }}</th>
                                    <th width="10px">
                                        <button type="button" class="btn btn-primary float-right add_question">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($test))
                                    @foreach ($test['questions'] as $question)
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <textarea name="questions[{{ $question_count }}]" class="form-control" id="" cols="30"
                                                        rows="3" required>{{ $question['question'] }}</textarea>
                                                </div>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm delete_question">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @php
                                            $question_count++;
                                        @endphp
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>{{ __('question') }}</th>
                                    <th width="10px">
                                        <button type="button" class="btn btn-primary float-right add_question">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- start setting for seved test --}}
@if (isset($test))
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="card-title">
                        {{ __('Report Setting') }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 table-responsive">
                            <table class="table table-striped table-bordered" id="settings_table">
                                <tbody>
                                    <a style="cursor: pointer" data-toggle="modal"
                                        data-target="#setting_modal{{ $test['id'] }}"
                                        class="dropdown-item print_barcode">

                                        {{ __('Setting') }}
                                    </a>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
{{-- end setting for seved test --}}
