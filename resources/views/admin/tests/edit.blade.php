@extends('layouts.app')

@section('title')
{{__('Edit Test')}}
@endsection
@section('css')
<style>
    .table > tbody > tr > td {
        padding: 10px !important;
    }
</style>
@endsection
@section('breadcrumb')
            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item "><a href="{{route('admin.tests.index')}}">{{__('Tests')}}</a></li>
            <li class="breadcrumb-item active">{{__('Edit Test')}}</li>
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">{{__('Edit Test')}}</h3>
    </div>
    <!-- /.card-header -->
    <form method="POST" action="{{route('admin.tests.update',$test['id'])}}" id="test_form">
        <!-- /.card-header -->
        <div class="card-body">
            @csrf
            @method('put')
            @include('admin.tests._form')
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary"> <i class="fa fa-check"></i> {{__('Save')}}</button>
        </div>
    </form>
    <!-- /.card-body -->
  </div>
  <form action="{{ route('admin.tests.setting_test', $test['id']) }}" method="POST" id="setting_test_{{ $test->id }}">
    @csrf
    @include('admin.tests._settings_modal')
  </form>
@endsection
@section('scripts')
  <script src="{{url('js/admin/tests.js')}}"></script>
@endsection
