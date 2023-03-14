@extends('layouts.app')

@section('title', __('Equipments'))

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('Equipments') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="index.html">{{ __('Dashboard') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('Equipments') }}</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            @can('equipment create')
                                <a href="{{ route('equipment.create') }}" class="btn btn-md btn-primary"> <i
                                        class="mdi mdi-plus"></i> {{ __('Create a new equipment') }}</a>
                            @endcan
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" id="data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Barcode') }}</th>
                                            <th>{{ __('Nomenklatur') }}</th>
                                            <th>{{ __('Equipment Category') }}</th>
                                            <th>{{ __('Manufacturer') }}</th>
                                            <th>{{ __('Type') }}</th>
                                            <th>{{ __('Serial Number') }}</th>
                                            <th>{{ __('Vendor') }}</th>
                                            <th>{{ __('Condition') }}</th>
                                            <th>{{ __('Risk Level') }}</th>
                                            <th>{{ __('Equipment Location') }}</th>
                                            <th>{{ __('Financing Code') }}</th>
                                            <th>{{ __('Photo') }}</th>
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
            ajax: "{{ route('equipment.index') }}",
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
                    data: 'nomenklatur',
                    name: 'nomenklatur.code_nomenklatur'
                },
                {
                    data: 'equipment_category',
                    name: 'equipment_category.code_categoty'
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
                    data: 'vendor',
                    name: 'vendor.code_vendor'
                },
                {
                    data: 'condition',
                    name: 'condition',
                },
                {
                    data: 'risk_level',
                    name: 'risk_level',
                },
                {
                    data: 'equipment_location',
                    name: 'equipment_location.code_location'
                },
                {
                    data: 'financing_code',
                    name: 'financing_code',
                },
                {
                    data: 'photo',
                    name: 'photo',
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
