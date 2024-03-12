@extends('layouts.app')

@section('title', __('Loans'))

@section('content')
                <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">{{ __('Loans') }}</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="/panel">Dashboard</a></li>
                                    <li class="breadcrumb-item active">{{ __('Loans') }}</li>
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
                                        class="mdi mdi-plus"></i> {{ __('Create a new loan') }}</a>
                            @endcan
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" id="data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('No Peminjaman') }}</th>
											<th>{{ __('Equipment') }}</th>
											<th>{{ __('Hospital') }}</th>
											<th>{{ __('Equipment Location') }}</th>
											<th>{{ __('Equipment Location') }}</th>
											<th>{{ __('Waktu Pinjam') }}</th>
											<th>{{ __('Waktu Dikembalikan') }}</th>
											<th>{{ __('Alasan Peminjaman') }}</th>
											<th>{{ __('Status Peminjaman') }}</th>
											<th>{{ __('Catatan Pengembalian') }}</th>
											<th>{{ __('Pic Penanggungjawab') }}</th>
											<th>{{ __('Bukti Peminjaman') }}</th>
											<th>{{ __('Bukti Pengembalian') }}</th>
											<th>{{ __('User') }}</th>
											<th>{{ __('User') }}</th>
                                            <th>{{ __('Created At') }}</th>
                                            <th>{{ __('Updated At') }}</th>
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
            ajax: "{{ route('loans.index') }}",
            columns: [
                {
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
                    data: 'equipment',
                    name: 'equipment.condition'
                },
				{
                    data: 'hospital',
                    name: 'hospital.bot_telegram'
                },
				{
                    data: 'equipment_location',
                    name: 'equipment_location.created_at'
                },
				{
                    data: 'equipment_location',
                    name: 'equipment_location.created_at'
                },
				{
                    data: 'waktu_pinjam',
                    name: 'waktu_pinjam',
                },
				{
                    data: 'waktu_dikembalikan',
                    name: 'waktu_dikembalikan',
                },
				{
                    data: 'alasan_peminjaman',
                    name: 'alasan_peminjaman',
                },
				{
                    data: 'status_peminjaman',
                    name: 'status_peminjaman',
                },
				{
                    data: 'catatan_pengembalian',
                    name: 'catatan_pengembalian',
                },
				{
                    data: 'pic_penanggungjawab',
                    name: 'pic_penanggungjawab',
                },
				{
                    data: 'bukti_peminjaman',
                    name: 'bukti_peminjaman',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        return `<div class="avatar">
                            <img src="${data}" alt="Bukti Peminjaman">
                        </div>`;
                        }
                    },
				{
                    data: 'bukti_pengembalian',
                    name: 'bukti_pengembalian',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        return `<div class="avatar">
                            <img src="${data}" alt="Bukti Pengembalian">
                        </div>`;
                        }
                    },
				{
                    data: 'user',
                    name: 'user.created_at'
                },
				{
                    data: 'user',
                    name: 'user.created_at'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'updated_at',
                    name: 'updated_at'
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
