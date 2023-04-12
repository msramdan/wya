@extends('layouts.app')

@section('title', __('Spareparts'))

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('Spareparts') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="index.html">{{ __('Dashboard') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('Spareparts') }}</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            @can('sparepart create')
                                <a href="{{ route('spareparts.create') }}" class="btn btn-md btn-primary"> <i
                                        class="mdi mdi-plus"></i> {{ __('Create a new sparepart') }}</a>
                            @endcan
                            <button id="btnExport" class="btn btn-success">
                                <i class='fas fa-file-excel'></i>
                                {{ __('Export') }}
                            </button>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" id="data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Barcode') }}</th>
                                            <th>{{ __('Sparepart Name') }}</th>
                                            <th>{{ __('Merk') }}</th>
                                            <th>{{ __('Sparepart Type') }}</th>

                                            <th>{{ __('Estimated Price') }}</th>
                                            <th>{{ __('Stock') }}</th>
                                            <th>{{ __('Unit Item') }}</th>
                                            {{-- <th>{{ __('Created At') }}</th>
                                            <th>{{ __('Updated At') }}</th> --}}
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
            ajax: "{{ route('spareparts.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'barcode',
                    name: 'barcode',
                },
                {
                    data: 'sparepart_name',
                    name: 'sparepart_name',
                },
                {
                    data: 'merk',
                    name: 'merk',
                },
                {
                    data: 'sparepart_type',
                    name: 'sparepart_type',
                },

                {
                    data: 'estimated_price',
                    name: 'estimated_price',
                },
                {
                    data: 'stock',
                    name: 'stock',
                },
                {
                    data: 'unit_item',
                    name: 'unit_item.code_unit'
                },
                // {
                //     data: 'created_at',
                //     name: 'created_at'
                // },
                // {
                //     data: 'updated_at',
                //     name: 'updated_at'
                // },
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
