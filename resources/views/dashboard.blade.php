@extends('layouts.app')

@section('title', __('Dashboard'))
@push('css')
    <link href="{{ asset('material/assets/css/daterangepicker.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
        integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
        crossorigin="" />
    <link href="{{ asset('material/assets/jqvmap/dist/jqvmap.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="../dist/leaflet.awesome-markers.css">
    <style>
        .map-embed {
            width: 100%;
            height: 400px;
        }

        a.resultnya {
            color: #1e7ad3;
            text-decoration: none;
        }

        a.resultnya:hover {
            text-decoration: underline
        }

        .search-box {
            position: relative;
            margin: 0 auto;
            width: 300px;
        }

        .search-box input#search-loc {
            height: 26px;
            width: 100%;
            padding: 0 12px 0 25px;
            background: white url("https://cssdeck.com/uploads/media/items/5/5JuDgOa.png") 8px 6px no-repeat;
            border-width: 1px;
            border-style: solid;
            border-color: #a8acbc #babdcc #c0c3d2;
            border-radius: 13px;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            -ms-box-sizing: border-box;
            -o-box-sizing: border-box;
            box-sizing: border-box;
            -webkit-box-shadow: inset 0 1px #e5e7ed, 0 1px 0 #fcfcfc;
            -moz-box-shadow: inset 0 1px #e5e7ed, 0 1px 0 #fcfcfc;
            -ms-box-shadow: inset 0 1px #e5e7ed, 0 1px 0 #fcfcfc;
            -o-box-shadow: inset 0 1px #e5e7ed, 0 1px 0 #fcfcfc;
            box-shadow: inset 0 1px #e5e7ed, 0 1px 0 #fcfcfc;
        }

        .search-box input#search-loc:focus {
            outline: none;
            border-color: #66b1ee;
            -webkit-box-shadow: 0 0 2px rgba(85, 168, 236, 0.9);
            -moz-box-shadow: 0 0 2px rgba(85, 168, 236, 0.9);
            -ms-box-shadow: 0 0 2px rgba(85, 168, 236, 0.9);
            -o-box-shadow: 0 0 2px rgba(85, 168, 236, 0.9);
            box-shadow: 0 0 2px rgba(85, 168, 236, 0.9);
        }

        .search-box .results {
            display: none;
            position: absolute;
            top: 35px;
            left: 0;
            right: 0;
            z-index: 9999;
            padding: 0;
            margin: 0;
            border-width: 1px;
            border-style: solid;
            border-color: #cbcfe2 #c8cee7 #c4c7d7;
            border-radius: 3px;
            background-color: #fdfdfd;
            background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #fdfdfd), color-stop(100%, #eceef4));
            background-image: -webkit-linear-gradient(top, #fdfdfd, #eceef4);
            background-image: -moz-linear-gradient(top, #fdfdfd, #eceef4);
            background-image: -ms-linear-gradient(top, #fdfdfd, #eceef4);
            background-image: -o-linear-gradient(top, #fdfdfd, #eceef4);
            background-image: linear-gradient(top, #fdfdfd, #eceef4);
            -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            -moz-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            -ms-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            -o-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            overflow: hidden auto;
            max-height: 34vh;
        }

        .search-box .results li {
            display: block
        }

        .search-box .results li:first-child {
            margin-top: -1px
        }

        .search-box .results li:first-child:before,
        .search-box .results li:first-child:after {
            display: block;
            content: '';
            width: 0;
            height: 0;
            position: absolute;
            left: 50%;
            margin-left: -5px;
            border: 5px outset transparent;
        }

        .search-box .results li:first-child:before {
            border-bottom: 5px solid #c4c7d7;
            top: -11px;
        }

        .search-box .results li:first-child:after {
            border-bottom: 5px solid #fdfdfd;
            top: -10px;
        }

        .search-box .results li:first-child:hover:before,
        .search-box .results li:first-child:hover:after {
            display: none
        }

        .search-box .results li:last-child {
            margin-bottom: -1px
        }

        .search-box .results a {
            display: block;
            position: relative;
            margin: 0 -1px;
            padding: 6px 40px 6px 10px;
            color: #808394;
            font-weight: 500;
            text-shadow: 0 1px #fff;
            border: 1px solid transparent;
            border-radius: 3px;
        }

        .search-box .results a span {
            font-weight: 200
        }

        .search-box .results a:before {
            content: '';
            width: 18px;
            height: 18px;
            position: absolute;
            top: 50%;
            right: 10px;
            margin-top: -9px;
            background: url("https://cssdeck.com/uploads/media/items/7/7BNkBjd.png") 0 0 no-repeat;
        }

        .search-box .results a:hover {
            text-decoration: none;
            color: #fff;
            text-shadow: 0 -1px rgba(0, 0, 0, 0.3);
            border-color: #2380dd #2179d5 #1a60aa;
            background-color: #338cdf;
            background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #59aaf4), color-stop(100%, #338cdf));
            background-image: -webkit-linear-gradient(top, #59aaf4, #338cdf);
            background-image: -moz-linear-gradient(top, #59aaf4, #338cdf);
            background-image: -ms-linear-gradient(top, #59aaf4, #338cdf);
            background-image: -o-linear-gradient(top, #59aaf4, #338cdf);
            background-image: linear-gradient(top, #59aaf4, #338cdf);
            -webkit-box-shadow: inset 0 1px rgba(255, 255, 255, 0.2), 0 1px rgba(0, 0, 0, 0.08);
            -moz-box-shadow: inset 0 1px rgba(255, 255, 255, 0.2), 0 1px rgba(0, 0, 0, 0.08);
            -ms-box-shadow: inset 0 1px rgba(255, 255, 255, 0.2), 0 1px rgba(0, 0, 0, 0.08);
            -o-box-shadow: inset 0 1px rgba(255, 255, 255, 0.2), 0 1px rgba(0, 0, 0, 0.08);
            box-shadow: inset 0 1px rgba(255, 255, 255, 0.2), 0 1px rgba(0, 0, 0, 0.08);
        }

        .lt-ie9 .search input#search-loc {
            line-height: 26px
        }
    </style>
@endpush

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">

                    <div class="h-100">
                        <div class="row mb-3 pb-1">
                            <div class="col-12">
                                <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                    <div class="flex-grow-1">
                                        <h4 class="fs-16 mb-1">Welcome, {{ Auth::user()->name }}</h4>
                                    </div>
                                    <div class="mt-3 mt-lg-0">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form method="get" action="/panel" id="form-date" class="row">
                            @if (!Auth::user()->roles->first()->hospital_id)
                                <div class="col-md-3 mb-2">
                                    <div class="input-group mb-2 mr-sm-2">
                                        <select name="hospital_id" id="hospital_id"
                                            class="form-control js-example-basic-multiple">
                                            @foreach ($hispotals as $hispotal)
                                                <option value="{{ $hispotal->id }}"
                                                    {{ $ids == $hispotal->id ? 'selected' : '' }}>
                                                    {{ $hispotal->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-3">
                                <div class="input-group mb-4">
                                    <span class="input-group-text" id="addon-wrapping"><i class="fa fa-calendar"></i></span>
                                    <input type="text" class="form-control" aria-describedby="addon-wrapping"
                                        id="daterange-btn" value="">
                                    <input type="hidden" name="start_date" id="start_date" value="{{ $microFrom }}">
                                    <input type="hidden" name="end_date" id="end_date" value="{{ $microTo }}">
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <!-- card -->
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total
                                                    Work Order</p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value"
                                                        data-target="{{ $countWorkOrder }}"></span></h4>
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-warning rounded fs-3">
                                                    <i class="mdi mdi-book-multiple"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end col -->
                            <div class="col-xl-3 col-md-6">
                                <!-- card -->
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total
                                                    Equiment</p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value"
                                                        data-target="{{ $countEquipment }}"></span></h4>
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-success rounded fs-3">
                                                    <i class="mdi mdi-cube"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end col -->

                            <div class="col-xl-3 col-md-6">
                                <!-- card -->
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total
                                                    Employee</p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value"
                                                        data-target="{{ $countEmployee }}"></span></h4>
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-info rounded fs-3">
                                                    <i class="fa fa-users" aria-hidden="true"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end col -->

                            <div class="col-xl-3 col-md-6">
                                <!-- card -->
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total
                                                    Vendor</p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value"
                                                        data-target="{{ $countVendor }}"></span></h4>
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-danger rounded fs-3">
                                                    <i class="fa fa-address-book" aria-hidden="true"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end col -->


                        </div>



                        {{-- grafik Total --}}
                        <div class="row">
                            <div class="col-xl-4 col-md-4">
                                <div class="card" style="height: 500px">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">
                                            Total Wo By Status
                                        </h4>
                                    </div>

                                    <div class="card-body">
                                        <canvas id="myChart1"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4">
                                <div class="card" style="height: 500px">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">
                                            Total Wo By Category
                                        </h4>
                                    </div>

                                    <div class="card-body">
                                        <canvas id="myChart2"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4">
                                <div class="card" style="height: 500px">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">
                                            Total WO By Type</h4>
                                    </div>

                                    <div class="card-body">
                                        <canvas id="myChart3"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- grafik Expense Cost --}}
                        <div class="row">
                            <div class="col-xl-6 col-md-6">
                                <div class="card" style="height: 450px">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">
                                            Proccess WO ( Finish Vs On Progress Vs Ready to Start )
                                        </h4>
                                    </div>

                                    <div class="card-body">
                                        <canvas id="myChart4"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6">
                                <div class="card" style="height: 450px">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">
                                            Expense Cost Wo
                                        </h4>
                                    </div>

                                    <div class="card-body">
                                        <canvas id="myChart5"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-4 col-md-4">
                                <div class="card" style="height: 400px">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">
                                            <i class="fa fa-exclamation-triangle text-danger fs-3" aria-hidden="true"></i>
                                            Opname Sparepart
                                        </h4>
                                    </div>

                                    <div class="card-body">
                                        <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                            <div class="table-responsive table-card">
                                                <table
                                                    class="table table-borderless table-hover table-nowrap align-middle table-sm">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Sparepart Name</th>
                                                            <th>Opname</th>
                                                            <th>Stock</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @foreach ($dataOpname as $row)
                                                            <tr>
                                                                <td>{{ $row->sparepart_name }}</td>
                                                                <td>{{ $row->opname }}</td>
                                                                <td style="color: red">{{ $row->stock }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4">
                                <div class="card" style="height: 400px">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1"><i class="fa fa-sign-in text-success fs-3"
                                                aria-hidden="true"></i> Stock
                                            In
                                            Sparepart</h4>
                                    </div>

                                    <div class="card-body">
                                        <div class="table-responsive table-card">
                                            <table
                                                class="table table-borderless table-hover table-nowrap align-middle mb-0 table-sm">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>No Referensi</th>
                                                        <th>Qty In</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @foreach ($in as $in)
                                                        <tr>
                                                            <td>{{ $in->no_referensi }}</td>
                                                            <td class="text-success">{{ $in->qty }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4">
                                <div class="card" style="height: 400px">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1"><i
                                                class="fa fa-sign-out text-warning fs-3" aria-hidden="true"></i> Stock
                                            Out
                                            Sparepart</h4>
                                    </div>

                                    <div class="card-body">
                                        <div class="table-responsive table-card">
                                            <table
                                                class="table table-borderless table-hover table-nowrap align-middle mb-0 table-sm">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>No Referensi</th>
                                                        <th>Qty Out</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($out as $out)
                                                        <tr>
                                                            <td>{{ $out->no_referensi }}</td>
                                                            <td class="text-warning">{{ $out->qty }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- map --}}
                        <div class="row">
                            <div class="col-xl-12 col-md-12">
                                <div class="card" style="height: 550px">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">Location Employee & Vendor</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="map-embed" id="map" style="height: 100%; z-index: 0;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('material/assets/jqvmap/dist/jquery.vmap.js') }}"></script>
    <script src="{{ asset('material/assets/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('material/assets/jqvmap/examples/js/jquery.vmap.sampledata.js') }}"></script>
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
        integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
        crossorigin=""></script>
    <script type="text/javascript" src="{{ asset('material/assets/js/moment.js') }}"></script>
    <script type="text/javascript" src="{{ asset('material/assets/js/daterangepicker.min.js') }}"></script>
    <script src="../dist/leaflet.awesome-markers.js"></script>
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
    <script>
        $(document).ready(function() {
            $('#daterange-btn').change(function() {
                $('#form-date').submit();
            });

            $('#hospital_id').change(function() {
                $('#form-date').submit();
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            const ctx = document.getElementById('myChart1');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['pending', 'rejected', 'accepted', 'on-going', 'finished', ],
                    datasets: [{
                        label: '# Total',
                        data: [
                            {{ totalWoByStatus('pending', $microFrom, $microTo, $ids) }},
                            {{ totalWoByStatus('rejected', $microFrom, $microTo, $ids) }},
                            {{ totalWoByStatus('accepted', $microFrom, $microTo, $ids) }},
                            {{ totalWoByStatus('on-going', $microFrom, $microTo, $ids) }},
                            {{ totalWoByStatus('finished', $microFrom, $microTo, $ids) }}
                        ],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255,99,132,1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });


        })
    </script>

    <script>
        const ctx2 = document.getElementById('myChart2');
        new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: ['Rutin', 'Non Rutin'],
                datasets: [{
                    label: '# Total',
                    data: [{{ totalWoByCategory('Rutin', $microFrom, $microTo, $ids) }},
                        {{ totalWoByCategory('Non Rutin', $microFrom, $microTo, $ids) }}
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <script>
        const ctx3 = document.getElementById('myChart3');
        new Chart(ctx3, {
            type: 'pie',
            data: {
                labels: ['Calibration', 'Service', 'Training', 'Inspection and Preventive Maintenance'],
                datasets: [{
                    label: '# Total',
                    data: [{{ totalWoByType('Calibration', $microFrom, $microTo, $ids) }},
                        {{ totalWoByType('Service', $microFrom, $microTo, $ids) }},
                        {{ totalWoByType('Training', $microFrom, $microTo, $ids) }},
                        {{ totalWoByType('Inspection and Preventive Maintenance', $microFrom, $microTo, $ids) }}
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <script>
        const ctx4 = document.getElementById('myChart4');
        new Chart(ctx4, {
            type: 'bar',
            data: {
                labels: ['Finish', 'Progress', 'Ready to Start'],
                datasets: [{
                    label: '# Proccess WO ( Finish Vs On Progress Vs Ready to Start )',
                    data: [300, 59, 80],

                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <script>
        const ctx5 = document.getElementById('myChart5');
        new Chart(ctx5, {
            type: 'bar',
            data: {
                labels: ['Calibration', 'Service', 'Replacement'],
                datasets: [{
                    label: '# Expense Cost Wo',
                    data: [{{ Expense('Calibration', $microFrom, $microTo, $ids) }},
                        {{ Expense('Service', $microFrom, $microTo, $ids) }},
                        {{ Expense('Replacement', $microFrom, $microTo, $ids) }},
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            var i = 1;

            function checkKosongLatLong() {
                if ($('#latitude').val() == '' || $('#longitude').val() == '') {
                    $('.alert-choose-loc').show();
                } else {
                    $('.alert-choose-loc').hide();
                }
            }
            var delay = (function() {
                var timer = 0;
                return function(callback, ms) {
                    clearTimeout(timer);
                    timer = setTimeout(callback, ms);
                };
            })()
            // initialize map
            const getLocationMap = L.map('map');
            // initialize OSM
            const osmUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
            const osmAttrib = 'Leaflet © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors';
            const osm = new L.TileLayer(osmUrl, {
                // minZoom: 0,
                // maxZoom: 3,
                attribution: osmAttrib
            });
            // render map
            getLocationMap.scrollWheelZoom.disable()
            @foreach ($vendor as $ins)
                getLocationMap.setView(new L.LatLng("{{ $ins->latitude }}", "{{ $ins->longitude }}"), 7);
            @endforeach
            @foreach ($employees as $ins)
                getLocationMap.setView(new L.LatLng("{{ $ins->latitude }}", "{{ $ins->longitude }}"), 7);
            @endforeach
            getLocationMap.addLayer(osm)
            // initial hidden marker, and update on click
            let location = '';

            @foreach ($vendor as $instance)
                getToLoc("{{ $instance->latitude }}", "{{ $instance->longitude }}", getLocationMap,
                    "{{ $instance->id }}", "{{ $instance->name_vendor }}", "vendor");
            @endforeach

            @foreach ($employees as $instance)
                getToLoc("{{ $instance->latitude }}", "{{ $instance->longitude }}", getLocationMap,
                    "{{ $instance->id }}", "{{ $instance->name }}", "employees");
            @endforeach

            function getToLoc(lat, lng, getLocationMap, id, name, type) {
                const zoom = 1;
                var url_edit = "";
                $.ajax({
                    url: `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`,
                    dataType: 'json',
                    success: function(result) {
                        if (type == "vendor") {
                            var marker = L.marker([lat, lng], {
                                icon: L.AwesomeMarkers.icon({
                                    icon: 'fa-address-book',
                                    prefix: 'fa',
                                    markerColor: 'red',
                                })
                            }).addTo(getLocationMap);
                        } else {
                            var marker = L.marker([lat, lng], {
                                icon: L.AwesomeMarkers.icon({
                                    icon: 'users',
                                    prefix: 'fa',
                                    markerColor: 'darkblue',
                                })
                            }).addTo(getLocationMap);
                        }
                        let list_of_location_html = '';
                        list_of_location_html += '<div>';
                        if (type == "vendor") {
                            list_of_location_html += `<b>Vendor : ${name}</b><br>`;
                            list_of_location_html += `<b>${result.display_name}</b><br>`;
                            list_of_location_html += `<span>latitude : ${result.lat}</span><br>`;
                            list_of_location_html += `<span>longitude: ${result.lon}</span><br>`;
                            // list_of_location_html +=
                            //     `<a href="${url_edit}" target="_blank" class="btn btn-primary" style="color: white; margin-top: 1rem;">Edit</a>`;
                            list_of_location_html += '</div>';
                            marker.bindPopup(list_of_location_html);
                        } else {
                            list_of_location_html += `<b>Employees : ${name}</b><br>`;
                            list_of_location_html += `<b>${result.display_name}</b><br>`;
                            list_of_location_html += `<span>latitude : ${result.lat}</span><br>`;
                            list_of_location_html += `<span>longitude: ${result.lon}</span><br>`;
                            list_of_location_html += '</div>';
                            marker.bindPopup(list_of_location_html);
                        }

                    }
                });
            }
        });
    </script>
@endpush
