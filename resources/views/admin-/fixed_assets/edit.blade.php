@extends('layouts.app')

@section('title')
    {{ __('Fixed Assets') }}
@endsection

@section('breadcrumb')
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.fixed_assets.index') }}">{{ __('Fixed Assets') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('Fixed Assets') }}</li>
@endsection

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"></h3>
        </div>
        <!-- /.card-header -->
        <form method="POST" action="{{ route('admin.fixed_assets.update', $fixed_asset->id) }}" id="fixed_asset_form"
            enctype="multipart/form-data">
            <!-- /.card-header -->
            <div class="card-body">
                @csrf
                @method('put')
                @include('admin.fixed_assets._form')
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
            </div>
        </form>
        <!-- /.card-body -->
    </div>
@endsection
@section('scripts')
    <script src="{{ url('js/admin/fixed_assets.js') }}"></script>
    @cannot('bulk_action_patient')
        <script>
            // change button
            $('.check_ask').on('change', function() {

                if ($(this).is(':checked')) {
                    $(this).val(1);
                    // this checked
                    $(this).prop('checked', true);
                } else {
                    $(this).val(0);
                    // this unchecked
                    $(this).prop('checked', false);
                }
            });


            $(document).ready(function() {
                table.on('init', function() {
                    $(document).find('#bulk_action_section').remove();
                });
            });
        </script>
    @endcan
@endsection
