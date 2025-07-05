@extends('layouts.app')

@section('title')
    {{ __('Edit Role') }}
@endsection

@section('css')
 <link rel="stylesheet" href="{{url('css/select2.css')}}">
@endsection

@section('breadcrumb')
            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin.roles.index')}}">{{__('Roles')}}</a></li>
            <li class="breadcrumb-item active">{{__('Edit Role')}}</li>
@endsection

@section('content')
<div class="app-content content ">
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"></h3>
    </div>
    <!-- /.card-header -->
    <form method="POST" action="{{route('admin.roles.update',$role['id'])}}">
        @csrf
        @method('put')
        <div class="card-body">
            <div class="col-lg-12">
                    @include('admin.roles._form')
            </div>
        </div>
        <div class="card-footer">
            <div class="col-lg-12">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-check"></i>
                    {{__('Save')}}
                </button>
            </div>
        </div>
    </form>

    <!-- /.card-body -->
</div>
</div>
@endsection
@section('scripts')
    <script src="{{url('js/admin/roles.js')}}"></script>
    <script>
        (function($){

            "use strict";

            @if(isset($role))
                @foreach($role['permissions'] as $permission)
                    $("#{{$permission['permission']['key']}}").prop('checked',true);
                @endforeach
            @endif

        })(jQuery);
    </script>
@endsection
