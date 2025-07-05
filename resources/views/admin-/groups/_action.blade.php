<div class="dropdown">
    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-cog"></i>
    </button>

    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

        @if ($group['due_for_patient'] > 0 || $group['due'] < 0)
            <a href="{{ route('admin.paid_due', $group['id']) }}" class="dropdown-item">
                <i class="fa fa-edit"></i>
                @if ($group['due_for_patient'] > 0)
                    {{ __('Paid Due') . $group['due_for_patient'] . ' ' . get_currency() }}
                @else
                    {{ __('Paid Due') . $group['due'] . ' ' . get_currency() }}
                @endif
            </a>
        @endif
        @can('edit_group')
            @if ($group->rays->isNotEmpty())
                <a href="{{ route('admin.ray_groups.edit', $group['id']) }}" class="dropdown-item">
                    <i class="fa fa-edit"></i>
                    {{ __('Edit') }}
                </a>
            @else
                <a href="{{ route('admin.groups.edit', $group['id']) }}" class="dropdown-item">
                    <i class="fa fa-edit"></i>
                    {{ __('Edit') }}
                </a>
            @endif
        @endcan

        @can('create_group')
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

            <a href="{{ route('admin.groups.working_paper', $group['id']) }}" class="dropdown-item">
                <i class="fas fa-file-word" aria-hidden="true"></i>
                {{ __('Working paper') }}
            </a>

            <a href="{{ route('admin.groups.show', $group['id']) }}" class="dropdown-item">
                <i class="fa fa-eye" aria-hidden="true"></i>
                {{ __('Show receipt') }}
            </a>
            @if ($email['receipt']['active'] && isset($group['receipt_pdf']))
                <form action="{{ route('admin.groups.send_receipt_mail', $group['id']) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="dropdown-item">
                        <i class="fa fa-envelope" aria-hidden="true" class="text-success"></i>
                        {{ __('Send receipt by mail') }}
                    </button>
                </form>
            @endif
        @endcan

        @can('edit_medical_report')
            <a href="{{ route('admin.medical_reports.edit', $group['id']) }}" class="dropdown-item">
                <i class="fa fa-flag"></i>
                {{ __('Enter report') }}
            </a>
        @endcan

        @can('edit_medical_report')
            @if (setting('portal') != null)
                <a href="{{ route('admin.invoice.sendInvoice', $group['id']) }}" class="dropdown-item">
                    {{-- <i class="fa fa-flag"></i> --}}
                    <i class="fa fa-file-invoice-dollar"></i>
                    {{ __('Send To Portal') }}
                </a>
            @endif
        @endcan


        @can('delete_group')
            <form method="POST" action="{{ route('admin.groups.destroy', $group['id']) }}" class="d-inline">
                <input type="hidden" name="_method" value="delete">
                <a href="#" class="dropdown-item delete_group">
                    <i class="fa fa-trash"></i>
                    {{ __('Delete') }}
                </a>
            </form>
        @endcan

        @can('edit_medical_report')
            <a href="#" data-toggle="modal" data-target="#exampleModalCenter{{ $group['id'] }}"
                class="dropdown-item">
                <i class="fa fa-check"></i>
                {{ __('Check Test') }}
            </a>
        @endcan

        <a href="{{ $group['receipt_pdf'] }}" class="dropdown-item" target="_blank">
            <i class="fa fa-print" aria-hidden="true"></i>
            {{ __('Print receipt') }}
        </a>
        <a href="{{ url('uploads/pdf_/receipt_2_') . $group['id'] }}.pdf" class="dropdown-item" target="_blank">
            <i class="fa fa-print" aria-hidden="true"></i>
            {{ __('Print receipt A4') }}
        </a>
        @if ($whatsapp['receipt']['active'] && isset($group['receipt_pdf']))
            <a target="_blank" href="{{ whatsapp_notification($group, 'receipt') }}" class="dropdown-item">
                <i class="fab fa-whatsapp" aria-hidden="true" class="text-success"></i>
                {{ __('Send receipt by WA') }}
            </a>
        @endif

        @can('create_group')
            <a href="{{ route('admin.cycle', $group['id']) }}" class="dropdown-item">
                <i class="fa fa-recycle"></i>
                {{ __('Cycle') }}
            </a>
        @endcan
    </div>
</div>

@php
    
    // get group by id
    $group = \App\Models\Group::find($group['id']);
    
@endphp

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter{{ $group['id'] }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:1050px !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Check Test') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.group.check.test', $group['id']) }}" method="post">
                    @csrf()
                    @foreach ($group->all_tests as $test)
                        <div class="form-group">
                            <div class="row">
                                <div class="col-6">
                                    <label for="">{{ $test->test->name }}</label>
                                    <input type="hidden" class="form-control" name="test_id[]"
                                        value="{{ $test->id }}">
                                    <input type="checkbox" class="form-control check-test"
                                        {{ $test->check_test == 1 ? 'checked' : '' }} name=""
                                        value="{{ $test->id }}">
                                    <input type="hidden" class="form-control check_test" name="check_test[]"
                                        value="{{ $test->check_test == 1 ? $test->id : '' }}">
                                </div>
                                <div class="col-2">
                                    <label for="">{{ __('Rejected') }}</label>
                                    <input type="checkbox" class="form-control sample_status"
                                        {{ $test->sample_status == 1 ? 'checked' : '' }}
                                        name="sample_status_test[{{ $test['id'] }}]" value="1">
                                    {{-- <input type="hidden" class="form-control check_test" name="check_test[]" value="{{ $test->check_test == 1 ? $test->id : '' }}">  --}}
                                </div>
                                <div class="col-4 ">
                                    <input type="text" class="form-control"
                                        name="sample_status_notes_test[{{ $test['id'] }}]"
                                        placeholder="{{ __('Reason of rejection') }}"
                                        value="{{ $test->sample_status_notes }}">
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @foreach ($group->all_cultures as $culture)
                        <div class="form-group">
                            <div class="row">
                                <div class="col-6">
                                    <label for="">{{ $culture->culture->name }}</label>
                                    <input type="hidden" class="form-control" name="culture_id[]"
                                        value="{{ $culture->id }}">
                                    <input type="checkbox" class="form-control check-test"
                                        {{ $culture->check_test == 1 ? 'checked' : '' }} name=""
                                        value="{{ $culture->id }}">
                                    <input type="hidden" class="form-control check_test" name="check_test[]"
                                        value="{{ $culture->check_test == 1 ? $culture->id : '' }}">
                                </div>
                                <div class="col-2">
                                    <label for="">{{ __('Rejected') }}</label>
                                    <input type="checkbox" class="form-control sample_status"
                                        {{ $culture->sample_status == 1 ? 'checked' : '' }}
                                        name="sample_status_culture[{{ $culture['id'] }}]" value="1">
                                    {{-- <input type="hidden" class="form-control check_test" name="check_test[]" value="{{ $test->check_test == 1 ? $test->id : '' }}">  --}}
                                </div>
                                <div class="col-4 ">
                                    <input type="text" class="form-control"
                                        name="sample_status_notes_culture[{{ $culture['id'] }}]"
                                        placeholder="{{ __('Reason of rejection') }}"
                                        value="{{ $culture->sample_status_notes }}">
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ __('Close') }}</button>
                        <button class="btn btn-primary">{{ __('Save') }}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
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