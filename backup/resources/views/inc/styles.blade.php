<!-- BEGIN PAGE LEVEL STYLES -->

{{--<link rel="stylesheet" href="{{asset('new_design/plugins/font-icons/fontawesome/css/regular.css')}}">--}}
{{--<link rel="stylesheet" href="{{asset('new_design/plugins/font-icons/fontawesome/css/fontawesome.css')}}">--}}
<link href="{{asset('new_design/assets/css/loader.css')}}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{url('plugins/summernote/summernote-bs4.css')}}">
<link href="{{asset('new_design/assets/css/loader.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('new_design/plugins/perfect-scrollbar/perfect-scrollbar.css')}}" rel="stylesheet" type="text/css" />

<!-- BEGIN GLOBAL MANDATORY STYLES -->
{{--<link href="{{asset('new_design/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />--}}

@if(app()->getLocale() == 'en')
    <link href="{{asset('new_design/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
@else
    <link href="{{asset('new_design/bootstrap/css/bootstrap_ar.min.css')}}" rel="stylesheet" type="text/css" />
@endif
<link rel="stylesheet" href="{{url('plugins/sweet-alert/sweetalert.css')}}">

<div id="theme">
    @if((auth()->guard('admin')->check()&&auth()->guard('admin')->user()->theme=='dark') && app()->getLocale() == 'en')

        <link href="{{asset('new_design/assets/css/main_en_dark.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('new_design/assets/css/structure_en_dark.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('new_design/plugins/perfect-scrollbar/perfect-scrollbar.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('new_design/plugins/highlight/styles/monokai-sublime.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('new_design/assets/css/scrollspyNav.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('new_design/assets/css/components/tabs-accordian/custom-tabs.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('new_design/assets/css/tables/table-basic.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('new_design/assets/css/components/custom-modal.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('new_design/plugins/apex/apexcharts.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('new_design/assets/css/elements/alert.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('new_design/assets/css/dashboard/dash_1.css')}}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="{{ asset('new_design/plugins/table/datatable/datatables.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('new_design/plugins/table/datatable/custom_dt_miscellaneous.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('new_design/assets/css/forms/theme-checkbox-radio.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('new_design/plugins/table/datatable/dt-global_style.css') }}">
        <link rel="stylesheet" href="{{url('plugins/fontawesome-free/css/all.min.css')}}">
        <link rel="stylesheet" href="{{url('new_design/assets/css/select2.css')}}">
        <link rel="stylesheet" href="{{ URL::asset('css/toastr.min.css')}}">
        <link rel="stylesheet" href="{{url('plugins/flatpickr/flatpickr.min.css')}}">
        <link rel="stylesheet" href="{{url('plugins/daterangepicker/daterangepicker.css')}}">
        <link rel="stylesheet" href="{{url('new_design/assets/css/dashboard/dash_2.css')}}">
    @elseif((auth()->guard('admin')->check()&&auth()->guard('admin')->user()->theme=='dark') && app()->getLocale() == 'ar')
    <link href='https://fonts.googleapis.com/css?family=Cairo' rel='stylesheet'>

    <link href="{{asset('new_design/assets/css/main_ar_dark.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('new_design/assets/css/structure_ar_dark.css')}}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="{{url('new_design/plugins/apex/apexcharts.css')}}">
        {{-- <link rel="stylesheet" href="{{url('new_design/assets-dark-rtl/css/dashboard/dash_2.css')}}"> --}}
        <link href="{{asset('new_design/plugins-dark-rtl/perfect-scrollbar/perfect-scrollbar.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('new_design/plugins-dark-rtl/highlight/styles/monokai-sublime.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('new_design/assets-dark-rtl/css/scrollspyNav.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('new_design/assets-dark-rtl/css/components/tabs-accordian/custom-tabs.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('new_design/assets-dark-rtl/css/tables/table-basic.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('new_design/assets-dark-rtl/css/components/custom-modal.css')}}" rel="stylesheet" type="text/css">
        {{-- <link href="{{asset('new_design/plugins-dark-rtl/apex/apexcharts.css')}}" rel="stylesheet" type="text/css"> --}}
        <link href="{{asset('new_design/assets-dark-rtl/css/elements/alert.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('new_design/assets-dark-rtl/css/dashboard/dash_1.css')}}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="{{ asset('new_design/plugins-dark-rtl/table/datatable/datatables.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('new_design/plugins-dark-rtl/table/datatable/custom_dt_miscellaneous.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('new_design/assets-dark-rtl/css/forms/theme-checkbox-radio.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('new_design/plugins-dark-rtl/table/datatable/dt-global_style.css') }}">
        <link rel="stylesheet" href="{{url('plugins/fontawesome-free/css/all.min.css')}}">
        <link rel="stylesheet" href="{{url('new_design/assets-dark-rtl/css/select2.css')}}">
        <link rel="stylesheet" href="{{ URL::asset('css/toastr.min.css')}}">
        <link rel="stylesheet" href="{{url('plugins/flatpickr/flatpickr.min.css')}}">
        <link rel="stylesheet" href="{{url('plugins/daterangepicker/daterangepicker.css')}}">
        {{-- <link rel="stylesheet" href="{{url('new_design/plugins-dark-rtl/apex/apexcharts.css')}}"> --}}
        <link rel="stylesheet" href="{{url('new_design/assets-dark-rtl/css/dashboard/dash_2.css')}}">
    @elseif((auth()->guard('admin')->check()&&auth()->guard('admin')->user()->theme!='dark') && app()->getLocale() == 'en')

        <link href="{{asset('new_design/assets/css/main_en_light.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('new_design/assets/css/structure_en_light.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('new_design/plugins-light-ltr/perfect-scrollbar/perfect-scrollbar.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('new_design/plugins-light-ltr/highlight/styles/monokai-sublime.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('new_design/assets-light-ltr/css/scrollspyNav.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('new_design/assets-light-ltr/css/components/tabs-accordian/custom-tabs.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('new_design/assets-light-ltr/css/tables/table-basic.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('new_design/assets-light-ltr/css/components/custom-modal.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('new_design/plugins-light-ltr/apex/apexcharts.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('new_design/assets-light-ltr/css/elements/alert.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('new_design/assets-light-ltr/css/dashboard/dash_1.css')}}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="{{url('new_design/assets-light-ltr/css/dashboard/dash_2.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset('new_design/plugins-light-ltr/table/datatable/datatables.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('new_design/plugins-light-ltr/table/datatable/custom_dt_miscellaneous.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('new_design/assets-light-ltr/css/forms/theme-checkbox-radio.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('new_design/plugins-light-ltr/table/datatable/dt-global_style.css') }}">
        <link rel="stylesheet" href="{{url('plugins/fontawesome-free/css/all.min.css')}}">
        <link rel="stylesheet" href="{{url('new_design/assets-light-ltr/css/select2.css')}}">
        <link rel="stylesheet" href="{{ URL::asset('css/toastr.min.css')}}">
        <link rel="stylesheet" href="{{url('plugins/flatpickr/flatpickr.min.css')}}">
        <link rel="stylesheet" href="{{url('plugins/daterangepicker/daterangepicker.css')}}">
    @else
        <link href='https://fonts.googleapis.com/css?family=Cairo' rel='stylesheet'>


        <link href="{{asset('new_design/assets/css/main_ar_light.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('new_design/assets/css/structure_ar_light.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('new_design/plugins-light-rtl/perfect-scrollbar/perfect-scrollbar.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('new_design/plugins-light-rtl/highlight/styles/monokai-sublime.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('new_design/assets-light-rtl/css/scrollspyNav.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('new_design/assets-light-rtl/css/components/tabs-accordian/custom-tabs.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('new_design/assets-light-rtl/css/tables/table-basic.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('new_design/assets-light-rtl/css/components/custom-modal.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('new_design/plugins-light-rtl/apex/apexcharts.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('new_design/assets-light-rtl/css/elements/alert.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('new_design/assets-light-rtl/css/dashboard/dash_1.css')}}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="{{ asset('new_design/plugins-light-rtl/table/datatable/datatables.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('new_design/plugins-light-rtl/table/datatable/custom_dt_miscellaneous.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('new_design/assets-light-rtl/css/forms/theme-checkbox-radio.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('new_design/plugins-light-rtl/table/datatable/dt-global_style.css') }}">
        <link rel="stylesheet" href="{{url('plugins/fontawesome-free/css/all.min.css')}}">
        <link rel="stylesheet" href="{{url('new_design/assets-light-ltr/css/select2.css')}}">
        <link rel="stylesheet" href="{{ URL::asset('css/toastr.min.css')}}">
        <link rel="stylesheet" href="{{url('plugins/flatpickr/flatpickr.min.css')}}">
        <link rel="stylesheet" href="{{url('plugins/daterangepicker/daterangepicker.css')}}">
        <link rel="stylesheet" href="{{url('new_design/assets-light-rtl/css/dashboard/dash_2.css')}}">
    @endif

</div>


<style>
    .row, .card-primary {
        margin-bottom: 10px;
    }
    body {
        font-family: 'Cairo';
    }
    {{--  @media (max-width: 576px){
        .sub-header-container  {
             margin-top: 40px;
             margin-bottom: 10px;
            }
    }  --}}
    .table > tbody > tr > td {
        padding: 10px;
    }
</style>
