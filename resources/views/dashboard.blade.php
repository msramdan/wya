@extends('layouts.app')

@section('title', 'Dashboard')
@push('css')
    <link href="{{ asset('material/assets/css/daterangepicker.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
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


    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">

                    <div class="h-100">
                        <div class="row mb-3 pb-1">
                            <div class="col-12">
                                <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                    <div class="flex-grow-1">
                                        <h4 class="fs-16 mb-1">{{ trans('dashboard.welcome') }} {{ Auth::user()->name }}
                                        </h4>
                                    </div>
                                    <div class="mt-3 mt-lg-0">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <input readonly type="text" class="form-control"
                                            placeholder="Search Equipment by QR" aria-label="Recipient's username">
                                        <button onclick="showQrScanner()" class="btn btn-primary" type="submit"><i
                                                class="fa fa-qrcode"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <form method="get" action="/panel" id="form-date" class="row">
                                    <div class="col-md-6">
                                        <div class="input-group mb-4">
                                            <span class="input-group-text" id="addon-wrapping"><i
                                                    class="fa fa-calendar"></i></span>
                                            <input type="text" class="form-control" aria-describedby="addon-wrapping"
                                                id="daterange-btn" value="">
                                            <input type="hidden" name="start_date" id="start_date"
                                                value="{{ $microFrom }}">
                                            <input type="hidden" name="end_date" id="end_date"
                                                value="{{ $microTo }}">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-3">
                                <button type="button" id="btnExport" class="btn btn-primary">
                                    <i class="fa fa-file-word" aria-hidden="true"></i>
                                    General Report
                                </button>
                            </div>

                        </div>



                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <!-- card -->
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                    <a href="" style="color: #A8AAB5" role="button"
                                                        id="btn_work_order_modal">{{ trans('dashboard.wo_total') }}</a>
                                                </p>
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
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                    <a href="" style="color: #A8AAB5" role="button"
                                                        id="btn_equipment_modal">{{ trans('dashboard.euip_total') }}</a>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span
                                                        class="counter-value" data-target="{{ $countEquipment }}"></span>
                                                </h4>
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
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                    <a href="" style="color: #A8AAB5" role="button"
                                                        id="btn_employee_modal">
                                                        {{ trans('dashboard.employee_total') }}</a>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span
                                                        class="counter-value" data-target="{{ $countEmployee }}"></span>
                                                </h4>
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
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                    <a href="" style="color: #A8AAB5" role="button"
                                                        id="btn_vendor_modal">{{ trans('dashboard.vendor_total') }}</a>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span
                                                        class="counter-value" data-target="{{ $countVendor }}"></span>
                                                </h4>
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
                                            <a href="" role="button" class="text-dark"
                                                id="btn_wo_by_status_modal">{{ trans('dashboard.total_status_wo') }}</a>
                                        </h4>
                                    </div>

                                    <div class="card-body" style="width: 90%">
                                        <canvas id="myChart1"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4">
                                <div class="card" style="height: 500px">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">
                                            <a href="" role="button" class="text-dark"
                                                id="btn_wo_by_category_modal">{{ trans('dashboard.total_category_wo') }}</a>
                                        </h4>
                                    </div>

                                    <div class="card-body" style="width: 90%">
                                        <canvas id="myChart2"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4">
                                <div class="card" style="height: 500px">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">
                                            <a href="" role="button" class="text-dark"
                                                id="btn_wo_by_type_modal">{{ trans('dashboard.total_type_wo') }}</a>
                                        </h4>
                                    </div>

                                    <div class="card-body" style="width: 90%">
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
                                            Proses Wo ( Finish Vs On Progress Vs Ready to Start )
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
                                            Biaya Work Order
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
                                            Stock Opname Sparepart
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
                                                aria-hidden="true"></i> Stock In Sparepart</h4>
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
                                                class="fa fa-sign-out text-warning fs-3" aria-hidden="true"></i>
                                            Stock Out Sparepart</h4>
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
                                        <h4 class="card-title mb-0 flex-grow-1">
                                            Lokasi Karyawan & Vendor</h4>
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
    @include('modal-dashboard')
@endsection
@push('css-libs')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/frappe-gantt/0.6.1/frappe-gantt.min.css"
        integrity="sha512-b6CPl1eORfMoZgwWGEYWNxYv79KG0dALXfVu4uReZJOXAfkINSK4UhA0ELwGcBBY7VJN7sykwrCGQnbS8qTKhQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script type="text/javascript" src="{{ asset('material/assets/js/moment.js') }}"></script>
    <script type="text/javascript" src="{{ asset('material/assets/js/daterangepicker.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"
        integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/frappe-gantt/0.6.1/frappe-gantt.min.js"
        integrity="sha512-HyGTvFEibBWxuZkDsE2wmy0VQ0JRirYgGieHp0pUmmwyrcFkAbn55kZrSXzCgKga04SIti5jZQVjbTSzFpzMlg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"
        integrity="sha512-r6rDA7W6ZeQhvl8S7yRVQUKVHdexq+GAlNkNNqVC7YyIV+NwqCTJe2hDWCiffTyRNOeGEzRRJ9ifvRm/HCzGYg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            var hospital_id = $('#hospital_id option:selected').val();
            // total work order
            $('#btn_work_order_modal').click(function(e) {
                e.preventDefault()
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
                        name: 'equipment.id'
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
                        name: "approval_users_id",
                        render: function(datum, type, row) {
                            let htmlEl = '<ul>';
                            row.approval_users_id.forEach((e) => {
                                switch (e.status) {
                                    case 'pending':
                                        rowStatus = 'primary';
                                        break;
                                    case 'rejected':
                                        rowStatus = 'danger';
                                        break;
                                    case 'accepted':
                                        rowStatus = 'success';
                                        break;
                                    default:
                                        rowStatus = 'success';
                                        break;
                                }

                                htmlEl +=
                                    `<li style="white-space: nowrap">${e.user_name}: <span class="badge bg-${rowStatus}">${e.status}</span></li>`;
                            })

                            htmlEl += '</ul>';

                            return htmlEl;
                        }
                    },
                    {
                        data: 'status_wo',
                        render: function(datum, type, row) {
                            switch (row.status_wo) {
                                case 'pending':
                                    rowStatus = 'primary';
                                    break;
                                case 'rejected':
                                    rowStatus = 'danger';
                                    break;
                                case 'accepted':
                                    rowStatus = 'success';
                                    break;
                                default:
                                    rowStatus = 'success';
                                    break;
                            }

                            return `<span class="badge bg-${rowStatus}">${row.status_wo}</span>`;
                        }
                    }
                ];
                if ($.fn.DataTable.isDataTable('#data-table-work-order')) {
                    $('#data-table-work-order').DataTable().destroy();
                }
                var table = $('#data-table-work-order').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('dashboard.work_order') }}",
                        data: function(s) {
                            s.hospital_id = hospital_id
                        }
                    },
                    columns: columns
                });
                $('#total_work_order').modal('show')
            })
            // total equipment
            $('#btn_equipment_modal').click(function(e) {
                e.preventDefault()
                let columns = [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'hospital',
                        name: 'hospital',
                    },
                    {
                        data: 'barcode',
                        name: 'barcode',
                    },
                    {
                        data: 'nomenklatur',
                        name: 'nomenklatur.code_nomenklatur'
                    },
                    {
                        data: 'serial_number',
                        name: 'serial_number',
                    },
                    {
                        data: 'equipment_category',
                        name: 'equipment_category.code_categoty'
                    },
                    {
                        data: 'manufacturer',
                        name: 'manufacturer',
                    },
                    {
                        data: 'type',
                        name: 'type',
                    },
                    {
                        data: 'equipment_location',
                        name: 'equipment_location.code_location'
                    },
                ];
                if ($.fn.DataTable.isDataTable('#data-table-equipment')) {
                    $('#data-table-equipment').DataTable().destroy();
                }
                var table = $('#data-table-equipment').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('dashboard.equipment') }}",
                        data: function(s) {
                            s.hospital_id = hospital_id
                        }
                    },
                    columns: columns
                })
                $('#total_euipment').modal('show')
            })
            // total employee
            $('#btn_employee_modal').click(function(e) {
                e.preventDefault()
                let columns = [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'hospital',
                        name: 'hospital',
                    },
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'nid_employee',
                        name: 'nid_employee',
                    },
                    {
                        data: 'employee_type',
                        name: 'employee_type.name_employee_type'
                    },
                    {
                        data: 'employee_status',
                        name: 'employee_status',
                    },
                    {
                        data: 'department',
                        name: 'department.code_department'
                    },
                    {
                        data: 'position',
                        name: 'position.code_position'
                    },
                    {
                        data: 'phone',
                        name: 'phone',
                    },
                ];
                if ($.fn.DataTable.isDataTable('#data-table-employee')) {
                    $('#data-table-employee').DataTable().destroy();
                }
                var table = $('#data-table-employee').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('dashboard.employee') }}",
                        data: function(s) {
                            s.hospital_id = hospital_id
                        }
                    },
                    columns: columns
                });
                $('#total_employee').modal('show')
            })
            // total vendor 'Rutin', $microFrom, $microTo, $ids
            $('#btn_vendor_modal').click(function(e) {
                e.preventDefault()
                let columns = [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'hospital',
                        name: 'hospital',
                    },
                    {
                        data: 'code_vendor',
                        name: 'code_vendor',
                    },
                    {
                        data: 'name_vendor',
                        name: 'name_vendor',
                    },
                    {
                        data: 'category_vendor',
                        name: 'category_vendor.name_category_vendors'
                    },
                    {
                        data: 'email',
                        name: 'email',
                    }
                ]
                if ($.fn.DataTable.isDataTable('#data-table-vendor')) {
                    $('#data-table-vendor').DataTable().destroy();
                }
                var table = $('#data-table-vendor').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('dashboard.vendor') }}",
                        data: function(s) {
                            s.hospital_id = hospital_id
                        }
                    },
                    columns: columns
                });
                $('#total_vendor').modal('show')
            })
            // total wo by status
            $('#btn_wo_by_status_modal').click(function(e) {
                e.preventDefault()
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
                        name: 'equipment.id'
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
                        name: "approval_users_id",
                        render: function(datum, type, row) {
                            let htmlEl = '<ul>';
                            row.approval_users_id.forEach((e) => {
                                switch (e.status) {
                                    case 'pending':
                                        rowStatus = 'primary';
                                        break;
                                    case 'rejected':
                                        rowStatus = 'danger';
                                        break;
                                    case 'accepted':
                                        rowStatus = 'success';
                                        break;
                                    default:
                                        rowStatus = 'success';
                                        break;
                                }

                                htmlEl +=
                                    `<li style="white-space: nowrap">${e.user_name}: <span class="badge bg-${rowStatus}">${e.status}</span></li>`;
                            })

                            htmlEl += '</ul>';

                            return htmlEl;
                        }
                    },
                    {
                        data: 'status_wo',
                        render: function(datum, type, row) {
                            switch (row.status_wo) {
                                case 'pending':
                                    rowStatus = 'primary';
                                    break;
                                case 'rejected':
                                    rowStatus = 'danger';
                                    break;
                                case 'accepted':
                                    rowStatus = 'success';
                                    break;
                                default:
                                    rowStatus = 'success';
                                    break;
                            }

                            return `<span class="badge bg-${rowStatus}">${row.status_wo}</span>`;
                        }
                    }
                ];
                var table = $('#data-table-work-order-by-status').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('dashboard.woBystatus') }}",
                        data: function(d) {
                            d.status = ['pending', 'rejected', 'accepted', 'on-going',
                                'finished'
                            ];
                            d.microFrom = "{{ $microFrom }}";
                            d.microTo = "{{ $microTo }}";
                            d.ids = "{{ $ids }}";
                        }
                    },
                    columns: columns
                });
                $('#total_wo_by_status').modal('show')
            })
            // total wo by category
            $('#btn_wo_by_category_modal').click(function(e) {
                e.preventDefault()
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
                        name: 'equipment.id'
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
                        name: "approval_users_id",
                        render: function(datum, type, row) {
                            let htmlEl = '<ul>';
                            row.approval_users_id.forEach((e) => {
                                switch (e.status) {
                                    case 'pending':
                                        rowStatus = 'primary';
                                        break;
                                    case 'rejected':
                                        rowStatus = 'danger';
                                        break;
                                    case 'accepted':
                                        rowStatus = 'success';
                                        break;
                                    default:
                                        rowStatus = 'success';
                                        break;
                                }

                                htmlEl +=
                                    `<li style="white-space: nowrap">${e.user_name}: <span class="badge bg-${rowStatus}">${e.status}</span></li>`;
                            })

                            htmlEl += '</ul>';

                            return htmlEl;
                        }
                    },
                    {
                        data: 'status_wo',
                        render: function(datum, type, row) {
                            switch (row.status_wo) {
                                case 'pending':
                                    rowStatus = 'primary';
                                    break;
                                case 'rejected':
                                    rowStatus = 'danger';
                                    break;
                                case 'accepted':
                                    rowStatus = 'success';
                                    break;
                                default:
                                    rowStatus = 'success';
                                    break;
                            }

                            return `<span class="badge bg-${rowStatus}">${row.status_wo}</span>`;
                        }
                    }
                ];
                var table = $('#data-table-work-order-by-category').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('dashboard.woBycategory') }}",
                        data: function(d) {
                            d.status = ['Rutin', 'Non Ruting'];
                            d.microFrom = "{{ $microFrom }}";
                            d.microTo = "{{ $microTo }}";
                            d.ids = "{{ $ids }}";
                        }
                    },
                    columns: columns
                });
                $('#total_wo_by_category').modal('show')
            })
            // total wo by type
            $('#btn_wo_by_type_modal').click(function(e) {
                e.preventDefault()
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
                        name: 'equipment.id'
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
                        name: "approval_users_id",
                        render: function(datum, type, row) {
                            let htmlEl = '<ul>';
                            row.approval_users_id.forEach((e) => {
                                switch (e.status) {
                                    case 'pending':
                                        rowStatus = 'primary';
                                        break;
                                    case 'rejected':
                                        rowStatus = 'danger';
                                        break;
                                    case 'accepted':
                                        rowStatus = 'success';
                                        break;
                                    default:
                                        rowStatus = 'success';
                                        break;
                                }

                                htmlEl +=
                                    `<li style="white-space: nowrap">${e.user_name}: <span class="badge bg-${rowStatus}">${e.status}</span></li>`;
                            })

                            htmlEl += '</ul>';

                            return htmlEl;
                        }
                    },
                    {
                        data: 'status_wo',
                        render: function(datum, type, row) {
                            switch (row.status_wo) {
                                case 'pending':
                                    rowStatus = 'primary';
                                    break;
                                case 'rejected':
                                    rowStatus = 'danger';
                                    break;
                                case 'accepted':
                                    rowStatus = 'success';
                                    break;
                                default:
                                    rowStatus = 'success';
                                    break;
                            }

                            return `<span class="badge bg-${rowStatus}">${row.status_wo}</span>`;
                        }
                    }
                ];
                var table = $('#data-table-work-order-by-type').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('dashboard.woBytype') }}",
                        data: function(d) {
                            d.status = ['Calibration', 'Service', 'Training',
                                'Inspection And Preventing Maintenance',
                                'finished'
                            ];
                            d.microFrom = "{{ $microFrom }}";
                            d.microTo = "{{ $microTo }}";
                            d.ids = "{{ $ids }}";
                        }
                    },
                    columns: columns
                });
                $('#total_wo_by_type').modal('show')
            })
        })
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

            $('#btnExport').click(function() {
                const hospital_id = $('#hospital_id').val()
                const start_date = $('#start_date').val()
                const end_date = $('#end_date').val()
                window.open('/panel/generalReport' + '?hospital_id=' + hospital_id + '&start_date=' +
                    start_date + '&end_date=' + end_date, '_blank')
            })
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
                labels: ['Calibration', 'Service', 'Training/Uji fungsi', 'Inspection and Preventive Maintenance'],
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
                    label: '# Total',
                    data: [{{ statusProsesWo('Finish', $microFrom, $microTo, $ids) }},
                        {{ statusProsesWo('Progress', $microFrom, $microTo, $ids) }},
                        {{ statusProsesWo('Ready to Start', $microFrom, $microTo, $ids) }},
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
                        modalScanner.hide();
                        html5QrcodeScanner.clear();
                        top.location.href = '../panel/equipment?id=' + data.id;
                    });
            });
        }
    </script>

    {{-- gmaps --}}
    <script>
        const googleMapsApiKey = '{{ config('app.google_maps_api_key') }}';
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key={{ config('app.google_maps_api_key') }}&libraries=places&callback=initMap">
    </script>
<script>
    // Initialize vendor and employee data from Blade template
    const vendorData = @json($vendor);
    const employeesData = @json($employees);

    function initMap() {
        const map = new google.maps.Map(document.getElementById('map'), {
            center: {
                lat: -2.5489,
                lng: 118.0149
            }, // Center coordinate of Indonesia
            zoom: 5,
        });

        // Icon for vendors (red marker)
        const vendorIcon = "http://maps.google.com/mapfiles/ms/icons/red-dot.png";

        // Icon for employees (blue marker)
        const employeeIcon = "http://maps.google.com/mapfiles/ms/icons/blue-dot.png";

        // Display markers for each vendor with red icon
        vendorData.forEach(vendor => {
            const vendorMarker = new google.maps.Marker({
                position: {
                    lat: parseFloat(vendor.latitude),
                    lng: parseFloat(vendor.longitude)
                },
                map: map,
                title: vendor.name_vendor,
                icon: vendorIcon
            });

            const vendorInfoWindow = new google.maps.InfoWindow({
                content: `<strong>${vendor.name_vendor}</strong><br>Latitude: ${vendor.latitude}<br>Longitude: ${vendor.longitude}`,
            });

            vendorMarker.addListener('click', () => {
                vendorInfoWindow.open(map, vendorMarker);
            });
        });

        // Display markers for each employee with blue icon
        employeesData.forEach(employee => {
            const employeeMarker = new google.maps.Marker({
                position: {
                    lat: parseFloat(employee.latitude),
                    lng: parseFloat(employee.longitude)
                },
                map: map,
                title: employee.name,
                icon: employeeIcon
            });

            const employeeInfoWindow = new google.maps.InfoWindow({
                content: `<strong>${employee.name}</strong><br>Latitude: ${employee.latitude}<br>Longitude: ${employee.longitude}`,
            });

            employeeMarker.addListener('click', () => {
                employeeInfoWindow.open(map, employeeMarker);
            });
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        initMap();
    });
</script>

@endpush
