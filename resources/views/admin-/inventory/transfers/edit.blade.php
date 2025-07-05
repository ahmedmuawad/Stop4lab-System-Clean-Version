@extends('layouts.app')

@section('title')
{{__('Edit transfer')}}
@endsection

@section('css')
    <link rel="stylesheet" href="{{url('plugins/summernote/summernote-bs4.css')}}">
@endsection

@section('breadcrumb')
            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item "><a href="{{route('admin.inventory.transfers.index')}}">{{__('Transfers')}}</a></li>
            <li class="breadcrumb-item active">{{__('Edit transfer')}}</li>
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title"></h3>
    </div>
    <form method="POST" action="{{route('admin.inventory.transfers.update',$transfer['id'])}}" id="transfers_form">
        @method('put')
        <!-- /.card-header -->
        <div class="card-body">
            @csrf
            @include('admin.inventory.transfers._form')
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
  <script src="{{url('js/admin/transfers.js')}}"></script>
@endsection
