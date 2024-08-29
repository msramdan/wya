@extends('layouts.app')

@section('title', __('Moving Equipment'))

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
                        <h4 class="mb-sm-0">{{ __('Moving Equipment') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/panel">Dashboard</a></li>
                                <li class="breadcrumb-item active">{{ __('Moving Equipment') }}</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            @can('loan create')
                                <a href="{{ route('loans.create') }}" class="btn btn-md btn-primary"> <i
                                        class="mdi mdi-plus"></i> {{ __('Create a new Moving Equipment') }}</a>
                            @endcan
                        </div>

                        <div class="card-body">

                            <div class="table-responsive p-1">
                                <table class="table table-striped" id="data-table">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('No Peminjaman') }}</th>
                                            <th>{{ __('PIC') }}</th>
                                            <th>{{ __('Merk') }}</th>
                                            <th>{{ __('Type') }}</th>
                                            <th>{{ __('SN') }}</th>
                                            <th>{{ __('Lokasi Awal') }}</th>
                                            <th>{{ __('Lokasi Tujuan') }}</th>
                                            <th>{{ __('Waktu') }}</th>
                                            <th>{{ __('Rencana Pengembalian') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Action') }}</th>
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


@push('js')
    <script>
        let columns = [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'no_peminjaman',
                name: 'no_peminjaman',
            },
            {
                data: 'employee_name',
                name: 'employee_name',
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
                data: 'serial_number',
                name: 'serial_number',
            },
            {
                data: 'resource_location',
                name: 'resource_location',
            },
            {
                data: 'destination_location',
                name: 'destination_location',
            },
            {
                data: 'waktu_pinjam',
                name: 'waktu_pinjam',
            },
            {
                data: 'rencana_pengembalian',
                name: 'rencana_pengembalian',
            },
            {
                data: 'status_peminjaman',
                render: function(datum, type, row) {
                    switch (row.status_peminjaman) {
                        case 'Belum dikembalikan':
                            rowStatus = 'danger';
                            break;
                        case 'Sudah dikembalikan':
                            rowStatus = 'success';
                            break;
                        default:
                            rowStatus = 'danger';
                            break;
                    }
                    return `<span class="badge bg-${rowStatus}">${row.status_peminjaman}</span>`;
                }
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ];

        var table = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('loans.index') }}",
                data: function(s) {
                    s.hospital_id = $('select[name=hospital_id] option').filter(':selected').val()
                }
            },
            columns: columns
        });
        $('#hospital_id').change(function() {
            table.draw();
        })
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
@endpush
