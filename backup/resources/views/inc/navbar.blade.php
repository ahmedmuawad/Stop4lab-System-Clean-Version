@if(Auth::guard('admin')->check())
<!--  BEGIN NAVBAR  -->
<div class="header-container fixed-top">
    <header class="header navbar navbar-expand-sm">
        <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-menu" style="color: white; margin-right: 30px; margin-left: 30px;}">
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg></a>
        <ul class="navbar-item theme-brand flex-row  text-center">
            <li class="nav-item theme-logo">
                <a href="#">
                    <img src="{{ url('img/logo.png') }}" class="navbar-logo" alt="logo">
                </a>
            </li>
            <li class="nav-item theme-text">
                <a href="#" class="nav-link"> {{ $info['name'] }} </a>
            </li>
        </ul>


        {{-- Branchs --}}
        @can('admin')
            @if (auth()->guard('admin')->user()->roles[0]->role_id != 6)
                <ul class="navbar-item flex-row ml-md-auto">


                    <li class="nav-item dropdown message-dropdown">
                        <a class="nav-link dropdown-toggle" id="language-dropdown" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <img src="{{ asset('assets/img/git.png') }}">
                            {{ session('branch_name') }}
                        </a>
                        <div class="dropdown-menu position-absolute" aria-labelledby="language-dropdown">
                            @if (count($user_branches))
                                @foreach ($user_branches as $branch)
                                    <a href="{{ route('admin.change_branch', $branch['branch_id']) }}"
                                        class="dropdown-item d-flex" href="javascript:void(0);">
                                        <img src="{{ asset('assets/img/git.png') }}">
                                        <span>{{ $branch['branch']['name'] }}</span></a>
                                @endforeach
                            @else
                                <p>{{ __('No other branches') }}</p>
                            @endif
                        </div>
                    </li>
                @else
                </ul>
            @endif
        @endcan
        <ul class="navbar-item flex-row ml-md-auto">

            <li class="nav-item dropdown language-dropdown">
                <a href="{{ url('admin/calce') }}">
                    <img src="{{ asset('assets/img/keys.png') }}" class="flag-width" alt="flag">
                </a>
            </li>
        </ul>
        <ul class="navbar-item flex-row ml-md-auto">

            <li class="nav-item dropdown language-dropdown">

                <a class="nav-link change_theme" href="#">
                    <i class="fa fa-moon" aria-hidden="true"></i>
                </a>

            </li>
        </ul>

        <ul class="navbar-item flex-row ml-md-auto">

            <li class="nav-item dropdown language-dropdown">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="language-dropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                    <span> {{ app()->getLocale() }} </span>
                </a>
                <div class="dropdown-menu position-absolute" aria-labelledby="language-dropdown">
                    @foreach ($languages as $lang)

                        @if (app()->getLocale() != $lang['iso'])
                            <a href="{{ route('change_locale', $lang['iso']) }}" class="dropdown-item d-flex" href="javascript:void(0);">
                        @if (($lang['iso'] != 1))
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                            <circle style="fill:#F0F0F0;" cx="256" cy="256" r="256"/>
                            <path style="fill:#D80027;" d="M256,0C145.929,0,52.094,69.472,15.923,166.957h480.155C459.906,69.472,366.071,0,256,0z"/>
                            <path d="M256,512c110.071,0,203.906-69.472,240.077-166.957H15.923C52.094,442.528,145.929,512,256,512z"/>
                            <path style="fill:#FF9811;" d="M345.043,228.174h-66.783c0-12.294-9.967-22.261-22.261-22.261s-22.261,9.967-22.261,22.261h-66.783  c0,12.295,10.709,22.261,23.003,22.261h-0.742c0,12.295,9.966,22.261,22.261,22.261c0,12.295,9.966,22.261,22.261,22.261h44.522  c12.295,0,22.261-9.966,22.261-22.261c12.295,0,22.261-9.966,22.261-22.261h-0.741C334.335,250.435,345.043,240.469,345.043,228.174  z"/>
                            </g></svg><span class="align-self-center">{{ $lang['iso'] }}</span></a>
                        @else
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="64px" height="64px" viewBox="0 0 64 64" aria-hidden="true" role="img" class="iconify iconify--emojione" preserveAspectRatio="xMidYMid meet"><path d="M48 6.6C43.3 3.7 37.9 2 32 2v4.6h16" fill="#ed4c5c"/><path d="M32 11.2h21.6C51.9 9.5 50 7.9 48 6.6H32v4.6z" fill="#fff"/><path d="M32 15.8h25.3c-1.1-1.7-2.3-3.2-3.6-4.6H32v4.6z" fill="#ed4c5c"/><path d="M32 20.4h27.7c-.7-1.6-1.5-3.2-2.4-4.6H32v4.6" fill="#fff"/><path d="M32 25h29.2c-.4-1.6-.9-3.1-1.5-4.6H32V25z" fill="#ed4c5c"/><path d="M32 29.7h29.9c-.1-1.6-.4-3.1-.7-4.6H32v4.6" fill="#fff"/><path d="M61.9 29.7H32V32H2c0 .8 0 1.5.1 2.3h59.8c.1-.8.1-1.5.1-2.3c0-.8 0-1.6-.1-2.3" fill="#ed4c5c"/><path d="M2.8 38.9h58.4c.4-1.5.6-3 .7-4.6H2.1c.1 1.5.3 3.1.7 4.6" fill="#fff"/><path d="M4.3 43.5h55.4c.6-1.5 1.1-3 1.5-4.6H2.8c.4 1.6.9 3.1 1.5 4.6" fill="#ed4c5c"/><path d="M6.7 48.1h50.6c.9-1.5 1.7-3 2.4-4.6H4.3c.7 1.6 1.5 3.1 2.4 4.6" fill="#fff"/><path d="M10.3 52.7h43.4c1.3-1.4 2.6-3 3.6-4.6H6.7c1 1.7 2.3 3.2 3.6 4.6" fill="#ed4c5c"/><path d="M15.9 57.3h32.2c2.1-1.3 3.9-2.9 5.6-4.6H10.3c1.7 1.8 3.6 3.3 5.6 4.6" fill="#fff"/><path d="M32 62c5.9 0 11.4-1.7 16.1-4.7H15.9c4.7 3 10.2 4.7 16.1 4.7" fill="#ed4c5c"/><path d="M16 6.6c-2.1 1.3-4 2.9-5.7 4.6c-1.4 1.4-2.6 3-3.6 4.6c-.9 1.5-1.8 3-2.4 4.6c-.6 1.5-1.1 3-1.5 4.6c-.4 1.5-.6 3-.7 4.6c-.1.8-.1 1.6-.1 2.4h30V2c-5.9 0-11.3 1.7-16 4.6" fill="#428bc1"/><g fill="#fff"><path d="M25 3l.5 1.5H27l-1.2 1l.4 1.5l-1.2-.9l-1.2.9l.4-1.5l-1.2-1h1.5z"/><path d="M29 9l.5 1.5H31l-1.2 1l.4 1.5l-1.2-.9l-1.2.9l.4-1.5l-1.2-1h1.5z"/><path d="M21 9l.5 1.5H23l-1.2 1l.4 1.5l-1.2-.9l-1.2.9l.4-1.5l-1.2-1h1.5z"/><path d="M25 15l.5 1.5H27l-1.2 1l.4 1.5l-1.2-.9l-1.2.9l.4-1.5l-1.2-1h1.5z"/><path d="M17 15l.5 1.5H19l-1.2 1l.4 1.5l-1.2-.9l-1.2.9l.4-1.5l-1.2-1h1.5z"/><path d="M9 15l.5 1.5H11l-1.2 1l.4 1.5l-1.2-.9l-1.2.9l.4-1.5l-1.2-1h1.5z"/><path d="M29 21l.5 1.5H31l-1.2 1l.4 1.5l-1.2-.9l-1.2.9l.4-1.5l-1.2-1h1.5z"/><path d="M21 21l.5 1.5H23l-1.2 1l.4 1.5l-1.2-.9l-1.2.9l.4-1.5l-1.2-1h1.5z"/><path d="M13 21l.5 1.5H15l-1.2 1l.4 1.5l-1.2-.9l-1.2.9l.4-1.5l-1.2-1h1.5z"/><path d="M25 27l.5 1.5H27l-1.2 1l.4 1.5l-1.2-.9l-1.2.9l.4-1.5l-1.2-1h1.5z"/><path d="M17 27l.5 1.5H19l-1.2 1l.4 1.5l-1.2-.9l-1.2.9l.4-1.5l-1.2-1h1.5z"/><path d="M9 27l.5 1.5H11l-1.2 1l.4 1.5l-1.2-.9l-1.2.9l.4-1.5l-1.2-1h1.5z"/><path d="M11.8 13l1.2-.9l1.2.9l-.5-1.5l1.2-1h-1.5L13 9l-.5 1.5h-1.4l1.2.9l-.5 1.6"/><path d="M3.8 25l1.2-.9l1.2.9l-.5-1.5l1.2-1H5.5L5 21l-.5 1.5h-1c0 .1-.1.2-.1.3l.8.6l-.4 1.6"/></g></svg><span class="align-self-center">{{ $lang['iso'] }}</span></a>
                        @endif
                               {{--  <img src="{{ url('uploads/languages/en.png') }}" class="flag-width"> <span class="align-self-center">{{ $lang['name'] }}</span></a>  --}}
                        @endif
                    @endforeach
                </div>
            </li>

            <li class="nav-item dropdown message-dropdown">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="messageDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="far fa-comment-dots"></i>
                </a>
                <div class="dropdown-menu position-absolute" aria-labelledby="messageDropdown" style="left: 6px !important;">
                    <div class="">

                        <a class="dropdown-item">
                            <div class="">

                                <div class="media">
                                    <div class="user-img">
                                        <div class="avatar avatar-xl">
                                            <span class="avatar-title rounded-circle">OG</span>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div class="list_unread_messages">

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </a>
                    </div>
                </div>
            </li>

            <li class="nav-item dropdown language-dropdown notification-dropdown">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="notificationDropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-bell">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg><span class="badge badge-success"></span>
                </a>
                <div class="dropdown-menu position-absolute" aria-labelledby="notificationDropdown">
                    <div class="notification-scroll">

                        <div class="dropdown-item">
                            <div class="media server-log">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 511.289 511.289" style="enable-background:new 0 0 511.289 511.289;" xml:space="preserve">
                                    <path style="fill:#B0D3F0;" d="M453.452,199.111L307.437,52.148c-7.585-7.585-7.585-19.911,0-27.496l12.326-12.326  c7.585-7.585,19.911-7.585,27.496,0l146.015,146.015c7.585,7.585,7.585,19.911,0,27.496l-12.326,12.326  C474.311,206.696,461.037,206.696,453.452,199.111"/>
                                    <path style="fill:#E4F4F9;" d="M24.889,466.489l13.274,13.274c33.185,33.185,88.178,33.185,121.363,0l285.393-284.444  c1.896-1.896,1.896-3.793,0-4.741L315.97,60.681c-0.948-0.948-3.793-0.948-4.741,0L24.889,347.022  C-8.296,380.207-8.296,433.304,24.889,466.489"/>
                                    <g>
                                        <path style="fill:#90BAE1;" d="M340.622,175.407c-2.844,0-4.741-0.948-6.637-2.844l-40.77-40.77c-3.793-3.793-3.793-9.481,0-13.274   c3.793-3.793,9.481-3.793,13.274,0l39.822,39.822c3.793,3.793,3.793,9.481,0,13.274   C345.363,174.459,342.519,175.407,340.622,175.407z"/>
                                        <path style="fill:#90BAE1;" d="M293.215,182.044c-2.844,0-4.741-0.948-6.637-2.844l-19.911-19.911   c-3.793-3.793-3.793-9.481,0-13.274s9.481-3.793,13.274,0l19.911,19.911c3.793,3.793,3.793,9.481,0,13.274   C297.956,181.096,296.059,182.044,293.215,182.044z"/>
                                        <path style="fill:#90BAE1;" d="M286.578,228.504c-2.844,0-4.741-0.948-6.637-2.844l-39.822-39.822   c-3.793-3.793-3.793-9.481,0-13.274s9.481-3.793,13.274,0l39.822,39.822c3.793,3.793,3.793,9.481,0,13.274   C291.319,227.556,289.422,228.504,286.578,228.504z"/>
                                        <path style="fill:#90BAE1;" d="M240.119,235.141c-2.844,0-4.741-0.948-6.637-2.844l-19.911-19.911   c-3.793-3.793-3.793-9.481,0-13.274s9.481-3.793,13.274,0l19.911,19.911c3.793,3.793,3.793,9.481,0,13.274   C244.859,234.193,242.015,235.141,240.119,235.141z"/>
                                        <path style="fill:#90BAE1;" d="M233.481,282.548c-2.844,0-4.741-0.948-6.637-2.844l-39.822-39.822   c-3.793-3.793-3.793-9.481,0-13.274s9.481-3.793,13.274,0l39.822,39.822c3.793,3.793,3.793,9.481,0,13.274   C238.222,281.6,235.378,282.548,233.481,282.548z"/>
                                    </g>
                                    <g>
                                        <path style="fill:#B0D3F0;" d="M46.696,325.215l-21.807,21.807c-33.185,33.185-33.185,86.282,0,119.467l13.274,13.274   c33.185,33.185,88.178,33.185,121.363,0l155.496-154.548H46.696z"/>
                                        <path style="fill:#B0D3F0;" d="M462.933,329.007L462.933,329.007c-11.378-11.378-11.378-29.393,0-39.822l19.911-20.859   l19.911,19.911c11.378,11.378,11.378,29.393,0,39.822C491.378,339.437,474.311,339.437,462.933,329.007"/>
                                    </g></svg>
                                <div class="media-body">
                                    <div class="list_stock_alerts">

                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </li>
            <li class="nav-item dropdown user-profile-dropdown language-dropdown">


                <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    @if(auth()->guard('admin')->check())
                    <img src="@if(!empty(auth()->guard('admin')->user()->avatar)){{url('uploads/user-avatar/'.auth()->guard('admin')->user()->avatar)}}@else {{url('img/avatar.png')}} @endif" alt="avatar">
                    @else
                    <img src="@if(!empty(auth()->guard('patient')->user()->avatar)){{url('uploads/patient-avatar/'.auth()->guard('patient')->user()->avatar)}}@else {{url('img/avatar.png')}} @endif" alt="avatar">
                    @endif
                    {{--  @if(Auth::guard('admin')->check())
                {{Auth::guard('admin')->user()->name}}
              @else
                {{Auth::guard('patient')->user()->name}}<br>
                {{__('Code')}}: {{Auth::guard('patient')->user()->code}}
              @endif  --}}
                </a>


                <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                    <div class="">
                        <div class="dropdown-item">
                            <a class="" href="{{route('admin.profile.edit')}}"><svg xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-user">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg> {{__('Profile')}}</a>
                        </div>

                        <div class="dropdown-item">
                            <button class="align-self-center" role="button"
                                onclick="document.getElementById('sign_out').submit();">
                                <form id="sign_out" method="POST"
                                    action="@if (auth()->guard('admin')->check()) {{ route('admin.logout') }}@else{{ route('patient.logout') }} @endif">
                                    @csrf
                                </form>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg> {{__('Sign Out')}}
                            </button>
                        </div>
                    </div>
                </div>
            </li>


        </ul>
    </header>
</div>
<!--  END NAVBAR  -->

<!--  BEGIN NAVBAR  -->
<div class="sub-header-container">
    <header class="header navbar navbar-expand-sm" style="@media (min-width: 768px){.sub-header-container { margin-top: 40px;}}">
        {{--  <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom">
            <svg
                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-menu">
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg></a>  --}}
            <ul class="navbar-nav flex-row">
                <li>
                    <div class="page-header">

                        <nav class="breadcrumb-one" aria-label="breadcrumb">
                            <ol class="breadcrumb" style="padding-right:50px; padding-left:50px;">
                                @yield('breadcrumb')
                            </ol>
                        </nav>

                    </div>
                </li>
            </ul>

    </header>
</div>
<!--  END NAVBAR  -->
@else

<div class="header-container fixed-top">
    <header class="header navbar navbar-expand-sm">
        <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom">
            <svg
                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-menu" style="color: white; margin-right: 30px; margin-left: 30px;}">
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg></a>
        <ul class="navbar-item theme-brand flex-row  text-center">
            <li class="nav-item theme-logo">
                <a href="#">
                    <img src="{{ url('img/logo.png') }}" class="navbar-logo" alt="logo">
                </a>
            </li>
            <li class="nav-item theme-text">
                <a href="#" class="nav-link"> {{ $info['name'] }} </a>
            </li>
        </ul>

        <ul class="navbar-item flex-row ml-md-auto">

            <li class="nav-item dropdown language-dropdown">

                <a class="nav-link change_theme" href="#">
                    <i class="fa fa-moon" aria-hidden="true"></i>
                </a>

            </li>
        </ul>


        <ul class="navbar-item flex-row ml-md-auto">

            <li class="nav-item dropdown language-dropdown">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="language-dropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                    <span> {{ app()->getLocale() }} </span>
                </a>
                <div class="dropdown-menu position-absolute" aria-labelledby="language-dropdown">
                    @foreach ($languages as $lang)

                        @if (app()->getLocale() != $lang['iso'])
                            <a href="{{ route('change_locale', $lang['iso']) }}" class="dropdown-item d-flex" href="javascript:void(0);">
                        @if (($lang['iso'] != 1))
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                            <circle style="fill:#F0F0F0;" cx="256" cy="256" r="256"/>
                            <path style="fill:#D80027;" d="M256,0C145.929,0,52.094,69.472,15.923,166.957h480.155C459.906,69.472,366.071,0,256,0z"/>
                            <path d="M256,512c110.071,0,203.906-69.472,240.077-166.957H15.923C52.094,442.528,145.929,512,256,512z"/>
                            <path style="fill:#FF9811;" d="M345.043,228.174h-66.783c0-12.294-9.967-22.261-22.261-22.261s-22.261,9.967-22.261,22.261h-66.783  c0,12.295,10.709,22.261,23.003,22.261h-0.742c0,12.295,9.966,22.261,22.261,22.261c0,12.295,9.966,22.261,22.261,22.261h44.522  c12.295,0,22.261-9.966,22.261-22.261c12.295,0,22.261-9.966,22.261-22.261h-0.741C334.335,250.435,345.043,240.469,345.043,228.174  z"/>
                            </g></svg><span class="align-self-center">{{ $lang['iso'] }}</span></a>
                        @else
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="64px" height="64px" viewBox="0 0 64 64" aria-hidden="true" role="img" class="iconify iconify--emojione" preserveAspectRatio="xMidYMid meet"><path d="M48 6.6C43.3 3.7 37.9 2 32 2v4.6h16" fill="#ed4c5c"/><path d="M32 11.2h21.6C51.9 9.5 50 7.9 48 6.6H32v4.6z" fill="#fff"/><path d="M32 15.8h25.3c-1.1-1.7-2.3-3.2-3.6-4.6H32v4.6z" fill="#ed4c5c"/><path d="M32 20.4h27.7c-.7-1.6-1.5-3.2-2.4-4.6H32v4.6" fill="#fff"/><path d="M32 25h29.2c-.4-1.6-.9-3.1-1.5-4.6H32V25z" fill="#ed4c5c"/><path d="M32 29.7h29.9c-.1-1.6-.4-3.1-.7-4.6H32v4.6" fill="#fff"/><path d="M61.9 29.7H32V32H2c0 .8 0 1.5.1 2.3h59.8c.1-.8.1-1.5.1-2.3c0-.8 0-1.6-.1-2.3" fill="#ed4c5c"/><path d="M2.8 38.9h58.4c.4-1.5.6-3 .7-4.6H2.1c.1 1.5.3 3.1.7 4.6" fill="#fff"/><path d="M4.3 43.5h55.4c.6-1.5 1.1-3 1.5-4.6H2.8c.4 1.6.9 3.1 1.5 4.6" fill="#ed4c5c"/><path d="M6.7 48.1h50.6c.9-1.5 1.7-3 2.4-4.6H4.3c.7 1.6 1.5 3.1 2.4 4.6" fill="#fff"/><path d="M10.3 52.7h43.4c1.3-1.4 2.6-3 3.6-4.6H6.7c1 1.7 2.3 3.2 3.6 4.6" fill="#ed4c5c"/><path d="M15.9 57.3h32.2c2.1-1.3 3.9-2.9 5.6-4.6H10.3c1.7 1.8 3.6 3.3 5.6 4.6" fill="#fff"/><path d="M32 62c5.9 0 11.4-1.7 16.1-4.7H15.9c4.7 3 10.2 4.7 16.1 4.7" fill="#ed4c5c"/><path d="M16 6.6c-2.1 1.3-4 2.9-5.7 4.6c-1.4 1.4-2.6 3-3.6 4.6c-.9 1.5-1.8 3-2.4 4.6c-.6 1.5-1.1 3-1.5 4.6c-.4 1.5-.6 3-.7 4.6c-.1.8-.1 1.6-.1 2.4h30V2c-5.9 0-11.3 1.7-16 4.6" fill="#428bc1"/><g fill="#fff"><path d="M25 3l.5 1.5H27l-1.2 1l.4 1.5l-1.2-.9l-1.2.9l.4-1.5l-1.2-1h1.5z"/><path d="M29 9l.5 1.5H31l-1.2 1l.4 1.5l-1.2-.9l-1.2.9l.4-1.5l-1.2-1h1.5z"/><path d="M21 9l.5 1.5H23l-1.2 1l.4 1.5l-1.2-.9l-1.2.9l.4-1.5l-1.2-1h1.5z"/><path d="M25 15l.5 1.5H27l-1.2 1l.4 1.5l-1.2-.9l-1.2.9l.4-1.5l-1.2-1h1.5z"/><path d="M17 15l.5 1.5H19l-1.2 1l.4 1.5l-1.2-.9l-1.2.9l.4-1.5l-1.2-1h1.5z"/><path d="M9 15l.5 1.5H11l-1.2 1l.4 1.5l-1.2-.9l-1.2.9l.4-1.5l-1.2-1h1.5z"/><path d="M29 21l.5 1.5H31l-1.2 1l.4 1.5l-1.2-.9l-1.2.9l.4-1.5l-1.2-1h1.5z"/><path d="M21 21l.5 1.5H23l-1.2 1l.4 1.5l-1.2-.9l-1.2.9l.4-1.5l-1.2-1h1.5z"/><path d="M13 21l.5 1.5H15l-1.2 1l.4 1.5l-1.2-.9l-1.2.9l.4-1.5l-1.2-1h1.5z"/><path d="M25 27l.5 1.5H27l-1.2 1l.4 1.5l-1.2-.9l-1.2.9l.4-1.5l-1.2-1h1.5z"/><path d="M17 27l.5 1.5H19l-1.2 1l.4 1.5l-1.2-.9l-1.2.9l.4-1.5l-1.2-1h1.5z"/><path d="M9 27l.5 1.5H11l-1.2 1l.4 1.5l-1.2-.9l-1.2.9l.4-1.5l-1.2-1h1.5z"/><path d="M11.8 13l1.2-.9l1.2.9l-.5-1.5l1.2-1h-1.5L13 9l-.5 1.5h-1.4l1.2.9l-.5 1.6"/><path d="M3.8 25l1.2-.9l1.2.9l-.5-1.5l1.2-1H5.5L5 21l-.5 1.5h-1c0 .1-.1.2-.1.3l.8.6l-.4 1.6"/></g></svg><span class="align-self-center">{{ $lang['iso'] }}</span></a>
                        @endif
                               {{--  <img src="{{ url('uploads/languages/en.png') }}" class="flag-width"> <span class="align-self-center">{{ $lang['name'] }}</span></a>  --}}
                        @endif
                    @endforeach
                </div>
            </li>



            <li class="nav-item dropdown user-profile-dropdown">


                <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">

                    <img src="@if(!empty(auth()->guard('patient')->user()->avatar)){{url('uploads/patient-avatar/'.auth()->guard('patient')->user()->avatar)}}@else {{url('img/avatar.png')}} @endif" alt="avatar">
                    {{--  @if(Auth::guard('admin')->check())
                    {{Auth::guard('admin')->user()->name}}
                    @else
                        {{Auth::guard('patient')->user()->name}}<br>
                        {{__('Code')}}: {{Auth::guard('patient')->user()->code}}
                    @endif  --}}
                </a>


                <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown" style="left:6px !important;">
                    <div class="">
                        <div class="dropdown-item">
                            <a class="" href="{{route('admin.profile.edit')}}"><svg xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-user">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg> {{__('Profile')}}</a>
                        </div>

                        <div class="dropdown-item" style="left: 50px !important;">
                            <button class="align-self-center" role="button"
                                onclick="document.getElementById('sign_out').submit();">
                                <form id="sign_out" method="POST"
                                    action="@if (auth()->guard('admin')->check()) {{ route('admin.logout') }}@else{{ route('patient.logout') }} @endif">
                                    @csrf
                                </form>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg> {{__('Sign Out')}}
                            </button>
                        </div>
                    </div>
                </div>
            </li>


        </ul>
    </header>
</div>

@endif
