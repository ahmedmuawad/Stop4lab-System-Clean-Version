@extends('layouts.app')

@section('title')
{{__('Branches Custody')}}
@endsection

@section('breadcrumb')
          <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
          <li class="breadcrumb-item active">{{__('Branches Custody')}}</li>
@endsection

@section('content')
<div class="card card-primary card-outline">
  <div class="card-header">
    <h3 class="card-title">
    </h3>
    @can('create_branch')
    <a href="{{route('admin.branches_custody.create')}}" class="btn btn-primary btn-sm float-right">
        <i class="fa fa-plus"></i> {{__('Create')}}
    </a>
    @endcan
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <div class="row">
      <div class="col-lg-12 table-responsive">
        <table id="branches_custody_table" class=" table table-striped table-bordered"  width="100%">
          <thead>
            <tr>
              <th width="10px">
                <input type="checkbox" class="check_all" name="" id="">
              </th>
              <th width="10px">#</th>
              <th>{{__('Branch')}}</th>
              <th>{{__('Custody')}}</th>
              <th>{{__('Type')}}</th>
              <th>{{__('Date')}}</th>
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

    <!-- /.card-header -->
    <div class="card-body">
      <div class="row">
        <div class="col-lg-12 table-responsive">
          <table id="pending_custody_table" class=" table table-striped table-bordered"  width="100%">
            <thead>
              <tr>
                <th width="10px">#</th>
                <th>{{__('Branch')}}</th>
                <th>{{__('Custody')}}</th>
                <th>{{__('Requested By')}}</th>
                <th>{{__('Date')}}</th>
                <th width="100px">{{__('Action')}}</th>
              </tr>
            </thead>
            <tbody>
  
              @foreach ($requsts as $item)
                  <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->branche->name }}</td>
                    <td>{{ $item->custody }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td>
                        <a href="{{route('admin.branches_custody_accept',$item['id'])}}" class="btn btn-primary btn-sm">
                          {{ __('Accept') }}
                        </a>
                        <a href="{{route('admin.branches_custody_refuse',$item['id'])}}" class="btn btn-danger btn-sm">
                          {{ __('Refuse') }}
                        </a>
                    </td>
                  </tr>
              @endforeach
  
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
    var can_delete=@can('delete_branch')true @else false @endcan
  </script>
  <script src="{{url('js/admin/branches_custody.js')}}"></script>
@endsection
