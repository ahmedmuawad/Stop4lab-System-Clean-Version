@extends('layouts.app')

@section('title')
{{__('Sample Types')}}
@endsection

@section('breadcrumb')
            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin.sample_types.index')}}">{{__('Sample Types')}}</a></li>
            <li class="breadcrumb-item active">{{__('Sample Types')}}</li>
@endsection

@section('content')
<div class="card card-primary card-outline">
    <div class="card-header">
      <h3 class="card-title">{{__('Sample Types')}}</h3>
    </div>
    <form action="{{route('admin.sample_types.store')}}" method="POST" id="sample_form">
        @csrf
        <!-- /.card-header -->
        @include('admin.sample_types._form')
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
            <i class="fa fa-check"></i> {{__('Save')}}
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
    <script src="{{url('js/admin/sample_types.js')}}"></script>
@endsection
