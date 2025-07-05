<!-- Title -->
<title>{{$info['name']}} | @yield('title')</title>
<!-- Favicon -->
<link rel="icon" href="{{URL::asset('new-design/assets/img/brand/favicon.png')}}" type="image/x-icon" />
<!-- Icons css -->
<link href="{{URL::asset('new-design/assets/css/icons.css')}}" rel="stylesheet">


@yield('css')

<!--- Style css -->
@if (App::getLocale() == 'ar')
<!--- Style css -->
<link href="{{URL::asset('new-design/assets/css-rtl/style.css')}}" rel="stylesheet">
<!--- Dark-mode css -->
<link href="{{URL::asset('new-design/assets/css-rtl/style-dark.css')}}" rel="stylesheet">
<!---Skinmodes css-->
<link href="{{URL::asset('new-design/assets/css-rtl/skin-modes.css')}}" rel="stylesheet">
<!--  Custom Scroll bar-->
<link href="{{URL::asset('new-design/assets/plugins/mscrollbar/jquery.mCustomScrollbar.css')}}" rel="stylesheet" />
<!--  Sidebar css -->
<link href="{{URL::asset('new-design/assets/plugins/sidebar/sidebar.css')}}" rel="stylesheet">
<!-- Sidemenu css -->
<link rel="stylesheet" href="{{URL::asset('new-design/assets/css-rtl/sidemenu.css')}}">
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

@else
<!--- Style css -->
<link href="{{URL::asset('new-design/assets/css/style.css')}}" rel="stylesheet">
<!--- Dark-mode css -->
<link href="{{URL::asset('new-design/assets/css/style-dark.css')}}" rel="stylesheet">
<!---Skinmodes css-->
<link href="{{URL::asset('new-design/assets/css/skin-modes.css')}}" rel="stylesheet">
<!--  Custom Scroll bar-->
<link href="{{URL::asset('new-design/assets/plugins/mscrollbar/jquery.mCustomScrollbar.css')}}" rel="stylesheet" />
<!--  Sidebar css -->
<link href="{{URL::asset('new-design/assets/plugins/sidebar/sidebar.css')}}" rel="stylesheet">
<!-- Sidemenu css -->
<link rel="stylesheet" href="{{URL::asset('new-design/assets/css/sidemenu.css')}}">
@endif