@extends('layouts.app')

@section('title')
{{__('Culture options')}}
@endsection

@section('breadcrumb')
            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item active">{{__('Culture options')}}</li>
@endsection

@section('content')
<div class="card card-primary card-outline">
    <div class="card-header">
      <h3 class="card-title">{{__('Culture options Table')}}</h3>
      @can('create_culture_option')
      <a href="{{route('admin.culture_options.create')}}" class="btn btn-primary btn-sm float-right">
        <i class="fa fa-plus"></i>  {{__('Create')}}
      </a>
      @endcan
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <div class="row">
        <div class="col-12">
          <table id="culture_options_table" class=" table table-striped table-bordered"  width="100%">
            <thead>
              <tr>
                <th width="10px">
                  <input type="checkbox" class="check_all" name="" id="">
                </th>
                <th width="10px">#</th>
                <th>{{__('Option')}}</th>
                <th width="80px">{{__('Action')}}</th>
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
    var can_delete=@can('delete_culture_option')true @else false @endcan
  </script>
  <script src="{{url('js/admin/culture_options.js')}}"></script>
@endsection
