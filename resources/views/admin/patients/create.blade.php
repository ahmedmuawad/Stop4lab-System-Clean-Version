@extends('layouts.app')

@section('title')
{{__('Create Patient')}}
@endsection
@section('breadcrumb')

            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin.patients.index')}}">{{__('Patients')}}</a></li>
            <li class="breadcrumb-item active">{{__('Create Patient')}}</li>

  </div>
@endsection
@section('content')
<div class="app-content content ">
    @if ($errors->any())
    <div class="alert alert-danger mt-1 alert-validation-msg" role="alert">
        <div class="alert-body">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info mr-50 align-middle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
            <span>Error : <strong>
                @foreach ($errors->all() as $error)
                    <li>{{__($error)}}</li>
                @endforeach
            </span>
        </div>
    </div>
@endif
    <form method="POST" action="{{route('admin.patients.store')}}" id="patient_form" enctype="multipart/form-data">
        <!-- /.card-header -->
        <div class="card-body">
            @csrf
            @include('admin.patients._form')
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
        </div>
    </form>

</div>
@endsection
@section('scripts')
  <script src="{{url('js/admin/patients.js')}}"></script>
@endsection
