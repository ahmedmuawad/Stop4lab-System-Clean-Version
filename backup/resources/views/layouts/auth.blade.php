
<!DOCTYPE html>
<html lang="en">
<head>
	<title>{{$info['name']}} | @yield('title')</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Stop4Labs System</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('new_design/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ url('new_design/assets/css/plugins.css')}}">
    <link rel="stylesheet" href="{{ url('new_design/assets/css/authentication/form-2.css')}}">
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="new_design/assets/css/forms/theme-checkbox-radio.css">
    <link rel="stylesheet" type="text/css" href="new_design/assets/css/forms/switches.css">
@if(session('rtl'))
	<link rel="stylesheet" href="{{ url('css/auth-rtl.css')}}">
@endif
<!--===============================================================================================-->
	<link rel="stylesheet" href="{{url('new_design/plugins/jquery-ui/jquery-ui.min.css')}}">

</head>
<body style="background-image: url('{{url("assets/images/banner.jpg")}}') !important; background-repeat: no-repeat;  background-size: cover;">





					{{--  <span class="login100-form-title p-b-30">
						<img src="{{url('img/logo.png')}}" height="100">
					</span>  --}}

					@include('partials.validation_errors')

					@yield('content')




	@yield('scripts')

</body>
</html>
