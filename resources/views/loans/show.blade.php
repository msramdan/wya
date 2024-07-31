@extends('layouts.app')

@section('title', __('Detail of Moving Equipment'))

@section('content')

    <div class="modal fade" id="equipmentDetailsModal" tabindex="-1" aria-labelledby="equipmentDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="equipmentDetailsModalLabel">Equipment Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <div class="page-body">
        <div class="container-fluid">
            <div class="page-header" style="margin-top: 5px">
                <div class="row">
                    <div class="col-sm-6">
                        <h3>{{ __('Moving Equipment') }}</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/panel">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('loans.index') }}">{{ __('Moving Equipment') }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ __('Detail') }}
                            </li>
                        </ol>
                    </div>
                    <div class="col-sm-6">
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped table-sm">
                                    <tr>
                                        <td class="fw-bold">{{ __('No Peminjaman') }}</td>
                                        <td>{{ $loan->no_peminjaman }}</td>
                                        <td class="fw-bold">{{ __('Equipment') }}</td>
                                        <td>
                                            {{ $loan->barcode }}
                                            <button class="btn btn-info btn-sm"
                                                onclick="showEquipmentDetails('{{ $loan->barcode }}')"><i
                                                    class="fa fa-info-circle" aria-hidden="true"></i> Info</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Hospital') }}</td>
                                        <td>{{ $loan->hospital_name }}</td>
                                        <td class="fw-bold">{{ __('Lokasi Asal') }}</td>
                                        <td>{{ $loan->resource_location }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Lokasi Tujuan') }}</td>
                                        <td>{{ $loan->destination_location }}</td>
                                        <td class="fw-bold">{{ __('Waktu Pinjam') }}</td>
                                        <td>{{ $loan->waktu_pinjam }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Waktu Dikembalikan') }}</td>
                                        <td>{{ isset($loan->waktu_dikembalikan) ? $loan->waktu_dikembalikan : '-' }}</td>
                                        <td class="fw-bold">{{ __('Alasan Peminjaman') }}</td>
                                        <td>{{ $loan->alasan_peminjaman }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Status Peminjaman') }}</td>
                                        <td>
                                            @if ($loan->status_peminjaman == 'Sudah dikembalikan')
                                                <span class="badge bg-success">{{ __('Sudah dikembalikan') }}</span>
                                            @elseif($loan->status_peminjaman == 'Belum dikembalikan')
                                                <span class="badge bg-danger">{{ __('Belum dikembalikan') }}</span>
                                            @endif
                                        </td>
                                        <td class="fw-bold">{{ __('Catatan Pengembalian') }}</td>
                                        <td>{{ isset($loan->catatan_pengembalian) ? $loan->catatan_pengembalian : '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Pic Penanggungjawab') }}</td>
                                        <td>{{ $loan->employee_name }}</td>
                                        <td class="fw-bold">{{ __('User Created') }}</td>
                                        <td>{{ $loan->user_created_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('User Updated') }}</td>
                                        <td>{{ $loan->user_updated_name }}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Bukti Peminjaman') }}</td>
                                        <td>
                                            @if ($loan->bukti_peminjaman == null)
                                                <img src="https://via.placeholder.com/350?text=No+Image+Avaiable"
                                                    alt="Bukti Peminjaman" class="rounded" width="200" height="150"
                                                    style="object-fit: cover">
                                            @else
                                                <img src="{{ asset('storage/uploads/bukti_peminjamen/' . $loan->bukti_peminjaman) }}"
                                                    alt="Bukti Peminjaman" class="img-thumbnail" width="200"
                                                    height="150" style="object-fit: cover">
                                            @endif
                                        </td>
                                        <td class="fw-bold">{{ __('Bukti Pengembalian') }}</td>
                                        <td>
                                            @if ($loan->bukti_pengembalian == null)
                                                -
                                            @else
                                                <img src="{{ asset('storage/uploads/bukti_pengembalians/' . $loan->bukti_pengembalian) }}"
                                                    alt="Bukti Pengembalian" class="img-thumbnail" width="200"
                                                    height="150" style="object-fit: cover">
                                            @endif
                                        </td>

                                    </tr>
                                </table>
                            </div>
                            <a style="margin-bottom: 30px" href="{{ url()->previous() }}"
                                class="btn btn-secondary">{{ __('Back') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function showEquipmentDetails(barcode) {
            $.ajax({
                url: `/api/getEquipmentByBarcode/${barcode}`,
                method: 'GET',
                success: function(response) {
                    if (response.barcode) {
                        $('#equipmentDetailsModal .modal-body').html(`
                        <table class="table table-bordered">
                            <tbody>
                                <tr><th>Barcode</th><td>${response.barcode}</td></tr>
                                <tr><th>Manufacturer</th><td>${response.manufacturer}</td></tr>
                                <tr><th>Type</th><td>${response.type}</td></tr>
                                <tr><th>Serial Number</th><td>${response.serial_number}</td></tr>
                                <tr><th>Condition</th><td>${response.condition}</td></tr>
                                <tr><th>Risk Level</th><td>${response.risk_level}</td></tr>
                                <tr><th>Financing Code</th><td>${response.financing_code}</td></tr>
                                <tr><th>Purchase Date</th><td>${response.tgl_pembelian}</td></tr>
                                <tr><th>Method</th><td>${response.metode}</td></tr>
                                <tr><th>Acquisition Value</th><td>${response.nilai_perolehan}</td></tr>
                                <tr><th>Residual Value</th><td>${response.nilai_residu}</td></tr>
                                <tr><th>Useful Life</th><td>${response.masa_manfaat}</td></tr>
                            </tbody>
                        </table>
                    `);
                    } else {
                        $('#equipmentDetailsModal .modal-body').html(`
                        <div class="alert alert-danger" role="alert">
                            Equipment not found.
                        </div>
                    `);
                    }
                    $('#equipmentDetailsModal').modal('show');
                },
                error: function() {
                    $('#equipmentDetailsModal .modal-body').html(`
                    <div class="alert alert-danger" role="alert">
                        Failed to fetch equipment details.
                    </div>
                `);
                    $('#equipmentDetailsModal').modal('show');
                }
            });
        }
    </script>
@endpush
