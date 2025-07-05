<div class="dropdown">
    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-cog"></i>
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        @can('edit_medical_report')
            <a class="dropdown-item" href="{{ route('admin.medical_reports.edit', $group['id']) }}">
                <i class="fa fa-flask" aria-hidden="true"></i>
                {{ __('Edit Report') }}
            </a>
        @endcan
        @can('sign_medical_report')
            <a class="dropdown-item" href="{{ route('admin.medical_reports.sign', $group['id']) }}">
                <i class="fas fa-signature" aria-hidden="true"></i>
                {{ __('Sign Report') }}
            </a>
        @endcan

        @can('view_medical_report')
            @if (isset($reports_settings['report_sign_stauts']) && $reports_settings['report_sign_stauts'] == true)
                <a class="dropdown-item"
                    href="{{ route('admin.medical_reports.print_report_with_header_action', $group['id']) }}"
                    target="_blank">
                    <i class="fa fa-print" aria-hidden="true"></i>
                    {{ __('Print') }}
                </a>

                <a class="dropdown-item"
                    href="{{ route('admin.medical_reports.print_report_without_header_action', $group['id']) }}"
                    target="_blank">
                    <i class="fa fa-print" aria-hidden="true"></i>
                    {{ __('Print_WithoutHeaders') }}
                </a>
            @else
                @if ($group['signed_by'] != null)
                    <a class="dropdown-item"
                        href="{{ route('admin.medical_reports.print_report_with_header_action', $group['id']) }}"
                        target="_blank">
                        <i class="fa fa-print" aria-hidden="true"></i>
                        {{ __('Print') }}
                    </a>

                    <a class="dropdown-item"
                        href="{{ route('admin.medical_reports.print_report_without_header_action', $group['id']) }}"
                        target="_blank">
                        <i class="fa fa-print" aria-hidden="true"></i>
                        {{ __('Print_WithoutHeaders') }}
                    </a>
                @endif
            @endif

        @endcan
        @can('edit_medical_report')
            <a style="cursor: pointer" data-toggle="modal" data-target="#print_barcode_modal{{ $group['id'] }}"
                class="dropdown-item print_barcode" group_id="{{ $group['id'] }}">
                <i class="fa fa-barcode" aria-hidden="true"></i>
                {{ __('Print_barcode_file') }}
            </a>

            <a style="cursor: pointer" data-toggle="modal" data-target="#print_barcode_file_modal{{ $group['id'] }}"
                class="dropdown-item print_barcode_file" group_id="{{ $group['id'] }}">
                <i class="fa fa-barcode" aria-hidden="true"></i>
                {{ __('Print barcode') }}
            </a>

            <a class="dropdown-item" href="{{ route('admin.medical_reports.show', $group['id']) }}">
                <i class="fa fa-eye" aria-hidden="true"></i>
                {{ __('Show') }}
            </a>
            @if ($whatsapp['report']['active'] && isset($group['report_pdf']) && $group['due'] == 0 && $group['signed_by'] != null)
                <a target="_blank" href="{{ route('admin.medical_report.get_whats_app_url', $group['id']) }}"
                    class="dropdown-item" target="_blank">
                    <i class="fab fa-whatsapp" aria-hidden="true" class="text-success"></i>
                    {{ __('Send receipt by WA') }}
                </a>
            @endif
            @if ($email['report']['active'] && isset($group['report_pdf']))
                <form action="{{ route('admin.medical_reports.send_report_mail', $group['id']) }}" method="POST"
                    class="d-inline">
                    @csrf
                    <button type="submit" class="dropdown-item">
                        <i class="fa fa-envelope" aria-hidden="true" class="text-success"></i>
                        {{ __('Send receipt by mail') }}
                    </button>
                </form>
            @endif
        @endcan

        @can('delete_group')
            <form method="POST" action="{{ route('admin.medical_reports.destroy', $group['id']) }}" class="d-inline">
                <input type="hidden" name="_method" value="delete">
                <a href="#" class="dropdown-item delete_medical_report">
                    <i class="fa fa-trash"></i>
                    {{ __('Delete') }}
                </a>
            </form>
        @endcan
    </div>
</div>

@php
    
    // get group by id
    $group = \App\Models\Group::find($group['id']);
    
@endphp

<div class="modal fade" id="print_barcode_modal{{ $group['id'] }}" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('Print barcode') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ route('admin.groups.print_barcode', $group['id']) }}" method="POST"
                id="print_barcode_form" target="_blank">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="number">{{ __('Number of samples') }}</label>
                                @php
                                    $sample_type_arr = [];
                                    $temp = [];
                                    
                                    foreach ($group->all_tests as $value) {
                                        if (isset($value->test->sample->parent)) {
                                            if (!in_array($value->test->sample->parent->id, $temp)) {
                                                $sample_type_arr[] = ['name' => $value->test->sample->parent->name, 'id' => $value->test->sample->parent->id];
                                                array_push($temp, $value->test->sample->parent->id);
                                            }
                                        }
                                    }
                                    foreach ($group->all_cultures as $value) {
                                        if (isset($value->culture->sample->parent)) {
                                            if (!in_array($value->culture->sample->parent->id, $sample_type_arr)) {
                                                $sample_type_arr[] = ['name' => $value->culture->sample->parent->name, 'id' => $value->culture->sample->parent->id];
                                                array_push($temp, $value->culture->sample->parent->id);
                                            }
                                        }
                                    }
                                @endphp

                                @foreach ($sample_type_arr as $item)
                                    <label for="number">{{ $item['name'] }}</label>
                                    <input type="number" id="number"
                                        name="sample_type_arr[{{ $item['id'] }}][number]"
                                        placeholder="{{ __('Number of samples') }}" class="form-control"
                                        value="1" min="0" required>
                                    <input type="hidden" id="number"
                                        name="sample_type_arr[{{ $item['id'] }}][name]"
                                        placeholder="{{ __('Number of samples') }}" class="form-control"
                                        value="{{ $item['name'] }}" min="0" required>
                                    <input type="hidden" id="number"
                                        name="sample_type_arr[{{ $item['id'] }}][id]"
                                        placeholder="{{ __('Number of samples') }}" class="form-control"
                                        value="{{ $item['id'] }}" min="0" required>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Print') }}</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade" id="print_barcode_file_modal{{ $group['id'] }}" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('Print barcode') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ route('admin.groups.print_barcode_file', $group['id']) }}" method="POST"
                id="print_barcode_form" target="_blank">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="number">{{ __('Number of samples') }}</label>
                                @php
                                    $sample_type_arr = [];
                                    $temp = [];
                                    foreach ($group->all_tests as $value) {
                                        if (isset($value->test->sample->parent->id)) {
                                            if (!in_array($value->test->sample->parent->id, $temp)) {
                                                $sample_type_arr[] = ['name' => $value->test->sample->parent->name, 'id' => $value->test->sample->parent->id];
                                                array_push($temp, $value->test->sample->parent->id);
                                            }
                                        }
                                    }
                                    foreach ($group->all_cultures as $value) {
                                        if (isset($value->culture->sample->parent->id)) {
                                            if (!in_array($value->culture->sample->parent->id, $sample_type_arr)) {
                                                $sample_type_arr[] = ['name' => $value->culture->sample->parent->name, 'id' => $value->culture->sample->parent->id];
                                                array_push($temp, $value->culture->sample->parent->id);
                                            }
                                        }
                                    }
                                @endphp

                                @foreach ($sample_type_arr as $item)
                                    <label for="number">{{ $item['name'] }}</label>
                                    <input type="number" id="number"
                                        name="sample_type_arr[{{ $item['id'] }}][number]"
                                        placeholder="{{ __('Number of samples') }}" class="form-control"
                                        value="1" min="0" required>
                                    <input type="hidden" id="number"
                                        name="sample_type_arr[{{ $item['id'] }}][name]"
                                        placeholder="{{ __('Number of samples') }}" class="form-control"
                                        value="{{ $item['name'] }}" min="0" required>
                                    <input type="hidden" id="number"
                                        name="sample_type_arr[{{ $item['id'] }}][id]"
                                        placeholder="{{ __('Number of samples') }}" class="form-control"
                                        value="{{ $item['id'] }}" min="0" required>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary">Print</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
