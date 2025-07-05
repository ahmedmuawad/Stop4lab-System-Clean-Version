@include('inc.function')
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <link rel="icon" type="image/x-icon" href="{{ url('img/logo.png')  }}" />
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    @include('inc.styles')
    @yield('css')

</head>

<body>
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

    @include('inc.scripts')

    @endif



</body>

</html>
