@extends('layouts.app')

@section('title')
{{__('Expenses')}}
@endsection

@section('breadcrumb')
          <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
          <li class="breadcrumb-item active">{{__('Expenses')}}</li>
@endsection

@section('content')
<div class="card card-primary card-outline">
  <div class="card-header">
    <h3 class="card-title"></h3>
   
    <a href="{{route('admin.expenses.create')}}" class="btn btn-primary btn-sm float-right">
     <i class="fa fa-plus"></i> {{__('Create')}}
    </a>
  
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <div class="row table-responsive">
                  <!-- filter -->

                  <div id="accordion">

                    <div class="card card-info">

                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="btn btn-primary collapsed"

                            aria-expanded="false">

                            <i class="fas fa-filter"></i> {{ __('Filters') }}

                        </a>

                        <div id="collapseOne" class="panel-collapse in collapse">

                            <div class="card-body">

                                <div class="row">

                                    <div class="col-lg-3">

                                        <div class="form-group">

                                            <label for="filter_date">{{ __('Date') }}</label>

                                            <input type="text" class="form-control" id="filter_date"

                                                placeholder="{{ __('Date') }}">

                                        </div>

                                    </div>

                                    <div class="col-lg-3">

                                        <div class="form-group">

                                            <label for="filter_category">{{ __('Category') }}</label>

                                            <select name="filter_category" id="filter_category" class="form-control select2">
                                              <option selected disabled>{{ __('Select') }}</option>
                                              @foreach($expense_categories as $category)
                                                <option value="{{$category['id']}}">{{$category['name']}}</option>
                                              @endforeach
                                            </select>

                                        </div>

                                    </div>

                                    <div class="col-lg-3">

                                        <div class="form-group">

                                            <label for="filter_branch">{{ __('Branch') }}</label>

                                            <select name="filter_branch" id="filter_branch"

                                                class="form-control select2">
                                                <option selected disabled>{{ __('Select') }}</option>
                                                @foreach($branchs as $branch)
                                                  <option value="{{$branch['id']}}">{{$branch['name']}}</option>
                                                @endforeach
                                            </select>

                                        </div>

                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- \filter -->
      <div class="col-12">
        <table id="expenses_table" class=" table table table-striped table-bordered"  width="100%">
          <thead>
            <tr>
              <th width="10px">
                <input type="checkbox" class="check_all" name="" id="">
              </th>
              <th width="10px">#</th>
              <th>{{__('Category')}}</th>
              <th>{{__('Date')}}</th>
              <th>{{__('Amount')}}</th>
              <th width="150px">{{__('Payment method')}}</th>
              <th>{{__('Notes')}}</th>
              <th>{{__('By')}}</th>
              <th>{{__('Source')}}</th>
              <th>{{__('Created_at')}}</th>
              <th>{{__('Custody')}}</th>
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
    var can_delete=@can('delete_expense')true @else false @endcan
  </script>
  <script src="{{url('js/admin/expenses.js')}}"></script>
@endsection
