@extends('layouts.app')

@section('title')
{{__('Expense Categories')}}
@endsection

@section('breadcrumb')
          <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
          <li class="breadcrumb-item active">{{__('Expense Categories')}}</li>
@endsection

@section('content')
<div class="card card-primary card-outline">
  <div class="card-header">
    <h3 class="card-title"></h3>
    @can('create_antibiotic')
    <a href="{{route('admin.expense_categories.create')}}" class="btn btn-primary btn-sm float-right">
     <i class="fa fa-plus"></i> {{__('Create')}}
    </a>
    @endcan
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <div class="row">
      <div class="col-lg-12 table-responsive">
        <table id="expense_categories_table" class=" table table table-striped table-bordered" width="100%">
          <thead>
            <tr>
              <th width="10px">
                <input type="checkbox" class="check_all" name="" id="">
              </th>
              <th width="10px">#</th>
              <th>{{__('Category')}}</th>
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
    var can_delete=@can('delete_expense_category')true @else false @endcan
  </script>
  <script src="{{url('js/admin/expense_categories.js')}}"></script>
@endsection
