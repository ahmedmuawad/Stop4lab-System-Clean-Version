@extends('layouts.app')

@section('title')
{{__('Create adjustment')}}
@endsection

@section('css')
    <link rel="stylesheet" href="{{url('plugins/summernote/summernote-bs4.css')}}">
@endsection

@section('breadcrumb')

            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item "><a href="{{route('admin.inventory.adjustments.index')}}">{{__('Adjustments')}}</a></li>
            <li class="breadcrumb-item active">{{__('Create adjustment')}}</li>

@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title"></h3>
    </div>
    <form method="POST" action="{{route('admin.inventory.adjustments.store')}}" id="adjustments_form">
        <!-- /.card-header -->
        <div class="card-body">
            @csrf
            @include('admin.inventory.adjustments._form')
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
              <i class="fa fa-check"></i> {{__('Save')}}
            </button>
        </div>
    </form>

</div>
@endsection
@section('scripts')
  <script src="{{url('js/admin/adjustments.js')}}"></script>
@endsection
