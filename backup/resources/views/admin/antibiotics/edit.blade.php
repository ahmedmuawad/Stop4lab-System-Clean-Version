@extends('layouts.app')

@section('title')
{{__('Edit Antibiotic')}}
@endsection

@section('breadcrumb')
            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin.antibiotics.index')}}">{{__('Antibiotics')}}</a></li>
            <li class="breadcrumb-item active">{{__('Edit Antibiotic')}}</li>
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">{{__('Edit Antibiotic')}}</h3>
    </div>
    <!-- /.card-header -->
    <form method="POST" action="{{route('admin.antibiotics.update',$antibiotic->id)}}">
        <!-- /.card-header -->
        <div class="card-body">
            @csrf
            @method('put')
            @include('admin.antibiotics._form')
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
              <i class="fa fa-check"></i> {{__('Save')}}
            </button>
        </div>
    </form>
    <!-- /.card-body -->
  </div>

@endsection
@section('scripts')
  <script src="{{url('js/admin/antibiotics.js')}}"></script>
@endsection
