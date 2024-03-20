<!doctype html>
<html lang="en" data-layout="horizontal" data-layout-style="" data-layout-position="fixed" data-topbar="light">

<head>

    <meta charset="utf-8" />
    <title>Monitoring Work Order</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <link rel="shortcut icon" href="{{ asset('material') }}/assets/images/favicon.ico">
    <script src="{{ asset('material') }}/assets/js/layout.js"></script>
    <link href="{{ asset('material') }}/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('material') }}/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('material') }}/assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('material') }}/assets/css/custom.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <div id="layout-wrapper">

        <header id="page-topbar">
            <div class="layout-width">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box horizontal-logo">
                            <a href="#" class="logo logo-dark">
                                <span class="logo-sm">
                                    @if (setting_web()->favicon != null)
                                    <img src="{{ Storage::url('public/img/setting_app/') . setting_web()->favicon }}" alt="" height="25">
                                    @endif
                                </span>
                                <span class="logo-lg">
                                    @if (setting_web()->logo != null)
                                    <img src="{{ Storage::url('public/img/setting_app/') . setting_web()->logo }}" alt="" style="width: 85%">
                                    @endif
                                </span>
                            </a>
                            <a href="#" class="logo logo-light">
                                <span class="logo-sm">
                                    @if (setting_web()->favicon != null)
                                    <img src="{{ Storage::url('public/img/setting_app/') . setting_web()->favicon }}" alt="" height="25">
                                    @endif
                                </span>
                                <span class="logo-lg">
                                    @if (setting_web()->logo != null)
                                    <img src="{{ Storage::url('public/img/setting_app/') . setting_web()->logo }}" alt="" style="width: 85%">
                                    @endif
                                </span>
                            </a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="dropdown ms-1 topbar-head-dropdown header-item">
                            @switch(app()->getLocale())
                            @case('id')
                            <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{ asset('/material/assets/images/flags/indonesia.png') }}" alt="Header Language" height="20" class="rounded">
                            </button>
                            @break

                            @case('en')
                            <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{ asset('/material/assets/images/flags/us.svg') }}" alt="Header Language" height="20" class="rounded">
                            </button>
                            @break

                            @default
                            @endswitch
                            <div class="dropdown-menu media-list dropdown-menu-end" style="">
                                <a href="{{ route('localization.switch', ['language' => 'id']) }}" class="dropdown-item media">
                                    <div class="media-body">
                                        <h6 class="media-heading">
                                            <img src="{{ asset('material/assets/images/flags/indonesia.png') }}" alt="" class="me-2 rounded" height="18" />
                                            <span class="align-middle">Indonesia</span>
                                        </h6>
                                    </div>
                                </a>
                                <a href="{{ route('localization.switch', ['language' => 'en']) }}" class="dropdown-item media">
                                    <div class="media-body">
                                        <h6 class="media-heading">
                                            <img src="{{ asset('material/assets/images/flags/us.svg') }}" class="me-2 rounded" height="18" alt="" />
                                            <span class="align-middle">English</span>
                                        </h6>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="ms-1 header-item  d-sm-flex">
                            <a href="/panel" target="_blank" title="Back to Admin" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none">
                                <i class=" bx bx-arrow-back fs-22"></i>
                            </a>
                        </div>

                        <div class="ms-1 header-item  d-sm-flex">
                            <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none" data-toggle="fullscreen">
                                <i class='bx bx-fullscreen fs-22'></i>
                            </button>
                        </div>

                        <div class="ms-1 header-item  d-sm-flex">
                            <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode shadow-none">
                                <i class='bx bx-moon fs-22'></i>
                            </button>
                        </div>
                        <div class="dropdown ms-sm-3 header-item topbar-user">
                            <button type="button" class="btn shadow-none" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="d-flex align-items-center">
                                    @if (auth()->user()->avatar == null)
                                    <img class="rounded-circle header-profile-user" src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim(auth()->user()->email))) }}&s=30" alt="Header Avatar">
                                    @else
                                    <img class="rounded-circle header-profile-user" src="{{ asset('uploads/images/avatars/' . auth()->user()->avatar) }}" alt="">
                                    @endif


                                    <span class="text-start ms-xl-2">
                                        <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ Auth::user()->name }}</span>
                                        <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">{{ Auth::user()->roles->first()->name }}</span>
                                    </span>
                                </span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="{{ route('profile') }}"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span class="align-middle">{{ trans('navbar.profile') }}</span></a>


                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i>
                                    <span class="align-middle" data-key="t-logout">{{ trans('navbar.logout') }}</span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="app-menu navbar-menu">
            {{-- <div id="scrollbar">
                <div class="container-fluid">
                    <div id="two-column-menu">
                    </div>
                    <ul class="navbar-nav" id="navbar-nav">
                    </ul>
                </div>
            </div> --}}
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xxl-12">
                                <div class="d-flex flex-column h-100">
                                    <div class="row h-100">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="mt-3">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">#</th>
                                                                    <th scope="col">First Name</th>
                                                                    <th scope="col">Last Name</th>
                                                                    <th scope="col">Email</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <th scope="row">1</th>
                                                                    <td>John</td>
                                                                    <td>Doe</td>
                                                                    <td>john@example.com</td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">2</th>
                                                                    <td>Jane</td>
                                                                    <td>Smith</td>
                                                                    <td>jane@example.com</td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">3</th>
                                                                    <td>Michael</td>
                                                                    <td>Johnson</td>
                                                                    <td>michael@example.com</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> © PT. Mitra Tera Akurasi.
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    Manajemen Asset Rumah Sakit
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>

            </div>
        </div>
        <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </button>
        <script src="{{ asset('material') }}/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('material') }}/assets/libs/simplebar/simplebar.min.js"></script>
        <script src="{{ asset('material') }}/assets/libs/node-waves/waves.min.js"></script>
        <script src="{{ asset('material') }}/assets/libs/feather-icons/feather.min.js"></script>
        <script src="{{ asset('material') }}/assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
        <script src="{{ asset('material') }}/assets/js/plugins-monitoring.js"></script>
        <script src="{{ asset('material') }}/assets/libs/apexcharts/apexcharts.min.js"></script>
        <script src="{{ asset('material') }}/assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
        <script src="{{ asset('material') }}/assets/libs/jsvectormap/maps/world-merc.js"></script>
        <script src="{{ asset('material') }}/assets/js/pages/dashboard-analytics.init.js"></script>
        <script src="{{ asset('material') }}/assets/js/app.js"></script>


</body>

</html>
