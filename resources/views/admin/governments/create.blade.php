@extends('layouts.app')

@section('title')
{{__('Create Government')}}
@endsection

@section('content')
<div class="app-content content ">
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">{{__('Create Government')}}</h3>
    </div>
    <form method="POST" action="{{route('admin.governments.store')}}">
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
