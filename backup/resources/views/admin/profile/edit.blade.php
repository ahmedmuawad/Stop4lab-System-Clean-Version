@extends('layouts.app')

@section('title')
{{ __('Profile') }}
@endsection
@section('breadcrumb')
                    <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
                    <li class="breadcrumb-item active">{{ __('Profile') }}</li>
@endsection
@section('content')

    @include('partials.validation_errors')


        <div class="content-header row">
        </div>
        <div class="content-body">
          <section class="invoice-list-wrapper">
              <div class="card">
                  <section id="advanced-search-datatable">
                  <div class="row">
                      <div class="col-12">
                          <div class="card">
                              <div class="card-header border-bottom">
                                  <a href="{{route('admin.profile.index')}}" class="btn btn-primary btn-sm">
                                      <i class="fa fa-plus"></i> {{ __('HR') }}
                                    </a>
                              </div>
                              <hr class="my-0">
                              <form method="POST" action="{{route('admin.profile.update')}}" enctype="multipart/form-data" id="profile_form">
                                @csrf
                                <div class="card-body ml-4">
                                    <div class="col-lg-12">
                                        @include('admin.profile._form')
                                    </div>
                                </div>
                            </form>
                              <!--Search Form -->
                          </div>
                      </div>
                  </div>
              </section>
              </div>
          </section>
        </div>



@endsection
@section('scripts')
    <script src="{{url('js/admin/profile.js')}}"></script>
@endsection
