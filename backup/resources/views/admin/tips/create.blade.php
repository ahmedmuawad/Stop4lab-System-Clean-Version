@extends('layouts.app')

@section('title')
{{__('Create tips')}}
@endsection

@section('breadcrumb')
            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item "><a href="{{route('admin.tips.index')}}">{{__('Tips And Offer')}}</a></li>
            <li class="breadcrumb-item active">{{__('Create Tips And Offer')}}</li>

@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title"></h3>
    </div>
    <form method="POST" action="{{route('admin.tips.store')}}" id="tips_form" enctype="multipart/form-data">
        <!-- /.card-header -->
        <div class="card-body">
            @csrf
            @include('admin.tips._form')
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
        </div>
    </form>

</div>
@endsection
@section('scripts')
  <script src="{{url('js/admin/tips.js')}}"></script>
@endsection
