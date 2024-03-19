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
                            <div class="row">

                                @if (!Auth::user()->roles->first()->hospital_id)
                                    <div class="col-md-3 mb-2">
                                        <div class="input-group mb-2 mr-sm-2">
                                            <select name="hospital_id" id="hospital_id"
                                                class="form-control js-example-basic-multiple">
                                                <option value="">--
                                                    {{ trans('inventory/equipment/index.filter_hospital') }} --</option>
                                                @foreach ($hispotals as $hispotal)
                                                    <option value="{{ $hispotal->id }}"
                                                        {{ isset($equipments) && $equipments->hospital_id == $hispotal->id ? 'selected' : (old('hospital_id') == $hispotal->id ? 'selected' : '') }}>
                                                        {{ $hispotal->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" id="data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Hospital') }}</th>
                                            <th>{{ __('No Peminjaman') }}</th>
                                            <th>{{ __('Equipment') }}</th>
                                            <th>{{ __('Waktu') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Penanggungjawab') }}</th>
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
                data: 'hospital_name',
                name: 'hospital_name'
            },
            {
                data: 'no_peminjaman',
                name: 'no_peminjaman',
            },
            {
                data: 'barcode',
                name: 'barcode'
            },
            {
                data: 'waktu_pinjam',
                name: 'waktu_pinjam',
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
                data: 'employee_name',
                name: 'employee_name',
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
@endpush
