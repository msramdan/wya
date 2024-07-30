@extends('layouts.app')

@section('title', __('kalender-pembelajaran/index.Kalender Pembelajaran'))
@push('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.8.0/main.css' rel='stylesheet' />
    <style>
        #calendar {
            width: 100%;
            margin: 0 auto;
        }

        #loading-indicator {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
    </style>
@endpush
@section('content')
    <div id="loading-indicator" style="display:none;">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Kalender Work Order</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                                <li class="breadcrumb-item active">
                                    Kalender Work Order</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="input-group mb-4">
                                        <select name="tahun" id="tahun" class="form-control select2-form">
                                            @php
                                                $startYear = 2023;
                                                $currentYear = date('Y');
                                                $endYear = $currentYear + 2;
                                            @endphp
                                            @foreach (range($startYear, $endYear) as $yearOption)
                                                <option value="{{ $yearOption }}"
                                                    {{ $yearOption == $year ? 'selected' : '' }}>
                                                    {{ $yearOption }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="input-group mb-4">
                                        <select name="jenis" id="jenis" class="form-control select2-form">
                                            <option value="All">--
                                                {{ trans('work-order/submission/index.filter_type') }} --</option>
                                            <option value="Calibration"
                                                {{ $selectedJenis == 'Calibration' ? 'selected' : '' }}>
                                                Calibration</option>
                                            <option value="Service" {{ $selectedJenis == 'Service' ? 'selected' : '' }}>
                                                Service
                                            </option>
                                            <option value="Training" {{ $selectedJenis == 'Training' ? 'selected' : '' }}>
                                                Training</option>
                                            <option value="Inspection and Preventive Maintenance"
                                                {{ $selectedJenis == 'Inspection and Preventive Maintenance' ? 'selected' : '' }}>
                                                Inspection and Preventive Maintenance
                                            </option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div id='calendar'></div>
                                </div>
                                <div class="col-sm-6" style="max-height: 400px; overflow-y: auto;">
                                    <table class="table table-striped" id="data-table" style="line-height: 5px">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>{{ trans('work-order/submission/index.wo_number') }}</th>
                                                <th>{{ __('Schedule Date') }}</th>
                                                <th>{{ __('Status') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
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

    <!-- Modal Bootstrap -->
    <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">Detail Work Order
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th scope="row">Nomor Work Order</th>
                                <td id="event_wo_number"></td>
                            </tr>
                            <tr>
                                <th scope="row">Type Work Order</th>
                                <td id="event_type_wo"></td>
                            </tr>
                            <tr>
                                <th scope="row">Barcode Equipment</th>
                                <td id="event_barcode"></td>
                            </tr>
                            <tr>
                                <th scope="row">Manufacturer Equipment</th>
                                <td id="event_manufacturer"></td>
                            </tr>
                            <tr>
                                <th scope="row">SN Equipment</th>
                                <td id="event_serial_number"></td>
                            </tr>
                            <tr>
                                <th scope="row">Status</th>
                                <td id="event_status"></td>
                            </tr>
                            <tr>
                                <th scope="row">Schedule Date</th>
                                <td id="event_pelaksanaan"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.8.0/main.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"
        integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function() {
            $('.select2-form').select2();

            var calendarEl = document.getElementById('calendar');
            var calendar;

            function showLoading() {
                $('#loading-indicator').show();
            }

            function hideLoading() {
                $('#loading-indicator').hide();
            }

            function fetchEvents(year, jenis) {
                showLoading();
                $.ajax({
                    url: '{{ route('getEvents') }}',
                    type: 'GET',
                    data: {
                        year: year,
                        jenis: jenis,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        calendar.removeAllEvents();
                        calendar.addEventSource(data);
                        var tableBody = $('#data-table tbody');
                        tableBody.empty();
                        $.each(data, function(index, event) {
                            tableBody.append('<tr><td>' + (index + 1) + '</td><td>' + event
                                .wo_number + '</td><td>' + event.pelaksanaan + '</td><td>' +
                                event.status + '</td></tr>');
                        });
                        hideLoading();
                    },
                    error: function(xhr, status, error) {
                        console.error('Failed to fetch events:', error);
                        hideLoading();
                    }
                });
            }

            function initializeCalendar(year, jenis) {
                var startOfYear = moment(year + '-01-01').format('YYYY-MM-DD');
                var endOfYear = moment(year + '-12-31').format('YYYY-MM-DD');

                calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    editable: true,
                    validRange: {
                        start: startOfYear,
                        end: endOfYear
                    },
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    eventClick: function(info) {
                        $('#event_wo_number').text(info.event.extendedProps.wo_number);
                        $('#event_type_wo').text(info.event.extendedProps.type_wo);
                        $('#event_barcode').text(info.event.extendedProps.barcode);
                        $('#event_manufacturer').text(info.event.extendedProps.manufacturer);
                        $('#event_serial_number').text(info.event.extendedProps.serial_number);
                        $('#event_status').text(info.event.extendedProps.status);
                        $('#event_pelaksanaan').text(info.event.extendedProps.pelaksanaan);
                        var modal = new bootstrap.Modal(document.getElementById('eventModal'));
                        modal.show();
                    },
                    dayMaxEventRows: true,
                });

                fetchEvents(year, jenis);
                calendar.render();
            }

            function updateURL(year, jenis) {
                var newUrl = '{{ url('/panel/kalender-wo') }}/' + year + '/' + jenis;
                window.history.replaceState({
                    path: newUrl
                }, '', newUrl);
            }

            $('#tahun, #jenis').on('change', function() {
                var selectedYear = $('#tahun').val();
                var selectedJenis = $('#jenis').val();
                fetchEvents(selectedYear, selectedJenis);
                updateURL(selectedYear, selectedJenis);
            });
            var initialYear = $('#tahun').val();
            var initialJenis = $('#jenis').val();
            initializeCalendar(initialYear, initialJenis);
        });
    </script>
@endpush
