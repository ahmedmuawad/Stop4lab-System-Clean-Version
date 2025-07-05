@extends('layouts.app')

@section('title')
    {{ __('Create invoice') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.groups.index') }}">{{ __('Invoices') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Patient Registeration') }}</li>
@endsection
@section('content')
    <!-- Form -->
    <form action="{{ route('admin.groups.store') }}" enctype="multipart/form-data" method="POST" id="group_form">
        @csrf
        {{-- ================== Task : test_sample ================== --}}
        @include('admin.groups._form')
    </form>
    <!-- \Form -->

    <!-- Models -->
    @include('admin.groups.modals.patient_modal')
    @include('admin.groups.modals.edit_patient_modal')
    @include('admin.groups.modals.doctor_modal')
    @include('admin.groups.modals.normal_doctor_modal')
    @include('admin.groups.modals.payment_method_modal')
    <!--\Models-->
@endsection

@section('scripts')
    <script>
        var test_arr = [];
        var culture_arr = [];
        var package_arr = [];

        (function($) {

            "use strict";

            @if (isset($visit))

                //selected tests
                @foreach ($visit['tests'] as $test)
                    test_arr.push('{{ $test['testable_id'] }}');
                @endforeach

                //selected cultures
                @foreach ($visit['cultures'] as $culture)
                    culture_arr.push('{{ $culture['testable_id'] }}');
                @endforeach

                //selected packages
                @foreach ($visit['packages'] as $package)
                    package_arr.push('{{ $package['testable_id'] }}');
                @endforeach
            @endif

        })(jQuery);
    </script>
    <script src="{{ url('js/admin/groups.js') }}"></script>


    <script>
        (function($) {
            "use strict";

            $('#government_id').change(function() {
                $.get("{{ url('admin/visits/') }}" + "/" + jQuery('#government_id').val() + "/get-regions",
                    function(response) {
                        let region_base = document.getElementById('region_id')
                        region_base.innerHTML = "";
                        region_base.innerHTML += "<option></option>";
                        response.data.forEach(function(e) {
                            region_base.innerHTML += "<option value='" + e.id + "" + "'>" + e.name +
                                "</option>";
                        })

                        let rep_base = document.getElementById('rep_id')
                        rep_base.innerHTML = "";
                        rep_base.innerHTML += "<option></option>";
                        response.rep.forEach(function(e) {
                            rep_base.innerHTML += "<option value='" + e.id + "" + "'>" + e.name +
                                "</option>";
                        })
                    }
                );
            })

            $('#region_id').change(function() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('admin.visits.get-users') }}",
                    data: {
                        'government_id': jQuery('#government_id').val(),
                        'region_id': jQuery('#region_id').val()
                    },
                    success: function(response) {
                        console.log(response)
                        let user_base = document.getElementById('user_id')
                        user_base.innerHTML = "";
                        user_base.innerHTML += "<option></option>";
                        response.data.forEach(function(e) {
                            user_base.innerHTML += "<option value='" + e.id + "" + "'>" + e
                                .lab_code + '-' + e.name + "</option>";
                        })
                    }
                });
            })

            @if (isset($visit) && isset($visit['patient']))
                $('#code').append(
                    '<option value="{{ $visit['patient_id'] }}" selected>{{ $visit['patient']['code'] }}</option>'
                    );
                $('#code').trigger({
                    type: 'select2:select',
                    params: {
                        data: {
                            id: "{{ $visit['patient_id'] }}",
                            text: "{{ $visit['patient']['code'] }}"
                        }
                    }
                });
            @endif
        })(jQuery);

    </script>


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
    </script>
@endsection
