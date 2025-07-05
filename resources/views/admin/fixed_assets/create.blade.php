@extends('layouts.app')

@section('title')
{{__('Fixed Assets')}}
@endsection

@section('breadcrumb')
            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item "><a href="{{route('admin.fixed_assets.index')}}">{{__('Fixed Assets')}}</a></li>
            <li class="breadcrumb-item active">{{__('Add Fixed Assets')}}</li>

@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title"></h3>
    </div>
    <form method="POST" action="{{route('admin.fixed_assets.store')}}" id="fixed_assets_form" enctype="multipart/form-data">
        <!-- /.card-header -->
        <div class="card-body">
            @csrf
            @include('admin.fixed_assets._form')
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
        </div>
    </form>

</div>
@endsection
@section('scripts')
  <script src="{{url('js/admin/fixed_assets.js')}}"></script>
@endsection
