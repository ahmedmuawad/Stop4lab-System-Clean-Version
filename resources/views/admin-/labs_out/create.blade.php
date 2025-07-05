@extends('layouts.app')

@section('title')
{{ __('Create Out Lab') }}
@endsection

@section('breadcrumb')
                    <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{route('admin.labs_out.index')}}">{{ __('Out Labs') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Create Out Lab') }}</li>
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ __('Create Out Lab') }}</h3>
    </div>
    <!-- /.card-header -->
    <form method="POST" action="{{route('admin.labs_out.store')}}">
        @csrf
        <div class="card-body">
            <div class="col-lg-12">
                @include('admin.labs_out._form')
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
    <script src="{{url('js/admin/labs_out.js')}}"></script>
@endsection

