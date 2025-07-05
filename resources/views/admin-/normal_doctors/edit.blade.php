@extends('layouts.app')

@section('title')
{{__('Create Doctor')}}
@endsection

@section('css')
@endsection

@section('breadcrumb')
            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item "><a href="{{route('admin.doctors.index')}}">{{__('Doctors')}}</a></li>
            <li class="breadcrumb-item active">{{__('Create doctor')}}</li>
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">{{__('Create Doctor')}}</h3>
    </div>
    <form method="POST" action="{{route('admin.normal_doctors.update',$doctor->id)}}">
      @csrf
      @method('put')
      <!-- /.card-header -->
          @include('admin.normal_doctors._form')
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
  <script src="{{url('js/admin/doctors.js')}}"></script>
@endsection
