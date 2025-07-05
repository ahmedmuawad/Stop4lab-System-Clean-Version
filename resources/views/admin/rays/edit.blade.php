@extends('layouts.app')

@section('title')
{{__('Create Ray')}}
@endsection

@section('breadcrumb')
            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item "><a href="{{route('admin.rays.index')}}">{{__('Rays')}}</a></li>
            <li class="breadcrumb-item active">{{__('Create Ray')}}</li>
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">{{__('Create')}}</h3>
    </div>
    <form method="POST" action="{{route('admin.rays.update',$test->id)}}" id="ray_form">
        <!-- /.card-header -->
        <div class="card-body">
            @csrf
            @method('put')
            @include('admin.rays._form')
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary"> <i class="fa fa-check"></i> {{__('Save')}}</button>
        </div>
    </form>

</div>
@endsection
@section('scripts')
  <script src="{{url('js/admin/rays.js')}}"></script>
@endsection
