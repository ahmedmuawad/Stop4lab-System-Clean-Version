@extends('layouts.app')

@section('title')
{{ __('Edit Vocation') }}
@endsection

@section('css')
<link rel="stylesheet" href="{{url('css/select2.css')}}">
@endsection

@section('breadcrumb')
                    <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
                    <li class="breadcrumb-item">
                        <a href="{{route('admin.vocations.index')}}">{{ __('Vocation') }}</a>
                    </li>
                    <li class="breadcrumb-item active">{{ __('Edit Vocation') }}</li>

@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ __('Edit Vocation') }}</h3>
    </div>
    <!-- /.card-header -->
    <form method="POST" action="{{route('admin.vocations.update',$vocation['id'])}}">
        @csrf
        @method('put')
        {{-- <input type="hidden" id="user_roles" value="{{$user['roles']}}">
        <input type="hidden" id="user_branches" value="{{$user['branches']}}"> --}}
        <div class="card-body">
            <div class="col-lg-12">
                @include('admin.vocations._form')
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
    <script src="{{url('js/admin/vocations.js')}}"></script>
@endsection
