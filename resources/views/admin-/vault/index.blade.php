@extends('layouts.app')

@section('title')
    {{__('Vault')}}
@endsection


@section('content')
<div class="app-content content ">
<div class="card card-primary card-outline">
    <div class="card-header">
        <h4>
            {{__('Vault')}}
        </h4>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
       <div class="col-lg-12 table-responsive">
          <table id="vault_table" class=" table table table-striped table-bordered"  width="100%">
            <thead>
            <tr>
              <th width="10px">
                <input type="checkbox" class="check_all" name="" id="">
              </th>
              <th width="10px">#</th>
              <th>{{__('employee')}}</th>
              <th>{{__('Start Time')}}</th>
              <th>{{__('End Time')}}</th>
              <th>{{__('Receipt Cash')}}</th>
              <th>{{__('Export Cash')}}</th>
              <th>{{__('Branch')}}</th>
              <th>{{__('Details')}}</th>
              <th>{{__('Notes')}}</th>
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
    var can_delete=@can('delete_violations')true @else false @endcan
  </script>
  <script src="{{url('js/admin/vault.js')}}"></script>
@endsection
