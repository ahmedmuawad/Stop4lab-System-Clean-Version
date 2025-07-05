@extends('layouts.app')

@section('title')
{{ __('Create category') }}
@endsection

@section('breadcrumb')
                    <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
                    <li class="breadcrumb-item">
                        <a href="{{route('admin.categories.index')}}">{{ __('Categories') }}</a>
                    </li>
                    <li class="breadcrumb-item active">{{ __('Create category') }}</li>

@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ __('Create category') }}</h3>
    </div>
    <!-- /.card-header -->
    <form method="POST" action="{{route('admin.categories.store')}}">
        @csrf
        <div class="card-body">
            <div class="col-lg-12">
                @include('admin.categories._form')
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
    <script src="{{url('js/admin/categories.js')}}"></script>
@endsection

