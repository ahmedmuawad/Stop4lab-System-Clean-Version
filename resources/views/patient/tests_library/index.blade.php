@extends('layouts.app')

@section('title')
{{__('Tests Library')}}
@endsection

@section('breadcrumb')
            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item active">{{__('Tests Library')}}</li>

@endsection

@section('content')
<div class="card card-primary card-outline">
    <div class="card-header">
      <ul class="nav nav-pills ml-auto p-2">
        <li class="nav-item"><a class="nav-link active" href="#tests" data-toggle="tab">{{__('Tests')}}</a></li>
        <li class="nav-item"><a class="nav-link" href="#cultures" data-toggle="tab">{{__('Cultures')}}</a></li>
        <li class="nav-item"><a class="nav-link" href="#packages" data-toggle="tab">{{__('Packages')}}</a></li>
      </ul>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <div class="tab-content">
        <div class="tab-pane active" id="tests">
          <div class="row">
            <div class="col-lg-12 table-responsive">
             <table id="analyses_table" class=" table table table-striped table-bordered">
               <thead>
                 <tr>
                   <th>{{__('Name')}}</th>
                   <th>{{__('Shortcut')}}</th>
                   <th>{{__('Sample Type')}}</th>
                   <th>{{__('precautions')}}</th>
                 </tr>
               </thead>
               <tbody>

               </tbody>
             </table>
            </div>
          </div>
        </div>
        <!-- /.tab-pane -->
        <div class="tab-pane" id="cultures">
          <div class="row">
            <div class="col-lg-12 table-responsive">
             <table id="cultures_table" class=" table table table-striped table-bordered" width="100%">
               <thead>
                 <tr>
                   <th>{{__('Name')}}</th>
                   <th>{{__('Sample Type')}}</th>
                   <th>{{__('precautions')}}</th>
                 </tr>
               </thead>
               <tbody>

               </tbody>
             </table>
            </div>
          </div>
        </div>
        <!-- /.tab-pane -->
        <!-- /.tab-pane -->
        <div class="tab-pane" id="packages">
          <div class="row">
            <div class="col-lg-12 table-responsive">
             <table id="packages_table" class=" table table table-striped table-bordered" width="100%">
               <thead>
                 <tr>
                   <th>{{__('Name')}}</th>
                   <th>{{__('Shortcut')}}</th>
                   <th>{{__('precautions')}}</th>
                 </tr>
               </thead>
               <tbody>

               </tbody>
             </table>
            </div>
          </div>
        </div>
        <!-- /.tab-pane -->
      </div>
    </div>
    <!-- /.card-body -->
  </div>
@endsection
@section('scripts')
  <script src="{{url('js/patient/tests_library.js')}}"></script>
@endsection
