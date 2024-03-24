<!doctype html>
<html lang="en" data-layout="horizontal" data-layout-style="" data-layout-position="fixed" data-topbar="light">

<head>

    <meta charset="utf-8" />
    <title>Monitoring Work Order</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <link rel="icon"
        @if (setting_web()->favicon != null) href="{{ Storage::url('public/img/setting_app/') . setting_web()->favicon }}" @endif
        type="image/x-icon">
    <script src="{{ asset('material/assets/js/layout.js') }}"></script>
    <link href="{{ asset('material/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('material/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('material/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('material/assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ asset('material/assets/css/select2.css') }}" rel="stylesheet" />
    <link href="{{ asset('material/assets/css/daterangepicker.min.css') }}" rel="stylesheet" />
</head>
<style>
    .table td button {
        width: 100%;
    }
</style>

<body>
    <div id="layout-wrapper">
        <header id="page-topbar">
            <div class="layout-width">
                <div class="navbar-header">
                    <div class="d-flex">
                        <div class="navbar-brand-box">
                            <a href="#" class="logo logo-dark">
                                <span class="logo-lg">
                                    @if (setting_web()->logo != null)
                                        <img src="{{ Storage::url('public/img/setting_app/') . setting_web()->logo }}"
                                            alt="" style="width: 85%">
                                    @endif
                                </span>
                            </a>
                            <a href="#" class="logo logo-light">
                                <span class="logo-lg">
                                    @if (setting_web()->logo != null)
                                        <img src="{{ Storage::url('public/img/setting_app/') . setting_web()->logo }}"
                                            alt="" style="width: 85%">
                                    @endif
                                </span>
                            </a>
                            <button type="button"
                                class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
                                id="vertical-hover">
                            </button>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="dropdown ms-1 topbar-head-dropdown header-item">
                            @switch(app()->getLocale())
                                @case('id')
                                    <button type="button"
                                        class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <img src="{{ asset('/material/assets/images/flags/indonesia.png') }}"
                                            alt="Header Language" height="20" class="rounded">
                                    </button>
                                @break

                                @case('en')
                                    <button type="button"
                                        class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <img src="{{ asset('/material/assets/images/flags/us.svg') }}" alt="Header Language"
                                            height="20" class="rounded">
                                    </button>
                                @break

                                @default
                            @endswitch
                            <div class="dropdown-menu media-list dropdown-menu-end" style="">
                                <a href="{{ route('localization.switch', ['language' => 'id']) }}"
                                    class="dropdown-item media">
                                    <div class="media-body">
                                        <h6 class="media-heading">
                                            <img src="{{ asset('material/assets/images/flags/indonesia.png') }}"
                                                alt="" class="me-2 rounded" height="18" />
                                            <span class="align-middle">Indonesia</span>
                                        </h6>
                                    </div>
                                </a>
                                <a href="{{ route('localization.switch', ['language' => 'en']) }}"
                                    class="dropdown-item media">
                                    <div class="media-body">
                                        <h6 class="media-heading">
                                            <img src="{{ asset('material/assets/images/flags/us.svg') }}"
                                                class="me-2 rounded" height="18" alt="" />
                                            <span class="align-middle">English</span>
                                        </h6>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="ms-1 header-item  d-sm-flex">
                            <a href="/panel" target="_blank" title="Back to Admin"
                                class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none">
                                <i class=" bx bx-arrow-back fs-22"></i>
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
                                        class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                                        class="align-middle">{{ trans('navbar.profile') }}</span></a>
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
        <div class="vertical-overlay"></div>
        <div class="app-menu navbar-menu">
            <div id="scrollbar">
                <div class="container-fluid">
                    <div id="two-column-menu">
                    </div>
                    <ul class="navbar-nav" id="navbar-nav">
                    </ul>
                </div>
            </div>
        </div>
        <div class="main-content">
            <div class="page-content" style="margin-top: 30px">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    @if (!Auth::user()->roles->first()->hospital_id)
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                <form class="form-inline" method="get">
                                                    @csrf
                                                    <div class="input-group mb-2 mr-sm-2">
                                                        <select name="hospital_id" id="hospital_id"
                                                            class="form-control js-example-basic-multiple">
                                                            <option value="">--
                                                                {{ trans('work-order/submission/index.filter_hospital') }}
                                                                --
                                                            </option>
                                                        </select>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="input-group mb-4">
                                                <span class="input-group-text" id="addon-wrapping"><i
                                                        class="fa fa-calendar"></i></span>
                                                <input type="text" class="form-control"
                                                    aria-describedby="addon-wrapping" id="daterange-btn"
                                                    value="">
                                                <input type="hidden" name="start_date" id="start_date"
                                                    value="{{ $microFrom ?? '' }}">
                                                <input type="hidden" name="end_date" id="end_date"
                                                    value="{{ $microTo ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="input-group mb-4">
                                                <select name="equipment_id" id="equipment_id"
                                                    class="form-control select2-form">
                                                    <option value="All">--
                                                        {{ trans('work-order/submission/index.filter_equipment') }}
                                                        --</option>
                                                    @foreach ($equipment as $row)
                                                        <option value="{{ $row->id }}"
                                                            {{ $equipment_id == $row->id ? 'selected' : '' }}>
                                                            {{ $row->serial_number }} |
                                                            {{ $row->barcode }} |
                                                            {{ $row->manufacturer }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="input-group mb-4">
                                                <select name="type_wo" id="type_wo"
                                                    class="form-control select2-form">
                                                    <option value="All">--
                                                        {{ trans('work-order/submission/index.filter_type') }}
                                                        --</option>
                                                    <option value="Calibration"
                                                        {{ $type_wo == 'Calibration' ? 'selected' : '' }}>
                                                        Calibration</option>
                                                    <option value="Service"
                                                        {{ $type_wo == 'Service' ? 'selected' : '' }}>
                                                        Service
                                                    </option>
                                                    <option value="Training"
                                                        {{ $type_wo == 'Training' ? 'selected' : '' }}>
                                                        Training</option>
                                                    <option value="Inspection and Preventive Maintenance"
                                                        {{ $type_wo == 'Inspection and Preventive Maintenance' ? 'selected' : '' }}>
                                                        Inspection and Preventive Maintenance
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="input-group mb-4">
                                                <select name="category_wo" id="category_wo"
                                                    class="form-control select2-form">
                                                    <option value="All">--
                                                        {{ trans('work-order/submission/index.filter_category') }}
                                                        --</option>
                                                    <option value="Rutin"
                                                        {{ $category_wo == 'Rutin' ? 'selected' : '' }}>
                                                        Rutin
                                                    </option>
                                                    <option value="Non Rutin"
                                                        {{ $category_wo == 'Non Rutin' ? 'selected' : '' }}>
                                                        Non Rutin</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="input-group mb-4">
                                                <select name="created_by" id="created_by"
                                                    class="form-control select2-form">
                                                    <option value="All">-- Semua Status --</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <table class="table table-bordered table-sm" id="data-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                @if (!Auth::user()->roles->first()->hospital_id)
                                                    <th>{{ __('Hospital') }}</th>
                                                @endif
                                                <th>No WO</th>
                                                <th>Jadwal</th>
                                                <th>Peralatan</th>
                                                <th>Jenis</th>
                                                <th>Kategori</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>

                                    </table>
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
    <script type="text/javascript" src="//code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('material/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('material/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('material/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('material/assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('material/assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('material/assets/js/app.js') }}"></script>
    <script src=https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js></script>
    <script src=https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('material') }}/assets/js/plugins-monitoring.js"></script>
    <script type="text/javascript" src="{{ asset('material/assets/js/moment.js') }}"></script>
    <script type="text/javascript" src="{{ asset('material/assets/js/daterangepicker.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2-form').select2();
        });
    </script>

    <script>
        let columns = [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            @if (!Auth::user()->roles->first()->hospital_id)
                {
                    data: 'hospital_name',
                    name: 'hospital_name',
                },
            @endif {
                data: 'wo_number',
                name: 'wo_number'
            },
            {
                data: 'schedule_date',
                name: 'schedule_date'
            },
            {
                data: 'barcode',
                name: 'barcode'
            },
            {
                data: 'type_wo',
                name: 'type_wo'
            },
            {
                data: 'category_wo',
                name: 'category_wo'
            },
            {
                data: 'status',
                render: function(datum, type, row) {
                    switch (row.status) {
                        case 'finished':
                            rowStatus = 'success';
                            break;
                        case 'on-progress':
                            rowStatus = 'secondary';
                            break;
                        case 'ready-to-start':
                            rowStatus = 'danger';
                            break;
                        default:
                            rowStatus = 'danger';
                            break;
                    }
                    return `<button class="btn btn-${rowStatus} btn-block">${row.status}</button>`;

                }
            }
        ];

        var table = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('monitoring') }}",
                data: function(s) {
                    s.start_date = $("#start_date").val();
                    s.end_date = $("#end_date").val();
                    s.equipment_id = $('select[name=equipment_id] option').filter(':selected').val()
                    s.type_wo = $('select[name=type_wo] option').filter(':selected').val()
                    s.category_wo = $('select[name=category_wo] option').filter(':selected').val()
                    s.created_by = $('select[name=created_by] option').filter(':selected').val()
                    s.hospital_id = $('select[name=hospital_id] option').filter(':selected').val()
                }
            },
            columns: columns
        });

        function replaceURLParams() {
            var params = new URLSearchParams();
            var startDate = $("#start_date").val();
            var endDate = $("#end_date").val();
            var equipmentId = $('select[name=equipment_id]').val();
            var typeWo = $('select[name=type_wo]').val();
            var categoryWo = $('select[name=category_wo]').val();
            var createdBy = $('select[name=created_by]').val();
            var hospitalId = $('select[name=hospital_id]').val();

            if (startDate) params.set('start_date', startDate);
            if (endDate) params.set('end_date', endDate);
            if (equipmentId) params.set('equipment_id', equipmentId);
            if (typeWo) params.set('type_wo', typeWo);
            if (categoryWo) params.set('category_wo', categoryWo);
            if (createdBy) params.set('created_by', createdBy);
            if (hospitalId) params.set('hospital_id', hospitalId);
            var newURL = "{{ route('monitoring') }}" + '?' + params.toString();
            history.replaceState(null, null, newURL);
        }


        $('#hospital_id').change(function() {
            table.draw();
            replaceURLParams()
        })
        $('#equipment_id').change(function() {
            table.draw();
            replaceURLParams()
        })
        $('#type_wo').change(function() {
            table.draw();
            replaceURLParams()
        })
        $('#category_wo').change(function() {
            table.draw();
            replaceURLParams()
        })
        $('#created_by').change(function() {
            table.draw();
            replaceURLParams()
        })

        $('#daterange-btn').change(function() {
            table.draw();
            replaceURLParams()
        })
    </script>


    <script>
        var start = {{ $microFrom }}
        var end = {{ $microTo }}
        var label = '';
        $('#daterange-btn').daterangepicker({
                locale: {
                    format: 'DD MMM YYYY'
                },
                startDate: moment(start),
                endDate: moment(end),
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf(
                        'month')],
                }
            },
            function(start, end, label) {
                $('#start_date').val(Date.parse(start));
                $('#end_date').val(Date.parse(end));
                if (isDate(start)) {
                    $('#daterange-btn span').html(start.format('DD MMM YYYY') + ' - ' + end.format('DD MMM YYYY'));
                }
            });

        function isDate(val) {
            var d = Date.parse(val);
            return Date.parse(val);
        }
    </script>

</html>
