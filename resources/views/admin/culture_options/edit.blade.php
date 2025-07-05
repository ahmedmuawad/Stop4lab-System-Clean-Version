@extends('layouts.app')

@section('title')
{{__('Culture options')}}
@endsection

@section('breadcrumb')
            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin.culture_options.index')}}">{{__('Culture Options')}}</a></li>
            <li class="breadcrumb-item active">{{__('Culture options')}}</li>
@endsection

@section('content')
<div class="card card-primary card-outline">
    <div class="card-header">
      <h3 class="card-title">{{__('Edit culture option')}}</h3>
    </div>
    <form action="{{route('admin.culture_options.update',$option['id'])}}" method="POST" id="option_form">
        @method('put')
        @csrf
        <!-- /.card-header -->
        @include('admin.culture_options._form')
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
            <i class="fa fa-check"></i> {{__('Save')}}
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
    <script src="{{url('js/admin/culture_options.js')}}"></script>
@endsection
