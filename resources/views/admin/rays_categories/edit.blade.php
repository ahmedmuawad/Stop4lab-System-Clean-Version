@extends('layouts.app')

@section('title')
{{ __('Edit category') }}
@endsection

@section('breadcrumb')

                    <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
                    <li class="breadcrumb-item">
                        <a href="{{route('admin.rays_categories.index')}}">{{ __('Categories') }}</a>
                    </li>
                    <li class="breadcrumb-item active">{{ __('Edit category') }}</li>
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ __('Edit category') }}</h3>
    </div>
    <!-- /.card-header -->
    <form method="POST" action="{{route('admin.rays_categories.update',$category['id'])}}">
        @csrf
        @method('put')
        <div class="card-body">
            <div class="col-lg-12">
                @include('admin.rays_categories._form')
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
    <script src="{{url('js/admin/rays_categories.js')}}"></script>
@endsection
