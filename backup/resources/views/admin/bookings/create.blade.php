@extends('layouts.app')

@section('title')
{{__('Create Sliders')}}
@endsection

@section('breadcrumb')
            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item "><a href="{{route('admin.sliders.index')}}">{{__('Sliders')}}</a></li>
            <li class="breadcrumb-item active">{{__('Create Sliders')}}</li>
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title"></h3>
    </div>
    <form method="POST" action="{{route('admin.sliders.store')}}" id="sliders_form" enctype="multipart/form-data">
        <!-- /.card-header -->
        <div class="card-body">
            @csrf
            @include('admin.sliders._form')
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
        </div>
    </form>

</div>
@endsection
@section('scripts')
  <script src="{{url('js/admin/sliders.js')}}"></script>
@endsection
