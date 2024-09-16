<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none">
{{-- head --}}
@include('layouts.header')
@stack('css-libs')
@stack('css-styles')

<body>
    <div id="layout-wrapper">
        <header id="page-topbar">
            <div class="layout-width">
                <div class="navbar-header">
                    <div class="d-flex">
                        <button type="button"
                            class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger shadow-none"
                            id="topnav-hamburger-icon">
                            <span class="hamburger-icon">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                        </button>

                    </div>

                    <div class="d-flex align-items-center">
                        <div class="ms-1 header-item  d-sm-flex">
                            <a href="{{ route('monitoring') }}" target="_blank"
                                class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none">
                                <i class="bx bx-desktop fs-22"></i>
                            </a>
                        </div>

                        <div class="ms-1 header-item  d-sm-flex">
                            <button type="button"
                                class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none"
                                data-toggle="fullscreen">
                                <i class='bx bx-fullscreen fs-22'></i>
                            </button>
                        </div>


                        <div class="ms-1 header-item  d-sm-flex">
                            <button type="button"
                                class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode shadow-none">
                                <i class='bx bx-moon fs-22'></i>
                            </button>
                        </div>

                        @php
                            // Menghitung total data loan yang sesuai kondisi
                            $loanCount = \App\Models\Loan::where('rencana_pengembalian', '<', date('Y-m-d'))
                                ->where('status_peminjaman', 'Belum dikembalikan')
                                ->where('hospital_id', session('sessionHospital'))
                                ->count();

                            // Mengambil data loan dengan limit 5 dan urutkan berdasarkan rencana_pengembalian secara ascending
                            $loans = \App\Models\Loan::where('rencana_pengembalian', '<', date('Y-m-d'))
                                ->where('status_peminjaman', 'Belum dikembalikan')
                                ->where('hospital_id', session('sessionHospital'))
                                ->orderBy('rencana_pengembalian', 'asc')
                                ->limit(5)
                                ->get();

                            // Menghitung total data work order processes sesuai kondisi (schedule_date hari ini)
                            $woCount = \App\Models\WorkOrderProcess::join(
                                'work_orders',
                                'work_orders.id',
                                '=',
                                'work_order_processes.work_order_id',
                            )
                                ->where('work_orders.hospital_id', session('sessionHospital'))
                                ->where('work_order_processes.schedule_date', date('Y-m-d'))
                                ->count();

                            // Mengambil data work order processes dengan limit 5 (schedule_date hari ini)
                            $workOrders = \App\Models\WorkOrderProcess::join(
                                'work_orders',
                                'work_orders.id',
                                '=',
                                'work_order_processes.work_order_id',
                            )
                                ->where('work_orders.hospital_id', session('sessionHospital'))
                                ->where('work_order_processes.schedule_date', date('Y-m-d'))
                                ->orderBy('work_order_processes.schedule_date', 'asc')
                                ->limit(5)
                                ->get();

                            // Menghitung total notifikasi (loan + work order process)
                            $totalNotificationCount = $loanCount + $woCount;
                        @endphp

                        <div class="dropdown topbar-head-dropdown ms-1 header-item" id="notificationDropdown">
                            <button type="button"
                                class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none"
                                id="page-header-notifications-dropdown" data-bs-toggle="dropdown"
                                data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                                <i class='bx bx-bell fs-22'></i>
                                <span
                                    class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger">
                                    {{ $totalNotificationCount }}
                                    <span class="visually-hidden">unread messages</span>
                                </span>
                            </button>

                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                aria-labelledby="page-header-notifications-dropdown">
                                <div class="dropdown-head bg-primary bg-pattern rounded-top">
                                    <div class="p-3">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h6 class="m-0 fs-16 fw-semibold text-white"> Pemberitahuan </h6>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="px-2 pt-2">
                                        <ul class="nav nav-tabs dropdown-tabs nav-tabs-custom" data-dropdown-tabs="true"
                                            id="notificationItemsTab" role="tablist">
                                            <li class="nav-item waves-effect waves-light">
                                                <a class="nav-link active" data-bs-toggle="tab" href="#messages-tab"
                                                    role="tab" aria-selected="true">
                                                    Proses WO ({{ $woCount }})
                                                </a>
                                            </li>
                                            <li class="nav-item waves-effect waves-light">
                                                <a class="nav-link " data-bs-toggle="tab" href="#all-noti-tab"
                                                    role="tab" aria-selected="false">
                                                    Peminjaman Alat ({{ $loanCount }})
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                </div>

                                <div class="tab-content position-relative" id="notificationItemsTabContent">

                                    {{-- Tab for Work Order Notifications --}}
                                    <div class="tab-pane fade py-2 ps-2" id="messages-tab" role="tabpanel">
                                        <div data-simplebar style="max-height: 300px;" class="pe-2">
                                            {{-- Looping Data Work Orders --}}
                                            @forelse($workOrders as $wo)
                                                <div
                                                    class="text-reset notification-item d-block dropdown-item position-relative">
                                                    <div class="d-flex">
                                                        <div class="avatar-xs me-3 flex-shrink-0">
                                                            <i class="fa fa-calendar text-info fa-2x"
                                                                aria-hidden="true"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <a href="/panel/work-order-processes/{{ $wo->work_order_id }}"
                                                                class="stretched-link">
                                                                <h6 class="mt-0 mb-2 lh-base">WO terjadwal untuk hari
                                                                    ini: {{ $wo->schedule_date }}</h6>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div
                                                    class="text-reset notification-item d-block dropdown-item position-relative">
                                                    <div class="d-flex">
                                                        <div class="flex-grow-1">
                                                            <h6 class="mt-0 mb-2 lh-base">Tidak ada pemberitahuan</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforelse

                                            <div class="my-3 text-center view-all">
                                                <a href="/panel/work-order-processes"
                                                    class="btn btn-soft-success waves-effect waves-light">
                                                    View All data <i class="ri-arrow-right-line align-middle"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>


                                    {{-- Tab for Loan Notifications --}}
                                    <div class="tab-pane fade show active py-2 ps-2" id="all-noti-tab" role="tabpanel">
                                        <div data-simplebar style="max-height: 300px;" class="pe-2">
                                            {{-- Looping Data Loans --}}
                                            @forelse($loans as $loan)
                                                <div
                                                    class="text-reset notification-item d-block dropdown-item position-relative">
                                                    <div class="d-flex">
                                                        <div class="avatar-xs me-3 flex-shrink-0">
                                                            <i class="fa fa-exclamation-triangle text-warning fa-2x"
                                                                aria-hidden="true"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <a href="{{ route('loans.show', $loan->id) }}"
                                                                class="stretched-link">
                                                                <h6 class="mt-0 mb-2 lh-base">Peminjaman peralatan
                                                                    melebihi rencana pengembalian pada
                                                                    {{ $loan->rencana_pengembalian }}</h6>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div
                                                    class="text-reset notification-item d-block dropdown-item position-relative">
                                                    <div class="d-flex">
                                                        <div class="flex-grow-1">
                                                            <h6 class="mt-0 mb-2 lh-base">Tidak ada pemberitahuan</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforelse

                                            <div class="my-3 text-center view-all">
                                                <a href="{{ route('loans.index') }}"
                                                    class="btn btn-soft-success waves-effect waves-light">
                                                    View All data <i class="ri-arrow-right-line align-middle"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="dropdown ms-sm-3 header-item topbar-user">
                            <button type="button" class="btn shadow-none" id="page-header-user-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="d-flex align-items-center">
                                    @if (auth()->user()->avatar == null)
                                        <img class="rounded-circle header-profile-user"
                                            src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim(auth()->user()->email))) }}&s=30"
                                            alt="Header Avatar">
                                    @else
                                        <img class="rounded-circle header-profile-user"
                                            src="{{ asset('uploads/images/avatars/' . auth()->user()->avatar) }}"
                                            alt="">
                                    @endif


                                    <span class="text-start ms-xl-2">
                                        <span
                                            class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ Auth::user()->name }}</span>
                                        <span
                                            class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">{{ Auth::user()->roles->first()->name }}</span>
                                    </span>
                                </span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="{{ route('profile') }}"><i
                                        class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i>
                                    <span class="align-middle">{{ trans('navbar.profile') }}</span></a>


                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i>
                                    <span class="align-middle"
                                        data-key="t-logout">{{ trans('navbar.logout') }}</span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    class="d-none">
                                    @csrf
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- ========== App Menu ========== -->
        <div class="app-menu navbar-menu">
            <div class="navbar-brand-box">
                <a href="#" class="logo logo-dark">
                    <span class="logo-lg">
                        @if (session('sessionHospital'))
                            <span
                                style="margin-top: 2px; font-size: 20px; color: #dddddd; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);"><b>Manajemen
                                    Aset</b></span>
                        @endif
                        @php
                            if (session('sessionHospital')) {
                                $hospitalId = session('sessionHospital');
                                $hospital = DB::table('hospitals')->where('id', $hospitalId)->first();
                                if ($hospital->logo != null) {
                                    echo '<img  style="width:120px; padding:2px" src="' .
                                        Storage::url('uploads/logos/') .
                                        $hospital->logo .
                                        '" alt="">';
                                }
                            } else {
                                if (setting_web()->logo != null) {
                                    echo '<img src="' .
                                        Storage::url('public/img/setting_app/') .
                                        setting_web()->logo .
                                        '" alt="">';
                                }
                            }
                        @endphp
                    </span>
                </a>
                <a href="#" class="logo logo-light">
                    <span class="logo-lg">
                        @if (session('sessionHospital'))
                            <span
                                style="margin-top: 2px; font-size: 20px; color: #dddddd; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);"><b>Manajemen
                                    Aset</b></span>
                        @endif
                        @php
                            if (session('sessionHospital')) {
                                $hospitalId = session('sessionHospital');
                                $hospital = DB::table('hospitals')->where('id', $hospitalId)->first();
                                if ($hospital->logo != null) {
                                    echo '<img  style="width:120px; padding:2px" src="' .
                                        Storage::url('uploads/logos/') .
                                        $hospital->logo .
                                        '" alt="">';
                                }
                            } else {
                                if (setting_web()->logo != null) {
                                    echo '<img src="' .
                                        Storage::url('public/img/setting_app/') .
                                        setting_web()->logo .
                                        '" alt="">';
                                }
                            }
                        @endphp
                    </span>
                </a>
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
                    id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>
            {{-- sidebar --}}
            @include('layouts.sidebar')
        </div>
        <div class="vertical-overlay"></div>
        <div class="main-content">
            @yield('content')
            {{-- footer --}}
            @include('layouts.footer')
        </div>

    </div>
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <a href="https://wa.me/6283874731480?text=Hello%20Admin,%20saya%20ingin%20bertanya%20mengenai%20Aplikasi%20Marsweb.%20Mohon%20bantuan%20dan%20informasinya.%20Terima%20kasih."
        target="_blank" id="whatsapp-button">
        <img src="{{ asset('wa.png') }}" alt="WhatsApp" style="width: 60px;">
        <span id="whatsapp-text">Hubungi kami</span>
    </a>


    {{-- script --}}
    @include('layouts.script')

    @stack('js-libs')

    @stack('js-scripts')
    <style>
        #whatsapp-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        #whatsapp-text {
            margin-left: 10px;
            font-size: 16px;
            color: #25D366;
            /* Warna hijau khas WhatsApp */
            font-weight: bold;
        }

        #whatsapp-button:hover #whatsapp-text {
            color: #128C7E;
            /* Warna hijau lebih gelap untuk efek hover */
        }
    </style>
</body>

</html>
