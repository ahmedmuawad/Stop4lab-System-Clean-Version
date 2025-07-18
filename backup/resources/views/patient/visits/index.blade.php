@extends('layouts.app')

@section('title')
{{__('Home Visit')}}
@endsection

@section('css')
    <link rel="stylesheet" href="{{url('plugins/datetimepicker/css/jquery.datetimepicker.min.css')}}">
@endsection

@section('breadcrumb')
            <li class="breadcrumb-item"><a href="{{route('patient.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item active">{{__('Home visit')}}</li>
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">{{__('Request a home visit')}}</h3>
    </div>
    <form action="{{route('patient.visits.store')}}" method="POST" enctype="multipart/form-data" id="visit_form">
        @csrf
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">

                    <!-- Patient -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5 class="card-title">
                                <i class="fas fa-user-injured"></i>
                                {{__('Paitent details')}}
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input patient_type" name="patient_type" id="patient"  type="radio" value="2" checked>
                                            <label for="patient" class="form-check-label">{{__('Current patient')}}</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input patient_type" name="patient_type" id="new_patient" type="radio" value="1">
                                            <label for="new_patient" class="form-check-label">{{__('New patient')}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row patient_info">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">
                                                <i class="fa fa-user"></i>
                                            </span>
                                            </div>
                                            <input type="text" class="form-control" placeholder="{{__('Name')}}" name="name" id="name" value="{{$patient['name']}}" disabled required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">
                                                <i class="fas fa-phone-alt"></i>
                                            </span>
                                            </div>
                                            <input type="text" class="form-control" placeholder="{{__('Phone')}}" name="phone" id="phone" value="{{$patient['phone']}}" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">
                                                    <i class="fas fa-mars"></i>
                                                </span>
                                                </div>
                                                <select class="form-control" name="gender" placeholder="{{__('Gender')}}" id="gender" disabled required>
                                                    <option value="" readonly selected>{{__('Select Gender')}}</option>
                                                    <option value="male" @if($patient['gender']=='male') selected @endif>{{__('Male')}}</option>
                                                    <option value="female" @if($patient['gender']=='female') selected @endif>{{__('Female')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                </span>
                                                </div>
                                                <input type="text" class="form-control" placeholder="{{__('Address')}}" name="address" id="address" value="{{$patient['address']}}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                </span>
                                                </div>
                                                <input type="email" class="form-control" placeholder="{{__('Email')}}" name="email" id="email" value="{{$patient['email']}}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">
                                                    <i class="fas fa-baby"></i>
                                                </span>
                                                </div>
                                                <input type="text" class="form-control datepicker" id="dob" placeholder="{{__('Date Of Birth')}}" name="dob" value="{{$patient['dob']}}" disabled readonly required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- \Patient -->

                    <!-- Details -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5 class="card-title">
                                <i class="fa fa-info-circle"></i>
                                {{__('Visit details')}}
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label for="tests">{{__('Select branch')}}</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text">
                                              <i class="fas fa-map-marked-alt nav-icon"></i>
                                          </span>
                                        </div>

                                        <select name="branch_id" id="branch" class="form-control" required>
                                            <option value="" selected disabled>{{__('Select branch')}}</option>
                                            @foreach($branches as $branch)
                                              <option value="{{$branch['id']}}">{{$branch['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="tests">{{__('Tests')}}</label>
                                        <select name="tests[]" id="tests" class="form-control" multiple></select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="cultures">{{__('Cultures')}}</label>
                                        <select name="cultures[]" id="cultures" class="form-control" multiple></select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="packages">{{__('Packages')}}</label>
                                        <select name="packages[]" id="packages" class="form-control" multiple></select>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="">{{__('Visit date')}}</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">
                                                    <i class="fas fa-calendar"></i>
                                                </span>
                                                </div>
                                                <input type="text" class="form-control flatpickr" id="visit_date" placeholder="{{__('Visit Date')}}" name="visit_date" required readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="">{{__('Visit address')}}</label>
                                        <input type="text" class="form-control" placeholder="{{__('Visit address')}}" name="visit_address" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- \Details -->

                    <!-- Location -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card card-danger">
                                <div class="card-header">
                                    <h5 class="card-title">
                                        <i  class="fas fa-map-marked-alt nav-icon"></i>
                                        {{__('Location on map')}}
                                    </h5>
                                    <button type="button" class="btn btn-primary current_location float-right">
                                        <i class="fa fa-map-marked-alt"></i>
                                        {{__('Current location')}}
                                    </button>
                                </div>
                                <div class="card-body p-0">
                                    <input
                                    id="pac-input"
                                    class="form-control"
                                    type="text"
                                    placeholder="{{__('Search for address')}}"
                                    class="form-control"
                                    />
                                    <input type="hidden" name="lat" id="visit_lat">
                                    <input type="hidden" name="lng" id="visit_lng">
                                    <input type="hidden" name="zoom_level" id="zoom_level">
                                    <div id="map" style="min-height:500px"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- \Location -->

                    <!-- Attachement -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card card-danger">
                                <div class="card-header">
                                    <h5 class="card-title">
                                        <i  class="fas fa-file-pdf nav-icon"></i>
                                        {{__('Attachment')}}
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputFile">
                                            {{__('Attachment Image')}} ({{__('optional')}})
                                        </label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="attach" accept="image/*" class="custom-file-input" id="attachment">
                                                <label class="custom-file-label" for="attachment">{{__('Choose file')}}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- \Attachement -->

                </div>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                {{__('Save')}}
            </button>
        </div>
        <!-- /.card-footer -->
    </form>


  </div>

@endsection
@section('scripts')
    <script src="{{url('plugins/datetimepicker/js/jquery.datetimepicker.full.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{$api_keys['google_map']}}&callback=initMap&libraries=places&v=weekly" defer></script>
    <script src="{{url('js/patient/visits.js')}}"></script>
@endsection
