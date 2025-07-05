@extends('layouts.app')

@section('title')
    {{__('Safe Transfers')}}
@endsection

@section('breadcrumb')
            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item active">{{__('Safe Transfers')}}</li>
            @endsection

@section('content')

<div class="card card-primary card-outline">
    <div class="card-header">
      <h3 class="card-title">
        {{__('Safe Transfers table')}}
      </h3>
      @can('create_category')
        <a href="{{route('admin.safe_transfer.create')}}" class="btn btn-primary btn-sm float-right">
          <i class="fa fa-plus"></i> {{ __('Create') }}
        </a>
      @endcan
    </div>
    <!-- /.card-header -->
    <div class="card-body">
       <div class="col-lg-12 table-responsive">
          <table id="end_transfer_table" class="table table-striped table-bordered"  width="100%">
            <thead>
            <tr>
              
              <th width="10px">#</th>
              <th>{{__('From Branch')}}</th>
              <th>{{__('To Branch')}}</th>
              <th>{{__('From User')}}</th>
              <th>{{__('To User')}}</th>
              <th>{{__('Amount')}}</th>
              <th>{{__('From')}} : {{ ('To') }}</th>
              <th>{{ __('Send Date') }}</th>
              <th width="300px">{{__('Action')}}</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
       </div>
    </div>
    <!-- /.card-body -->
  </div>

@endsection
@section('scripts')
  <script>
    var can_delete=@can('delete_category')true @else false @endcan
  </script>
  <script src="{{url('js/admin/safe_transfer.js')}}"></script>
@endsection
