@extends('layouts.app')

@section('title')
{{__('Create Branch Custody')}}
@endsection

@section('breadcrumb')
            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item "><a href="{{route('admin.branches_custody.index')}}">{{__('Branches Custody')}}</a></li>
            <li class="breadcrumb-item active">{{__('Create Branch Custody')}}</li>
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title"></h3>
    </div>
    <form method="POST" action="{{route('admin.branches_custody.store')}}">
        <!-- /.card-header -->
        <div class="card-body">
            @csrf
            @include('admin.branch_custody._form')
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
