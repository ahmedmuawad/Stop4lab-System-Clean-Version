@extends('layouts.app')

@section('title')
  {{__('Dashboard')}}
@endsection

@section('css')
<style>
    .btn {
        text-align: center !important;
    }
    .widget-card-four {
    padding: 25px 23px;
    margin: 30px;
    height: 220px;
    background: #0e1726;
    }
.widget-account-invoice-two {
    padding: 22px 19px;
    margin: 33px 0;
    height: 215px;
}
    .layout-spacing {
        padding: 7px;
    }
</style>
    <link rel="stylesheet" href="{{url('plugins/swtich-netliva/css/netliva_switch.css')}}">
    <link rel="stylesheet" href="{{url('new_design/plugins/apex/apexcharts.css')}}">
    {{--  <link rel="stylesheet" href="{{url('new_design/assets/css/dashboard/dash_2.css')}}">  --}}
@endsection
@section('breadcrumb')
            <li class="breadcrumb-item active">{{__('Dashboard')}}</li>
@endsection
@section('content')
<div class="app-content content">


  @php
  use App\Models\Employee;
  if(auth()->guard('admin')->check()){
      $employee =   Employee::where('user_id',auth()->guard('admin')->user()->id)->first();
  }
@endphp






@can('create_vault')
<div class="row layout-spacing" style="margin-top: 50px; margin-right: 5px; padding:5px; margin-left: 10px;">

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-3 col-3 layout-spacing" style="text-align: center;" type="button" id="">
        <button class="btn btn-warning mb-2 mr-2">
            <a href="{{ route('admin.reports.work_one_day') }}" >
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 508 508" style="enable-background:new 0 0 508 508;" xml:space="preserve">
                    <circle style="fill:#90DFAA;" cx="254" cy="254" r="254"/>
                    <path style="fill:#FF7058;" d="M351.6,128.8H156.4l67.2,194.8L419.2,302V196C419.2,158.8,388.8,128.8,351.6,128.8z"/>
                    <path style="fill:#F1543F;" d="M156.4,128.8c-37.2,0-67.2,30-67.2,67.2v110.4l134.4,17.2V196C223.6,158.8,193.2,128.8,156.4,128.8z"/>
                    <polygon style="fill:#324A5E;" points="419.2,222.8 223.6,239.6 223.6,252.8 419.2,236 "/>
                    <polygon style="fill:#2B3B4E;" points="223.6,239.6 88.8,226.4 88.8,239.6 222.8,252.8 223.6,252.8 223.6,252.8 "/>
                    <path style="fill:#FFD05B;" d="M350,199.2l-38,2.8c-1.2,0-2,1.2-2,2v16.4c0,1.2,1.2,2.4,2.4,2l8.4-0.8v43.2c0,2,1.6,3.6,3.6,3.6  l14.4-0.8c2,0,3.2-1.6,3.2-3.6v-44l8-0.8c1.2,0,2-1.2,2-2v-16.4C352,200,351.2,199.2,350,199.2z"/>
                    <path style="fill:#324A5E;" d="M332.4,240c-1.6,0-2.8,1.2-2.8,2.8v14.4c0,1.6,1.2,2.8,2.8,2.8c1.6,0,2.8-1.2,2.8-2.8v-14.4  C335.2,241.2,333.6,240,332.4,240z"/>
                    <circle style="fill:#FFD05B;" cx="192.4" cy="340.4" r="70.4"/>
                    <path style="fill:#FFFFFF;" d="M192.4,394c-29.6,0-53.6-24-53.6-53.6s24-53.6,53.6-53.6s53.6,24,53.6,53.6  C246.4,370,222,394,192.4,394z"/>
                    <path style="fill:#324A5E;" d="M195.6,368.4v8.8h-6v-8.4c-5.6,0-10.4-1.2-15.2-3.6V354c1.6,1.2,4,2.4,6.8,3.6c3.2,1.2,5.6,1.6,8,2  v-14.4c-6.4-2.4-10.4-4.8-12.8-7.6c-2.4-2.8-3.6-6-3.6-10s1.6-7.6,4.4-10.8c2.8-2.8,6.8-4.8,11.6-5.2V304h6v7.2  c5.6,0.4,10,1.2,12.4,2.8v10.8c-3.6-2.4-8-3.6-12.4-4V336c6,2,10,4.4,12.4,7.2c2.4,2.8,3.6,6,3.6,10c0,4.4-1.6,8-4.4,10.8  C204.8,366,200.8,367.6,195.6,368.4z M189.6,333.6v-12.8c-3.6,0.8-5.6,2.4-5.6,5.6C184,329.2,186,331.6,189.6,333.6z M195.6,346.8  v12c4-0.4,5.6-2.4,5.6-5.6C201.2,350.8,199.2,348.4,195.6,346.8z"/>

                    </svg>
                {{__('Total In Vault')}} = {{ get_visa_vault() + get_cash_vault()  }}
            </a>
        </button>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-3 col-3 layout-spacing" style="text-align: center;" type="button" id="">
        <button class="btn btn-warning mb-2 mr-2">
            <a href="{{ route('admin.vault.create') }}" >
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 508 508" style="enable-background:new 0 0 508 508;" xml:space="preserve">
                    <circle style="fill:#90DFAA;" cx="254" cy="254" r="254"/>
                    <path style="fill:#FF7058;" d="M351.6,128.8H156.4l67.2,194.8L419.2,302V196C419.2,158.8,388.8,128.8,351.6,128.8z"/>
                    <path style="fill:#F1543F;" d="M156.4,128.8c-37.2,0-67.2,30-67.2,67.2v110.4l134.4,17.2V196C223.6,158.8,193.2,128.8,156.4,128.8z"/>
                    <polygon style="fill:#324A5E;" points="419.2,222.8 223.6,239.6 223.6,252.8 419.2,236 "/>
                    <polygon style="fill:#2B3B4E;" points="223.6,239.6 88.8,226.4 88.8,239.6 222.8,252.8 223.6,252.8 223.6,252.8 "/>
                    <path style="fill:#FFD05B;" d="M350,199.2l-38,2.8c-1.2,0-2,1.2-2,2v16.4c0,1.2,1.2,2.4,2.4,2l8.4-0.8v43.2c0,2,1.6,3.6,3.6,3.6  l14.4-0.8c2,0,3.2-1.6,3.2-3.6v-44l8-0.8c1.2,0,2-1.2,2-2v-16.4C352,200,351.2,199.2,350,199.2z"/>
                    <path style="fill:#324A5E;" d="M332.4,240c-1.6,0-2.8,1.2-2.8,2.8v14.4c0,1.6,1.2,2.8,2.8,2.8c1.6,0,2.8-1.2,2.8-2.8v-14.4  C335.2,241.2,333.6,240,332.4,240z"/>
                    <circle style="fill:#FFD05B;" cx="192.4" cy="340.4" r="70.4"/>
                    <path style="fill:#FFFFFF;" d="M192.4,394c-29.6,0-53.6-24-53.6-53.6s24-53.6,53.6-53.6s53.6,24,53.6,53.6  C246.4,370,222,394,192.4,394z"/>
                    <path style="fill:#324A5E;" d="M195.6,368.4v8.8h-6v-8.4c-5.6,0-10.4-1.2-15.2-3.6V354c1.6,1.2,4,2.4,6.8,3.6c3.2,1.2,5.6,1.6,8,2  v-14.4c-6.4-2.4-10.4-4.8-12.8-7.6c-2.4-2.8-3.6-6-3.6-10s1.6-7.6,4.4-10.8c2.8-2.8,6.8-4.8,11.6-5.2V304h6v7.2  c5.6,0.4,10,1.2,12.4,2.8v10.8c-3.6-2.4-8-3.6-12.4-4V336c6,2,10,4.4,12.4,7.2c2.4,2.8,3.6,6,3.6,10c0,4.4-1.6,8-4.4,10.8  C204.8,366,200.8,367.6,195.6,368.4z M189.6,333.6v-12.8c-3.6,0.8-5.6,2.4-5.6,5.6C184,329.2,186,331.6,189.6,333.6z M195.6,346.8  v12c4-0.4,5.6-2.4,5.6-5.6C201.2,350.8,199.2,348.4,195.6,346.8z"/>

                    </svg>
                {{__('Received Cach')}} = {{ get_cash_vault() }}
            </a>
        </button>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-3 col-3 layout-spacing" style="text-align: center;" type="button" id="">
        <button class="btn btn-warning mb-2 mr-2">
            <a href="{{ route('admin.vault.create') }}" >
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 508 508" style="enable-background:new 0 0 508 508;" xml:space="preserve">
                    <circle style="fill:#90DFAA;" cx="254" cy="254" r="254"/>
                    <path style="fill:#FF7058;" d="M351.6,128.8H156.4l67.2,194.8L419.2,302V196C419.2,158.8,388.8,128.8,351.6,128.8z"/>
                    <path style="fill:#F1543F;" d="M156.4,128.8c-37.2,0-67.2,30-67.2,67.2v110.4l134.4,17.2V196C223.6,158.8,193.2,128.8,156.4,128.8z"/>
                    <polygon style="fill:#324A5E;" points="419.2,222.8 223.6,239.6 223.6,252.8 419.2,236 "/>
                    <polygon style="fill:#2B3B4E;" points="223.6,239.6 88.8,226.4 88.8,239.6 222.8,252.8 223.6,252.8 223.6,252.8 "/>
                    <path style="fill:#FFD05B;" d="M350,199.2l-38,2.8c-1.2,0-2,1.2-2,2v16.4c0,1.2,1.2,2.4,2.4,2l8.4-0.8v43.2c0,2,1.6,3.6,3.6,3.6  l14.4-0.8c2,0,3.2-1.6,3.2-3.6v-44l8-0.8c1.2,0,2-1.2,2-2v-16.4C352,200,351.2,199.2,350,199.2z"/>
                    <path style="fill:#324A5E;" d="M332.4,240c-1.6,0-2.8,1.2-2.8,2.8v14.4c0,1.6,1.2,2.8,2.8,2.8c1.6,0,2.8-1.2,2.8-2.8v-14.4  C335.2,241.2,333.6,240,332.4,240z"/>
                    <circle style="fill:#FFD05B;" cx="192.4" cy="340.4" r="70.4"/>
                    <path style="fill:#FFFFFF;" d="M192.4,394c-29.6,0-53.6-24-53.6-53.6s24-53.6,53.6-53.6s53.6,24,53.6,53.6  C246.4,370,222,394,192.4,394z"/>
                    <path style="fill:#324A5E;" d="M195.6,368.4v8.8h-6v-8.4c-5.6,0-10.4-1.2-15.2-3.6V354c1.6,1.2,4,2.4,6.8,3.6c3.2,1.2,5.6,1.6,8,2  v-14.4c-6.4-2.4-10.4-4.8-12.8-7.6c-2.4-2.8-3.6-6-3.6-10s1.6-7.6,4.4-10.8c2.8-2.8,6.8-4.8,11.6-5.2V304h6v7.2  c5.6,0.4,10,1.2,12.4,2.8v10.8c-3.6-2.4-8-3.6-12.4-4V336c6,2,10,4.4,12.4,7.2c2.4,2.8,3.6,6,3.6,10c0,4.4-1.6,8-4.4,10.8  C204.8,366,200.8,367.6,195.6,368.4z M189.6,333.6v-12.8c-3.6,0.8-5.6,2.4-5.6,5.6C184,329.2,186,331.6,189.6,333.6z M195.6,346.8  v12c4-0.4,5.6-2.4,5.6-5.6C201.2,350.8,199.2,348.4,195.6,346.8z"/>

                    </svg>
                {{__('Received Visa')}} = {{ get_visa_vault() }}
            </a>
        </button>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-3 col-3 layout-spacing" style="text-align: center;" type="button" id="">
        <button class="btn btn-warning mb-2 mr-2">
            <a class="" onclick="">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                    <circle style="fill:#FF7069;" cx="256" cy="256" r="256"/>
                    <path style="fill:#F2C53F;" d="M369.247,481.777c0,16.724-50.77,30.223-113.366,30.223s-113.366-13.499-113.366-30.223v-30.223  h113.366h113.366V481.777z"/>
                    <path style="fill:#FFE356;" d="M255.881,426.587c62.596,0,113.366,12.424,113.366,27.595c0,15.291-50.77,27.595-113.366,27.595  s-113.366-12.424-113.366-27.595C142.514,438.891,193.284,426.587,255.881,426.587z"/>
                    <path style="fill:#F2C53F;" d="M350.372,437.697c0,16.724-50.77,30.223-113.366,30.223S123.64,454.421,123.64,437.697v-30.223  h113.366h113.366V437.697z"/>
                    <path style="fill:#FFE356;" d="M237.006,382.507c62.596,0,113.366,12.424,113.366,27.595c0,15.291-50.77,27.595-113.366,27.595  S123.64,425.273,123.64,410.102C123.64,394.811,174.41,382.507,237.006,382.507z"/>
                    <path style="fill:#F2C53F;" d="M388.719,385.135c0,16.724-50.77,30.223-113.366,30.223s-113.366-13.499-113.366-30.223v-30.223  h113.366h113.366V385.135z"/>
                    <path style="fill:#FFE356;" d="M275.352,329.945c62.596,0,113.366,12.424,113.366,27.595c0,15.291-50.77,27.595-113.366,27.595  s-113.366-12.424-113.366-27.595C161.986,342.249,212.756,329.945,275.352,329.945z"/>
                    <path style="fill:#F2C53F;" d="M423.362,342.249c0,16.724-50.77,30.223-113.366,30.223s-113.366-13.499-113.366-30.223v-30.223  h113.366h113.366V342.249z"/>
                    <path style="fill:#FFE356;" d="M309.995,287.059c62.596,0,113.366,12.424,113.366,27.595c0,15.291-50.77,27.595-113.366,27.595  s-113.366-12.424-113.366-27.595C196.629,299.364,247.399,287.059,309.995,287.059z"/>
                    <path style="fill:#F2C53F;" d="M388.719,294.346c0,16.724-50.77,30.223-113.366,30.223s-113.366-13.499-113.366-30.223v-30.223  h113.366h113.366V294.346z"/>
                    <path style="fill:#FFE356;" d="M275.352,239.156c62.596,0,113.366,12.424,113.366,27.595c0,15.291-50.77,27.595-113.366,27.595  s-113.366-12.424-113.366-27.595C161.986,251.461,212.756,239.156,275.352,239.156z"/>
                    <path style="fill:#F2C53F;" d="M351.209,245.846c0,16.724-50.77,30.223-113.366,30.223s-113.366-13.499-113.366-30.223v-30.223  h113.366h113.366V245.846z"/>
                    <path style="fill:#FFE356;" d="M237.723,190.656c62.596,0,113.366,12.424,113.366,27.595c0,15.291-50.77,27.595-113.366,27.595  s-113.366-12.424-113.366-27.595C124.357,202.96,175.126,190.656,237.723,190.656z"/>
                    <path style="fill:#F2C53F;" d="M381.073,204.035c0,16.724-50.77,30.223-113.366,30.223s-113.366-13.499-113.366-30.223v-30.223  h113.366h113.366V204.035z"/>
                    <path style="fill:#FFE356;" d="M267.707,148.846c62.596,0,113.366,12.424,113.366,27.595c0,15.291-50.77,27.595-113.366,27.595  s-113.366-12.424-113.366-27.595C154.341,161.15,205.111,148.846,267.707,148.846z"/>
                    <path style="fill:#FFFFFF;" d="M234.856,193.523c7.048,1.434,14.216,2.15,21.264,2.509c7.168,0.239,13.618,0,19.711-0.836  c5.973-0.836,10.99-2.031,15.052-3.584c3.225-1.314,5.376-2.628,6.57-4.062c1.075-1.434,1.195-2.867,0.239-4.301  c-0.836-1.434-2.509-2.628-4.898-3.823c-2.389-1.195-5.973-2.748-10.632-4.539l22.1-8.72c4.42,1.911,5.256,3.942,2.389,6.092  c-2.389,1.792-1.314,3.225,3.345,4.301c2.389,0.597,5.137,0.836,8.123,0.717s5.376-0.478,7.168-1.195  c1.553-0.597,2.748-1.434,3.584-2.509c0.717-1.075,0.956-2.15,0.717-3.345c-0.358-1.553-1.672-2.986-4.062-4.301  c-2.389-1.314-5.973-2.628-10.512-3.942l5.734-2.27c2.867-1.195,2.867-2.031-0.119-2.748s-5.973-0.478-8.84,0.717l-5.615,2.27  c-10.273-2.031-19.95-2.867-29.028-2.509c-8.959,0.358-16.605,1.792-22.697,4.181c-4.659,1.911-7.168,3.703-7.526,5.495  c-0.358,1.792,0.717,3.464,3.345,5.137c2.628,1.672,6.331,3.464,11.349,5.376l-24.728,9.796c-2.509-0.956-3.942-2.031-4.659-2.867  c-0.597-0.956-0.597-1.792,0-2.628s1.792-2.031,3.345-3.464c0.717-0.717,0.836-1.314,0.119-1.911  c-0.717-0.597-2.15-1.195-4.301-1.672c-2.628-0.597-5.495-0.836-8.601-0.717s-5.495,0.478-7.168,1.195  c-2.27,0.956-4.062,2.031-5.137,3.225c-1.075,1.195-1.314,2.628-0.836,4.181c0.478,1.553,2.15,3.106,4.659,4.539  c2.628,1.553,6.451,3.106,11.468,4.539h-0.119l-3.225,1.314c-1.911,0.717-1.434,1.792,1.075,2.389l0,0  c2.509,0.597,5.973,0.478,7.884-0.358l3.464-1.434V193.523z M275.233,171.782l20.308-8.123c-4.778-0.597-9.079-0.836-12.663-0.717  c-3.703,0.119-6.929,0.717-9.915,1.792c-2.748,1.075-3.823,2.15-3.225,3.225s2.509,2.27,5.495,3.703V171.782z M268.424,180.144  l-23.294,9.198c5.376,0.836,10.512,1.075,15.291,0.836c4.778-0.239,8.482-0.956,11.468-2.15c3.106-1.195,4.181-2.509,3.345-3.703  c-0.836-1.195-3.106-2.628-6.809-4.301V180.144z"/>

                    </svg>
                {{__('Custody')}} = {{ get_custody_branch()}}
            </a>
        </button>
    </div>
    </div>

@endcan

@if (isset($employee))
<div class="row layout-spacing" style="margin-top: 50px; margin-right: 5px; padding:5px; margin-left: 10px;">

<div class="col-xl-3 col-lg-6 col-md-6 col-sm-3 col-3 layout-spacing" style="text-align: center;" type="button" id="">
</div>
<div class="col-xl-3 col-lg-6 col-md-6 col-sm-3 col-3 layout-spacing" style="text-align: center;" type="button" id="">
    <button class="btn btn-warning mb-2 mr-2">
        <a class="" onclick="document.getElementById('cheackin_form').submit();">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
            <path style="fill:#72C6EF;" d="M488.727,197.818v116.364l-46.545,23.273v139.636c0,12.858-10.415,23.273-23.273,23.273h-46.545  c-12.858,0-23.273-10.415-23.273-23.273V337.455l-46.545-23.273V197.818c0-18.851,12.102-38.167,34.909-46.545  c11.055-3.956,23.273-11.636,23.273-11.636c19.316,15.476,50.502,15.476,69.818,0c0,0,23.855,7.68,34.909,11.636  C488.262,159.651,488.727,178.967,488.727,197.818z"/>
            <path style="fill:#FAA85F;" d="M58.182,256l11.636-71.61c0,0,0.465-26.589,23.273-33.036c11.055-3.037,23.273-11.718,23.273-11.718  c19.316,11.904,50.502,11.904,69.818,0c0,0,12.218,8.681,23.273,11.729c22.807,6.447,23.273,33.036,23.273,33.036L244.364,256"/>
            <g>
                <path style="fill:#00384E;" d="M469.376,140.323c-11.171-4.003-35.258-11.764-35.258-11.764c-3.735-1.21-7.808-0.454-10.845,2.001   c-14.976,11.997-40.297,11.997-55.273,0c-3.875-3.107-9.286-3.398-13.463-0.768c-3.107,1.955-12.905,7.633-21.085,10.566   c-25.844,9.484-42.543,32.035-42.543,57.46v46.545h-36.643l-9.926-61.079c-0.535-13.265-7.715-36.329-31.791-43.136   c-7.377-2.036-16.675-7.913-19.642-9.996c-3.793-2.7-8.855-2.863-12.835-0.419c-15.616,9.635-41.996,9.635-57.612,0   c-3.98-2.444-9.03-2.281-12.835,0.419c-2.967,2.095-12.265,7.971-19.7,10.019c-24.017,6.784-31.197,29.847-31.732,43.113   l-9.914,61.079H23.273c-6.435,0-11.636,5.201-11.636,11.636c0,6.435,5.201,11.636,11.636,11.636h267.636v46.545   c0,4.41,2.49,8.436,6.435,10.415l40.111,20.049v132.445c0,19.247,15.663,34.909,34.909,34.909h46.545   c19.247,0,34.909-15.663,34.909-34.909V344.646l40.111-20.061c3.945-1.967,6.435-5.993,6.435-10.403V197.818   C500.364,179.456,500.364,151.692,469.376,140.323z M81.303,186.263c0.093-0.547,0.14-1.105,0.151-1.664   c0-0.186,0.477-18.001,14.732-22.028c7.75-2.141,15.558-6.307,20.771-9.46c20.527,9.414,48.116,9.414,68.631,0   c5.213,3.153,12.998,7.331,20.701,9.449c14.045,3.98,14.778,21.388,14.79,22.051c0.012,0.559,0.058,1.117,0.151,1.664l9.449,58.089   h-21.225v-23.273c0-6.435-5.201-11.636-11.636-11.636s-11.636,5.201-11.636,11.636v23.273h-69.818v-23.273   c0-6.435-5.201-11.636-11.636-11.636c-6.435,0-11.636,5.201-11.636,11.636v23.273H71.866L81.303,186.263z M477.091,306.991   l-23.273,11.636v-74.263c0-6.435-5.201-11.636-11.636-11.636c-6.435,0-11.636,5.201-11.636,11.636v93.091v139.636   c0,6.423-5.213,11.636-11.636,11.636h-11.636V337.455c0-6.435-5.201-11.636-11.636-11.636c-6.435,0-11.636,5.201-11.636,11.636   v151.273h-11.636c-6.423,0-11.636-5.213-11.636-11.636V337.455v-93.091c0-6.435-5.201-11.636-11.636-11.636   s-11.636,5.201-11.636,11.636v74.263l-23.273-11.636V197.818c0-15.558,10.705-29.533,27.194-35.596   c6.807-2.432,13.859-6.063,18.839-8.809c21.644,12.975,51.025,12.672,72.308-0.908c7.657,2.49,21.376,6.993,28.916,9.681   c14.173,5.213,15.651,14.86,15.651,35.631V306.991z"/>
                <path style="fill:#00384E;" d="M395.636,116.364c32.081,0,58.182-26.1,58.182-58.182S427.718,0,395.636,0   s-58.182,26.1-58.182,58.182S363.555,116.364,395.636,116.364z M395.636,23.273c19.247,0,34.909,15.663,34.909,34.909   s-15.663,34.909-34.909,34.909c-19.247,0-34.909-15.663-34.909-34.909S376.39,23.273,395.636,23.273z"/>
                <path style="fill:#00384E;" d="M151.273,116.364c32.081,0,58.182-26.1,58.182-58.182S183.354,0,151.273,0   S93.091,26.1,93.091,58.182S119.191,116.364,151.273,116.364z M151.273,23.273c19.247,0,34.909,15.663,34.909,34.909   s-15.663,34.909-34.909,34.909s-34.909-15.663-34.909-34.909S132.026,23.273,151.273,23.273z"/>
            </g>
            <g>
                <circle style="fill:#FFFFFF;" cx="395.636" cy="58.182" r="34.909"/>
                <circle style="fill:#FFFFFF;" cx="151.273" cy="58.182" r="34.909"/>
            </svg>
            {{__('Check In')}}
        </a>
    </button>
</div>
<div class="col-xl-3 col-lg-6 col-md-6 col-sm-3 col-3 layout-spacing" style="text-align: center;" type="button" id="">
    <button class="btn btn-warning mb-2 mr-2">
        <a class="" onclick="document.getElementById('cheackout_form').submit();">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                <g>
                    <g>
                        <path style="fill:#FFEEBB;" d="M472,128H40c-22.055,0-40,17.945-40,40v176c0,22.055,17.945,40,40,40h432c22.055,0,40-17.945,40-40    V168C512,145.945,494.055,128,472,128z"/>
                    </g>
                    <g>
                        <path style="fill:#73D14F;" d="M92.102,244C76.016,244,64,235.555,64,228s12.016-16,28.102-16s28.102,8.445,28.102,16    c0,6.625,5.375,12,12,12s12-5.375,12-12c0-19.244-16.864-34.874-40.102-38.937V176c0-6.625-5.375-12-12-12s-12,5.375-12,12v13.063    C56.864,193.126,40,208.756,40,228c0,22.43,22.883,40,52.102,40c16.086,0,28.102,8.445,28.102,16s-12.016,16-28.102,16    S64,291.555,64,284c0-6.625-5.375-12-12-12s-12,5.375-12,12c0,19.244,16.864,34.874,40.102,38.937V336c0,6.625,5.375,12,12,12    s12-5.375,12-12v-13.063c23.238-4.063,40.102-19.693,40.102-38.937C144.203,261.57,121.32,244,92.102,244z"/>
                    </g>
                    <g>
                        <g>
                            <path style="fill:#73D14F;" d="M280,192h-96c-4.422,0-8-3.578-8-8s3.578-8,8-8h96c4.422,0,8,3.578,8,8S284.422,192,280,192z"/>
                        </g>
                    </g>
                    <g>
                        <g>
                            <path style="fill:#73D14F;" d="M392,224H184c-4.422,0-8-3.578-8-8s3.578-8,8-8h208c4.422,0,8,3.578,8,8S396.422,224,392,224z"/>
                        </g>
                    </g>
                    <g>
                        <g>
                            <path style="fill:#5C546A;" d="M216,272h-32c-4.422,0-8-3.578-8-8s3.578-8,8-8h32c4.422,0,8,3.578,8,8S220.422,272,216,272z"/>
                        </g>
                    </g>
                    <g>
                        <g>
                            <path style="fill:#5C546A;" d="M216,304h-32c-4.422,0-8-3.578-8-8s3.578-8,8-8h32c4.422,0,8,3.578,8,8S220.422,304,216,304z"/>
                        </g>
                    </g>
                    <g>
                        <g>
                            <path style="fill:#5C546A;" d="M216,336h-32c-4.422,0-8-3.578-8-8s3.578-8,8-8h32c4.422,0,8,3.578,8,8S220.422,336,216,336z"/>
                        </g>
                    </g>
                    <g>
                        <g>
                            <path style="fill:#8A8895;" d="M344,272h-96c-4.422,0-8-3.578-8-8s3.578-8,8-8h96c4.422,0,8,3.578,8,8S348.422,272,344,272z"/>
                        </g>
                    </g>
                    <g>
                        <g>
                            <path style="fill:#8A8895;" d="M360,304H248c-4.422,0-8-3.578-8-8s3.578-8,8-8h112c4.422,0,8,3.578,8,8S364.422,304,360,304z"/>
                        </g>
                    </g>
                    <g>
                        <g>
                            <path style="fill:#8A8895;" d="M336,336h-88c-4.422,0-8-3.578-8-8s3.578-8,8-8h88c4.422,0,8,3.578,8,8S340.422,336,336,336z"/>
                        </g>
                    </g>
                    <g>
                        <g>
                            <path style="fill:#5C546A;" d="M400,344c-2.102,0-4.141-0.828-5.656-2.344l-16-16c-3.125-3.125-3.125-8.188,0-11.313     s8.188-3.125,11.313,0l7.422,7.422l5.742-14.359c2.242-5.586,7.344-9.445,13.328-10.063c6.016-0.555,11.766,2.102,15.094,7.102     l33.766-60.328c2.148-3.867,7.023-5.273,10.875-3.109c3.867,2.148,5.258,7.016,3.109,10.875l-33.516,60.32     c-2.75,4.969-7.781,8.07-13.461,8.297c-5.555,0.273-10.938-2.453-14.086-7.18l-10.5,25.648c-1,2.5-3.188,4.328-5.82,4.867     C401.07,343.945,400.531,344,400,344z"/>
                        </g>
                    </g>
                </g>

                </svg>
            {{__('Check Out')}}
        </a>
    </button>
</div>


<form method="POST" id="cheackin_form" action="{{route('admin.attendance.store')}}">
  @csrf
  <input type="hidden" name="employee_id" value="{{$employee->id}}">
  <input type="hidden" name="attendance_type" value="0">
</form>
<form method="POST" id="cheackout_form" action="{{route('admin.attendance.store')}}">
  @csrf
  <input type="hidden" name="employee_id" value="{{$employee->id}}">
  <input type="hidden" name="attendance_type" value="1">
</form>
</div>
@endif
<div class="row layout-spacing" style="margin: 10px;">
            <div class="col-xl-9 col-lg-12 col-md-4 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-chart-three">
                    <div class="widget-heading">
                        <div class="">
                            <h5 class="">{{ __('Income Statics') }}</h5>
                        </div>

                        <div class="dropdown ">

                            {{-- <input type="text" class="form-control datepicker_month" id="filter_income" value="{{get_system_date('','m-Y')}}">
                            <div class="col-lg-3">
                              <select name="" id="filter_income_branch" class="form-control">
                                <option value="" selected>{{__('All branches')}}</option>
                                @foreach($all_branches as $branch)
                                  <option value="{{$branch['id']}}">{{$branch['name']}}</option>
                                @endforeach
                              </select>
                            </div> --}}
                            {{-- <div class="dropdown-menu dropdown-menu-right" aria-labelledby="uniqueVisitors">

                                <a class="dropdown-item" href="javascript:void(0);">View</a>
                                <a class="dropdown-item" href="javascript:void(0);">Update</a>
                                <a class="dropdown-item" href="javascript:void(0);">Download</a>
                            </div> --}}
                        </div>
                    </div>

                    <div class="widget-content">
                        <div id="uniqueVisits2"></div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-activity-five">

                    <div class="widget-heading">
                        <h5 class="">{{ __('Activity Log') }}</h5>

                        <div class="task-action">
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" id="pendingTask" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="pendingTask" style="will-change: transform;">
                                    <a class="dropdown-item" href="javascript:void(0);">View All</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Mark as Read</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="widget-content">

                        <div class="w-shadow-top"></div>

                        <div class="mt-container mx-auto">
                            <div class="timeline-line">
                              @foreach ($activity as $item)
                                  <div class="item-timeline timeline-new">
                                    <div class="t-dot">
                                        <div class="t-secondary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></div>
                                    </div>
                                    <div class="t-content">
                                        <div class="t-uppercontent">
                                            <h5>{{ $item->description }} <a href="javscript:void(0);"></a></h5>
                                        </div>
                                        <p>{{ $item->created_at->diffforhumans() }}</p>
                                    </div>
                                  </div>
                              @endforeach


                            </div>
                        </div>

                        <div class="w-shadow-bottom"></div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
              <div class="widget widget-card-four">
                  <div class="widget-content">
                      <div class="w-header">
                          <div class="w-info">
                              <h6 class="value">{{ __('Total Income Today') }}</h6>
                          </div>
                      </div>

                      <div class="w-content">

                          <div class="w-info">
                              <p class="value">{{ $totalToday }} <span>{{ __('this Day') }}</span> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-up"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg></p>
                          </div>

                      </div>
                  </div>
              </div>
          </div>
          @can('view_accounting_report')
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-account-invoice-two">
                    <div class="widget-content">
                        <div class="account-box">
                            <div class="info">
                                <div class="inv-title">
                                    <h5 class="">{{__('Total Balance') }}</h5>
                                </div>
                                <div class="inv-balance-info">

                                    <p class="inv-balance">{{ $paid }} EGP</p>

                                    <span class="inv-stats balance-credited">+ {{ $due }}</span>

                                </div>
                            </div>
                            <div class="acc-action">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endcan

            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-card-four">
                    <div class="widget-content">
                        <div class="w-header">
                            <div class="w-info">
                                <h6 class="value">{{ __('Expenses') }}</h6>
                            </div>
                        </div>

                        <div class="w-content">

                            <div class="w-info">
                                <p class="value">{{ $expenses }} <span>{{ __('this week') }}</span> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-up"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg></p>
                            </div>

                        </div>

                        <div class="w-progress-stats">
                            <div class="progress">
                                <div class="progress-bar bg-gradient-secondary" role="progressbar" style="width: {{ (int)($persentageOfCustoday) }}%" aria-valuenow="{{ $persentageOfCustoday }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                            <div class="">
                                <div class="w-icon">
                                    <p>{{ round($persentageOfCustoday,2) }}%</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </br>
        <div class="col-xl-9 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-chart-three">
                <div class="widget-heading">
                    <div class="">
                        <h5 class="">{{ __('Latest Updates') }}</h5>
                    </div>

                    <div class="dropdown ">

                    </div>
                </div>

                <div class="widget-content">
                    <div id="" style="padding: 20px;">
                        <strong>{{__('Changelog in Stop4Labs Version 2.0.1 (18 Oct 2022)') }}</strong>
                    </br>
                            <ul><strong>{{__('Update:')}}</strong> {{__('New Design Availble') }}</ul>
                            <ul><strong>{{__('Added')}}:</strong> {{__('Custody and Valut module') }} </ul>
                            <ul><strong>{{__('Update:')}}</strong> {{__('Cancel test and Retrieve Invoice') }}  </ul>
                            <ul><strong>{{__('Update:')}}</strong> {{__('Patient registeration form') }}</ul>
                            <ul><strong>{{__('Update:')}}</strong> {{__('Add Increased In and Decreased In in test details') }} </ul>
                            <ul><strong>{{__('Added')}}:</strong> {{__('Print all report in same page or seperate each one as a option') }}</ul>
                            <ul><strong>{{__('Update:')}}</strong> {{__('Add Min and Max Value to test result') }}</ul>
                            <ul><strong>{{__('Update:')}}</strong> {{__('Expense Details and automaticly deduct from branch custody') }}</ul>
                            <ul><strong>{{__('Update:')}}</strong> {{__('Workload Monthly and daily report') }}</ul>
                            <ul><strong>{{__('Update:')}}</strong> {{__('Testes branch report') }}</ul>
                            <ul><strong>{{__('Update:')}}</strong> {{__('Expenses full report') }}</ul>














                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-activity-five">

                <div class="widget-heading">
                    <h5 class="">{{ __('System Tutorial') }}</h5>

                </div>

                <div class="widget-content">

                    <div class="w-shadow-top"></div>

                    <div class="mt-container mx-auto">
                        <div class="timeline-line">

                              <div class="item-timeline timeline-new">
                                <div class="t-dot">
                                    <div class="t-secondary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></div>
                                </div>
                                <div class="t-content">
                                    <div class="t-uppercontent">
                                        <h5>{{__('Respetion') }}: <a href="https://drive.google.com/file/d/182eDGvRG_O93azIPRvHpCgXjxQAJaZ5M/view?usp=share_link"><span>{{__('Respetion Module') }}</span></a></h5>
                                    </div></br>
                                    <p> <iframe src="https://drive.google.com/file/d/182eDGvRG_O93azIPRvHpCgXjxQAJaZ5M/preview" width="100%" allow="autoplay"></iframe></p>
                                </div>
                              </div>

                              <div class="item-timeline timeline-new">
                                <div class="t-dot">
                                    <div class="t-secondary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></div>
                                </div>
                                <div class="t-content">
                                    <div class="t-uppercontent">
                                        <h5>{{__('Medical Reports') }}: <a href="javscript:void(0);"><span>{{__('Medical reports & Tests & Cultures & Price lists')}}</span></a></h5>
                                    </div></br>
                                    <p> <iframe src="https://drive.google.com/file/d/16PrNIJm2OzcVpfBAuyj8hlgTYlhFN-S-/preview" width="100%" allow="autoplay"></iframe> </p>
                                </div>
                              </div>

                              <div class="item-timeline timeline-new">
                                <div class="t-dot">
                                    <div class="t-secondary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></div>
                                </div>
                                <div class="t-content">
                                    <div class="t-uppercontent">
                                        <h5>{{__('Accountant & inventory') }}: <a href="javscript:void(0);"><span>{{__('Accountant (contarcts-inventory-accounting-reporting-branches & custody') }}</span></a></h5>
                                    </div></br>
                                    <p> <iframe src="https://drive.google.com/file/d/1cFtbXtF_I1Cwsj0Tci-HlekCPjre9KUJ/preview" width="100%" allow="autoplay"></iframe> </p>
                                </div>
                              </div>

                              <div class="item-timeline timeline-new">
                                <div class="t-dot">
                                    <div class="t-secondary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></div>
                                </div>
                                <div class="t-content">
                                    <div class="t-uppercontent">
                                        <h5>{{__('HR & Users') }}: <a href="javscript:void(0);"><span>{{__('HR & Users - Rules module + chat')}}</span></a></h5>
                                    </div></br>
                                    <p><iframe src="https://drive.google.com/file/d/1On2GUnHsoZ_S8QzwCNz9Z2GKu11v1zbn/preview" width="100%" allow="autoplay"></iframe> </p>
                                </div>
                              </div>

                              <div class="item-timeline timeline-new">
                                <div class="t-dot">
                                    <div class="t-secondary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></div>
                                </div>
                                <div class="t-content">
                                    <div class="t-uppercontent">
                                        <h5>{{__('Mobile app & Visits module') }}: <a href="javscript:void(0);"><span>{{__('How to Control your mobile app and visits')}}</span></a></h5>
                                    </div></br>
                                    <p> <iframe src="https://drive.google.com/file/d/14zmAERPV4Zuc5ayuAkR5scpMkfQjTkYC/preview" width="100%" allow="autoplay"></iframe> </p>
                                </div>
                              </div>



                        </div>
                    </div>

                </div>
            </div>
        </div>
</div>

</div>

@endsection

@section('scripts')
  <!-- Switch -->
  <script src="{{url('plugins/swtich-netliva/js/netliva_switch.js')}}"></script>


<script src="{{url('js/admin/dashboard.js')}}"></script>
<script src="{{url('new_design/assets/js/custom.js')}}"></script>
<script src="{{url('new_design/plugins/apex/apexcharts.min.js')}}"></script>
<script src="{{url('new_design/assets/js/dashboard/dash_2.js')}}"></script>

@endsection
