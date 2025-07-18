@extends('layouts.app')

@section('title')
{{__('Create Antibiotic')}}
@endsection

@section('css')
    <link rel="stylesheet" href="{{url('plugins/summernote/summernote-bs4.css')}}">
@endsection

@section('breadcrumb')
            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item "><a href="{{route('admin.antibiotics.index')}}">{{__('Antibiotics')}}</a></li>
            <li class="breadcrumb-item active">{{__('Create antibiotic')}}</li>
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">{{__('Create Antibiotic')}}</h3>
    </div>
    <form method="POST" action="{{route('admin.antibiotics.store')}}">
        <!-- /.card-header -->
        <div class="card-body">
            @csrf
            @include('admin.antibiotics._form')
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
              <i class="fa fa-check"></i> {{__('Save')}}
            </button>
        </div>
    </form>

</div>
@endsection
@section('scripts')
  <script src="{{url('js/admin/antibiotics.js')}}"></script>
@endsection
