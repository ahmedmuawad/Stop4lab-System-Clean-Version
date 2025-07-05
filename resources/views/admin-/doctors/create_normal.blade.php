extends('layouts.app')

@section('title')
{{__('Create Doctor')}}
@endsection

@section('css')
@endsection

@section('breadcrumb')
            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item "><a href="{{route('admin.doctors.index')}}">{{__('Doctors')}}</a></li>
            <li class="breadcrumb-item active">{{__('Create doctor')}}</li>
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title"></h3>
    </div>
    <form method="POST" action="{{route('admin.create_normal_doctor')}}">
        <!-- /.card-header -->
        <div class="card-body">
            @csrf
            <div class="row">
               <div class="col-lg-12">
                  <div class="form-group">
                   <div class="input-group mb-6">
                       <div class="input-group-prepend">
                         <span class="input-group-text" id="basic-addon1">
                             <i class="fa fa-user"></i>
                         </span>
                       </div>
                       <input type="text" class="form-control" placeholder="{{__('Doctor Name')}}" name="name" id="name" @if(isset($doctor)) value="{{$doctor->name}}" @endif required>
                   </div>
                  </div>
               </div>
          </div>
          <div class="row">
               <div class="col-lg-12">
                 <div class="form-group">
                  <div class="input-group mb-6">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fa fa-user"></i>
                        </span>
                      </div>
                      <input type="text" class="form-control" placeholder="{{__('Specialization')}}" name="code" id="code" @if(isset($doctor)) value="{{$doctor->code}}" @endif>
                  </div>
                 </div>
              </div>

           </div>

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
  <script src="{{url('js/admin/doctors.js')}}"></script>
@endsection
