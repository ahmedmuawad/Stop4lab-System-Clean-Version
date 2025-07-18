<!-- main-sidebar -->
@php
if (session()->has('branch_id')) {
    $branch_rays = App\Models\Branch::find(session('branch_id'));
    if ($branch_rays != null) {
        $branch_rays = $branch_rays->ray_status;
    }
} else {
    $branch_rays = 0;
}
@endphp

<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar sidebar-scroll">
    <div class="main-sidebar-header active">
        <a class="desktop-logo logo-light active" href="{{ url('/' . ($page = 'index')) }}"><img
                src="{{ URL::asset('new-design/assets/img/brand/logo.png') }}" class="main-logo" alt="logo"></a>
        <a class="desktop-logo logo-dark active" href="{{ url('/' . ($page = 'index')) }}"><img
                src="{{ URL::asset('new-design/assets/img/brand/logo-white.png') }}" class="main-logo dark-theme"
                alt="logo"></a>
        <a class="logo-icon mobile-logo icon-light active" href="{{ url('/' . ($page = 'index')) }}"><img
                src="{{ URL::asset('new-design/assets/img/brand/favicon.png') }}" class="logo-icon" alt="logo"></a>
        <a class="logo-icon mobile-logo icon-dark active" href="{{ url('/' . ($page = 'index')) }}"><img
                src="{{ URL::asset('new-design/assets/img/brand/favicon-white.png') }}" class="logo-icon dark-theme"
                alt="logo"></a>
    </div>
    <div class="main-sidemenu">
        <div class="app-sidebar__user clearfix">
            <div class="dropdown user-pro-body">
                <div class="">
                    <img alt="user-img" class="avatar avatar-xl brround"
                        src="{{ URL::asset('new-design/assets/img/faces/6.jpg') }}"><span
                        class="avatar-status profile-status bg-green"></span>
                </div>
                <div class="user-info">
                    <h4 class="font-weight-semibold mt-3 mb-0">{{ Auth::user()->name }}</h4>
                    <span class="mb-0 text-muted">{{ Auth::user()->email }}</span>
                </div>
            </div>
        </div>
        <ul class="side-menu">
            <li class="side-item side-item-category">
                <a class="side-menu__item" href="{{ route('admin.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="#33A9F8" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="feather feather-home">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span class="side-menu__label" style="padding-left: 5px; padding-right: 5px;">
                        {{ __('Dashboard') }}</span></a>

            </li>


            @can('view_group')
                <li class="side-item side-item-category">{{ __('Reception') }}</li>

                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . ($page = '#')) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            version="1.1" id="Layer_1" x="0px" y="0px" width="24" height="24" viewBox="0 0 503.607 503.607"
                            style="enable-background:new 0 0 503.607 503.607;" xml:space="preserve">
                            <g transform="translate(1 1)">
                                <polygon style="fill:#FD9808;"
                                    points="334.738,217.229 418.672,217.229 418.672,183.656 334.738,183.656  " />
                                <g>
                                    <path style="fill:#FFDD09;"
                                        d="M427.066,183.656H326.344c0-27.698,22.662-50.361,50.361-50.361l0,0    C404.403,133.295,427.066,155.957,427.066,183.656" />
                                    <polygon style="fill:#FFDD09;"
                                        points="326.344,242.41 427.066,242.41 427.066,217.229 326.344,217.229   " />
                                </g>
                                <path style="fill:#DB4D6C;"
                                    d="M192.049,57.754c0,27.698-22.662,50.361-50.361,50.361S91.328,85.452,91.328,57.754   S113.99,7.393,141.689,7.393S192.049,30.056,192.049,57.754" />
                                <path style="fill:#1CD759;"
                                    d="M181.138,129.098c-11.751,7.554-25.18,12.59-39.449,12.59s-27.698-5.036-38.61-12.59   c-17.626,11.751-28.538,31.895-28.538,54.557v58.754h134.295v-58.754C208.836,160.993,197.925,140.849,181.138,129.098" />
                                <polygon style="fill:#FD9808;"
                                    points="343.131,292.77 494.213,292.77 494.213,242.41 343.131,242.41  " />
                                <polygon style="fill:#FFFFFF;"
                                    points="7.393,292.77 158.475,292.77 158.475,242.41 7.393,242.41  " />
                                <polygon style="fill:#FFDD09;"
                                    points="32.574,292.77 469.033,292.77 469.033,242.41 32.574,242.41  " />
                                <path style="fill:#FD9808;"
                                    d="M469.033,494.213h-268.59c-9.233,0-16.787-7.554-16.787-16.787V292.77H485.82v184.656   C485.82,486.659,478.266,494.213,469.033,494.213" />
                                <path style="fill:#FFFFFF;"
                                    d="M301.164,494.213H32.574c-9.233,0-16.787-7.554-16.787-16.787V292.77h302.164v184.656   C317.951,486.659,310.397,494.213,301.164,494.213" />
                                <path style="fill:#FFDD09;"
                                    d="M443.852,494.213H57.754c-9.233,0-16.787-7.554-16.787-16.787V292.77h419.672v184.656   C460.639,486.659,453.085,494.213,443.852,494.213" />
                                <path style="fill:#33A9F8;"
                                    d="M309.557,393.492c0-36.931-30.216-67.148-67.148-67.148s-67.148,30.216-67.148,67.148   s30.216,67.148,67.148,67.148S309.557,430.423,309.557,393.492" />
                                <path style="fill:#54C9FD;"
                                    d="M284.377,393.492c0-36.931-24.341-67.148-54.557-67.148s-54.557,30.216-54.557,67.148   s24.341,67.148,54.557,67.148S284.377,430.423,284.377,393.492" />
                                <path
                                    d="M494.213,301.164H7.393c-5.036,0-8.393-3.357-8.393-8.393V242.41c0-5.036,3.357-8.393,8.393-8.393h486.82   c5.036,0,8.393,3.357,8.393,8.393v50.361C502.607,297.807,499.249,301.164,494.213,301.164z M15.787,284.377H485.82v-33.574H15.787   V284.377z" />
                                <path
                                    d="M208.836,250.803H74.541c-5.036,0-8.393-3.357-8.393-8.393v-58.754c0-24.341,11.751-47.003,31.895-61.272   c2.518-1.679,6.715-1.679,10.072,0c20.144,14.269,47.843,14.269,67.987,0c2.518-1.679,6.715-1.679,10.072,0   c20.144,14.269,31.895,36.931,31.895,61.272v58.754C217.229,247.446,213.872,250.803,208.836,250.803z M82.934,234.016h117.508   v-50.361c0-16.787-7.554-32.734-20.144-44.485c-23.502,14.269-53.718,14.269-77.22,0c-12.59,11.751-20.144,27.698-20.144,44.485   V234.016z" />
                                <path
                                    d="M141.689,116.508c-32.734,0-58.754-26.02-58.754-58.754S108.954-1,141.689-1s58.754,26.02,58.754,58.754   S174.423,116.508,141.689,116.508z M141.689,15.787c-23.502,0-41.967,18.466-41.967,41.967s18.466,41.967,41.967,41.967   s41.967-18.466,41.967-41.967S165.19,15.787,141.689,15.787z" />
                                <path
                                    d="M418.672,225.623h-83.934c-5.036,0-8.393-3.357-8.393-8.393v-33.574c0-5.036,3.357-8.393,8.393-8.393h83.934   c5.036,0,8.393,3.357,8.393,8.393v33.574C427.066,222.266,423.708,225.623,418.672,225.623z M343.131,208.836h67.148v-16.787   h-67.148V208.836z" />
                                <path
                                    d="M427.066,192.049H326.344c-5.036,0-8.393-3.357-8.393-8.393c0-32.734,26.02-58.754,58.754-58.754   s58.754,26.02,58.754,58.754C435.459,188.692,432.102,192.049,427.066,192.049z M335.577,175.262h82.256   c-4.197-19.305-20.984-33.574-41.128-33.574S339.774,155.957,335.577,175.262z" />
                                <path
                                    d="M427.066,250.803H326.344c-5.036,0-8.393-3.357-8.393-8.393v-25.18c0-5.036,3.357-8.393,8.393-8.393h100.721   c5.036,0,8.393,3.357,8.393,8.393v25.18C435.459,247.446,432.102,250.803,427.066,250.803z M334.738,234.016h83.934v-8.393h-83.934   V234.016z" />
                                <path
                                    d="M469.033,502.607H32.574c-14.269,0-25.18-10.911-25.18-25.18V292.77c0-5.036,3.357-8.393,8.393-8.393H485.82   c5.036,0,8.393,3.357,8.393,8.393v184.656C494.213,491.695,483.302,502.607,469.033,502.607z M24.18,301.164v176.262   c0,5.036,3.357,8.393,8.393,8.393h436.459c5.036,0,8.393-3.357,8.393-8.393V301.164H24.18z" />
                                <path
                                    d="M141.689,217.229c-3.357,0-5.875-1.679-7.554-4.197l-25.18-41.967c-1.679-3.357-1.679-7.554,1.679-10.072l25.18-25.18   c3.357-3.357,8.393-3.357,11.751,0l25.18,25.18c2.518,2.518,3.357,6.715,1.679,10.072l-25.18,41.967   C147.564,215.551,145.046,217.229,141.689,217.229z M127.42,168.548l14.269,24.341l14.269-24.341l-14.269-15.108L127.42,168.548z" />
                                <path
                                    d="M242.41,469.033c-41.967,0-75.541-33.574-75.541-75.541s33.574-75.541,75.541-75.541s75.541,33.574,75.541,75.541   S284.377,469.033,242.41,469.033z M242.41,334.738c-32.734,0-58.754,26.02-58.754,58.754s26.02,58.754,58.754,58.754   s58.754-26.02,58.754-58.754S275.144,334.738,242.41,334.738z" />
                                <path
                                    d="M242.41,435.459c-23.502,0-41.967-18.466-41.967-41.967c0-5.036,3.357-8.393,8.393-8.393c5.036,0,8.393,3.357,8.393,8.393   c0,14.269,10.911,25.18,25.18,25.18c5.036,0,8.393,3.357,8.393,8.393S247.446,435.459,242.41,435.459z" />
                                <path
                                    d="M275.984,401.885c-5.036,0-8.393-3.357-8.393-8.393c0-14.269-10.911-25.18-25.18-25.18c-5.036,0-8.393-3.357-8.393-8.393   c0-5.036,3.357-8.393,8.393-8.393c23.502,0,41.967,18.466,41.967,41.967C284.377,398.528,281.02,401.885,275.984,401.885z" />
                                <path
                                    d="M74.541,469.033H15.787c-5.036,0-8.393-3.357-8.393-8.393c0-5.036,3.357-8.393,8.393-8.393h58.754   c5.036,0,8.393,3.357,8.393,8.393C82.934,465.675,79.577,469.033,74.541,469.033z" />
                                <path
                                    d="M74.541,435.459H15.787c-5.036,0-8.393-3.357-8.393-8.393s3.357-8.393,8.393-8.393h58.754c5.036,0,8.393,3.357,8.393,8.393   S79.577,435.459,74.541,435.459z" />
                                <path
                                    d="M485.82,469.033h-58.754c-5.036,0-8.393-3.357-8.393-8.393c0-5.036,3.357-8.393,8.393-8.393h58.754   c5.036,0,8.393,3.357,8.393,8.393C494.213,465.675,490.856,469.033,485.82,469.033z" />
                                <path
                                    d="M485.82,435.459h-58.754c-5.036,0-8.393-3.357-8.393-8.393s3.357-8.393,8.393-8.393h58.754   c5.036,0,8.393,3.357,8.393,8.393S490.856,435.459,485.82,435.459z" />
                            </g>
                        </svg>
                        <span class="side-menu__label" style="padding-left: 10px; padding-right: 10px;">
                            {{ __('Invoices') }}</span><i class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">
                        <li>
                            <a class="slide-item" href="{{ route('admin.groups.index') }}">
                                {{ __('All Invoices') }}</a>
                        </li>
                        <li>
                            <a class="slide-item" href="{{ route('admin.groups.create') }}">
                                {{ __('Create Invoice') }}</a>
                        </li>
                        @if ($branch_rays)
                            <li>
                                <a class="slide-item" href="{{ route('admin.ray_groups.create') }}">
                                    {{ __('Create Ray Invoice') }}</a>
                            </li>
                        @endif
                        @can('view_retrieve_group')
                            <li>
                                <a class="slide-item" href="{{ url('admin/retrieved') }}">
                                    {{ __('Retrieved') }}</a>
                            </li>
                        @endcan
                        <li>
                            <a class="slide-item" href="{{ route('admin.patients.index') }}">
                                {{ __('Patients') }}</a>
                        </li>
                        <li>
                            <a class="slide-item" href="{{ route('admin.patients.create') }}">
                                {{ __('Add Patient') }}</a>
                        </li>
                    </ul>
                </li>
            @endcan






        </ul>
    </div>
</aside>
<!-- main-sidebar -->
