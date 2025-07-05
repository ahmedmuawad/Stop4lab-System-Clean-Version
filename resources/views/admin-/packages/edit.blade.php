@extends('layouts.app')

@section('title')
{{__('Edit package')}}
@endsection

@section('breadcrumb')

            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin.packages.index')}}">{{__('Packages')}}</a></li>
            <li class="breadcrumb-item active">{{__('Edit package')}}</li>

@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">{{__('Edit package')}}</h3>
    </div>
    <!-- /.card-header -->
    <form method="POST" action="{{route('admin.packages.update',$package->id)}}" id="package_form">
        <!-- /.card-header -->
        <div class="card-body">
            @csrf
            @method('put')
            @include('admin.packages._form')
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
        </div>
    </form>
    <!-- /.card-body -->
  </div>

@endsection
@section('scripts')
  <script src="{{url('js/admin/packages.js')}}"></script>
@endsection
