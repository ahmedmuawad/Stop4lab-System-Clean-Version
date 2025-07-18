@extends('layouts.app')

@section('title')
{{ __('Edit home visit') }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{url('plugins/datetimepicker/css/jquery.datetimepicker.min.css')}}">
@endsection

@section('breadcrumb')
                    <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
                    <li class="breadcrumb-item">
                        <a href="{{route('admin.users.index')}}">{{ __('Home visits') }}</a>
                    </li>
                    <li class="breadcrumb-item active">{{ __('Edit home visit') }}</li>

@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"></h3>
    </div>
    <!-- /.card-header -->
    <form method="POST" action="{{route('admin.visits.update',$visit['id'])}}" enctype="multipart/form-data"  id="visit_form">
        @csrf
        @method('put')
        <div class="card-body">
            <div class="col-lg-12">
                @include('admin.visits._form')
            </div>
        </div>
        <div class="card-footer">
            <div class="col-lg-12">
                <button type="submit" class="btn btn-primary">
                  <i class="fa fa-check"></i>  {{__('Save')}}
                </button>
            </div>
        </div>
    </form>

    <!-- /.card-body -->
</div>

@include('admin.visits._patient_modal')

@endsection
@section('scripts')
    <script src="{{url('plugins/datetimepicker/js/jquery.datetimepicker.full.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{$api_keys['google_map']}}&callback=initMapEdit&libraries=places&v=weekly" defer></script>
    <script src="{{url('js/admin/visits.js')}}"></script>
@endsection
