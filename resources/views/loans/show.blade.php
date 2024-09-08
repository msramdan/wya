@extends('layouts.app')

@section('title', __('Detail of Peminjaman Peralatan'))

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

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('Peminjaman Peralatan') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="/panel">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('loans.index') }}">{{ __('Peminjaman Peralatan') }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ __('Detail') }}
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
                            <div class="row">
                                <div class="col-md-6">
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
                                                <td>{{ isset($loan->waktu_dikembalikan) ? $loan->waktu_dikembalikan : '-' }}
                                                </td>
                                                <td class="fw-bold">{{ __('Alasan Peminjaman') }}</td>
                                                <td>{{ $loan->alasan_peminjaman }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">{{ __('Status Peminjaman') }}</td>
                                                <td>
                                                    @if ($loan->status_peminjaman == 'Sudah dikembalikan')
                                                        <span
                                                            class="badge bg-success">{{ __('Sudah dikembalikan') }}</span>
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
                                                <td class="fw-bold">{{ __('Rencana Pengembalian') }}</td>
                                                <td>{{ $loan->rencana_pengembalian }}</td>
                                            </tr>
                                        </table>
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="alert alert-secondary" role="alert">
                                        <b> <i class="fa fa-file" aria-hidden="true"></i> Bukti peminjaman</b>
                                    </div>
                                    <table class="table table-bordered" id="dynamic_field3">
                                        <thead>
                                            <tr>
                                                <th>{{ trans('inventory/equipment/form.desc') }}</th>
                                                <th>{{ trans('inventory/equipment/form.file') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($photo as $row)
                                                <tr id="detail_photo<?= $row->id ?>">
                                                    <td>
                                                        <input type="hidden" name="id_asal_photo[]"
                                                            value="{{ $row->id }}" class="form-control " />
                                                        <input required type="text" value="{{ $row->name_photo }}"
                                                            placeholder="" class="form-control" readonly />
                                                    </td>
                                                    <td style="width: 200px">
                                                        <center>
                                                            <a href="#" style="width: 160px" class="btn btn-primary"
                                                                data-bs-toggle="modal" id="view_photo_eq"
                                                                data-id="{{ $row->id }}"
                                                                data-photo_eq="{{ $row->photo }}"
                                                                data-name_photo="{{ $row->name_photo }}"
                                                                data-bs-target="#largeModalPhoto" title="View Gambar"><i
                                                                    class="mdi mdi-file"></i>
                                                                View File
                                                            </a>

                                                        </center>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <br>

                                    <div class="alert alert-secondary" role="alert">
                                        <b> <i class="fa fa-file" aria-hidden="true"></i> Bukti pengembalian</b>
                                    </div>

                                    @if ($loan->bukti_pengembalian == null)
                                                    -
                                                @else
                                                    <img src="{{ asset('storage/uploads/bukti_pengembalians/' . $loan->bukti_pengembalian) }}"
                                                        alt="Bukti Pengembalian" class="img-thumbnail" width="200"
                                                        height="150" style="object-fit: cover">
                                                @endif
                                </div>
                            </div>
                            <div class="modal fade" id="largeModalPhoto" tabindex="-1" role="dialog"
                                aria-labelledby="basicModal" aria-hidden="true">
                                <div class="modal-dialog ">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Name Photo : <span id="name_photo"></span></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                            <hr>
                                        </div>
                                        <div class="modal-body">
                                            <center><img src="" id="photo_eq" style="width: 100%;margin:0px" />
                                            </center>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ url()->previous() }}" class="btn btn-secondary"><i
                                    class="mdi mdi-arrow-left-thin"></i> {{ __('Back') }}</a>

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
    <script type="text/javascript">
        $(document).on('click', '#view_photo_eq', function() {
            var photo_eq = $(this).data('photo_eq');
            var name_photo = $(this).data('name_photo');
            $('#largeModalPhoto #photo_eq').attr("src", "../../../storage/img/moving_photo/" + photo_eq);
            $('#largeModalPhoto #name_photo').text(name_photo);
        })
    </script>
@endpush
