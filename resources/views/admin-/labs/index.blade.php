@extends('layouts.app')

@section('title')
{{__('Labs users')}}
@endsection

@section('breadcrumb')
          <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
          <li class="breadcrumb-item active">{{__('Labs users')}}</li>
@endsection

@section('content')
<div class="app-content content ">
  <div class="content-overlay"></div>
  <div class="header-navbar-shadow"></div>
  <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body">
        <section class="invoice-list-wrapper">
            <div class="card">
                <section id="advanced-search-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h4 class="card-title">{{__('Labs users')}}</h4>
                                @can('create_role')
                                  <a href="{{route('admin.labs.create')}}" class="btn btn-primary btn-sm float-right">
                                      <i class="fa fa-plus"></i> {{ __('Create') }}
                                  </a>
                                @endcan
                            </div>
                            <hr class="my-0">
                            <div class="card-datatable">
                                <div id="DataTables_Table_2_wrapper" class="dataTables_wrapper dt-bootstrap4 table-responsive"><table class="table table-striped table-bordered" id="labs_table" role="grid" aria-describedby="DataTables_Table_2_info">
                                    <thead>
                                        <tr role="row">
                                          <th width="10px">
                                            <input type="checkbox" class="check_all" name="" id="">
                                          </th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_2" rowspan="1" colspan="1" style="width: 138.688px;" aria-label="#: activate to sort column ascending">#</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_2" rowspan="1" colspan="1" style="width: 142.438px;" aria-label="Created By: activate to sort column ascending">{{__('Name')}}</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_2" rowspan="1" colspan="1" style="width: 142.438px;" aria-label="Created By: activate to sort column ascending">{{__('Email')}}</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_2" rowspan="1" colspan="1" style="width: 142.438px;" aria-label="Created By: activate to sort column ascending">{{__('Code')}}</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_2" rowspan="1" colspan="1" style="width: 128.844px;" aria-label="Barcode: activate to sort column ascending">{{__('Action')}}</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                        </tr>
                                    </tfoot>
                              </table>
                            </div>
                            <!--Search Form -->
                        </div>
                    </div>
                </div>
            </section>
            </div>
        </section>
      </div>
  </div>
</div>
{{-- <div class="card card-primary card-outline">
  <div class="card-header">
    <h3 class="card-title">{{__('Labs Table')}}</h3>
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <div class="row">
      <div class="col-lg-12 table-responsive">
        <table id="labs_table" class="table table-striped table-bordered" width="100%">
          <thead>
            <tr>
              <th width="10px">
                <input type="checkbox" class="check_all" name="" id="">
              </th>
              <th width="10px">#</th>
              <th>{{__('Name')}}</th>
              <th>{{__('Email')}}</th>
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
</div> --}}
@endsection

@section('scripts')
<script>
    var can_delete=@can('delete_contract')true @else false @endcan
  </script>
  <script src="{{url('js/admin/labs.js')}}"></script>
@endsection
