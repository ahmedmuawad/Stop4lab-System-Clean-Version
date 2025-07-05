@extends('layouts.auth')
@section('title')
  {{__('Register Lab')}}
@endsection
@section('content')

<form action="{{route('new-design.admin.auth.register_submit')}}" method="post" class="validate-form">

    <span class="login100-form-title p-b-43">
        {{__('Register Lab')}}
    </span>

    <div class="wrap-input100 validate-input @if($errors->has('name')) error-validation @endif">
        <input class="input100" type="name" name="name" id="name" value="{{old('name')}}" required>
        <span class="focus-input100"></span>
        <span class="label-input100">{{__('Name')}}</span>
    </div>
    <div class="wrap-input100 validate-input">
    <select name="government_id" id="government_id" class="form-control" required>
                        <option value=""></option>
                        @foreach($governments as $government)
                        <option value="{{ $government->id }}">{{ $government->name }}</option>
                        @endforeach
                    </select>
        <span class="focus-input100"></span>
        <span class="label-input100">{{__('Government')}}</span>
    </div>

    <div class="wrap-input100 validate-input">
                    <select name="region_id" id="region_id" class="form-control" required>

                    </select>
                    <span class="focus-input100"></span>
        <span class="label-input100">{{__('Region')}}</span>
    </div>


    <div class="wrap-input100 validate-input @if($errors->has('email')) error-validation @endif">
        <input class="input100" type="email" name="email" id="email" value="{{old('email')}}" required>
        <span class="focus-input100"></span>
        <span class="label-input100">{{__('Email')}}</span>
    </div>


    <div class="wrap-input100 validate-input @if($errors->has('password')) error-validation @endif">
        <input class="input100" type="password" name="password" id="password" required>
        <span class="focus-input100"></span>
        <span class="label-input100">{{__('Password')}}</span>
    </div>

    <div class="wrap-input100 validate-input @if($errors->has('confirm_password')) error-validation @endif">
        <input class="input100" type="password" name="confirm_password" id="confirm_password" required>
        <span class="focus-input100"></span>
        <span class="label-input100">{{__('Confirm Password')}}</span>
    </div>


    <div class="container-login100-form-btn">
        <button class="login100-form-btn" type="submit">
            {{__('Register')}}
        </button>
    </div>


</form>

<span class="login100-form-title p-b-30 p-t-30">
    <a href="{{url('/admin/auth/login')}}">
        <h5 class="d-inline">
            <i class="fas fa-user-injured"></i>
            {{__('Login Lab')}}
        </h5>
    </a>
</span>


@endsection

@section('scripts')
<!-- <script src="{{url('js/admin/labs.js')}}"></script> -->
<script>
        $('#government_id').change(function () {
            $.get("{{ url('admin/auth/government') }}" + "/" + jQuery('#government_id').val() + "/get-regions",
                function(response){
                    let regions = response.data
                    let region_base = document.getElementById('region_id')
                    region_base.innerHTML = "";
                    region_base.innerHTML += "<option></option>";
                    regions.forEach(function(e) {
                        region_base.innerHTML += "<option value='" + e.id +"" + "'>" + e.name + "</option>";
                    })
                }
            );
        })
    </script>
@endsection
