@extends('layouts.app')

@section('title')
{{__('Create Expense Category')}}
@endsection

@section('breadcrumb')
            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item "><a href="{{route('admin.expenses.index')}}">{{__('Expense Categories')}}</a></li>
            <li class="breadcrumb-item active">{{__('Create Expense Category')}}</li>
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title"></h3>
    </div>
    <form method="POST" action="{{route('admin.expense_categories.store')}}">
        <!-- /.card-header -->
        <div class="card-body">
            @csrf
            @include('admin.accounting.expense_categories._form')
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
  <script src="{{url('js/admin/expense_categories.js')}}"></script>
@endsection
