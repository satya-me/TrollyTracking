<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="Portal - Bootstrap 5 Admin Dashboard Template For Developers">
    <meta name="author" content="Xiaoying Riley at 3rd Wave Media">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">

    <!-- FontAwesome JS-->
    {{-- <script defer src="assets/plugins/fontawesome/js/all.min.js"></script> --}}
    <script defer src="{{ asset('assets/plugins/fontawesome/js/all.min.js') }}"></script>
    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
    <!-- App CSS -->
    <link id="theme-style" rel="stylesheet" href="{{ asset('assets/css/portal.css') }}">
    @yield('css')
</head>

<body class="app">
    <header class="app-header fixed-top">
        <div class="app-header-inner">
            <div class="container-fluid py-2">
                <div class="app-header-content">
                    <div class="row justify-content-between align-items-center">

                        <div class="col-auto">
                            <a id="sidepanel-toggler" class="sidepanel-toggler d-inline-block d-xl-none" href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                    viewBox="0 0 30 30" role="img">
                                    <title>Menu</title>
                                    <path stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10"
                                        stroke-width="2" d="M4 7h22M4 15h22M4 23h22"></path>
                                </svg>
                            </a>
                        </div><!--//col-->
                        <div class="search-mobile-trigger d-sm-none col">
                            <i class="search-mobile-trigger-icon fas fa-search"></i>
                        </div><!--//col-->


                        <div class="app-utilities col-auto">

                            {{-- <div class="app-utility-item">
                                <a href="#" title="Settings">

                                    <iconify-icon icon="akar-icons:gear" width="30" height="30"
                                        style="color: #15a362; "></iconify-icon>
                                </a>
                            </div> --}}

                            <div class="app-utility-item app-user-dropdown dropdown">
                                <iconify-icon icon="ph:user" width="30" height="30" style="color: #15a362; "
                                    class="" id="user-dropdown-toggle" data-bs-toggle="dropdown" role="button"
                                    aria-expanded="false"></iconify-icon>
                                {{-- <a class="dropdown-toggle" id="user-dropdown-toggle" data-bs-toggle="dropdown"
                                    href="#" role="button" aria-expanded="false"><img
                                        src="{{ asset('assets/images/user.png') }}" alt="user profile"></a> --}}
                                <ul class="dropdown-menu" aria-labelledby="user-dropdown-toggle">
                                    <li><a class="dropdown-item" href="#">{{ Auth::user()->name }}</a></li>
                                    {{-- <li><a class="dropdown-item" href="#">Settings</a></li> --}}
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="app-sidepanel" class="app-sidepanel">
            <div id="sidepanel-drop" class="sidepanel-drop"></div>
            <div class="sidepanel-inner d-flex flex-column">
                <a href="#" id="sidepanel-close" class="sidepanel-close d-xl-none">&times;</a>
                <div class="app-branding">
                    <a class="app-logo" href="{{ route('supervisor.home') }}"><img class="logo-icon me-2"
                            src="{{ asset('assets/images/Payal Dealers.png') }}" alt="logo"></a>

                </div>

                <nav id="app-nav-main" class="app-nav app-nav-main flex-grow-1">
                    <ul class="app-menu list-unstyled accordion" id="menu-accordion">
                        <li class="nav-item">
                            <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
                            <a class="nav-link " href="{{route('user.qr')}}">
                                <span class="nav-icon">
                                    <iconify-icon icon="mdi:qrcode-scan" width="30" height="30"
                                        style="color: #15a362"></iconify-icon>
                                </span>
                                <span class="nav-link-text" style="margin-left: 5px;">QR CODE Generate</span>
                            </a>
                        </li>

                        {{-- <li class="nav-item">

                            <a class="nav-link " href="#">
                                <span class="nav-icon">
                                    <iconify-icon icon="oui:app-reporting" width="30" height="30"
                                        style="color: #15a362"></iconify-icon>
                                </span>
                                <span class="nav-link-text" style="margin-left: 5px;">QR CODE Report</span>
                            </a>
                        </li> --}}

                    </ul><!--//app-menu-->
                </nav>


            </div>
        </div>
    </header>

    <div class="app-wrapper">

        @yield('content')



    </div>


    <!-- Javascript -->
    <script src="{{ asset('assets/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

    <!-- Charts JS -->
    <script src="{{ asset('assets/plugins/chart.js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/js/index-charts.js') }}"></script>

    <!-- Page Specific JS -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    @yield('js')
    @yield('html')
</body>

</html>
