@extends('layouts.app')

@section('title')
    {{ __('Edit patient') }}
@endsection

@section('content')
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Edit patient') }}</h3>
                </div>
                <!-- /.card-header -->
                <form method="POST" action="{{ route('admin.patients.update', $patient->id) }}" id="patient_form"
                    enctype="multipart/form-data">
                    <!-- /.card-header -->
                    <div class="card-body">
                        @csrf
                        @method('put')
                        @include('admin.patients._form')
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
            <script src="{{ url('js/admin/patients.js') }}"></script>
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
