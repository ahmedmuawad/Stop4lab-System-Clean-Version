@extends('layouts.app')

@section('title')
    {{__('Vocations')}}
@endsection
@section('breadcrumb')
                    <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
                    <li class="breadcrumb-item active">{{ __('Vocations') }}</li>
@endsection

@section('content')
<div class="app-content content ">
<div class="card card-primary card-outline">
    <div class="card-header">
      <h3 class="card-title">
      </h3>
      {{-- @can('create_hr')
        <a href="{{route('admin.vocations.create')}}" class="btn btn-primary btn-sm float-right">
          <i class="fa fa-plus"></i> {{ __('Create') }}
        </a>
      @endcan --}}
    </div>
    <!-- /.card-header -->
    <div class="card-body">
       <div class="col-lg-12 table-responsive">
          <table id="reports_table" class=" table table table-striped table-bordered"  width="100%">
            <thead>
            <tr>
              <th width="10px">
                <input type="checkbox" class="check_all" name="" id="">
              </th>
              <th width="10px">#</th>
              <th>{{__('Employee')}}</th>
              <th>{{__('From')}}</th>
              <th>{{__('To')}}</th>
              <th>{{__('durations')}}</th>
              <th>{{__('day')}}</th>
              <th>{{__('Notes')}}</th>
              <th>{{__('Type')}}</th>
              <th>{{__('Status')}}</th>
              <th>{{__('Date')}}</th>
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
</div>

  @endsection
@section('scripts')
  <script>
    var can_delete=@can('delete_vocations')true @else false @endcan
  </script>
  <script src="{{url('js/admin/vocations.js')}}"></script>
@endsection
