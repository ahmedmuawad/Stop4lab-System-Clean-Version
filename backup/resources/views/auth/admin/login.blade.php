@extends('layouts.auth')
@section('title')
  {{__('Login Admin Panel')}}
@endsection
@section('content')


    <div class="form-container outer">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">
                        {{--  <div class="container-login100-form-btn mb-4" style="text-align:center;">
                            <div class="dropdown text-uppercase">
                                <button class="btn btn-default dropdown-toggle text-uppercase" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-globe"></i>	{{app()->getLocale()}}
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    @foreach($languages as $lang)
                                        @if(app()->getLocale()!=$lang['iso']) <a class="dropdown-item"  href="{{route('change_locale',$lang['iso'])}}">{{$lang['iso']}}</a> @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>  --}}
                        <h1 class="">Sign In</h1>
                        <p class="">Log in to your account to continue.</p>


                        <form action="{{route('admin.auth.login_submit')}}" method="post" class="text-left">

                            <div class="form">

                                <div id="username-field" class="field-wrapper input validate-input @if($errors->has('email')) error-validation @endif">
                                    <label for="username">{{__('Email')}}</label>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    <input id="email" name="email" type="text" class="form-control" placeholder="Email Address">
                                </div>

                                <div id="password-field" class="field-wrapper input mb-2 validate-input @if($errors->has('password')) error-validation @endif">
                                    <div class="d-flex justify-content-between">
                                        <label for="password">PASSWORD</label>
                                        <a href="auth_pass_recovery_boxed.html" class="forgot-pass-link">Forgot Password?</a>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                    <input id="password" name="password" type="password" class="form-control" placeholder="Password">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="toggle-password" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                </div>
                                <div class="d-sm-flex justify-content-between">
                                    <div class="field-wrapper">
                                        <button type="submit" class="btn btn-primary" value="">Log In</button>
                                    </div>
                                </div>



                            </div>
                        </form>
                        {{--  <div class="d-sm-flex justify-content-between">
                            <div class="field-wrapper">
                                <button href="{{url('admin.auth.register')}}" class="btn btn-primary" value="">{{__('Register Lab')}}</button>
                            </div>
                        </div>
                        <div class="d-sm-flex justify-content-between">
                            <div class="field-wrapper">
                                <a href="{{url('/')}}" class="btn btn-primary" value="">{{__('Login Patient')}}</a>
                            </div>
                        </div>
                        <div class="d-sm-flex justify-content-between">
                            <div class="field-wrapper">
                                <button href="{{url('/admin/auth/lab_login')}}" class="btn btn-primary" value="">{{__('Login Lab')}}</button>
                            </div>
                        </div>  --}}



                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection

@section('scripts')

<!-- END GLOBAL MANDATORY SCRIPTS -->
  <script src="{{url('assets/js/authentication/form-2.js')}}"></script>
@endsection
