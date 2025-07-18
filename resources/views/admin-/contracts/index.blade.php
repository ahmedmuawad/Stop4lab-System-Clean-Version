@extends('layouts.app')

@section('title')
{{__('Contracts')}}
@endsection

@section('breadcrumb')
          <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
          <li class="breadcrumb-item active">{{__('Contracts')}}</li>
@endsection

@section('content')
<div class="card card-primary card-outline">
  <div class="card-header">
    <h3 class="card-title"></h3>
    @can('create_contract')
    <a href="{{route('admin.contracts.create')}}" class="btn btn-primary btn-sm float-right">
      <i class="fa fa-plus"></i> {{__('Create')}}
    </a>
    @endcan
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <div class="row">
      <div class="col-lg-12 table-responsive">
        <table id="contracts_table" class="table table-striped table-bordered" width="100%">
          <thead>
            <tr>
              <th width="10px">
                <input type="checkbox" class="check_all" name="" id="">
              </th>
              <th width="10px">#</th>
              <th>{{__('Title')}}</th>
              <th>المنطقة</th>
              <th>المحافظة</th>
              <th width="100px">{{__('Action')}}</th>
            </tr>
          </thead>
          <tbody>

          </tbody>

        </table>
      </div>
    </div>
  </div>
  <!-- /.card-body -->
</div>
@endsection

@section('scripts')
  <script>
    var can_delete=@can('delete_contract')true @else false @endcan
  </script>
  <script src="{{url('js/admin/contracts.js')}}"></script>
@endsection
