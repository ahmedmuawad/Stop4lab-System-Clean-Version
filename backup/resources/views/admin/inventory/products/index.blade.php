@extends('layouts.app')

@section('title')
{{__('Products')}}
@endsection

@section('breadcrumb')
          <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
          <li class="breadcrumb-item active">{{__('Products')}}</li>
@endsection

@section('content')
<div class="card card-primary card-outline">
  <div class="card-header">
    <h3 class="card-title"></h3>
    @can('create_product')
    <a href="{{route('admin.inventory.products.create')}}" class="btn btn-primary btn-sm float-right">
     <i class="fa fa-plus"></i> {{__('Create')}}
    </a>
    @endcan
  </div>
  <!-- /.card-header -->
  <div class="card-body">

    <div class="row table-responsive">
      <div class="col-12">
        <table id="products_table" class="table table-striped table-bordered"  width="100%">
          <thead>
            <tr>
              <th width="10px">
                <input type="checkbox" class="check_all" name="" id="">
              </th>
              <th width="10px">#</th>
              <th>{{__('Name')}}</th>
              <th>{{__('SKU')}}</th>
              <th>النوع</th>
              <th width="10px">{{__('Initial')}}</th>
              <th width="10px">{{__('Purchases')}}</th>
              <th width="10px">{{__('In')}}</th>
              <th width="10px">{{__('Out')}}</th>
              <th width="10px">{{__('Consumption')}}</th>
              <th width="10px">{{__('Stock')}}</th>
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
    var can_delete=@can('delete_product')true @else false @endcan
  </script>
  <script src="{{url('js/admin/products.js')}}"></script>
@endsection
