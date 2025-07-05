@extends('layouts.app')

@section('title')
{{ __('Edit Violations') }}
@endsection

@section('css')
<link rel="stylesheet" href="{{url('css/select2.css')}}">
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
</div>
@endsection
@section('scripts')
    <script src="{{url('js/admin/attendace.js')}}"></script>
@endsection
