@extends('layouts.app')

@section('title', __('Work Order Procesess'))

@section('content')
    <div class="modal fade" id="modal-dialog3">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ trans('work-order/submission/index.informasi') }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tr>
                            <td width="25%">{{ trans('inventory/equipment/index.barcode') }}</td>
                            <td><span id="modal_barcode"></span></td>
                        </tr>
                        <tr>
                            <td>{{ trans('inventory/equipment/index.nomenklatur') }}</td>
                            <td><span id="modal_nomenklatur"></span></td>
                        </tr>
                        <tr>
                            <td>{{ __('SN') }}</td>
                            <td><span id="modal_sn"></span></td>
                        </tr>
                        <tr>
                            <td>{{ trans('inventory/equipment/index.category') }}</td>
                            <td><span id="modal_category"></span></td>
                        </tr>
                        <tr>
                            <td>{{ trans('inventory/equipment/index.manufacture') }}</td>
                            <td><span id="modal_manufacture"></span></td>
                        </tr>
                        <tr>
                            <td>{{ trans('inventory/equipment/index.type') }}</td>
                            <td><span id="modal_type"></span></td>
                        </tr>
                        <tr>
                            <td>{{ trans('inventory/equipment/index.location') }}</td>
                            <td><span id="modal_location"></span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ trans('work-order/processes/index.head') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/panel">Dashboard</a></li>
                                <li class="breadcrumb-item active">{{ trans('work-order/processes/index.head') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
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
                                                        {{ trans('work-order/submission/index.filter_hospital') }} --
                                                    </option>
                                                    @foreach ($hispotals as $hispotal)
                                                        <option value="{{ $hispotal->id }}"
                                                            {{ isset($workOrders) && $workOrders->hospital_id == $hispotal->id ? 'selected' : (old('hospital_id') == $hispotal->id ? 'selected' : '') }}>
                                                            {{ $hispotal->name }}
                                                        </option>
                                                    @endforeach
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
                                        <input type="text" class="form-control" aria-describedby="addon-wrapping"
                                            id="daterange-btn" value="">
                                        <input type="hidden" name="start_date" id="start_date"
                                            value="{{ $microFrom }}">
                                        <input type="hidden" name="end_date" id="end_date" value="{{ $microTo }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group mb-4">
                                        <select name="equipment_id" id="equipment_id" class="form-control select2-form">
                                            <option value="All">--
                                                {{ trans('work-order/submission/index.filter_equipment') }} --</option>
                                            @foreach ($equipment as $row)
                                                <option value="{{ $row->id }}">{{ $row->serial_number }} |
                                                    {{ $row->barcode }} | {{ $row->manufacturer }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group mb-4">
                                        <select name="type_wo" id="type_wo" class="form-control select2-form">
                                            <option value="All">--
                                                {{ trans('work-order/submission/index.filter_type') }} --</option>
                                            <option value="Calibration">Calibration</option>
                                            <option value="Service">Service</option>
                                            <option value="Training">Training</option>
                                            <option value="Inspection and Preventive Maintenance">Inspection and Preventive
                                                Maintenance</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group mb-4">
                                        <select name="category_wo" id="category_wo" class="form-control select2-form">
                                            <option value="All">--
                                                {{ trans('work-order/submission/index.filter_category') }} --</option>
                                            <option value="Rutin">Rutin</option>
                                            <option value="Non Rutin">Non Rutin</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group mb-4">
                                        <select name="created_by" id="created_by" class="form-control select2-form">
                                            <option value="All">--
                                                {{ trans('work-order/submission/index.filter_created') }} --</option>
                                            @foreach ($user as $row)
                                                <option value="{{ $row->id }}">{{ $row->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- <div class="col-md-1">
                                    <div class="input-group mb-4">
                                        <button id="btnExport" class="btn btn-success">
                                            {{ __('Export') }}
                                        </button>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" id="data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th style="white-space: nowrap">
                                                {{ trans('work-order/processes/index.hospital') }}</th>
                                            <th style="white-space: nowrap">
                                                {{ trans('work-order/processes/index.wo_number') }}</th>
                                            <th style="white-space: nowrap">
                                                {{ trans('work-order/processes/index.filed_date') }}</th>
                                            <th style="white-space: nowrap">
                                                {{ trans('work-order/processes/index.equipment') }}</th>
                                            <th style="white-space: nowrap">{{ trans('work-order/processes/index.type') }}
                                            </th>
                                            <th style="white-space: nowrap">
                                                {{ trans('work-order/processes/index.category') }}</th>
                                            <th style="white-space: nowrap">
                                                {{ trans('work-order/processes/index.created_by') }}</th>
                                            <th style="white-space: nowrap">
                                                {{ trans('work-order/processes/index.approval_user') }}</th>
                                            <th style="white-space: nowrap">
                                                {{ trans('work-order/processes/index.status') }}</th>
                                            <th style="white-space: nowrap">
                                                {{ trans('work-order/processes/index.action') }}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
    <link href="{{ asset('material/assets/css/daterangepicker.min.css') }}" rel="stylesheet" />
@endpush

@push('js')
    <script type="text/javascript" src="{{ asset('material/assets/js/moment.js') }}"></script>
    <script type="text/javascript" src="{{ asset('material/assets/js/daterangepicker.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2-form').select2();
        });
    </script>
    <script>
        $(document).on('click', '#view_data', function() {
            var barcode = $(this).data('equipment');
            var url = '/panel/getDetailEquipment/' + barcode;
            $.ajax({
                url: url,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                data: {},
                dataType: 'json',
                success: function(result) {
                    $('#modal_barcode').text(result['data']['barcode']);
                    $('#modal_nomenklatur').text(result['data']['nomenklatur']['name_nomenklatur']);
                    $('#modal_sn').text(result['data']['serial_number']);
                    $('#modal_category').text(result['data']['equipment_category']['category_name']);
                    $('#modal_manufacture').text(result['data']['manufacturer']);
                    $('#modal_type').text(result['data']['type']);
                    $('#modal_location').text(result['data']['equipment_location']['location_name']);
                }
            });
        })
    </script>
    <script>
        let columns = [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'hospital',
                name: 'hospital'
            },
            {
                data: 'wo_number',
                name: 'wo_number'
            },
            {
                data: 'filed_date',
                name: 'filed_date',
            },
            {
                data: 'equipment',
                name: 'equipment.id',
                render: function(datum, type, row) {
                    return `${row.equipment} <a id="view_data" href="#modal-dialog3" data-bs-toggle="modal" data-equipment="${row.equipment}">
																<i style="color : #17a2b8" class="fas fa-info-circle fs-15 align-middle"></i>
															</a>`;
                }
            },
            {
                data: 'type_wo',
                name: 'type_wo',
            },
            {
                data: 'category_wo',
                name: 'category_wo',
            },
            {
                data: 'user',
                name: 'user.name'
            },
            {
                data: 'finished_processes',
                name: 'finished_processes'
            },
            {
                data: 'status_wo',
                render: function(datum, type, row) {
                    switch (row.status_wo) {
                        case 'accepted':
                            rowStatus = 'primary';
                            break;
                        case 'on-going':
                            rowStatus = 'info';
                            break;
                        case 'finished':
                            rowStatus = 'success';
                            break;
                    }

                    return `<span class="badge bg-${rowStatus}">${row.status_wo == 'accepted' ? 'ready for process' : row.status_wo}</span>`;
                }
            },
            {
                data: 'action',
                name: 'action'
            },
        ];

        var table = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('work-order-processes.index') }}?user_id={{ Auth::user()->id }}",
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
        $('#hospital_id').change(function() {
            table.draw();
        })
        $('#equipment_id').change(function() {
            table.draw();
        })
        $('#type_wo').change(function() {
            table.draw();
        })
        $('#category_wo').change(function() {
            table.draw();
        })
        $('#created_by').change(function() {
            table.draw();
        })

        $('#daterange-btn').change(function() {
            table.draw();
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
@endpush
