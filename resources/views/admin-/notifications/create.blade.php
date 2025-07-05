@extends('layouts.app')

@section('title')
{{__('Create Notifications')}}
@endsection

@section('breadcrumb')
            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item "><a href="{{route('admin.notifications.index')}}">{{__('Notifications')}}</a></li>
            <li class="breadcrumb-item active">{{__('Create Notifications')}}</li>
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title"></h3>
    </div>
    <form method="POST" action="{{route('admin.notifications.store')}}" id="notifications_form" enctype="multipart/form-data">
        <!-- /.card-header -->
        <div class="card-body">
            @csrf
            @include('admin.notifications._form')
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
        </div>
    </form>

</div>
@endsection
@section('scripts')
  <script src="{{url('js/admin/notifications.js')}}"></script>
@endsection
