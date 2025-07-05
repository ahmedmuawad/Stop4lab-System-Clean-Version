@extends('layouts.app')
@section('title')
{{__('Tests')}}
@endsection
@section('breadcrumb')
        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
        <li class="breadcrumb-item active">{{__('Tests')}}</li>
@endsection

@section('content')
<div class="card card-primary card-outline">
    <div class="card-header">
      <h3 class="card-title">{{__('Tests Table')}}</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <div class="row">
       {{-- <div class="table-responsive"> --}}
        {{-- <table id="tests_table" class="table table-striped table-bordered"  width="100%"> --}}
            <div class="table-responsive">
                <table id="example2" class="table table-striped datatable table-bordered">
            {{-- <table id="example2" class="table table-striped  datatable table-bordered"> --}}
          
        <thead>
            <tr class="text-center">
                <th># </th>
                  <th>@lang('egs-code') </th>
                  <th>@lang('gpc_code') </th>
                  <th>@lang('status') </th>
                  <th>@lang('name_ar') </th>
                  <th>@lang('desc_ar') </th>
                  <th>@lang('name_en') </th>
                  <th>@lang('desc_en') </th>
                  <th>@lang('active_from') </th>
                  <th>@lang('active_to') </th>
              </tr>
          </thead>
          <tbody>
                @foreach($culturies as $index=>$cuture)
            <tr style="height:40px" class="text-center">

                <td style="white-space: nowrap;">{{ $index + 1}}</td>
                <td style="white-space: nowrap;">{{ $cuture['itemCode']}}</td>
                <td style="white-space: nowrap;">{{ $cuture['parentItemCode']}}</td>
                @if($cuture['status'] === "Approved")
                <td style="white-space: nowrap;">@lang('Approved')</td>
                @else
                <td style="white-space: nowrap;">@lang('pending')</td>
                
                @endif
                <td style="white-space: nowrap;">{{ $cuture['codeNameSecondaryLang']}}</td>
                <td style="white-space: nowrap;">{{ $cuture['descriptionSecondaryLang']}}</td>
                <td style="white-space: nowrap;">{{ $cuture['codeNamePrimaryLang']}}</td>
                <td style="white-space: nowrap;">{{ $cuture['descriptionPrimaryLang']}}</td>
                <td style="white-space: nowrap;">{{ \Carbon\Carbon::parse($cuture['activeFrom'])->format('d-m-Y')}}</td>
                @if($cuture['activeTo'] == NULL)
                <td>--</td>
                @else
                <td style="white-space: nowrap;">{{ \Carbon\Carbon::parse($cuture['activeTo'])->format('d-m-Y')}}</td>
                @endif
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
    var can_delete=@can('delete_test')true @else false @endcan
  </script>
  {{-- <script src="{{url('js/admin/tests.js')}}"></script> --}}
@endsection
