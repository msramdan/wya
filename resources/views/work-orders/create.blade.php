@extends('layouts.app')

@section('title', __('Create Work Orders'))

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ trans('work-order/submission/index.head') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="/panel">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a
                                        href="{{ route('work-orders.index') }}">{{ trans('work-order/submission/index.head') }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ __('Create') }}
                                </li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('work-orders.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('POST')

                                @include('work-orders.include.form')

                                <div class="d-flex justify-content-end">
                                    <a href="{{ url()->previous() }}" class="btn btn-secondary me-2"><i
                                            class="mdi mdi-arrow-left-thin"></i> {{ __('Kembali') }}</a>
                                    <button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save"></i>
                                        {{ __('Simpan') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalScanner" tabindex="-1" aria-labelledby="modalScannerLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalScannerLabel">Modal Scanner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="camera-scanner"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css-libs')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/frappe-gantt/0.6.1/frappe-gantt.min.css"
        integrity="sha512-b6CPl1eORfMoZgwWGEYWNxYv79KG0dALXfVu4uReZJOXAfkINSK4UhA0ELwGcBBY7VJN7sykwrCGQnbS8qTKhQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@push('js-libs')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"
        integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/frappe-gantt/0.6.1/frappe-gantt.min.js"
        integrity="sha512-HyGTvFEibBWxuZkDsE2wmy0VQ0JRirYgGieHp0pUmmwyrcFkAbn55kZrSXzCgKga04SIti5jZQVjbTSzFpzMlg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"
        integrity="sha512-r6rDA7W6ZeQhvl8S7yRVQUKVHdexq+GAlNkNNqVC7YyIV+NwqCTJe2hDWCiffTyRNOeGEzRRJ9ifvRm/HCzGYg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endpush

@push('js-scripts')
    <script>
        $(document).ready(function() {
            var cek = {{ session('sessionHospital') }}
            console.log(cek)
            if (cek != '' || cek != null) {
                getEquipmentLocation(cek);
            }
        });

        const _temp = '<option value="" selected disabled>-- Select location --</option>';
        $('#hospital_id').change(function() {
            $('#vendor-id, #equipment-category-id, #location_id').html(_temp);
            if ($(this).val() != "") {
                getEquipmentLocation($(this).val());
            }
        })

        function getEquipmentLocation(hospitalId) {
            let url = '{{ route('api.getEquipmentLocation', ':id') }}';
            url = url.replace(':id', hospitalId)
            $.ajax({
                url,
                method: 'GET',
                beforeSend: function() {
                    $('#location_id').prop('disabled', true);
                },
                success: function(res) {
                    const options = res.data.map(value => {
                        return `<option value="${value.id}">${value.location_name}</option>`
                    });
                    $('#location_id').html(_temp + options)
                    $('#location_id').prop('disabled', false);
                },
                error: function(err) {
                    $('#location_id').prop('disabled', false);
                    alert(JSON.stringify(err))
                }

            })
        }
    </script>

    <script>
        /**
         * Event When Equipment Location is changed
         *
         */
        $('#location_id').on("select2:select", function(e) {
            eventChangeLocationId();
        });

        /**
         * Event When Equipment is changed
         *
         */
        $('#equipment-id').on('select2:select', function(e) {
            eventChangeEquipmentId();
        });

        /**
         * Event When Category WO Changed
         *
         */
        $('#category-wo').on('change', function() {
            const value = $('#category-wo').val();

            if (value != '') {
                $('#schedule-information-container').hasClass('d-none') ? $('#schedule-information-container')
                    .removeClass('d-none') : '';
            }

            if (value == 'Non Rutin') {
                !$('#end-date').parent().hasClass('d-none') ? $('#end-date').parent().addClass('d-none') : '';
                !$('#start-date').parent().hasClass('d-none') ? $('#start-date').parent().addClass('d-none') : '';
                !$('#schedule-wo').parent().hasClass('d-none') ? $('#schedule-wo').parent().addClass('d-none') : '';
                $('#schedule-date').parent().hasClass('d-none') ? $('#schedule-date').parent().removeClass(
                    'd-none') : '';
            } else if (value == 'Rutin') {
                !$('#schedule-date').parent().hasClass('d-none') ? $('#schedule-date').parent().addClass('d-none') :
                    '';
                $('#end-date').parent().hasClass('d-none') ? $('#end-date').parent().removeClass('d-none') : '';
                $('#start-date').parent().hasClass('d-none') ? $('#start-date').parent().removeClass('d-none') : '';
                $('#schedule-wo').parent().hasClass('d-none') ? $('#schedule-wo').parent().removeClass('d-none') :
                    '';
            }
        })

        /**
         * Checking if location id value is not empty
         *
         */
        if ($('#location_id').val() != null) {
            eventChangeLocationId(() => {
                eventChangeEquipmentId();
            });
        }

        /**
         * Function event on change location id
         *
         */
        function eventChangeLocationId(cb = null) {
            const equipmentLocationId = $('#location_id').val();
            const valueEquipmentId = '{{ old('equipment_id') }}';
            const sessionHospital = '{{ session('sessionHospital') }}';

            fetch(
                    `{{ route('api.equipment.index') }}?equipment_location_id=${equipmentLocationId}&session_hospital=${sessionHospital}`)
                .then((res) => res.json())
                .then((response) => {
                    $('#equipment-id').select2('destroy');
                    $("#equipment-id").html('<option value="" selected disabled>-- Select equipment --</option>');

                    response.data.forEach((equipment) => {
                        $("#equipment-id").append(
                            `<option value="${equipment.id}" ${valueEquipmentId == equipment.id ? 'selected' : ''}>${equipment.serial_number} | ${equipment.type} | ${equipment.manufacturer}</option>`
                        );
                    });
                    $('#equipment-id').select2();
                    !$('#container-equipment-detail').hasClass('d-none') ? $('#container-equipment-detail').addClass(
                        'd-none') : '';

                    if (cb != null) {
                        cb();
                    }
                });
        }

        /**
         * Function event on change equipment id
         *
         */
        function eventChangeEquipmentId() {
            const value = $('#equipment-id').val();

            fetch(`{{ route('api.equipment.index') }}/${value}`)
                .then((res) => res.json())
                .then((response) => {
                    let data = response.data;
                    $('#container-equipment-detail').hasClass('d-none') ? $('#container-equipment-detail').removeClass(
                        'd-none') : '';

                    $('#container-equipment-detail #equipment-detail-content').html(
                        `<div class="row">
                            <div class="col-lg-4">
                                <img src="/storage/img/equipment/${data.photo}" class="img-thumbnail" alt="">
                            </div>
                            <div class="col-lg-8">
                                <table class="table">
                                    <tr>
                                        <th>Barcode</th>
                                        <th>:</th>
                                        <td>${data.barcode}</td>
                                    </tr>
                                    <tr>
                                        <th>Equipment Category</th>
                                        <th>:</th>
                                        <td>${data.equipment_category.category_name}</td>
                                    </tr>
                                    <tr>
                                        <th>Type</th>
                                        <th>:</th>
                                        <td>${data.type}</td>
                                    </tr>
                                    <tr>
                                        <th>Vendor</th>
                                        <th>:</th>
                                        <td>${data.vendor.name_vendor}</td>
                                    </tr>
                                    <tr>
                                        <th>Risk Level</th>
                                        <th>:</th>
                                        <td>${data.risk_level}</td>
                                    </tr>
                                    <tr>
                                        <th>Financing Code</th>
                                        <th>:</th>
                                        <td>${data.financing_code}</td>
                                    </tr>
                                    <tr>
                                        <th>Nomenklatur</th>
                                        <th>:</th>
                                        <td>${data.nomenklatur.name_nomenklatur}</td>
                                    </tr>
                                    <tr>
                                        <th>Manufacturer</th>
                                        <th>:</th>
                                        <td>${data.manufacturer}</td>
                                    </tr>
                                    <tr>
                                        <th>Serial Number</th>
                                        <th>:</th>
                                        <td>${data.serial_number}</td>
                                    </tr>
                                    <tr>
                                        <th>Condition</th>
                                        <th>:</th>
                                        <td>${data.condition}</td>
                                    </tr>
                                    <tr>
                                        <th>Equipment Location</th>
                                        <th>:</th>
                                        <td>${data.equipment_location.location_name}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>`
                    );
                });
        }

        /**
         * Event on change schedule wo
         *
         */
        $('#schedule-wo').on('select2:select', function(e) {
            refreshGanttChart();
        });

        /**
         * Event on change view mode
         *
         */
        $('#view_mode').on('select2:select', function(e) {
            refreshGanttChart($('#view_mode').val());
        });

        /**
         * Event on change schedule wo
         *
         */
        $('#start-date').on('change', function(e) {
            refreshGanttChart();
        });

        /**
         * Event on change schedule wo
         *
         */
        $('#end-date').on('change', function(e) {
            refreshGanttChart();
        });

        /**
         * Event on change schedule data
         *
         */
        $('#schedule-date').on('change', function(e) {
            refreshGanttChart();
        });

        /**
         * Trigger Gantt Chart
         *
         */
        function refreshGanttChart(viewModeParram = null) {
            let workOrderSchedules = [];
            let viewMode = 'Day';

            if ($('#category-wo').val() == 'Non Rutin') {
                if ($('#schedule-date').val() != '') {
                    view_mode = 'Day';

                    workOrderSchedules.push({
                        id: 'Schedule',
                        name: 'Schedule Non Rutin',
                        start: $('#schedule-date').val(),
                        end: $('#schedule-date').val(),
                        progress: 100,
                    });
                }
            } else if ($('#category-wo').val() == 'Rutin') {
                if ($('#schedule-wo').val() != null && $('#end-date').val() != '' && $('#start-date').val() != '') {
                    let startDateValue = $('#start-date').val();
                    let endDateValue = $('#end-date').val();
                    let scheduleWoValue = $('#schedule-wo').val();
                    let scheduleWoFormatted = '';
                    let stepModeAmount = 1;
                    let counter = 1;

                    if (['Harian', 'Mingguan'].includes($('#schedule-wo').val())) {

                        switch (scheduleWoValue) {
                            case 'Harian':
                                scheduleWoFormatted = 'days';
                                viewMode = 'Day';
                                break;
                            case 'Mingguan':
                                scheduleWoFormatted = 'weeks';
                                viewMode = 'Week';
                                break;
                            case 'Bulanan':
                                scheduleWoFormatted = 'months';
                                viewMode = 'Month';
                                break;
                            case '2 Bulanan':
                                stepModeAmount = 2;
                                scheduleWoFormatted = 'months';
                                viewMode = 'Month';
                                break;
                            case '3 Bulanan':
                                stepModeAmount = 3;
                                scheduleWoFormatted = 'months';
                                viewMode = 'Month';
                                break;
                            case '4 Bulanan':
                                stepModeAmount = 4;
                                scheduleWoFormatted = 'months';
                                viewMode = 'Month';
                                break;
                            case '6 Bulanan':
                                stepModeAmount = 6;
                                scheduleWoFormatted = 'months';
                                viewMode = 'Month';
                                break;
                            case 'Tahunan':
                                scheduleWoFormatted = 'years';
                                break;
                        }

                        // while (startDateValue <= endDateValue) {
                        //     let tempEndData = moment(startDateValue).add(stepModeAmount, scheduleWoFormatted).format(
                        //         "YYYY-MM-DD");

                        //     if (moment(tempEndData).subtract(1, 'days').format("YYYY-MM-DD") <= endDateValue) {
                        //         workOrderSchedules.push({
                        //             id: 'Schedule ' + counter,
                        //             name: 'Schedule Rutin ' + counter,
                        //             start: startDateValue,
                        //             end: moment(tempEndData).subtract(1, 'days').format("YYYY-MM-DD"),
                        //             progress: 100,
                        //         });
                        //     }

                        //     startDateValue = tempEndData;
                        //     counter++;
                        // }

                        while (moment(startDateValue).isSameOrBefore(moment(endDateValue))) {
                            let tempEndData = moment(startDateValue).add(stepModeAmount, scheduleWoFormatted).format(
                                "YYYY-MM-DD");

                            workOrderSchedules.push({
                                id: 'Schedule ' + counter,
                                name: 'Schedule Rutin ' + counter,
                                start: startDateValue,
                                end: moment(tempEndData).subtract(1, 'days').format("YYYY-MM-DD"),
                                progress: 100,
                            });

                            startDateValue = moment(tempEndData).format("YYYY-MM-DD");
                            counter++;
                        }

                    } else {
                        switch (scheduleWoValue) {
                            case 'Harian':
                                scheduleWoFormatted = 'days';
                                viewMode = 'Day';
                                break;
                            case 'Mingguan':
                                scheduleWoFormatted = 'weeks';
                                viewMode = 'Week';
                                break;
                            case 'Bulanan':
                                scheduleWoFormatted = 'months';
                                viewMode = 'Month';
                                break;
                            case '2 Bulanan':
                                stepModeAmount = 2;
                                scheduleWoFormatted = 'months';
                                viewMode = 'Month';
                                break;
                            case '3 Bulanan':
                                stepModeAmount = 3;
                                scheduleWoFormatted = 'months';
                                viewMode = 'Month';
                                break;
                            case '4 Bulanan':
                                stepModeAmount = 4;
                                scheduleWoFormatted = 'months';
                                viewMode = 'Month';
                                break;
                            case '6 Bulanan':
                                stepModeAmount = 6;
                                scheduleWoFormatted = 'months';
                                viewMode = 'Month';
                                break;
                            case 'Tahunan':
                                scheduleWoFormatted = 'years';
                                break;
                            default:
                                scheduleWoFormatted = 'months'; // Nilai default jika tidak ada yang cocok
                                viewMode = 'Month';
                                break;
                        }

                        while (moment(startDateValue).isSameOrBefore(moment(endDateValue))) {
                            let tempEndData = moment(startDateValue).add(stepModeAmount, scheduleWoFormatted).format(
                                "YYYY-MM-DD");

                            workOrderSchedules.push({
                                id: 'Schedule ' + counter,
                                name: 'Schedule Rutin ' + counter,
                                start: startDateValue,
                                end: moment(tempEndData).subtract(1, 'days').format("YYYY-MM-DD"),
                                progress: 100,
                            });

                            startDateValue = moment(tempEndData).format("YYYY-MM-DD");
                            counter++;
                        }
                    }
                }
            }

            console.log(workOrderSchedules);

            if (workOrderSchedules.length > 0) {
                if (['Harian', 'Mingguan'].includes($('#schedule-wo').val())) {
                    !$('#table-container').hasClass('d-none') ? $('#table-container').addClass('d-none') : '';
                    $('#gantt').hasClass('d-none') ? $('#gantt').removeClass('d-none') : '';
                    $('#group-viewmode').hasClass('d-none') ? $('#group-viewmode').removeClass('d-none') : '';

                    if (!viewModeParram) {
                        $('#view_mode').val(viewMode).trigger('change');
                    }

                    $('#gantt').hasClass('d-none') ? $('#gantt').removeClass('d-none') : '';
                    this.gantt = new Gantt("#gantt", workOrderSchedules, {
                        step: 1,
                        view_mode: viewModeParram ? viewModeParram : viewMode,
                        view_modes: ['Day', 'Week', 'Month'],
                    });
                    $('.gantt .bar-wrapper').css('pointer-events', 'none');
                } else {
                    !$('#gantt').hasClass('d-none') ? $('#gantt').addClass('d-none') : '';
                    $('#table-container').hasClass('d-none') ? $('#table-container').removeClass('d-none') : '';
                    !$('#group-viewmode').hasClass('d-none') ? $('#group-viewmode').addClass('d-none') : '';

                    $('#table-container tbody').html('');
                    workOrderSchedules.forEach((e, i) => {
                        $('#table-container tbody').append(`
                            <tr>
                                <td>${i + 1}</td>
                                <td>${e.start}</td>
                            </tr>
                        `);
                    });
                }
            } else {
                !$('#gantt').hasClass('d-none') ? $('#gantt').addClass('d-none') : '';
                !$('#group-viewmode').hasClass('d-none') ? $('#group-viewmode').addClass('d-none') : '';
                !$('#table-container').hasClass('d-none') ? $('#table-container').addClass('d-none') : '';
            }
        }

        /**
         * Show QR Scanner
         *
         */
        function showQrScanner() {
            const modalScanner = new bootstrap.Modal(document.getElementById('modalScanner'));
            modalScanner.show()

            let html5QrcodeScanner = new Html5QrcodeScanner(
                "camera-scanner", {
                    fps: 10,
                    qrbox: 250
                }
            );
            html5QrcodeScanner.render((decodedText, decodedResult) => {
                fetch('{{ url('/') }}/api/equipments/' + decodedText + '/barcode')
                    .then((res) => res.json())
                    .then((response) => {
                        const data = response.data;
                        $('#location_id').val(data.equipment_location_id).trigger('change');
                        eventChangeLocationId(() => {
                            $('#equipment-id').val(data.id).trigger('change');
                            eventChangeEquipmentId();
                            modalScanner.hide();
                            html5QrcodeScanner.clear();
                        });
                    });
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            var i = 1;
            $('#add_berkas3').click(function() {
                i++;
                $('#dynamic_field3').append('<tr id="row3' + i +
                    '"><td><input required type="text" name="name_photo[]" placeholder="" class="form-control " /></td><td><input type="file" name="file_photo_work_order_photo_before[]" class="form-control" required="" /></td><td><button type="button" name="remove" id="' +
                    i +
                    '" class="btn btn-danger btn_remove3"><i class="fa fa-trash" aria-hidden="true"></i></button></td></tr>'
                );
            });

            $(document).on('click', '.btn_remove3', function() {
                var button_id = $(this).attr("id");
                $('#row3' + button_id + '').remove();
            });

            $(document).on('click', '.btn_remove3', function() {
                var bid = this.id;
                var trid = $(this).closest('tr').attr('id');
                $('#' + trid + '').remove();
            });
        });
    </script>
@endpush
