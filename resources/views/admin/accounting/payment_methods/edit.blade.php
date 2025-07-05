@extends('layouts.app')

@section('title')
{{__('Edit payment method')}}
@endsection

@section('breadcrumb')
            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin.payment_methods.index')}}">{{__('Payment methods')}}</a></li>
            <li class="breadcrumb-item active">{{__('Edit payment_method')}}</li>
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title"></h3>
    </div>
    <!-- /.card-header -->
    <form method="POST" action="{{route('admin.payment_methods.update',$payment_method->id)}}" id="patient_form">
        <!-- /.card-header -->
        <div class="card-body">
            @csrf
            @method('put')
            @include('admin.accounting.payment_methods._form')
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
        </div>
    </form>
    <!-- /.card-body -->
  </div>

@endsection
@section('scripts')
  <script src="{{url('js/admin/payment_methods.js')}}"></script>
@endsection
