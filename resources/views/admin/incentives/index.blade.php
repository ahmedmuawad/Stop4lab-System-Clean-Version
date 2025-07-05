@extends('layouts.app')

@section('title')
    {{__('Employees')}}
@endsection
@section('breadcrumb')
                    <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
                    <li class="breadcrumb-item active">{{ __('incentives') }}</li>
@endsection

@section('content')
<div class="app-content content ">
  {{-- @include('partials.validation_errors') --}}
<div class="card card-primary card-outline">
    <div class="card-header">
      <h3 class="card-title">
      </h3>
      @can('create_hr')
        <a href="{{route('admin.incentives.create')}}" class="btn btn-primary btn-sm float-right">
          <i class="fa fa-plus"></i> {{ __('Create') }}
        </a>
      @endcan
    </div>
    <!-- /.card-header -->
    <div class="card-body">
       <div class="col-lg-12 table-responsive">
          <table id="incentives_table" class=" table table table-striped table-bordered"  width="100%">
            <thead>
            <tr>
              <th width="10px">
                <input type="checkbox" class="check_all" name="" id="">
              </th>
              <th width="10px">#</th>
              <th>{{__('Type')}}</th>
              {{-- <th>{{__('Job')}}</th> --}}
              <th>{{__('Period')}}</th>
              <th>{{__('Target')}}</th>
              <th>{{__('Precentage')}}</th>
              <th>
                {{__('branch_id')}}
              </th>
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
    var can_delete=@can('delete_hr')true @else false @endcan
  </script>
  <script src="{{url('js/admin/incentives.js')}}"></script>
@endsection
