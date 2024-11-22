@extends('layouts.app')

@section('title', __('Aduan'))

@push('css')
    <style>
        .badge-width {
            display: inline-block;
            /* Memastikan span memiliki lebar tetap */
            width: 140px;
            /* Atur lebar sesuai kebutuhan */
            text-align: center;
            /* Untuk memastikan teks berada di tengah */
            font-size: 0.9em;
            /* Ukuran font lebih kecil */
            line-height: 1.5;
            /* Mengatur tinggi garis untuk vertikal center */
        }
    </style>
@endpush

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('Aduan') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/panel">Dashboard</a></li>
                                <li class="breadcrumb-item active">{{ __('Aduan') }}</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Nama') }}</th>
                                            <th>{{ __('Email') }}</th>
                                            <th>{{ __('Judul') }}</th>
                                            <th>{{ __('Tanggal') }}</th>
                                            <th>{{ __('Type') }}</th>
                                            <th>{{ __('Is Read') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>Token</th>
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
        $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('aduans.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nama',
                    name: 'nama',
                },
                {
                    data: 'email',
                    name: 'email',
                },
                {
                    data: 'judul',
                    name: 'judul',
                },
                {
                    data: 'tanggal',
                    name: 'tanggal',
                },
                {
                    data: 'type',
                    name: 'type',
                },
                {
                    data: 'is_read',
                    name: 'is_read',
                },
                {
                    data: 'status',
                    name: 'status',
                },
                {
                    data: 'token',
                    name: 'token',
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
        });
    </script>
@endpush
