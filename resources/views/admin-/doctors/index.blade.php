@extends('layouts.app')

@section('title')
  {{__('Doctors')}}
@endsection

@section('breadcrumb')

          <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
          <li class="breadcrumb-item active">{{__('Doctors')}}</li>

@endsection

@section('content')
<div class="card card-primary card-outline">
  <div class="card-header">
    <h3 class="card-title"></h3>
    @can('create_contract')
    <a href="{{route('admin.doctors.create')}}" class="btn btn-primary btn-sm float-right">
     <i class="fa fa-plus"></i> {{__('Create Doctor')}}
    </a>
    <a href="{{route('admin.normal_doctors.create')}}" class="btn btn-primary btn-sm float-right mr-2">
      <i class="fa fa-plus"></i> {{__('Create Normal Doctor')}}
     </a>
    @endcan

  </div>
  <!-- /.card-header -->
  <div class="card-body">

    <div class="row">
      <div class="col-lg-12">
        <!-- Tools -->
        <div id="accordion">
          <div class="card card-info">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="btn btn-primary collapsed" aria-expanded="false">
              <i class="fas fa-file-excel"></i>
              {{__('Import / Export')}}
            </a>
            <div id="collapseOne" class="panel-collapse in collapse">
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-12 text-center">
                    <a class="btn btn-success" href="{{route('admin.doctors.export')}}">
                      <i class="fa fa-file-excel"></i>
                      {{__('Export')}}
                    </a>
                    <a class="btn btn-success" href="{{route('admin.doctors.download_template')}}">
                      <i class="fa fa-file-excel"></i>
                      {{__('Download template')}}
                    </a>
                  </div>
                  <div class="col-lg-12">
                    <!-- import form -->
                    <form action="{{route('admin.doctors.import')}}" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="row mt-3">
                        <div class="col-lg-12">
                          <div class="card card-primary card-outline">
                            <div class="card-header">
                              <h5 class="card-title">
                                  {{__('Import')}}
                              </h5>
                            </div>
                            <div class="card-body">
                              <div class="input-group">
                                <div class="custom-file">
                                  <input type="file" class="custom-file-input" id="exampleInputFile" name="import" required>
                                  <label class="custom-file-label" for="exampleInputFile">{{__('Choose file')}}</label>
                                </div>
                              </div>
                            </div>
                            <div class="card-footer">
                              <button type="submit" class="btn btn-primary">
                                <i class="fa fa-check"></i>
                                {{__('Import')}}
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                    <!-- /import form -->
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- \Tools -->
      </div>
    </div>
    <h4>{{__('Doctors')}}</h4>
    <div class="row table-responsive">
      <div class="col-12">
        <table id="doctors_table" class="table table-striped table-bordered"  width="100%">
          <thead>
            <tr>
              <th width="10px">
                <input type="checkbox" class="check_all" name="" id="">
              </th>
              <th width="10px">#</th>
              <th>{{__('Code')}}</th>
              <th>{{__('Name')}}</th>
              <th>{{__('Phone')}}</th>
              <th>{{__('Email')}}</th>
              <th>{{__('Address')}}</th>
              <th>{{__('Commission')}}</th>
              <th>{{__('Total')}}</th>
              <th>{{__('Paid')}}</th>
              <th>{{__('Due')}}</th>
              <th width="80px">{{__('Action')}}</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>
    </div>
</br>
<h4>{{__('Normal Doctors')}}</h4>

    <div class="row table-responsive">
      <div class="col-12">
        <table id="normal_doctors_table" class="table table-striped table-bordered"  width="100%">
          <thead>
            <tr>
              <th width="10px">#</th>
              <th>{{__('Name')}}</th>
              <th>{{__('Specialization')}}</th>
              <th width="80px">{{__('Action')}}</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- /.card-body -->
</div>

@endsection
@section('scripts')
  <script>
    var can_delete=@can('delete_doctor')true @else false @endcan
  </script>
  <script src="{{url('js/admin/doctors.js')}}"></script>
@endsection
