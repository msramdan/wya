@extends('layouts.app')

@section('title', __('Roles'))

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Peran dan Izin Akses</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/panel">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Peran dan Izin Akses</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            @can('role & permission create')
                                <a href="{{ route('roles.create') }}" class="btn btn-md btn-primary"> <i
                                        class="mdi mdi-plus"></i> Tambah</a>
                            @endcan
                        </div>

                        <div class="card-body">
                            <div class="table-responsive p-1">
                                <table class="table table-striped" id="data-table">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Peran</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </section>
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
                    data: 'name',
                    name: 'name'
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
                    url: "{{ route('roles.index') }}",
                    data: function(s) {
                    }
                },
                columns: columns
            })
        </script>
    @endpush
