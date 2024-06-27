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
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <!-- Add this in the head section -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Add this before the closing </body> tag -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


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
                        {{-- <div class="search-mobile-trigger d-sm-none col">
                            <i class="search-mobile-trigger-icon fas fa-search"></i>
                        </div><!--//col--> --}}
                        {{-- <div class="app-search-box col">
                            <form class="app-search-form">
                                <input type="text" placeholder="Find Trolly.. Like N1/W1" name="search"
                                    class="form-control search-input">
                                <button type="submit" class="btn search-btn btn-primary" value="Search"><i
                                        class="fas fa-search"></i></button>
                            </form>
                        </div><!--//app-search-box--> --}}

                        <div class="app-search-box col">
                            <form action="{{ route('search-trolly') }}" method="GET">
                                <div class="d-flex align-items-center justify-content-between gap-2">
                                    <div class="input-group">
                                        <select class="form-select" id="department" name="department">
                                            <option value="">Select Department</option>
                                            <option value="RCN RECEIVING">RCN RECEIVING</option>
                                            <option value="RCN GRADING">RCN GRADING</option>
                                            <option value="RCN BOILING">RCN BOILING</option>
                                            <option value="SCOOPING">SCOOPING</option>
                                            <option value="BORMA/ DRYING">BORMA/ DRYING</option>
                                            <option value="PEELING">PEELING</option>
                                            <option value="SMALL TAIHO">SMALL TAIHO</option>
                                            <option value="MAYUR">MAYUR</option>
                                            <option value="HAMSA">HAMSA</option>
                                            <option value="WHOLES GRADING">WHOLES GRADING</option>
                                            <option value="LW GRADING">LW GRADING</option>
                                            <option value="SHORTING">SHORTING</option>
                                            <option value="DP & DS GRADING">DP & DS GRADING</option>
                                            <option value="PACKING">PACKING</option>
                                        </select>
                                        <input type="text" class="form-control" name="search_trolly" placeholder="Find Trolly" aria-label="Find Trolly">
                                        <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>


                        <div class="app-utilities col-auto">

                            <div class="app-utility-item">
                                <a href="#" title="Settings">

                                    <iconify-icon icon="akar-icons:gear" width="30" height="30"
                                        style="color: #15a362; "></iconify-icon>
                                </a>
                            </div>

                            <div class="app-utility-item app-user-dropdown dropdown">
                                <iconify-icon icon="ph:user" width="30" height="30" style="color: #15a362; "
                                    class="" id="user-dropdown-toggle" data-bs-toggle="dropdown" role="button"
                                    aria-expanded="false"></iconify-icon>
                                {{-- <a class="dropdown-toggle" id="user-dropdown-toggle" data-bs-toggle="dropdown"
                                    href="#" role="button" aria-expanded="false"><img
                                        src="{{ asset('assets/images/user.png') }}" alt="user profile"></a> --}}
                                <ul class="dropdown-menu" aria-labelledby="user-dropdown-toggle">
                                    <li><a class="dropdown-item" href="#">{{ Auth::user()->name }}</a></li>
                                    <li><a class="dropdown-item" href="#">Settings</a></li>
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
                    <a class="app-logo" href="{{ route('admin.home') }}"><img class="logo-icon me-2"
                            src="{{ asset('assets/images/Payal Dealers.png') }}" alt="logo"></a>

                </div>

                <nav id="app-nav-main" class="app-nav app-nav-main flex-grow-1">
                    <ul class="app-menu list-unstyled accordion" id="menu-accordion">
                        <li class="nav-item">
                            <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
                            <a class="nav-link {{ \Route::currentRouteName() == 'admin.home' ? 'active' : '' }}"
                                href="{{ route('admin.home') }}">
                                <span class="nav-icon">
                                    <iconify-icon icon="f7:house-fill" width="30" height="30"
                                        style="color: #15a362"></iconify-icon>
                                </span>
                                <span class="nav-link-text" style="margin-left: 5px;">Dashboard</span>
                            </a><!--//nav-link-->
                        </li><!--//nav-item-->
                        <li class="nav-item">
                            <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
                            <a class="nav-link {{ \Route::currentRouteName() == 'admin.supervisor' ? 'active' : '' }}"
                                href="{{ route('admin.supervisor') }}">
                                <span class="nav-icon">
                                    <iconify-icon icon="bi:people" width="30" height="30"
                                        style="color: #15a362"></iconify-icon>
                                </span>
                                <span class="nav-link-text" style="margin-left: 5px;">Add Supervisor</span>
                            </a><!--//nav-link-->
                        </li><!--//nav-item-->
                        <li class="nav-item">
                            <a class="nav-link {{ \Route::currentRouteName() == 'search-trolly' ? 'active' : '' }}"
                               href="{{ route('search-trolly') }}">
                                <span class="nav-icon">
                                    <iconify-icon icon="bi:card-list" width="30" height="30" style="color: #15a362"></iconify-icon>
                                </span>
                                <span class="nav-link-text" style="margin-left: 5px;">Find Trolly</span>
                            </a>
                        </li>



                        <li class="nav-item">
                            <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
                            <a class="nav-link {{ \Route::currentRouteName() == 'admin.productivity' ? 'active' : '' }}"
                                href="{{ route('admin.productivity') }}">
                                <span class="nav-icon">
                                    <iconify-icon icon="bi:bar-chart-line" width="30" height="30"
                                        style="color: #15a362"></iconify-icon>
                                </span>
                                <span class="nav-link-text" style="margin-left: 5px;">Productivity Report</span>
                            </a><!--//nav-link-->
                        </li><!--//nav-item-->
                        <li class="nav-item">
                            <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
                            <a class="nav-link {{ \Route::currentRouteName() == 'admin.qr' ? 'active' : '' }}"
                                href="{{ route('admin.qr') }}">
                                <span class="nav-icon">
                                    <iconify-icon icon="mdi:qrcode-scan" width="30" height="30"
                                        style="color: #15a362"></iconify-icon>
                                </span>
                                <span class="nav-link-text" style="margin-left: 5px;">QR CODE Generate</span>
                            </a><!--//nav-link-->
                        </li>

                        <li class="nav-item">
                            <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
                            <a class="nav-link {{ \Route::currentRouteName() == 'admin.qrcode-report' ? 'active' : '' }}"
                                href="{{ route('admin.qrcode-report') }}">
                                <span class="nav-icon">
                                    <iconify-icon icon="oui:app-reporting" width="30" height="30"
                                        style="color: #15a362"></iconify-icon>
                                </span>
                                <span class="nav-link-text" style="margin-left: 5px;">QR CODE Report</span>
                            </a><!--//nav-link-->
                        </li>

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
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>



    @yield('js')
    @yield('html')
</body>

</html>
