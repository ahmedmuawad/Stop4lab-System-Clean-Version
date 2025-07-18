<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>{{$info['name']}} | @yield('title')</title>
<meta name="theme-color" content="#ffffff">
<!-- Tell the browser to be responsive to screen width -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{url('plugins/fontawesome-free/css/all.min.css')}}">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Tempusdominus Bbootstrap 4 -->
<link rel="stylesheet" href="{{url('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
<!-- iCheck -->
<link rel="stylesheet" href="{{url('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
<!-- JQVMap -->
<link rel="stylesheet" href="{{url('plugins/jqvmap/jqvmap.min.css')}}">
<!-- Theme style -->
<link rel="stylesheet" href="{{url('dist/css/adminlte.min.css')}}">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="{{url('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
<!-- Daterange picker -->
<link rel="stylesheet" href="{{url('plugins/daterangepicker/daterangepicker.css')}}">
<!-- summernote -->
<link rel="stylesheet" href="{{url('plugins/summernote/summernote-bs4.css')}}">
<!-- Google Font: Source Sans Pro -->
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
<!-- Datatables -->
<link rel="stylesheet" href="{{url('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{url('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{url('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('plugins/datatables-fixedheader/css/fixedHeader.bootstrap4.min.css')}}">
<!-- toastr css -->
<link rel="stylesheet" href="{{ URL::asset('css/toastr.min.css')}}">
<!-- select2 css -->
<link rel="stylesheet" href="{{ url('css/select2.css')}}" type="text/css">
<!-- jquery ui -->
<link rel="stylesheet" href="{{url('plugins/jquery-ui/jquery-ui.min.css')}}">
<!-- sweetalert -->
<link rel="stylesheet" href="{{url('plugins/sweet-alert/sweetalert.css')}}">
<!-- Flatpickr -->
<link rel="stylesheet" href="{{url('plugins/flatpickr/flatpickr.min.css')}}">
<!-- RTL -->
@if(session('rtl'))
    <link rel="stylesheet" href="{{url('css/rtl.css')}}">
    <link rel="stylesheet" href="{{url('css/bootstrap-rtl.min.css')}}">
@endif

<div id="theme">
    @if(auth()->guard('admin')->check()&&auth()->guard('admin')->user()->theme=='dark')
        <link rel="stylesheet" href="{{url('dist/css/dark-theme.css')}}">
    @elseif(auth()->guard('admin')->check())
        <link rel="stylesheet" href="{{url('dist/css/light-theme.css')}}">
    @endif

    @if(auth()->guard('patient')->check()&&auth()->guard('patient')->user()->theme=='dark')
        <link rel="stylesheet" href="{{url('dist/css/dark-theme.css')}}">
    @elseif(auth()->guard('patient')->check())
        <link rel="stylesheet" href="{{url('dist/css/light-theme.css')}}">
    @endif
</div>


@yield('css')
