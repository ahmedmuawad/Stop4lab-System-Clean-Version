@extends('layouts.auth')
@section('title')
    {{ __('Login') }}
@endsection
@section('content')
    <div class="form-container outer">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">
                        <form action="{{ route('patient.auth.login_submit') }}" method="post" class="validate-form text-left">

                            <h1 class="">Sign In</h1>
                            <p style="color: white;">Log in to your account to continue.</p>

                            <div class="form">
                                <div id="username-field"
                                    class="field-wrapper input validate-input @if ($errors->has('code')) error-validation @endif">
                                    <label for="username">{{ __('Patient Code') }}</label>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    <input id="code" name="code" type="text" class="form-control"
                                        placeholder="Patient Code">
                                </div>
                                <div class="d-sm-flex justify-content-between">
                                    <div class="field-wrapper">
                                        <button type="submit" class="btn btn-primary login100-form" value="">Log
                                            In</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
@endsection
