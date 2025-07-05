@extends('layouts.app')

@section('title')
    {{__('Safe Transfers')}}
@endsection

@section('breadcrumb')
            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item active">{{__('Safe Transfers')}}</li>
            @endsection

@section('content')

<div class="card card-primary card-outline">

  <form action="{{ route('admin.safe_transfer.index') }}" type="get">
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

                            <input type="text" class="form-control" id="filter_date" name="filter_date"

                                placeholder="{{ __('Date') }}">

                        </div>

                    </div>

                    <div class="col-lg-3">

                        <div class="form-group">

                            <label for="filter_from_branch">{{ __('From Branch') }}</label>

                            <select name="filter_from_branch" id="filter_from_branch" class="form-control branch_id">

                            </select>

                        </div>

                    </div>

                    <div class="col-lg-3">

                        <div class="form-group">

                            <label for="filter_to_branch">{{ __('To Branch') }}</label>

                            <select name="filter_to_branch" id="filter_to_branch"

                                class="form-control branch_id">

                            </select>

                        </div>

                    </div>

                    <div class="col-lg-3">

                        <div class="form-group">

                            <label for="filter_from_user">{{ __('From User') }}</label>

                            <select name="filter_from_user" id="filter_from_user" class="form-control user_id">

                            </select>

                        </div>

                    </div>

                    <div class="col-lg-3">

                        <div class="form-group">

                            <label for="filter_to_user">{{ __('To User') }}</label>

                            <select name="filter_to_user" id="filter_to_user" class="form-control user_id">

                            </select>

                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>

    <button type="submit" class="btn btn-primary ">
        send
    </button>
  </div>
</form>
    <div class="card-header">
      <h3 class="card-title">
        {{__('Safe Transfers table')}}
      </h3>
      @can('create_safe')
        <a href="{{route('admin.safe_transfer.create')}}" class="btn btn-primary btn-sm float-right">
          <i class="fa fa-plus"></i> {{ __('Create') }}
        </a>
      @endcan
    </div>
    <!-- /.card-header -->
    <div class="card-body">
       <div class="col-lg-12 table-responsive">
          <table id="safe_transfer_table" class="table table-striped table-bordered"  width="100%">
            <thead>
            <tr>
              
              @if ($type == "all")<th width="10px"></th>@endif
              <th width="10px">#</th>
              <th>{{__('From Branch')}}</th>
              <th>{{__('To Branch')}}</th>
              <th>{{__('From User')}}</th>
              <th>{{__('To User')}}</th>
              <th>{{__('Amount')}}</th>
              <th>{{__('From')}} : {{ ('To') }}</th>
              <th>{{ __('Send Date') }}</th>
              <th width="200px">{{__('Action')}}</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
       </div>
    </div>
    <!-- /.card-body -->

    {{-- @if ($type == "main")
      <div class="card-footer">
          {{ __("Total In Bank ") }} =  {{ $total }}  {{ get_currency() }} <br>
          {{ __("Total In Bank Other") }} =  {{ get_bank_other() }}  {{ get_currency() }}
      </div>
    @endif

    <div class="card-footer">
      <div class="total_cach">

      </div>
      {{ __("Total Cach ") }} =  {{ $totalCach }}  {{ get_currency() }} <br>
      {{ __("Total Other ") }} =  {{ $totalOther }}  {{ get_currency() }}
    </div> --}}

  </div>

@endsection
@section('scripts')
  <script>
    var can_delete=@can('delete_category')true @else false @endcan
  </script>

    <script src="{{url('js/admin/safe_transfer_refused.js')}}"></script>

@endsection
