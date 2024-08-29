@extends('layouts.app')

@section('title', __('Unit Items'))

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ trans('main-data/unit-item/index.head') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/panel">Dashboard</a></li>
                                <li class="breadcrumb-item active">{{ trans('main-data/unit-item/index.head') }}</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            @can('unit item create')
                                <a href="{{ route('unit-items.create') }}" class="btn btn-md btn-primary"> <i
                                        class="mdi mdi-plus"></i> {{ trans('main-data/unit-item/index.create') }}</a>
                            @endcan
                        </div>

                        <div class="card-body">
                            <div class="table-responsive p-1">
                                <table class="table table-striped" id="data-table">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>{{ trans('main-data/unit-item/index.unit_code') }}</th>
                                            <th>{{ trans('main-data/unit-item/index.unit_name') }}</th>
                                            <th>{{ trans('main-data/unit-item/index.action') }}</th>
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
                data: 'code_unit',
                name: 'code_unit',
            },
            {
                data: 'unit_name',
                name: 'unit_name',
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
                url: "{{ route('unit-items.index') }}",
                data: function(s) {}
            },
            columns: columns
        });
    </script>
@endpush
