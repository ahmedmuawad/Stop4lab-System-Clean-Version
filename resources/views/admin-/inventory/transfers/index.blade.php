@extends('layouts.app')

@section('title')
{{__('Transfers')}}
@endsection

@section('breadcrumb')
          <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
          <li class="breadcrumb-item active">{{__('Transfers')}}</li>

@endsection

@section('content')
<div class="card card-primary card-outline">
  <div class="card-header">
    <h3 class="card-title"></h3>
    @can('create_transfer')
    <a href="{{route('admin.inventory.transfers.create')}}" class="btn btn-primary btn-sm float-right">
     <i class="fa fa-plus"></i> {{__('Create')}}
    </a>
    @endcan
  </div>
  <!-- /.card-header -->
  <div class="card-body">

    <div class="row table-responsive">
      <div class="col-12">
        <table id="transfers_table" class="table table-striped table-bordered"  width="100%">
          <thead>
            <tr>
              <th width="10px">
                <input type="checkbox" class="check_all" name="" id="">
              </th>
              <th width="10px">#</th>
              <th>{{__('Date')}}</th>
              <th>{{__('From branch')}}</th>
              <th>{{__('To branch')}}</th>
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
    var can_delete=@can('delete_transfer')true @else false @endcan
  </script>
  <script src="{{url('js/admin/transfers.js')}}"></script>
@endsection
