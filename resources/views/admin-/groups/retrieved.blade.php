@extends('layouts.app')

@section('title')
    {{__('Retrieved')}}
@endsection
@section('breadcrumb')

            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin.groups.index')}}">{{__('Invoices')}}</a></li>
            <li class="breadcrumb-item active">{{__('Retrieved')}}</li>

@endsection
@section('content')


    <div class="content-header row">
    </div>
    <div class="content-body">

        <section class="invoice-list-wrapper">
            <div class="card">


                <section id="advanced-search-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <hr class="my-0">
                                <div class="card-datatable px-2">
                                    <div id="DataTables_Table_2_wrapper" class="dataTables_wrapper dt-bootstrap4 table-responsive" style="width:100% !important;">
                                        <div class="d-flex justify-content-between align-items-center mx-0 row">
                                            <div class="col-sm-12 col-md-6"><div class="dataTables_length" id="DataTables_Table_2_length">
                                                </div>
                                            </div></div>
                                        <table class="table table-striped table-bordered" id="groups_retrieved_table" role="grid" aria-describedby="DataTables_Table_2_info" style="width:100% !important;">
                                            <thead>
                                            <tr role="row">
                                                <th class="sorting" tabindex="0" aria-controls="groups_table" rowspan="1" colspan="1" style="width: 138.688px;" aria-label="#: activate to sort column ascending">#</th>
                                                <th class="sorting" tabindex="0" aria-controls="groups_table" rowspan="1" colspan="1" style="width: 142.438px;" aria-label="Created By: activate to sort column ascending">{{ __('Created By') }}</th>
                                                <th class="sorting" tabindex="0" aria-controls="groups_table" rowspan="1" colspan="1" style="width: 116.594px;" aria-label="Patient Code: activate to sort column ascending">{{ __('Patient Code') }}</th>
                                                <th class="sorting" tabindex="0" aria-controls="groups_table" rowspan="1" colspan="1" style="width: 116.594px;" aria-label="Patient Code: activate to sort column ascending">{{ __('Patient Name') }}</th>
                                                <th class="sorting" tabindex="0" aria-controls="groups_table" rowspan="1" colspan="1" style="width: 163.906px;" aria-label="Subtotal: activate to sort column ascending">{{ __('Subtotal') }}</th>
                                                <th class="sorting" tabindex="0" aria-controls="groups_table" rowspan="1" colspan="1" style="width: 163.906px;" aria-label="Total: activate to sort column ascending">{{ __('Total') }}</th>
                                                <th class="sorting" tabindex="0" aria-controls="groups_table" rowspan="1" colspan="1" style="width: 163.906px;" aria-label="Paid: activate to sort column ascending">{{ __('Paid')}}</th>
                                                <th class="sorting" tabindex="0" aria-controls="groups_table" rowspan="1" colspan="1" style="width: 163.906px;" aria-label="Due: activate to sort column ascending">{{ __('Due') }}</th>
                                                <th class="sorting" tabindex="0" aria-controls="groups_table" rowspan="1" colspan="1" style="width: 163.906px;" aria-label="Delayed Money: activate to sort column ascending">{{ __('Delayed Money') }}</th>
                                                <th class="sorting" tabindex="0" aria-controls="groups_table" rowspan="1" colspan="1" style="width: 163.906px;" aria-label="Date: activate to sort column ascending">{{ __('Retrieved Date') }}</th>
                                                <th class="sorting" tabindex="0" aria-controls="groups_table" rowspan="1" colspan="1" style="width: 163.906px;" aria-label="Branch: activate to sort column ascending">{{ __('Branch') }}</th>
                                                <th class="sorting" tabindex="0" aria-controls="groups_table" rowspan="1" colspan="1" style="width: 163.906px;" aria-label="Branch: activate to sort column ascending">{{ __('Retrieved By') }}</th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>
                                                <th rowspan="1" colspan="1">#</th>
                                                <th rowspan="1" colspan="1">{{ __('Created By') }}</th>
                                                <th rowspan="1" colspan="1">{{ __('Patient Code') }}</th>
                                                <th rowspan="1" colspan="1">{{ __('Patient Name') }}</th>
                                                <th rowspan="1" colspan="1">{{ __('Subtotal') }}</th>
                                                <th rowspan="1" colspan="1">{{ __('Total') }}</th>
                                                <th rowspan="1" colspan="1">{{ __('Paid')}}</th>
                                                <th rowspan="1" colspan="1">{{ __('Due') }}</th>
                                                <th rowspan="1" colspan="1">{{ __('Delayed Money') }}</th>
                                                <th rowspan="1" colspan="1">{{ __('Retrieved Date') }}</th>
                                                <th rowspan="1" colspan="1">{{ __('Branch') }}</th>
                                                <th rowspan="1" colspan="1">{{ __('Retrieved By') }}</th>

                                            </tr>
                                            </tfoot>
                                            <tbody>
                                            <tr class="odd">
                                                <td valign="top" colspan="6" class="dataTables_empty">
                                                    Loading...
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </section>

    </div>


    <!-- /.card-body -->
    </div>

@endsection
@section('scripts')
    <script>
        var can_delete =
            @can('delete_group')
                true
        @else
            false
        @endcan;
        var can_view =
            @can('view_group')
                true
        @else
            false
        @endcan;
    </script>
    <script src="{{ url('js/admin/groups.js') }}"></script>
@endsection
