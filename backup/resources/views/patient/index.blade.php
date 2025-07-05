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
    <div class="row layout-spacing" style="margin-top: 50px; margin-right: 5px; padding:5px; margin-left: 10px;">

    </div>
</div>


@endsection
@section('scripts')

@endsection
