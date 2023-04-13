@extends('layouts.app')

@section('title', __('Work Order Procesess'))

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('Work Order Procesess') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="index.html">{{ __('Dashboard') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('Work Order Procesess') }}</li>
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
                                <table class="table table-bordered table-sm" id="data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th style="white-space: nowrap">{{ __('Wo Number') }}</th>
                                            <th style="white-space: nowrap">{{ __('Equipment') }}</th>
                                            <th style="white-space: nowrap">{{ __('Type Wo') }}</th>
                                            <th style="white-space: nowrap">{{ __('Category Wo') }}</th>
                                            <th style="white-space: nowrap">{{ __('Schedule Date') }}</th>
                                            <th style="white-space: nowrap">{{ __('Actual Start Date') }}</th>
                                            <th style="white-space: nowrap">{{ __('Actual Finished Date') }}</th>
                                            <th style="white-space: nowrap">{{ __('Schedule Wo') }}</th>
                                            <th style="white-space: nowrap">{{ __('Note') }}</th>
                                            <th style="white-space: nowrap">{{ __('User') }}</th>
                                            <th style="white-space: nowrap">{{ __('Finished Processes') }}</th>
                                            <th style="white-space: nowrap">{{ __('Status Wo') }}</th>
                                            <th style="white-space: nowrap">{{ __('Filed Date') }}</th>
                                            <th style="white-space: nowrap">{{ __('Created At') }}</th>
                                            <th style="white-space: nowrap">{{ __('Updated At') }}</th>
                                            <th style="white-space: nowrap">{{ __('Action') }}</th>
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
            ajax: "{{ route('work-order-processes.index') }}?user_id={{ Auth::user()->id }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'wo_number',
                    name: 'wo_number'
                },
                {
                    data: 'equipment',
                    name: 'equipment.id'
                },
                {
                    data: 'type_wo',
                    name: 'type_wo',
                },
                {
                    data: 'category_wo',
                    name: 'category_wo',
                },
                {
                    data: 'schedule_date',
                    render: function(datum, type, row) {
                        return row.schedule_date ? row.schedule_date : row.start_date;
                    }
                },
                {
                    data: 'actual_start_date',
                    render: function(datum, type, row) {
                        return row.actual_start_date ? row.actual_start_date : '-';
                    }
                },
                {
                    data: 'actual_end_date',
                    render: function(datum, type, row) {
                        return row.actual_end_date ? row.actual_end_date : '-';
                    }
                },
                {
                    data: 'schedule_wo',
                    render: function(datum, type, row) {
                        return row.schedule_wo ? row.schedule_wo : '-';
                    }
                },
                {
                    data: 'note',
                    name: 'note',
                },
                {
                    data: 'user',
                    name: 'user.name'
                },
                {
                    data: 'finished_processes',
                    name: 'finished_processes'
                },
                {
                    data: 'status_wo',
                    render: function(datum, type, row) {
                        switch (row.status_wo) {
                            case 'accepted':
                                rowStatus = 'primary';
                                break;
                            case 'on-going':
                                rowStatus = 'info';
                                break;
                            case 'finished':
                                rowStatus = 'success';
                                break;
                        }

                        return `<span class="badge bg-${rowStatus}">${row.status_wo == 'accepted' ? 'ready for process' : row.status_wo}</span>`;
                    }
                },
                {
                    data: 'filed_date',
                    name: 'filed_date',
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
                    data: 'status_wo',
                    render: function(datum, type, row) {
                        return `<a href="{{ route('work-order-processes.index') }}/${row.id}" class="btn btn-sm btn-success"><i class="mdi mdi-table-edit"></i></a>`
                    }
                },
            ],
        });
    </script>
@endpush
