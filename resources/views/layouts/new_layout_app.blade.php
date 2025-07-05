@include('inc.function')
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="{{asset('logo-stop.png')}}" type="image/png" />
	<!--plugins-->
    @include('inc.styles')
    @yield('css')
	@yield("style")
	<link href="{{asset('assets/plugins/simplebar/css/simplebar.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/plugins/metismenu/css/metisMenu.min.css')}}" rel="stylesheet" />

</head>

<body>
	<!--wrapper-->
    <div class="preloader">
    </div>
     <!-- BEGIN LOADER -->
    <div id="load_screen" class="loader"> <div class="loader"> <div class="loader-content">
        <div class="spinner-grow align-self-center"></div>
    </div></div></div>
    <!--  END LOADER --> 
    @if(Auth::guard('admin')->check())
    @include('inc.navbar')
    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        @include('inc.sidebar')

        <!--  BEGIN CONTENT PART  -->
        <div id="content" class="main-content">

            @yield('content')
            <input type="hidden" id="system_currency" value="{{cache('currency')}}">
            <input type="hidden" id="system_date" value="{{date('Y-m-d')}}">
        </div>
        <!--  END CONTENT PART  -->

    </div>
    <!-- END MAIN CONTAINER -->

    @include('inc.scripts')
    @else
    @include('inc.navbar')
    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        @include('inc.sidebar')

        <!--  BEGIN CONTENT PART  -->
        <div id="content" class="main-content">
            @yield('content')
            <input type="hidden" id="system_currency" value="{{cache('currency')}}">
            <input type="hidden" id="system_date" value="{{date('Y-m-d')}}">
        </div>
        <!--  END CONTENT PART  -->
    </div>
    <!-- END MAIN CONTAINER -->
     <!--end switcher-->
	<!-- Bootstrap JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js')}}"></script>
	<!--plugins-->
    <script src="{{ asset('assets/js/jquery.min.js')}}"></script>
    <script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js')}}"></script>
    <script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js')}}"></script>
    <script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js')}}"></script>
	<!--app JS-->
    <script src="{{ asset('assets/js/app.js')}}"></script>
    @yield("scripts")
    @include('inc.script')
    @endif
</body>
</html>
