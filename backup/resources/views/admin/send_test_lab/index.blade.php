@extends('layouts.app')



@section('title')

    {{ __('Medical reports') }}

@endsection



@section('breadcrumb')
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('Medical reports') }}</li>
@endsection



@section('content')





    <div class="card card-primary card-outline">

        <div class="card-header">

            <h3 class="card-title">{{ __('Medical reports table') }}</h3>

        </div>

        <!-- /.card-header -->
    <form action="{{ route('admin.send_test_submit') }}" method="POST">
        <div class="card-body">

            @csrf
            <div class="row">

                <div class="col-lg-12 table-responsive">

                    <table id="send_lab_table" class="table table-striped table-bordered table-sm" width="100%">

                        <thead>

                            <tr>

                                <th width="10px">#</th>

                                <th width="10px">الفرع</th>

                                <th width="10px">{{ __('Created By') }}</th>

                                <th width="10px">{{ __('Contract') }}</th>

                                <th width="10px">{{ __('Barcode') }}</th>

                                <th width="100px">{{ __('Patient Code') }}</th>

                                <th>{{ __('Patient Name') }}</th>

                                <th width="50px">{{ __('Gender') }}</th>

                                <th width="50px">{{ __('Age') }}</th>

                                <th width="50px">{{ __('Phone') }}</th>

                                <th width="300px">{{ __('Tests') }}</th>

                                <th width="50px">{{ __('Test Cost') }}</th>

                                <th width="50px">{{ __('Send Status') }}</th>

                                <th width="50px">{{ __('Send Date') }}</th>

                                <th width="50px">{{ __('Send To') }}</th>

                                <th width="100px">{{ __('Date') }}</th>

                                <th class="text-center" width="10px">{{ __('Done') }}</th>

                                <th class="text-center" width="10px">{{ __('Signed') }}</th>

                                <th class="text-center" width="10px">{{ __('Signed By') }}</th>

                                <th width="50px">{{ __('Notes') }}</th>

                            </tr>

                        </thead>

                        <tbody>



                        </tbody>

                    </table>

                </div>

            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary save_contract">
                <i class="fa fa-check"></i> {{__('Save')}}
                </button>
            </div>
        </div>
    </form>
        <!-- /.card-body -->

    </div>



@endsection

@section('scripts')
<script>

    var can_delete =

        @can('delete_medical_report')

            true

        @else

            false

        @endcan ;
</script>
<script src="{{ url('js/admin/send_to_lab.js') }}"></script>
{{-- @if($type == 'all')
    <script src="{{ url('js/admin/medical_reports.js') }}"></script>
@elseif($type == 'done')
    <script src="{{ url('js/admin/medical_reports_done.js') }}"></script>
@elseif($type == 'pending')
    <script src="{{ url('js/admin/medical_reports_pending.js') }}"></script>
@elseif($type == 'unsigned')
    <script src="{{ url('js/admin/medical_reports_unsigned.js') }}"></script>
@endif --}}



@endsection

