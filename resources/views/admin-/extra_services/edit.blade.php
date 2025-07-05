@extends('layouts.app')

@section('title')
{{ __('Edit ExtraService') }}
@endsection

@section('css')
<link rel="stylesheet" href="{{url('css/select2.css')}}">
@endsection
@section('breadcrumb')
                    <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{route('admin.extraService.index')}}">{{__('Extra Service')}}</a></li>
                    <li class="breadcrumb-item active">{{ __('Edit Extra Service') }}</li>
@endsection


@section('content')
<div class="app-content content ">
    <div class="card card-primary">
        @if ($errors->any())
            <div class="callout callout-danger">
                <h5 class="text-danger">
                    <i class="fa fa-times"></i> {{__('Failed')}}
                </h5>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card-header">
            <h3 class="card-title"></h3>
        </div>
        <!-- /.card-header -->
        <form method="POST" action="{{route('admin.extraService.update',$extraService['id'])}}">
            @csrf
            @method('put')
            {{-- <input type="hidden" id="user_roles" value="{{$user['roles']}}">
            <input type="hidden" id="user_branches" value="{{$user['branches']}}"> --}}
            <div class="card-body">
                <div class="col-lg-12">
                    @include('admin.extra_services._form')
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
</div>
@endsection
@section('scripts')
    <script src="{{url('js/admin/employees.js')}}"></script>
@endsection
