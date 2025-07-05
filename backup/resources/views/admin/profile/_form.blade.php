<div class="row">
    <div class="col-lg-3">
        <div class="card card-primary">
            <div class="card-header">
                <h5 class="text-center m-0 p-0">
                    {{__('Avatar')}}
                </h5>
            </div>
            <div class="card-footer m-0 p-0 pt-3">
                <div class="col-lg-12">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="avatar" id="avatar" />
                                <label class="custom-file-label" for="">{{__('Choose avatar')}}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body m-0 p-0">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <a href="@if (!empty(auth()->guard('admin')->user()->avatar)) {{ url('uploads/user-avatar/' . auth()->guard('admin')->user()->avatar) }}@else{{ url('img/avatar.png') }} @endif"
                        data-toggle="lightbox" data-title="Avatar" alt="users avatar"
                        class="user-avatar users-avatar-shadow rounded mr-2 my-25 cursor-pointer">
                        <img src="@if (!empty(auth()->guard('admin')->user()->avatar)) {{ url('uploads/user-avatar/' . auth()->guard('admin')->user()->avatar) }}@else{{ url('img/avatar.png') }} @endif"
                            alt="users avatar" class="user-avatar users-avatar-shadow rounded mr-2 my-25 cursor-pointer"
                             id="patient_avatar" alt="">
                    </a>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-danger btn-sm float-right" id="delete_avatar" style="width:100%">
                    <i class="fa fa-trash"></i>
                </button>
            </div>

        </div>

    </div>
    <!-- Bootstrap Validation -->
    <div class="col-md-6 col-9">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{__('Profile')}}</h4>
            </div>
            <div class="card-body">
                {{-- <form class="needs-validation" novalidate> --}}
                    <div class="form-group">
                        <label class="form-label" for="basic-addon-name">{{__('Name')}}</label>

                        <input type="text" name="name" value="{{auth()->guard('admin')->user()->name}}" id="basic-addon-name" class="form-control" placeholder="{{__('Name')}}" aria-label="Name" aria-describedby="basic-addon-name" required />

                    </div>
                    <div class="form-group">
                        <label class="form-label" for="basic-default-email1">{{__('Email Address')}}</label>
                        <input type="email" id="basic-default-email1" class="form-control" placeholder="{{__('Email Address')}}" name="email" value="{{auth()->guard('admin')->user()->email}}" required />
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="password">{{__('Password')}}</label>
                        <input type="password" id="password" class="form-control" placeholder="{{__('Password')}}" name="password"  />
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="password_confirmation">{{__('Password Confirmation')}}</label>
                        <input type="password" id="password_confirmation" class="form-control"  placeholder="{{__('Password Confirmation')}}" name="password_confirmation"  />
                    </div>
                    @can('sign_medical_report')
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">{{__('Choose your signature')}}</label>
                                <div class="custom-file">
                                    <input type="file" accept="image/*"  name="signature" class="custom-file-input" id=""/>
                                    <label class="custom-file-label" for="">{{__('Choose your signature')}}</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h5 class="card-title" style="text-align: center!important;float: unset;">
                                        {{__('Signature')}}
                                    </h5>
                                </div>
                                <div class="card-body p-1">
                                    <a href="@if(!empty(auth()->guard('admin')->user()->signature)){{url('uploads/signature/'.auth()->guard('admin')->user()->signature)}}@else{{url('img/no-image.png')}}@endif" data-toggle="lightbox" data-title="Signature">
                                        <img src="@if(!empty(auth()->guard('admin')->user()->signature)){{url('uploads/signature/'.auth()->guard('admin')->user()->signature)}}@else{{url('img/no-image.png')}}@endif"  class="img-thumbnail" id="user_signature" alt="">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endcan
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                        </div>
                    </div>
                {{-- </form> --}}
            </div>
        </div>

    </div>
    <!-- /Bootstrap Validation -->
</div>



