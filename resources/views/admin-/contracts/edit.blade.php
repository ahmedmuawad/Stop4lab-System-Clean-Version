@extends('layouts.app')

@section('title')
{{__('Edit Contract')}}
@endsection

@section('breadcrumb')
          <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
          <li class="breadcrumb-item"><a href="{{route('admin.contracts.index')}}">{{__('Contracts')}}</a></li>
          <li class="breadcrumb-item active">{{__('Edit Contract')}}</li>
@endsection
@section('content')

<div class="app-content content ">
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">{{__('Edit Contract')}}</h3>
    </div>
    <br>
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
                    <a class="btn btn-success" href="{{ route('admin.contract.export',$contract->id) }}">
                      <i class="fa fa-file-excel"></i>
                      {{__('Export')}}
                    </a>
                    <a class="btn btn-success" href="{{route('admin.contract.download_template',$contract->id)}}">
                      <i class="fa fa-file-excel"></i>
                      {{__('Download template')}}
                    </a>
                  </div>
                  <div class="col-lg-12">
                    <!-- import form -->
                    <form action="{{route('admin.contract.import',$contract->id)}}" method="POST" enctype="multipart/form-data">
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
    <!-- /.card-header -->
    <form method="POST" action="{{route('admin.contracts.update',$contract->id)}}" id="contract_form">
        <!-- /.card-header -->
        <div class="card-body">
            @csrf
            @method('put')
            @include('admin.contracts._form')
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary save_contract">
              <i class="fa fa-check"></i> {{__('Save')}}
            </button>
        </div>
    </form>
    <!-- /.card-body -->
  </div>
</div>
@endsection
@section('scripts')
  <script src="{{url('js/admin/contracts.js')}}"></script>
@endsection
