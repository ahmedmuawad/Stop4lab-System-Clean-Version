@extends('layouts.app')

@section('title')
{{__('Create Contract')}}
@endsection

@section('css')
    <link rel="stylesheet" href="{{url('plugins/summernote/summernote-bs4.css')}}">
@endsection
@section('breadcrumb')
          <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
          <li class="breadcrumb-item"><a href="{{route('admin.contracts.index')}}">{{__('Contracts')}}</a></li>
          <li class="breadcrumb-item active">{{__('Create Contract')}}</li>
@endsection
@section('content')
<div class="app-content content ">
<div class="card card-primary">
  @include('partials.validation_errors')
    <div class="card-header">
      <h3 class="card-title">{{__('Create Contract')}}</h3>
    </div>
    <form method="POST" action="{{route('admin.contracts.store')}}" id="contract_form">
        <!-- /.card-header -->
        <div class="card-body">
            @csrf
            @include('admin.contracts._form')
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary save_contract">
              <i class="fa fa-check"></i> {{__('Save')}}
            </button>
        </div>
    </form>

</div>
@endsection
@section('scripts')
  <script src="{{url('js/admin/contracts.js')}}"></script>
@endsection
