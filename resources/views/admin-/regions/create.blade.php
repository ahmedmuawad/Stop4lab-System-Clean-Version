@extends('layouts.app')

@section('title')
{{__('Create Region')}}
@endsection
@section('breadcrumb')
          <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
          <li class="breadcrumb-item"><a href="{{route('admin.governments.index')}}">{{__('Governments')}}</a></li>
          <li class="breadcrumb-item active">{{__('Create Region')}}</li>
@endsection
@section('content')

<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">{{$government->name . ' - ' .__('Create Region')}}</h3>
    </div>
    <form method="POST" action="{{route('admin.regions.store', $government->id)}}">
        <!-- /.card-header -->
        <div class="card-body">
            @csrf
            <div class="form-group">
                <label class="form-label" for="name">{{__('Name')}}</label>
                <input type="text" class="form-control" placeholder="{{__('Name')}}" name="name" id="name" required>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary save_contract">
              <i class="fa fa-check"></i> {{__('Save')}}
            </button>
        </div>
    </form>

</div>
@endsection
