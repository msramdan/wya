<div class="row">
    <div class="col-md-6">
        <div class="table-responsive">
            <table class="table table-hover table-striped table-sm">
                <tr>
                    <td class="fw-bold">{{ __('No Peminjaman') }}</td>
                    <td>{{ $loan->no_peminjaman }}</td>
                    <td class="fw-bold">{{ __('Equipment') }}</td>
                    <td>{{ $loan->barcode }}</td>
                </tr>
                <tr>
                    <td class="fw-bold">{{ __('Hospital') }}</td>
                    <td>{{ $loan->hospital_name }}</td>
                    <td class="fw-bold">{{ __('Resource location') }}</td>
                    <td>{{ $loan->resource_location }}</td>
                </tr>
                <tr>
                    <td class="fw-bold">{{ __('Destination location') }}</td>
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
                    <td>{{ isset($loan->catatan_pengembalian) ? $loan->catatan_pengembalian : '-' }}</td>
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
                            <input type="hidden" name="id_asal_photo[]" value="{{ $row->id }}"
                                class="form-control " />
                            <input required type="text" value="{{ $row->name_photo }}" placeholder=""
                                class="form-control" readonly />
                        </td>
                        <td style="width: 200px">
                            <center>
                                <a href="#" style="width: 160px" class="btn btn-primary" data-bs-toggle="modal"
                                    id="view_photo_eq" data-id="{{ $row->id }}"
                                    data-photo_eq="{{ $row->photo }}" data-name_photo="{{ $row->name_photo }}"
                                    data-bs-target="#largeModalPhoto" title="View Gambar"><i class="mdi mdi-file"></i>
                                    View File
                                </a>

                            </center>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="largeModalPhoto" tabindex="-1" role="dialog" aria-labelledby="basicModal"
    aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Name Photo : <span id="name_photo"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <hr>
            </div>
            <div class="modal-body">
                <center><img src="" id="photo_eq" style="width: 100%;margin:0px" />
                </center>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
