@extends('layouts.app')

@section('title')
{{ __('Create know') }}
@endsection

@section('breadcrumb')
                    <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
                    <li class="breadcrumb-item">
                        <a href="{{route('admin.knows.index')}}">{{ __('knows') }}</a>
                    </li>
                    <li class="breadcrumb-item active">{{ __('Create know') }}</li>

@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ __('Create know') }}</h3>
    </div>
    <!-- /.card-header -->
    <form method="POST" action="{{route('admin.knows.store')}}">
        @csrf
        <div class="card-body">
            <div class="col-lg-12">
                @include('admin.knows_by._form')
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
    <script src="{{url('js/admin/knows.js')}}"></script>
@endsection

