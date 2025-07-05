@extends('layouts.app')

@section('title')
{{ __('Edit Violations') }}
@endsection

@section('css')
<link rel="stylesheet" href="{{url('css/select2.css')}}">
@endsection

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">
                    <i class="fa fa-user-circle"></i>
                    {{__('Violations')}}
                </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
                    <li class="breadcrumb-item">
                        <a href="{{route('admin.vocations.index')}}">{{ __('Vocation') }}</a>
                    </li>
                    <li class="breadcrumb-item active">{{ __('Edit Vocation') }}</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection

@section('content')
<div class="app-content content ">
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ __('Edit Violation') }}</h3>
    </div>
    <!-- /.card-header -->
    <form method="POST" action="{{route('admin.violations.update',$violation['id'])}}">
        @csrf
        @method('put')
        {{-- <input type="hidden" id="user_roles" value="{{$user['roles']}}">
        <input type="hidden" id="user_branches" value="{{$user['branches']}}"> --}}
        <div class="card-body">
            <div class="col-lg-12">
                @include('admin.violations._form')
            </div>
        </div>
        <div class="card-footer">
            <div class="col-lg-12">
                <button type="submit" class="btn btn-primary">
                  <i class="fa fa-check"></i>  {{__('Save')}}
                </button>
            </div>
        </div>
    </form>

    <!-- /.card-body -->
</div>

@endsection
@section('scripts')
    <script src="{{url('js/admin/violation.js')}}"></script>
@endsection
