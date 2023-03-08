@extends('layouts.app')

@section('title', __('Vendors'))

@section('content')
                <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">{{ __('Vendors') }}</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="index.html">{{ __('Dashboard') }}</a></li>
                                    <li class="breadcrumb-item active">{{ __('Vendors') }}</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                    <div class="card-header">
                            @can('vendor create')
                                <a href="{{ route('vendors.create') }}" class="btn btn-md btn-primary"> <i
                                        class="mdi mdi-plus"></i> {{ __('Create a new vendor') }}</a>
                            @endcan
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" id="data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Code Vendor') }}</th>
											<th>{{ __('Name Vendor') }}</th>
											<th>{{ __('Category Vendor') }}</th>
											<th>{{ __('Email') }}</th>
											<th>{{ __('Province') }}</th>
											<th>{{ __('Kabkot') }}</th>
											<th>{{ __('Kecamatan') }}</th>
											<th>{{ __('Kelurahan') }}</th>
											<th>{{ __('Zip Kode') }}</th>
											<th>{{ __('Longitude') }}</th>
											<th>{{ __('Latitude') }}</th>
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
            ajax: "{{ route('vendors.index') }}",
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
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
                },
				{
                    data: 'province',
                    name: 'province.provinsi'
                },
				{
                    data: 'kabkot',
                    name: 'kabkot.provinsi_id'
                },
				{
                    data: 'kecamatan',
                    name: 'kecamatan.kabkot_id'
                },
				{
                    data: 'kelurahan',
                    name: 'kelurahan.kecamatan_id'
                },
				{
                    data: 'zip_kode',
                    name: 'zip_kode',
                },
				{
                    data: 'longitude',
                    name: 'longitude',
                },
				{
                    data: 'latitude',
                    name: 'latitude',
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
