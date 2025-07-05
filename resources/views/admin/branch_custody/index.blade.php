@extends('layouts.app')

@section('title')
{{__('Branches Custody')}}
@endsection

@section('breadcrumb')
          <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
          <li class="breadcrumb-item active">{{__('Branches Custody')}}</li>
@endsection

@section('content')
<div class="card card-primary card-outline">
  <div class="card-header">
    <h3 class="card-title">
    </h3>
    @can('create_branch')
    <a href="{{route('admin.branches_custody.create')}}" class="btn btn-primary btn-sm float-right">
        <i class="fa fa-plus"></i> {{__('Create')}}
    </a>
    @endcan
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <div class="row">
      <div class="col-lg-12 table-responsive">
        <table id="branches_custody_table" class=" table table-striped table-bordered"  width="100%">
          <thead>
            <tr>
              <th width="10px">
                <input type="checkbox" class="check_all" name="" id="">
              </th>
              <th width="10px">#</th>
              <th>{{__('Branch')}}</th>
              <th>{{__('Custody')}}</th>
              <th>{{__('Type')}}</th>
              <th>{{__('Date')}}</th>
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


  <div class="row">
    @foreach ($branches as $branche)
        <div class="btn btn-success col-4">
            {{ $branche->name }} 
            {{ __('Cach') }}  = {{ formated_price($branche->get_safe) }} <br>
            {{ __('Other (Visa)') }}  {{ formated_price(get_safe_other($branche->id,null))}} <br>
            {{ __('Total trans') }} = {{  formated_price((get_safe_other($branche->id,null) - get_safe_other($branche->id,null) * 0.02) + $branche->get_safe)   }}
        </div>
    @endforeach

    <div class="btn btn-primary col-4">
      {{ __('Main Safe') }} = {{ formated_price(get_main_safe()) }}<br>
      {{ __('Other (Visa)') }} = {{ formated_price(get_main_safe_other()) }}
    </div>

    <div class="btn btn-primary col-4">
      {{ __('Bank') }} = {{  formated_price(get_bank()) }}<br>
      {{ __('Other (Visa)') }} = {{ formated_price(get_bank_other()) }}
    </div>
  </div>

<div class="row">
    <a class="btn btn-warning col-4" href="{{ route('admin.transfer_to_bank') }}">
        {{ __('Transfer Custody To Bank') }} = {{ formated_price(get_total_branches_custody()) }}<br>
    </a>
</div>

  <div class="row">
    @foreach ($branches as $branche)
          @if(get_safe_other($branche->id,null) > 0)
            <a class="btn btn-danger col-4" href="{{ route('admin.convertBranchSafeToVisa',$branche->id) }}">
              {{ $branche->name }} -  {{ __('Transfer From Vist To Cach') }}
            </a>
          @endif
    @endforeach
    @if (get_main_safe_other() > 0)                
      <a class="btn btn-danger col-4" href="{{ route('admin.convertMainSafeToVisa') }}">
        {{ __('Main Safe') }} -  {{ __('Transfer From Vist To Cach') }}
      </a>
    @endif
    @if (get_bank_other() > 0)              
      <a class="btn btn-danger col-4" href="{{ route('admin.convertBankToVisa') }}">
        {{ __('Bank') }} -  {{ __('Transfer From Vist To Cach') }}
      </a>
    @endif
  </div>

    <!-- /.card-header -->
    <div class="card-body">
      <div class="row">
        <div class="col-lg-12 table-responsive">
          <table id="pending_custody_table" class=" table table-striped table-bordered"  width="100%">
            <thead>
              <tr>
                <th width="10px">#</th>
                <th>{{__('Branch')}}</th>
                <th>{{__('Custody')}}</th>
                <th>{{__('Requested By')}}</th>
                <th>{{__('Date')}}</th>
                <th>{{__('Type')}}</th>
                <th width="100px">{{__('Action')}}</th>
              </tr>
            </thead>
            <tbody>
  
              @foreach ($requsts as $item)
                  <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->branche->name }}</td>
                    <td>{{ $item->custody }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td>
                      @if ($item->custody_type == 1)
                          {{ __('Bank') }}
                        @elseif ($item->custody_type == 2)
                          {{ __('From Lab') }}
                        @elseif ($item->custody_type == 3)
                          {{ __('Main Safe') }}
                        @elseif ($item->custody_type == 4)
                          {{ __('Branch Safe') }}
                      @endif
                    </td>
                    <td>
                        <a href="{{route('admin.branches_custody_accept',$item['id'])}}" class="btn btn-primary btn-sm">
                          {{ __('Accept') }}
                        </a>
                        <a href="{{route('admin.branches_custody_refuse',$item['id'])}}" class="btn btn-danger btn-sm">
                          {{ __('Refuse') }}
                        </a>
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
  <script>
    var can_delete=@can('delete_branch')true @else false @endcan
  </script>
  <script src="{{url('js/admin/branches_custody.js')}}"></script>
@endsection
