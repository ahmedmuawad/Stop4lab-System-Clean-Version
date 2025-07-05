@extends('layouts.app')

@section('title')
{{__('Create Branch')}}
@endsection

@section('breadcrumb')
            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item "><a href="{{route('admin.branches.index')}}">{{__('Branches')}}</a></li>
            <li class="breadcrumb-item active">{{__('Create Branch')}}</li>
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title"></h3>
    </div>
    <form method="POST" action="{{route('admin.branches.store')}}" id="branch_form">
        <!-- /.card-header -->
        <div class="card-body">
            @csrf
            @include('admin.branches._form')
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
              <i class="fa fa-check"></i> {{__('Save')}}
            </button>
        </div>
    </form>

</div>
@endsection
@section('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key={{$api_keys['google_map']}}&callback=initMap&libraries=&v=weekly" defer></script>
<script src="{{url('js/admin/branches.js')}}"></script>
@endsection
