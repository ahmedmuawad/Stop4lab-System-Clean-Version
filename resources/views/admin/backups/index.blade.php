@extends('layouts.app')

@section('title')
    {{__('Backups')}}
@endsection

@section('breadcrumb')
          <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
          <li class="breadcrumb-item active">{{__('Database Backups')}}</li>

@endsection

@section('content')
<div class="card card-primary card-outline">
  <div class="card-header">
    <h3 class="card-title">
      {{__('Backups Table')}}
    </h3>
    @can('create_backup')
    <a href="{{route('admin.backups.create')}}" class="btn btn-primary btn-sm float-right">
        <i class="fa fa-plus"></i> {{__('Create Database Backup')}}
    </a>
    @endcan
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <div class="row table-responsive">
      <div class="col-12">
        <table id="example1" class=" table table table-striped table-bordered">
          <thead>
            <tr>
              <th>{{__('Backup')}}</th>
              <th>{{__('Date')}}</th>
              <th width="100px">{{__('Action')}}</th>
            </tr>
          </thead>
          <tbody>
              @foreach($backups as $backup)
              <tr>
                <td>{{$backup->getFilename()}}</td>
                <td>{{date('Y-m-d',$backup->getATime())}}</td>
                <td>
                    @can('view_backup')
                      <a href="{{route('admin.backups.show',$backup->getFilename())}}" class="btn btn-primary btn-sm">
                        <i class="fa fa-download"></i>
                      </a>
                    @endif

                    @can('delete_backup')
                      <form action="{{route('admin.backups.destroy',$backup->getFilename())}}" class="d-inline" method="POST">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger btn-sm delete_backup">
                          <i class="fa fa-trash"></i>
                        </button>
                      </form>
                    @endcan

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
  <script src="{{url('js/admin/backups.js')}}"></script>
@endsection
