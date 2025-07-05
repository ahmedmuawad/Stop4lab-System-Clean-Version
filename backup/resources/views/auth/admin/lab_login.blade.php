@extends('layouts.auth')
@section('title')
  {{__(' Lab Login')}}
@endsection
@section('content')

<form action="{{route('new-design.admin.auth.lab_login_submit')}}" method="post" class="validate-form">

    <span class="login100-form-title p-b-20 p-t-20">
        {{__('Login Lab')}}
    </span>

    <div class="wrap-input100 validate-input @if($errors->has('code')) error-validation @endif">
        <input class="input100" type="text" name="lab_code" id="code" required>
        <span class="focus-input100"></span>
        <span class="label-input100">{{__(' Code')}}</span>
    </div>

    <div class="flex-sb-m w-full p-t-3 p-b-32">
        <div class="contact100-form-checkbox">
            <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember">
            <label class="label-checkbox100" for="ckb1">
                {{__('Remember Me')}}
            </label>
        </div>

        <div>
            <a href="{{route('patient.auth.mail')}}" class="txt1">
                {{__('Forgot Code ?')}}
            </a>
        </div>
    </div>

    <div class="container-login100-form-btn mb-10">
        <button class="login100-form-btn">
            {{__('Login')}}
        </button>
    </div>

    <br>

    <span class="login100-form-title mt-10">
        <span class="h6">{{__('New here ?')}}</span>
        <a href="{{route('new-design.admin.auth.register')}}">
           <span class="h6">{{__('Create Account')}}</span>
        </a>
    </span>

</form>

@endsection


@section('scripts')
@endsection
