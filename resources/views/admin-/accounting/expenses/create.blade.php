@extends('layouts.app')

@section('title')
{{__('Create Expense')}}
@endsection

@section('css')
    <link rel="stylesheet" href="{{url('plugins/summernote/summernote-bs4.min.css')}}">
@endsection

@section('breadcrumb')

            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item "><a href="{{route('admin.expenses.index')}}">{{__('Expenses')}}</a></li>
            <li class="breadcrumb-item active">{{__('Create Expense')}}</li>

@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title"></h3>
    </div>
    <form method="POST" action="{{route('admin.expenses.store')}}">
        <!-- /.card-header -->
        <div class="card-body">
            @csrf
            @include('admin.accounting.expenses._form')
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
              <i class="fa fa-check"></i> {{__('Save')}}
            </button>
        </div>
    </form>

</div>

@include('admin.accounting.expenses.category_modal')

@endsection
@section('scripts')
  <script src="{{url('plugins/summernote/summernote-bs4.min.js')}}"></script>
  <script src="{{url('js/admin/expenses.js')}}"></script>
@endsection
