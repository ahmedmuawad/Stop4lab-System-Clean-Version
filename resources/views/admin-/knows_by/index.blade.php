@extends('layouts.app')

@section('title')
    {{__('knows')}}
@endsection

@section('breadcrumb')
            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item active">{{__('knows')}}</li>
            @endsection

@section('content')

<div class="card card-primary card-outline">
    <div class="card-header">
      <h3 class="card-title">
        {{__('knows table')}}
      </h3>
      @can('create_category')
        <a href="{{route('admin.knows.create')}}" class="btn btn-primary btn-sm float-right">
          <i class="fa fa-plus"></i> {{ __('Create') }}
        </a>
      @endcan
    </div>
    <!-- /.card-header -->
    <div class="card-body">
       <div class="col-lg-12 table-responsive">
          <table id="knows_table" class="table table-striped table-bordered"  width="100%">
            <thead>
            <tr>
              <th width="10px">
                <input type="checkbox" class="check_all" name="" id="">
              </th>
              <th width="10px">#</th>
              <th>{{__('Name')}}</th>
              <th width="100px">{{__('Action')}}</th>
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
    var can_delete=@can('delete_group')true @else false @endcan
  </script>
  <script src="{{url('js/admin/knows.js')}}"></script>
@endsection
