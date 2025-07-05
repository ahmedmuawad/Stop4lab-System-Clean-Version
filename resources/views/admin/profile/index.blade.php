@extends('layouts.app')

@section('title')
{{ __('Profile') }}
@endsection
@section('breadcrumb')
                    <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{route('admin.profile.edit')}}">{{__('Edit Profile')}}</a></li>
                    <li class="breadcrumb-item active">{{ __('Request') }}</li>
@endsection
@section('content')

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"></h3>
        </div>
        <!-- /.card-header -->
        <form method="POST" action="{{route('admin.vocations.store')}}">
            @csrf
            <div class="card-body">
                <div class="col-lg-12">
                    @include('admin.profile._request')
                </div>
            </div>
        </form>
    </div>
    <div class="card-body">
        <div class="col-lg-12 table-responsive">
           <table id="attendance_table" class=" table table table-striped table-bordered"  width="100%">
             <thead>
             <tr>
               <th>{{__('Employee')}}</th>
               <th>{{__('Start Shift')}}</th>
               <th>{{__('End Shift')}}</th>
             </tr>
             </thead>
             <tbody>
                @if ($attendance)
                    <tr>
                        <td>{{$attendance->employee->user->name}}</td>
                        <td>{{$attendance->start_shift}}</td>
                        <td>{{$attendance->end_shift}}</td>
                    </tr>
                @endif
             </tbody>
           </table>
        </div>
     </div>
    </div>

@endsection
@section('scripts')
    <script src="{{url('js/admin/profile.js')}}"></script>
@endsection
