@extends('layouts.app')

@section('title')
{{__('Create Test')}}
@endsection

@section('css')
    <link rel="stylesheet" href="{{url('plugins/summernote/summernote-bs4.css')}}">
@endsection

@section('breadcrumb')
            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item "><a href="{{route('admin.tests.index')}}">{{__('Tests')}}</a></li>
            <li class="breadcrumb-item active">{{__('Create Test')}}</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">{{__('Create')}}</h3>
    </div>
    <form method="POST" action="{{route('admin.tests.store')}}" id="test_form">
        <!-- /.card-header -->
        <div class="card-body">
            @csrf
            @include('admin.tests._form')
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary"> <i class="fa fa-check"></i> {{__('Save')}}</button>
        </div>
    </form>
</div>

@endsection
@section('scripts')
  <script src="{{url('js/admin/tests.js')}}"></script>
@endsection
